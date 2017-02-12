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
    public function getTags() {
        $tags    = array();
        $regex   = '~(?:^|\s)#(' . self::$HashTagRegex . ')(?:\s|$)~ms';
        $content = preg_replace('~\s+~s', '  ', $this->getContent());

        if (preg_match_all($regex, $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $tags[$match[1]] = true;
            }
        }

        return array_keys($tags);
    }

    /**
     *
     */
    public function rawObject() {
        $note = $this->asObject();
        $note->created = strtotime($note->created);
        $note->changed = strtotime($note->changed);
        return $note;
    }

    /**
     * Basic setter for field "text"
     * Replace TAB with 4 spaces
     *
     * @param  mixed    $text Text value
     * @return Instance For fluid interface
     */
    public function setContent($text)
    {
        return parent::setContent(str_replace("\t", '    ', $text));
    }   // setText()

    /**
     * Basic setter for field "uid"
     *
     * @param  mixed    $uid Uid value
     * @return Instance For fluid interface
     */
    public function setUid($uid)
    {
        // immutable
        return $this;
    }   // setUid()

    /**
     * Raw setter for field "uid", for INSERT, REPLACE and UPDATE
     *
     * @param  mixed    $uid Uid value
     * @return Instance For fluid interface
     */
    public function setUidRaw($uid)
    {
        // immutable
        return $this;
    }   // setUidRaw()

    // -------------------------------------------------------------------------
    // PROTECTED
    // -------------------------------------------------------------------------

    /**
     * Update note tags
     */
    protected function afterInsert($rc) {
        NoteTag::updateHashTagsFromNote($this);
        return parent::afterInsert($rc);
    }

    /**
     * Update note tags
     */
    protected function afterUpdate($rc) {
        NoteTag::updateHashTagsFromNote($this);
        return parent::afterUpdate($rc);
    }

    /**
     * Update note tags
     */
    protected function afterDelete($rc) {
        NoteTag::updateHashTagsFromNote($this);
        return parent::afterDelete($rc);
    }

    /**
     *
     */
    protected function _asObject()
    {
        $data = parent::_asObject();
        unset($data->id);
        $data->content = str_replace("\r", '', $data->content);
        $data->tags    = $this->getTags();
        $data->created_ts = strtotime($data->created);
        $data->changed_ts = strtotime($data->changed);
        return $data;
    }

}
