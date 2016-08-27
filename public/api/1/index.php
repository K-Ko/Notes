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

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

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

foreach (glob(__DIR__ . DS . 'routes' . DS . '*.php') as $file) {
	require_once $file;
}

$app->run();
