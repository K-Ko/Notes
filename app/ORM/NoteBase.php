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
     * Basic setter for field "uid"
     *
     * @param  mixed    $uid Uid value
     * @return Instance For fluid interface
     */
    public function setUid($uid)
    {
        $this->fields['uid'] = $uid;
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
        $this->raw['uid'] = $uid;
        return $this;
    }   // setUidRaw()

    /**
     * Basic setter for field "title"
     *
     * @param  mixed    $title Title value
     * @return Instance For fluid interface
     */
    public function setTitle($title)
    {
        $this->fields['title'] = $title;
        return $this;
    }   // setTitle()

    /**
     * Raw setter for field "title", for INSERT, REPLACE and UPDATE
     *
     * @param  mixed    $title Title value
     * @return Instance For fluid interface
     */
    public function setTitleRaw($title)
    {
        $this->raw['title'] = $title;
        return $this;
    }   // setTitleRaw()

    /**
     * Basic setter for field "content"
     *
     * @param  mixed    $content Content value
     * @return Instance For fluid interface
     */
    public function setContent($content)
    {
        $this->fields['content'] = $content;
        return $this;
    }   // setContent()

    /**
     * Raw setter for field "content", for INSERT, REPLACE and UPDATE
     *
     * @param  mixed    $content Content value
     * @return Instance For fluid interface
     */
    public function setContentRaw($content)
    {
        $this->raw['content'] = $content;
        return $this;
    }   // setContentRaw()

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
     * Basic getter for field "uid"
     *
     * @return mixed Uid value
     */
    public function getUid()
    {
        return $this->fields['uid'];
    }   // getUid()

    /**
     * Basic getter for field "title"
     *
     * @return mixed Title value
     */
    public function getTitle()
    {
        return $this->fields['title'];
    }   // getTitle()

    /**
     * Basic getter for field "content"
     *
     * @return mixed Content value
     */
    public function getContent()
    {
        return $this->fields['content'];
    }   // getContent()

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
     * Basic getter for field "changed"
     *
     * @return mixed Changed value
     */
    public function getChanged()
    {
        return $this->fields['changed'];
    }   // getChanged()

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
     * Filter for field "title"
     *
     * @param  mixed    $title Filter value
     * @return Instance For fluid interface
     */
    public function filterByTitle($title)
    {
        $this->filter[] = '`title` = '.$this->quote($title);
        return $this;
    }   // filterByTitle()

    /**
     * Filter for field "uid"
     *
     * @param  mixed    $uid Filter value
     * @return Instance For fluid interface
     */
    public function filterByUid($uid)
    {
        $this->filter[] = '`uid` = '.$this->quote($uid);
        return $this;
    }   // filterByUid()

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
     * Filter for field "content"
     *
     * @param  mixed    $content Filter value
     * @return Instance For fluid interface
     */
    public function filterByContent($content)
    {
        $this->filter[] = '`content` = '.$this->quote($content);
        return $this;
    }   // filterByContent()

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
          `uid` char(16) NOT NULL,
          `title` varchar(255) NOT NULL DEFAULT \'\',
          `content` text NOT NULL,
          `created` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
          `changed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`),
          UNIQUE KEY `name` (`title`),
          UNIQUE KEY `uid` (`uid`),
          KEY `created` (`created`),
          KEY `changed` (`changed`)
        ) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8
    ';

    /**
     *
     */
    protected $fields = array(
        'id'      => '',
        'uid'     => '',
        'title'   => '',
        'content' => '',
        'created' => '',
        'changed' => ''
    );

    /**
     *
     */
    protected $nullable = array(
        'id'      => false,
        'uid'     => false,
        'title'   => false,
        'content' => false,
        'created' => false,
        'changed' => false
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
