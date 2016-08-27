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
$app->GET('/tags', function($request, $response, $args) {
    $tags = new ORM\Tags;
    return $response->withJson($tags->orderBy('tag')->find()->asObject());
});
