<?php
/**
 * Abstract base class for table "tags"
 *
 * *** NEVER EVER EDIT THIS FILE! ***
 *
 * To extend the functionallity, edit "Tags.php"
 *
 * If you make changes here, they will be lost on next build!
 *
 * @author     Knut Kohl <github@knutkohl.de>
 * @copyright  2017 Knut Kohl
 * @license    MIT License (MIT) http://opensource.org/licenses/MIT
 *
 * @author     ORM class builder
 * @version    1.4.0 / 2016-07-18
 */
namespace ORM;

/**
 *
 */
abstract class TagsBase extends \ORM
{

    // -----------------------------------------------------------------------
    // PUBLIC
    // -----------------------------------------------------------------------

    // -----------------------------------------------------------------------
    // Setter methods
    // -----------------------------------------------------------------------

    /**
     * "tags" is a view, no setters
     */

    // -----------------------------------------------------------------------
    // Getter methods
    // -----------------------------------------------------------------------

    /**
     * Basic getter for field "tag"
     *
     * @return mixed Tag value
     */
    public function getTag()
    {
        return $this->fields['tag'];
    }   // getTag()

    /**
     * Basic getter for field "notes"
     *
     * @return mixed Notes value
     */
    public function getNotes()
    {
        return $this->fields['notes'];
    }   // getNotes()

    /**
     * Basic getter for field "count"
     *
     * @return mixed Count value
     */
    public function getCount()
    {
        return $this->fields['count'];
    }   // getCount()

    // -----------------------------------------------------------------------
    // Filter methods
    // -----------------------------------------------------------------------

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
     * Filter for field "notes"
     *
     * @param  mixed    $notes Filter value
     * @return Instance For fluid interface
     */
    public function filterByNotes($notes)
    {
        $this->filter[] = '`notes` = '.$this->quote($notes);
        return $this;
    }   // filterByNotes()

    /**
     * Filter for field "count"
     *
     * @param  mixed    $count Filter value
     * @return Instance For fluid interface
     */
    public function filterByCount($count)
    {
        $this->filter[] = '`count` = '.$this->quote($count);
        return $this;
    }   // filterByCount()

    // -----------------------------------------------------------------------
    // PROTECTED
    // -----------------------------------------------------------------------

    /**
     * Table name
     *
     * @var string $table Table name
     */
    protected $table = 'tags';

    /**
     * SQL for creation
     *
     * @var string $createSQL
     */
    protected $createSQL = '
        CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tags` AS select `t`.`tag` AS `tag`,concat(\'["\',group_concat(`n`.`uid` separator \'","\'),\'"]\') AS `notes`,count(`nt`.`note`) AS `count` from ((`tag` `t` left join `note_tag` `nt` on((`t`.`id` = `nt`.`tag`))) join `note` `n` on((`nt`.`note` = `n`.`id`))) group by `nt`.`tag` having `count`
    ';

    /**
     *
     */
    protected $fields = array(
        'tag'   => '',
        'notes' => '',
        'count' => ''
    );

    /**
     *
     */
    protected $nullable = array(

    );

    /**
     *
     */
    protected $primary = array(

    );

    /**
     *
     */
    protected $autoinc = '';

}
