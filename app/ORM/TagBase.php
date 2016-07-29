<?php
/**
 * Abstract base class for table "tag"
 *
 * *** NEVER EVER EDIT THIS FILE! ***
 *
 * To extend the functionallity, edit "Tag.php"
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
abstract class TagBase extends \ORM
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
     * Basic getter for field "id"
     *
     * @return mixed Id value
     */
    public function getId()
    {
        return $this->fields['id'];
    }   // getId()

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

    // -----------------------------------------------------------------------
    // PROTECTED
    // -----------------------------------------------------------------------

    /**
     * Table name
     *
     * @var string $table Table name
     */
    protected $table = 'tag';

    /**
     * SQL for creation
     *
     * @var string $createSQL
     */
    protected $createSQL = '
        CREATE TABLE `tag` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `tag` varchar(255) NOT NULL DEFAULT \'\' COMMENT \'Unique hash tag\',
          PRIMARY KEY (`id`),
          UNIQUE KEY `tag` (`tag`)
        ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8
    ';

    /**
     *
     */
    protected $fields = array(
        'id'  => '',
        'tag' => ''
    );

    /**
     *
     */
    protected $nullable = array(
        'id'  => false,
        'tag' => false
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
