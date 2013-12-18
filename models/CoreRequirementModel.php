<?php
/**
 * Created by PhpStorm.
 * User: tonimoeckel
 * Date: 09.12.13
 * Time: 13:53
 */

namespace Dreebit;

class CoreRequirementModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_core_requirement';

    /**
     * Find by an project id
     * @param integer
     * @return \Contao\ModelCollection|null
     */
    public static function findByProject($id)
    {
        // do some magic here

        return static::findBy('pid',$id);
    }

}