<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package   dreebit_core
 * @author    Lars Grossmann
 * @license   Copyright
 * @copyright DREEBIT GmbH
 */


/**
 * Table core_project
 */
$GLOBALS['TL_DCA']['tl_core_sub_requirement'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'enableVersioning'            => true,
        'ptable'                      => 'tl_core_requirement',
        //'onload_callback'             => array(array("tl_core_requirement","onLoad")),
        'onversion_callback'          => array(array('tl_core_sub_requirement','onChange')),
        'sql' => array
        (
            'keys' => array
            (
                'id'    => 'primary',
                'pid'   => 'index'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 1,
            'fields'                  => array('title'),
            'flag'                    => 1,
            'panelLayout'			  => 'sort,search,limit'
        ),
        'label' => array
        (
            'fields'                  => array('title'),
            'format'                  => '%s'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['core_project']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['core_project']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['core_project']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['core_project']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),

    // Select
    'select' => array
    (
        'buttons_callback' => array()
    ),

    // Edit
    'edit' => array
    (
        'buttons_callback' => array()
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__'                => array(''),
        'default'                     => '{title_legend},title,description;'
    ),

    // Subpalettes
    'subpalettes' => array
    (
        ''                            => ''
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'pid' => array
        (
            'foreignKey'              => 'tl_core_requirement.id',
            'relation'                => array("type"=>"belongsTo","load"=>"lazy"),
            'sql'                     => "int(10) unsigned NOT NULL"
        ),
        'title' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_core_requirement']['title'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'description' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_core_requirement']['description'],
            'exclude'                 => true,
            'inputType'               => 'textarea',
            'sql'                     => "text NOT NULL"
        ),
    )
);


//
//if (!BackendUser::getInstance()->isAdmin && Input::get('id') && Input::get('table') == 'tl_core_requirement') {
//
//    $projectsArr = Database::getInstance()->prepare('SELECT id FROM tl_core_project WHERE id=? AND (supplier IN (?) OR customer IN (?))')
//        ->limit(1)
//        ->execute(intval(Input::get('id')), implode(',',BackendUser::getInstance()->groups), implode(',',BackendUser::getInstance()->groups))
//        ->first();
//
//    if (!$projectsArr) {
//        Backend::redirect('contao/main.php?act=error');
//    }
//
//    $GLOBALS['TL_DCA']['tl_core_requirement']['list']['sorting']['filter'] = array(array('pid=?', $projectsArr->id));
//}




class tl_core_sub_requirement extends Backend
{
    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function onChange($tableName, $versionId, DC_Table $container){

        $sub_requirement = \Dreebit\CoreSubRequirementModel::findOneBy('id',$container->id);
        $requirement =  \Dreebit\CoreRequirementModel::findOneBy('id',$sub_requirement->pid);
//        echo '<pre>'; var_dump($requirement);die;
        $requirement->state = 'open';
        $requirement->save();

    }



}