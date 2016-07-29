<?php
/**
 * Real access class for table "note"
 *
 * To extend the functionallity, edit here
 *
 * @author     Knut Kohl <github@knutkohl.de>
 * @copyright  2016 Knut Kohl
 * @license    MIT License (MIT) http://opensource.org/licenses/MIT
 * @version    1.0.0
 *
 * 1.1.0
 * - Add method for formating
 * - Add method for hash tag finding
 *
 * 1.0.0
 * - Initial creation
 */
namespace ORM;

/**
 *
 */
class Note extends NoteBase
{

    /**
     *
     */
    public static $DateTimeFormat;

    /**
     *
     */
    public static $HashTagRegex;

    /**
     * Find hash tags in 'name' and 'text'
     */
    function getTags() {
        $tags = array();

        foreach (array($this->getName(), $this->getText()) as $txt) {
            if (preg_match_all(self::$HashTagRegex, $txt, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $tags[$match[1]] = true;
                }
            }
        }

        return array_keys($tags);
    }

    /**
     *
     */
    function format( $formatText = false ) {
        $note = $this->asObject();

        $note->created = date(self::$DateTimeFormat, strtotime($note->created));
        $note->changed = date(self::$DateTimeFormat, strtotime($note->changed));

        if ($formatText) {
            // 1st parse for tags
            $note->text = preg_replace(
                self::$HashTagRegex,
                '<a class="hidden-print" href="?tag=$1">#$1</a>'.
                // Hide on screens, print only
                '<span class="hidden-screen">#$1</span>',
                $note->text
            );
            $note->text = \Parsedown::instance()->text($note->text);
        }

        // Add. calculated attribute
        $note->tags = $this->getTags();

        return $note;
    }

    // -------------------------------------------------------------------------
    // PROTECTED
    // -------------------------------------------------------------------------

    /**
     *
     */
    protected function _asObject()
    {
        $data = parent::_asObject();
        $data->tags = $this->getTags();
        return $data;
    }

}
