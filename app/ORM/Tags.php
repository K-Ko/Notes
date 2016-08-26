<?php
/**
 * Real access class for table "tags"
 *
 * To extend the functionallity, edit here
 *
 * @author     Knut Kohl <github@knutkohl.de>
 * @copyright  2016 Knut Kohl
 * @license    MIT License (MIT) http://opensource.org/licenses/MIT
 * @version    1.0.0
 *
 * 1.0.0
 * - Initial creation
 */
namespace ORM;

/**
 *
 */
class Tags extends TagsBase
{

    /**
     * Insert your extensions here...
     *
     * Access table name with $this->table
     */

    // -------------------------------------------------------------------------
    // PROTECTED
    // -------------------------------------------------------------------------

    /**
     *
     */
    protected function _asObject()
    {
        $data = parent::_asObject();
        $data->notes   = json_decode($data->notes);
        $data->count   = +$data->count;
        return $data;
    }


}
