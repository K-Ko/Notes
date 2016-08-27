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

/**
 *
 */
$app->GET('/notes', function($request, $response, $args) {
    $note = new ORM\Note;
    if ($q = $request->getQueryParam('q')) {
        $note->filterRaw('`title` LIKE "%{1}%" OR `content` LIKE "%{1}%"', $q);
        $notes = $note->find()->asObject();
    } elseif ($t = $request->getQueryParam('t')) {
        $tags = new ORM\Tags;
        $tags->filterByTag($t)->findOne();

        $notes = array();

        if ($tags->getNotes()) {
            $note = new ORM\Note;
            foreach (json_decode($tags->getNotes()) as $uid) {
                $notes[] = $note->reset()->filterByUid($uid)->findOne()->asObject();
            }
        }
    } else {
        $notes = $note->find()->asObject();
    }

    return $response->withJson($notes);
});

/**
 *
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
 *
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
 *
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

/**
 *
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
 *
 */
$app->POST('/render', function($request, $response, $args) {
    $title   = $request->getParsedBodyParam('title');
    $content = $request->getParsedBodyParam('content');

    $note = new ORM\Note;
    $note->setTitle($title)->setContent($content);
    return $response->withJson($note->format(true));
});

/**
 *
 */
$app->GET('/render/{uid}', function($request, $response, $args) {
    $note = new ORM\Note;
    $note->filterByUid($request->getAttribute('uid'))->findOne();
    if ($note->getId()) {
        return $response->withJson($note->format(true));
    }
    return $response->withStatus(404);
});
