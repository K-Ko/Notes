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
 *
 */
$app->POST('/logout', function($request, $response, $args) {
    $session = new ORM\Session;
    $session->filterByToken($request->getParsedBodyParam('token'))->delete();
    return $response;
});

/**
 *
 */
$app->GET('/config', function($request, $response, $args) {
    return $response->withJson(array(
        'i18n'    => $this->I18N,
        'version' => file(ROOTDIR . DS . '.version', FILE_IGNORE_NEW_LINES)
    ));
});
