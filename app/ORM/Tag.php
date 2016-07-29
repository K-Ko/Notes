<?php
/**
 * Real access class for table "tag"
 *
 * To extend the functionallity, edit here
 *
 * @author     Knut Kohl <github@knutkohl.de>
 * @copyright  2016 Knut Kohl
 * @license    MIT License (MIT) http://opensource.org/licenses/MIT
 * @version    1.0.0
 *
 * 1.1.0 / 2016-07-28
 * - Add method to remove orphan tags without notes
 *
 * 1.0.0
 * - Initial creation
 */
namespace ORM;

/**
 *
 */
class Tag extends TagBase
{

    /**
     * Remove orphan tags without notes
     */
    public function removeOrphanTags() {
        return $this->_query('
            DELETE `tag`
              FROM `tag`
              LEFT JOIN `note_tag` ON `tag`.`id` = `note_tag`.`tag`
             WHERE `note_tag`.`note` IS NULL
        '); // Works not with table aliases...
    }

}
