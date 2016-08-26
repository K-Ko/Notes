<?php
/**
 * Notes API
 *
 * @version 1
 *
 * @author     Knut Kohl <github@knutkohl.de>
 * @copyright  2016 Knut Kohl
 * @license    MIT License (MIT) http://opensource.org/licenses/MIT
 * @version    1.0.0
 */

require_once __DIR__ . '/../../../bootstrap.php';

use Dflydev\FigCookies\Cookies;
use Dflydev\FigCookies\SetCookie;
use Dflydev\FigCookies\FigResponseCookies;

$app = new Slim\App(array(
    'displayErrorDetails' => DEVELOP,
    'routerCacheFile' => ROOTDIR . DS . 'tmp' . DS . 'router.'.$version.'.cache'
));

$container = $app->getContainer();

$container['config'] = $config;
$container['I18N']   = $I18N;

$app->add(function ($request, $response, $next) {
    $path = $request->getUri()->getPath();

    if (!in_array($path, array('login', 'config'))) {
        $cookies = Cookies::fromRequest($request);

        if ($cookies->has('token')) {
            $session = new ORM\Session;
            $session->filterByToken($cookies->get('token')->getValue())
                    ->filterRaw('until >= {1}', time())
                    ->findOne();
            if (!$session->getUser()) {
                return $response->withStatus(401);
            }
        } else {
            return $response->withStatus(401);
        }
    }

    return $next($request, $response);
});

/**
 * GET getConfig
 * Summary:
 * Notes: Get actual translation
 * Output-Formats: [application/json]
 */
$app->POST('/login', function($request, $response, $args) {

    $user     = $request->getParsedBodyParam('user');
    $password = $request->getParsedBodyParam('password');

    $found = false;

    foreach ($this->config['BasicAuth'] as $user_allowed=>$password_allowed) {
        if (strtolower($user_allowed) === strtolower($user) &&
            $password_allowed === $password) {
            $found = $user_allowed;
            break;
        }
    }

    if ($found) {
        $token = SHA1(time());
        $until = $this->config['SessionLifeTime'] > 0
               ? time() + $this->config['SessionLifeTime'] * 86400
               : 0;

        $session = new ORM\Session;
        $session->setUser($found)
                ->setToken($token)
                ->setUntil($until ? date('Y-m-d H:i:s', $until) : '9999-12-31')
                ->replace();

        $response = FigResponseCookies::set(
            $response,
            SetCookie::create('token')->withPath('/')
                                      ->withValue($token)
                                      ->withExpires(date('r', $until))
        );

        return $response->withJson(array('user' => $found));
    }

    return $response->withStatus(401);
});

/**
 * GET Logout
 * Summary:
 * Notes: Get actual translation
 * Output-Formats: [application/json]
 */
$app->POST('/logout', function($request, $response, $args) {
    $session = new ORM\Session;
    $session->filterByToken($request->getParsedBodyParam('token'))->delete();
    return $response;
});

/**
 * GET getConfig
 * Summary:
 * Notes: Get actual translation
 * Output-Formats: [application/json]
 */
$app->GET('/config', function($request, $response, $args) {
    return $response->withJson(array(
        'i18n'    => $this->I18N,
        'version' => file(ROOTDIR . DS . '.version', FILE_IGNORE_NEW_LINES)
    ));
});

/**
 * GET getNotes
 * Summary:
 * Notes: Get all notes
 * Output-Formats: [application/json]
 */
$app->GET('/notes', function($request, $response, $args) {
    $note = new ORM\Note;
    return $response->withJson($note->find()->asObject());
});

/**
 * PUT createNote
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->PUT('/notes', function($request, $response, $args) {
    $title = $request->getParsedBodyParam('title');
    if ($title == '') {
        return $response->withJson('Title must not be empty', 400);
    }

    $content = $request->getParsedBodyParam('content');
    if ($content == '') {
        return $response->withJson('Content must not be empty', 400);
    }

    $note = new ORM\Note;
    $note->setTitle($title)->setContent($content);

    if ($note->insert()) {
        return $response->withJson($note->filterById($note->getId())->findOne()->asObject(), 201);
    }


    return $response->withStatus(400);
});

/**
 * GET getNote
 * Summary:
 * Notes: Get a note
 * Output-Formats: [application/json]
 */
$app->GET('/notes/{uid}', function($request, $response, $args) {
    $note = new ORM\Note;
    $note->filterByUid($request->getAttribute('uid'))->findOne();
    if ($note->getId()) {
        return $response->withJson($note->asObject());
    }
    return $response->withStatus(404);
});

/**
 * GET getNoteHTML
 * Summary:
 * Notes: Get a rendered note
 * Output-Formats: [application/json]
 */
$app->GET('/notes/html/{uid}', function($request, $response, $args) {
    $note = new ORM\Note;
    $note->filterByUid($request->getAttribute('uid'))->findOne();
    if ($note->getId()) {
        return $response->withJson($note->format(true));
    }
    return $response->withStatus(404);
});

/**
 * DELETE deleteNote
 * Summary: 
 * Notes: 
 * Output-Formats: [application/json]
 */
$app->DELETE('/notes/{uid}', function($request, $response, $args) {
    $note = new ORM\Note;
    $note->filterByUid($request->getAttribute('uid'))->findOne();
    if ($note->getId() && $note->delete()) {
        return $response->withStatus(204);
    }
    return $response->withJson('Note not found', 404);
});

/**
 * GET getNotesByTag
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->GET('/notes/tag/{tag}', function($request, $response, $args) {
    $tags = new ORM\Tags;
    $tags->filterByTag($request->getAttribute('tag'))->findOne();

    $notes = array();

    if ($tags->getNotes()) {
        $note = new ORM\Note;
        foreach (json_decode($tags->getNotes()) as $uid) {
            $notes[] = $note->reset()->filterByUid($uid)->findOne()->asObject();
        }
    }

    return $response->withJson($notes);
});

/**
 * GET getTags
 * Summary:
 * Notes: Get all tags
 * Output-Formats: [application/json]
 */
$app->GET('/tags', function($request, $response, $args) {
    $tags = new ORM\Tags;
    return $response->withJson($tags->orderBy('tag')->find()->asObject());
});

/**
 * GET getNotesForTag
 * Summary: 
 * Notes: Get notes for given tag
 * Output-Formats: [application/json]
 */
$app->GET('/tags/{tag}', function($request, $response, $args) {
    $tags = new ORM\Tags;
    $tags->filterByTag($request->getAttribute('tag'))->findOne();
    if ($tags->getId()) {
        return $response->withJson($tags->asObject());
    }
    return $response->withStatus(404);
});

/**
 * POST updateNote
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->POST('/notes/render', function($request, $response, $args) {
    $title   = $request->getParsedBodyParam('title');
    $content = $request->getParsedBodyParam('content');

    $note = new ORM\Note;
    $note->setTitle($title)->setContent($content);
    return $response->withJson($note->format(true));
});

/**
 * POST updateNote
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->POST('/notes/{id}', function($request, $response, $args) {
    $title = $request->getParsedBodyParam('title');
    if ($title == '') {
        return $response->withJson('Title must not be empty', 400);
    }

    $content = $request->getParsedBodyParam('content');
    if ($content == '') {
        return $response->withJson('Content must not be empty', 400);
    }

    $note = new ORM\Note;
    $note->filterByUid($request->getParsedBodyParam('uid'))->findOne();
    if ($note->getId()) {
        $note->setTitle($title)->setContent($content)->update();
        return $response->withJson($note->findOne()->format(true), 200);
    }

    return $response->withStatus(404);
});

$app->run();
