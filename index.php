<?php
/**
 * Index file
 *
 * @author     Knut Kohl <github@knutkohl.de>
 * @copyright  2016 Knut Kohl
 * @license    MIT License (MIT) http://opensource.org/licenses/MIT
 * @version    1.0.0
 */

$_ts = microtime(true);

/**
 * Helper functions
 */
function info_exit($msg, $url='/') { _exit($msg, $url, 'success autohide'); }
function error_exit($msg, $url='/') { _exit($msg, $url, 'danger'); }
function _exit($msg, $url='/', $type) {
    $_SESSION['message'] = array($type, $msg);
    die(header('Location: '.$url));
}

/**
 * Setup environment
 */
define('DS', DIRECTORY_SEPARATOR); // Shortcut
define('ROOTDIR', __DIR__);
define('DEVELOP', file_exists('.develop'));
DEVELOP && ini_set('display_errors', 1) && error_reporting(-1);

require 'vendor' . DS . 'autoload.php';

$config = require 'config.php';

/**
 * Start session
 */
session_start() && session_regenerate_id();

/**
 * User and Basic auth
 */
$_SESSION['user'] = !empty($config['BasicAuth'])
                  ? BasicAuth::validate($config['BasicAuth'])
                  : '';

$c = $config['Database'];
$db = new MySQLiExt($c['host'], $c['user'], $c['pass'], $c['db'], $c['port'], $c['socket']);
unset($c);

ORM::setDatabase($db);

// Prepare ORM note table
ORM\Note::$DateTimeFormat = $config['DateTimeFormat'];
ORM\Note::$HashTagRegex   = '~#('.$config['HashTagRegex'].')\b~';

// Prepare View
$view = new View(ROOTDIR . DS . 'tpl', 'html', ROOTDIR . DS . 'tmp');
$view->reuseCode = !DEVELOP;

/**
 * Go
 */
switch (true) {

    /**
     * Search for hashtag
     */
    case $Tag = filter_input(INPUT_GET, 'tag', FILTER_SANITIZE_STRING):

        $ORMTags = ORM\Tags::f()->filterByTag($Tag)->findOne();

        $ORMTags->getId() || error_exit('No notes with <tt>#'.$Tag.'</tt>');

        $ORMNote = new ORM\Note;
        $Notes = array();

        foreach (json_decode($ORMTags->getNotes(), true) as $id) {
            $ORMNote->reset()->filterById($id)->findOne();
            $Notes[] = $ORMNote->format();
        }

        $view->tag = $Tag;
        $view->notes = $Notes;
        $view->template = 'tag';

        break;

    /**
     * Show a note
     */
    case $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT):

        $ORMNote = new ORM\Note($id);

        $ORMNote->getId() || error_exit('Unknown note');

        $view->note = $ORMNote->format(true);
        $view->template = 'show';

        break;

    /**
     * Add a new note
     */
    case array_key_exists('add', $_GET):

        // Prepare "empty" note to edit
        $Note = ORM\Note::f()->asObject();
        $Note->id = -1;

        $view->note = $Note;
        $view->template = 'edit';

        break;

    /**
     * Edit a note
     */
    case $id = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT):

        $ORMNote = new ORM\Note($id);

        $ORMNote->getId() || error_exit('Unknown note');

        $view->note = $ORMNote->format();
        $view->template = 'edit';

        break;

    /**
     * Save a note
     */
    case $id = filter_input(INPUT_POST, 'edit', FILTER_VALIDATE_INT):

        if ($id < 0) {
            // New note
            $ORMNote = new ORM\Note;
        } else {
            // Existing note
            $ORMNote = new ORM\Note($id);
            $ORMNote->getId() || error_exit('Unknown note');
        }

        $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));

        if (!$name) error_exit('Name must not be empty!');

        $text = filter_input(INPUT_POST, 'text');

        if (!$text) error_exit('Note text must not be empty!');

        $ORMNote->setName($name)->setText($text)->setChangedBy($_SESSION['user']);

        if ($id < 0) {
            // New note
            $ORMNote->setCreatedBy($_SESSION['user'])->insert();
        } else {
            // Existing note
            $ORMNote->update();
        }

        // Update hashtags table
        $ORMNoteTag = new ORM\NoteTag;
        $ORMNoteTag->filterByNote($ORMNote->getId())->delete();

        $ORMTag = new ORM\Tag;
    
        $ORMNoteTag->setNote($ORMNote->getId());
        foreach ($ORMNote->getTags() as $tag) {
            $ORMTag->reset()->filterByTag($tag)->findOne();
            $ORMTag->getId() || $ORMTag->setTag($tag)->insert();
            $ORMNoteTag->setTag($ORMTag->getId())->insert();
        }

        // Remove orphan tags without notes
        $ORMTag->removeOrphanTags();

        // Reset buffered tags
        unset($_SESSION['tags']);

        info_exit('Note saved', '?id='.$ORMNote->getId());

        break;

    /**
     * Delete a note
     */
    case $id = filter_input(INPUT_POST, 'delete', FILTER_VALIDATE_INT):

        $ORMNote = new ORM\Note($id);

        if (!($name = $ORMNote->getName())) error_exit('Unknown note');

        $ORMNote->delete(); // Deletes also entries in note_tag table

        // Remove orphan tags without notes
        ORM\Tag::f()->removeOrphanTags();

        // Reset buffered tags
        unset($_SESSION['tags']);

        info_exit('Note "' . $name . '" deleted');

        break;

    /**
     * List all notes
     */
    default:

        $ORMNote = new ORM\Note;

        $view->notes = $ORMNote->orderDesc('changed')->find()->asObject();
        $view->template = 'list';

        break;
}

/**
 * Get all hashtags and count of notes for each
 */
$ORMTags = new ORM\Tags;

if (!isset($_SESSION['tags'])) {
    $_SESSION['tags'] = array();
    foreach ($ORMTags->find() as $row) {
        $_SESSION['tags'][$row->getTag()] = $row->getCount();
    }
}

$view->tags = $_SESSION['tags'];

$view->message = isset($_SESSION['message']) ? $_SESSION['message'] : false;
unset($_SESSION['message']);

$view->version = file('.version', FILE_IGNORE_NEW_LINES);
$view->list = $config['List'];
$view->language = $config['Language'];
$view->I18N = require ROOTDIR . DS . 'lang' . DS . $config['Language'] . '.php';

$view->output('index');

echo PHP_EOL.sprintf('<!-- generated in %.0f ms -->', (microtime(true)-$_ts)*1000);
