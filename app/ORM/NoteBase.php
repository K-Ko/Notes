<?php
/**
 * Abstract base class for table "note"
 *
 * *** NEVER EVER EDIT THIS FILE! ***
 *
 * To extend the functionallity, edit "Note.php"
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
abstract class NoteBase extends \ORM
{

    // -----------------------------------------------------------------------
    // PUBLIC
    // -----------------------------------------------------------------------

    // -----------------------------------------------------------------------
    // Setter methods
    // -----------------------------------------------------------------------

    /**
     * "id" is AutoInc, no setter
     */

    /**
     * Basic setter for field "name"
     *
     * @param  mixed    $name Name value
     * @return Instance For fluid interface
     */
    public function setName($name)
    {
        $this->fields['name'] = $name;
        return $this;
    }   // setName()

    /**
     * Raw setter for field "name", for INSERT, REPLACE and UPDATE
     *
     * @param  mixed    $name Name value
     * @return Instance For fluid interface
     */
    public function setNameRaw($name)
    {
        $this->raw['name'] = $name;
        return $this;
    }   // setNameRaw()

    /**
     * Basic setter for field "text"
     *
     * @param  mixed    $text Text value
     * @return Instance For fluid interface
     */
    public function setText($text)
    {
        $this->fields['text'] = $text;
        return $this;
    }   // setText()

    /**
     * Raw setter for field "text", for INSERT, REPLACE and UPDATE
     *
     * @param  mixed    $text Text value
     * @return Instance For fluid interface
     */
    public function setTextRaw($text)
    {
        $this->raw['text'] = $text;
        return $this;
    }   // setTextRaw()

    /**
     * Basic setter for field "created"
     *
     * @param  mixed    $created Created value
     * @return Instance For fluid interface
     */
    public function setCreated($created)
    {
        $this->fields['created'] = $created;
        return $this;
    }   // setCreated()

    /**
     * Raw setter for field "created", for INSERT, REPLACE and UPDATE
     *
     * @param  mixed    $created Created value
     * @return Instance For fluid interface
     */
    public function setCreatedRaw($created)
    {
        $this->raw['created'] = $created;
        return $this;
    }   // setCreatedRaw()

    /**
     * Basic setter for field "created_by"
     *
     * @param  mixed    $created_by CreatedBy value
     * @return Instance For fluid interface
     */
    public function setCreatedBy($created_by)
    {
        $this->fields['created_by'] = $created_by;
        return $this;
    }   // setCreatedBy()

    /**
     * Raw setter for field "created_by", for INSERT, REPLACE and UPDATE
     *
     * @param  mixed    $created_by CreatedBy value
     * @return Instance For fluid interface
     */
    public function setCreatedByRaw($created_by)
    {
        $this->raw['created_by'] = $created_by;
        return $this;
    }   // setCreatedByRaw()

    /**
     * Basic setter for field "changed"
     *
     * @param  mixed    $changed Changed value
     * @return Instance For fluid interface
     */
    public function setChanged($changed)
    {
        $this->fields['changed'] = $changed;
        return $this;
    }   // setChanged()

    /**
     * Raw setter for field "changed", for INSERT, REPLACE and UPDATE
     *
     * @param  mixed    $changed Changed value
     * @return Instance For fluid interface
     */
    public function setChangedRaw($changed)
    {
        $this->raw['changed'] = $changed;
        return $this;
    }   // setChangedRaw()

    /**
     * Basic setter for field "changed_by"
     *
     * @param  mixed    $changed_by ChangedBy value
     * @return Instance For fluid interface
     */
    public function setChangedBy($changed_by)
    {
        $this->fields['changed_by'] = $changed_by;
        return $this;
    }   // setChangedBy()

    /**
     * Raw setter for field "changed_by", for INSERT, REPLACE and UPDATE
     *
     * @param  mixed    $changed_by ChangedBy value
     * @return Instance For fluid interface
     */
    public function setChangedByRaw($changed_by)
    {
        $this->raw['changed_by'] = $changed_by;
        return $this;
    }   // setChangedByRaw()

    // -----------------------------------------------------------------------
    // Getter methods
    // -----------------------------------------------------------------------

    /**
     * Basic getter for field "id"
     *
     * @return mixed Id value
     */
    public function getId()
    {
        return $this->fields['id'];
    }   // getId()

    /**
     * Basic getter for field "name"
     *
     * @return mixed Name value
     */
    public function getName()
    {
        return $this->fields['name'];
    }   // getName()

    /**
     * Basic getter for field "text"
     *
     * @return mixed Text value
     */
    public function getText()
    {
        return $this->fields['text'];
    }   // getText()

    /**
     * Basic getter for field "created"
     *
     * @return mixed Created value
     */
    public function getCreated()
    {
        return $this->fields['created'];
    }   // getCreated()

    /**
     * Basic getter for field "created_by"
     *
     * @return mixed CreatedBy value
     */
    public function getCreatedBy()
    {
        return $this->fields['created_by'];
    }   // getCreatedBy()

    /**
     * Basic getter for field "changed"
     *
     * @return mixed Changed value
     */
    public function getChanged()
    {
        return $this->fields['changed'];
    }   // getChanged()

    /**
     * Basic getter for field "changed_by"
     *
     * @return mixed ChangedBy value
     */
    public function getChangedBy()
    {
        return $this->fields['changed_by'];
    }   // getChangedBy()

    // -----------------------------------------------------------------------
    // Filter methods
    // -----------------------------------------------------------------------

    /**
     * Filter for field "id"
     *
     * @param  mixed    $id Filter value
     * @return Instance For fluid interface
     */
    public function filterById($id)
    {
        $this->filter[] = '`id` = '.$this->quote($id);
        return $this;
    }   // filterById()

    /**
     * Filter for field "name"
     *
     * @param  mixed    $name Filter value
     * @return Instance For fluid interface
     */
    public function filterByName($name)
    {
        $this->filter[] = '`name` = '.$this->quote($name);
        return $this;
    }   // filterByName()

    /**
     * Filter for field "created"
     *
     * @param  mixed    $created Filter value
     * @return Instance For fluid interface
     */
    public function filterByCreated($created)
    {
        $this->filter[] = '`created` = '.$this->quote($created);
        return $this;
    }   // filterByCreated()

    /**
     * Filter for field "changed"
     *
     * @param  mixed    $changed Filter value
     * @return Instance For fluid interface
     */
    public function filterByChanged($changed)
    {
        $this->filter[] = '`changed` = '.$this->quote($changed);
        return $this;
    }   // filterByChanged()

    /**
     * Filter for field "text"
     *
     * @param  mixed    $text Filter value
     * @return Instance For fluid interface
     */
    public function filterByText($text)
    {
        $this->filter[] = '`text` = '.$this->quote($text);
        return $this;
    }   // filterByText()

    /**
     * Filter for field "created_by"
     *
     * @param  mixed    $created_by Filter value
     * @return Instance For fluid interface
     */
    public function filterByCreatedBy($created_by)
    {
        $this->filter[] = '`created_by` = '.$this->quote($created_by);
        return $this;
    }   // filterByCreatedBy()

    /**
     * Filter for field "changed_by"
     *
     * @param  mixed    $changed_by Filter value
     * @return Instance For fluid interface
     */
    public function filterByChangedBy($changed_by)
    {
        $this->filter[] = '`changed_by` = '.$this->quote($changed_by);
        return $this;
    }   // filterByChangedBy()

    // -----------------------------------------------------------------------
    // PROTECTED
    // -----------------------------------------------------------------------

    /**
     * Table name
     *
     * @var string $table Table name
     */
    protected $table = 'note';

    /**
     * SQL for creation
     *
     * @var string $createSQL
     */
    protected $createSQL = '
        CREATE TABLE `note` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL DEFAULT \'\',
          `text` text NOT NULL,
          `created` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
          `created_by` varchar(127) NOT NULL DEFAULT \'\',
          `changed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          `changed_by` varchar(127) NOT NULL DEFAULT \'\',
          PRIMARY KEY (`id`),
          UNIQUE KEY `name` (`name`),
          KEY `created` (`created`),
          KEY `changed` (`changed`)
        ) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8
    ';

    /**
     *
     */
    protected $fields = array(
        'id'         => '',
        'name'       => '',
        'text'       => '',
        'created'    => '',
        'created_by' => '',
        'changed'    => '',
        'changed_by' => ''
    );

    /**
     *
     */
    protected $nullable = array(
        'id'         => false,
        'name'       => false,
        'text'       => false,
        'created'    => false,
        'created_by' => false,
        'changed'    => false,
        'changed_by' => false
    );

    /**
     *
     */
    protected $primary = array(
        'id'
    );

    /**
     *
     */
    protected $autoinc = 'id';

}
