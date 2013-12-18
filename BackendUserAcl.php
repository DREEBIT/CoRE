<?php
/**
 * Created by PhpStorm.
 * User: tonimoeckel
 * Date: 10.12.13
 * Time: 19:17
 */

namespace Dreebit;


class BackendUserAcl
{
    private static $instance = NULL;

    private function __construct(){


    }


    private function __clone(){

    }

    public static function getInstance(){

        if (self::$instance == NULL){
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param String $id
     */
    public function isAllowedForProject($pid){

        if (\BackendUser::getInstance()->isAdmin){
            return true;
        }

        $projectsArr = \Database::getInstance()->prepare('SELECT id FROM tl_core_project WHERE id=? AND (supplier IN (?) OR customer IN (?))')
            ->limit(1)
            ->execute(intval(\Input::get('id')), implode(',',\BackendUser::getInstance()->groups), implode(',',\BackendUser::getInstance()->groups))
            ->first();

        if ($projectsArr) {
            return true;
        }

        return false;

    }

    /**
     * @param String $id
     */
    public function isAllowedForRequirement($rid){

        if (\BackendUser::getInstance()->isAdmin){
            return true;
        }

        $projectsArr = \Database::getInstance()->prepare('SELECT tl_core_project.id FROM tl_core_project INNER JOIN tl_core_requirement ON tl_core_project.id =tl_core_requirement.pid WHERE tl_core_requirement.id=? AND (tl_core_project.supplier IN (?) OR tl_core_project.customer IN (?))')
            ->limit(1)
            ->execute(intval(\Input::get('id')), implode(',',\BackendUser::getInstance()->groups), implode(',',\BackendUser::getInstance()->groups))
            ->first();

        if ($projectsArr) {
            return true;
        }

        return false;

    }


    public function getProjectForRequirement($id){

        $project = \Database::getInstance()->prepare('SELECT * FROM tl_core_requirement INNER JOIN tl_core_project WHERE tl_core_requirement.id=? AND tl_core_project.id = tl_core_requirement.pid')
            ->limit(1)
            ->execute($id)
            ->first();

        return $project;
    }


    public function getRequirement($id){

        $requirement = \Database::getInstance()->prepare('SELECT * FROM tl_core_requirement WHERE tl_core_requirement.id=?')
            ->limit(1)
            ->execute($id)
            ->first();

        return $requirement;
    }

    public function getPalletsForUser(){

        $pallets = array('{title_legend}','title','state','acceptButton','description','category','steakholder','testCases','prerequisite','influenceTo','files','sub_requirements');

//        if (\BackendUser::getInstance()->isAdmin){
//
//        }else {
//            $insert = array("acceptButton");
//            array_splice($pallets,3,0, $insert);
//        }

        return implode(",",$pallets).';';

    }


}