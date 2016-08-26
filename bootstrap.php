<?php
/**
 * Bootstrap file for API and index
 *
 * @author     Knut Kohl <github@knutkohl.de>
 * @copyright  2016 Knut Kohl
 * @license    MIT License (MIT) http://opensource.org/licenses/MIT
 * @version    1.0.0
 */

$_ts = microtime(true);

/**
 * Setup environment
 */
define('DS', DIRECTORY_SEPARATOR); // Shortcut
define('ROOTDIR', __DIR__);
define('DEVELOP', file_exists('.develop') || (array_key_exists('HTTP_X_DEBUG', $_SERVER) && $_SERVER['HTTP_X_DEBUG']));
DEVELOP && ini_set('display_errors', 1) && error_reporting(-1);

require ROOTDIR . DS . 'vendor' . DS . 'autoload.php';

$config = require ROOTDIR . DS . 'config' . DS . 'config.php';

$c = $config['Database'];
$db = new MySQLiExt($c['host'], $c['user'], $c['pass'], $c['db'], $c['port'], $c['socket']);
unset($c);

ORM::setDatabase($db);

// Prepare ORM note table
ORM\Note::$DateTimeFormat = $config['DateTimeFormat'];
ORM\Note::$HashTagRegex   = '~#('.$config['HashTagRegex'].')\b~';

$I18N = require ROOTDIR . DS . 'lang' . DS . $config['Language'] . '.php';
