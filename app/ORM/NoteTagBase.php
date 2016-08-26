<?php
/**
 * Abstract base class for table "note_tag"
 *
 * *** NEVER EVER EDIT THIS FILE! ***
 *
 * To extend the functionallity, edit "NoteTag.php"
 *
 * If you make changes here, they will be lost on next build!
 *
 * @author     Knut Kohl <github@knutkohl.de>
 * @copyright  2016 Knut Kohl
 * @license    MIT License (MIT) http://opensource.org/licenses/MIT
 *
 * @author     ORM class builder
 * @version    1.4.0 / 2016-07-18
 */
namespace ORM;

/**
 *
 */
abstract class NoteTagBase extends \ORM
{

    // -----------------------------------------------------------------------
    // PUBLIC
    // -----------------------------------------------------------------------

    // -----------------------------------------------------------------------
    // Setter methods
    // -----------------------------------------------------------------------

    /**
     * Basic setter for field "note"
     *
     * @param  mixed    $note Note value
     * @return Instance For fluid interface
     */
    public function setNote($note)
    {
        $this->fields['note'] = $note;
        return $this;
    }   // setNote()

    /**
     * Raw setter for field "note", for INSERT, REPLACE and UPDATE
     *
     * @param  mixed    $note Note value
     * @return Instance For fluid interface
     */
    public function setNoteRaw($note)
    {
        $this->raw['note'] = $note;
        return $this;
    }   // setNoteRaw()

    /**
     * Basic setter for field "tag"
     *
     * @param  mixed    $tag Tag value
     * @return Instance For fluid interface
     */
    public function setTag($tag)
    {
        $this->fields['tag'] = $tag;
        return $this;
    }   // setTag()

    /**
     * Raw setter for field "tag", for INSERT, REPLACE and UPDATE
     *
     * @param  mixed    $tag Tag value
     * @return Instance For fluid interface
     */
    public function setTagRaw($tag)
    {
        $this->raw['tag'] = $tag;
        return $this;
    }   // setTagRaw()

    // -----------------------------------------------------------------------
    // Getter methods
    // -----------------------------------------------------------------------

    /**
     * Basic getter for field "note"
     *
     * @return mixed Note value
     */
    public function getNote()
    {
        return $this->fields['note'];
    }   // getNote()

    /**
     * Basic getter for field "tag"
     *
     * @return mixed Tag value
     */
    public function getTag()
    {
        return $this->fields['tag'];
    }   // getTag()

    // -----------------------------------------------------------------------
    // Filter methods
    // -----------------------------------------------------------------------

    /**
     * Filter for unique fields "note', 'tag"
     *
     * @param  mixed    $note, $tag Filter values
     * @return Instance For fluid interface
     */
    public function filterByNoteTag($note, $tag)
    {

        $this->filter[] = '`note` = '.$this->quote($note).'';
        $this->filter[] = '`tag` = '.$this->quote($tag).'';
        return $this;
    }   // filterByNoteTag()

    /**
     * Filter for field "tag"
     *
     * @param  mixed    $tag Filter value
     * @return Instance For fluid interface
     */
    public function filterByTag($tag)
    {
        $this->filter[] = '`tag` = '.$this->quote($tag);
        return $this;
    }   // filterByTag()

    /**
     * Filter for field "note"
     *
     * @param  mixed    $note Filter value
     * @return Instance For fluid interface
     */
    public function filterByNote($note)
    {
        $this->filter[] = '`note` = '.$this->quote($note);
        return $this;
    }   // filterByNote()

    // -----------------------------------------------------------------------
    // PROTECTED
    // -----------------------------------------------------------------------

    /**
     * Table name
     *
     * @var string $table Table name
     */
    protected $table = 'note_tag';

    /**
     * SQL for creation
     *
     * @var string $createSQL
     */
    protected $createSQL = '
        CREATE TABLE `note_tag` (
          `note` int(10) unsigned NOT NULL,
          `tag` int(10) unsigned NOT NULL,
          PRIMARY KEY (`note`,`tag`),
          KEY `tag` (`tag`),
          CONSTRAINT `note_tag_ibfk_1` FOREIGN KEY (`note`) REFERENCES `note` (`id`) ON DELETE CASCADE,
          CONSTRAINT `note_tag_ibfk_2` FOREIGN KEY (`tag`) REFERENCES `tag` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ';

    /**
     *
     */
    protected $fields = array(
        'note' => '',
        'tag'  => ''
    );

    /**
     *
     */
    protected $nullable = array(
        'note' => false,
        'tag'  => false
    );

    /**
     *
     */
    protected $primary = array(
        'note',
        'tag'
    );

    /**
     *
     */
    protected $autoinc = '';

}
