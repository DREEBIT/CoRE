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

$implodedUserGroups = implode(",", BackendUser::getInstance()->groups) ? implode(",", BackendUser::getInstance()->groups) : "NULL";
$isAdmin = BackendUser::getInstance()->isAdmin ? 1 : 0;


/**
 * Table core_project
 */
$GLOBALS['TL_DCA']['tl_core_project'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
        'ctable'                      => array('tl_core_requirement'),
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
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
            'filter'                  =>array(array('supplier IN ('.$implodedUserGroups.') OR customer IN ('.$implodedUserGroups.') OR '.$isAdmin))
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
            'requirements' => array(
                'label'					=> &$GLOBALS['TL_LANG']['tl_core_project']['requirements'],
                'href'					=> 'table=tl_core_requirement',
                'icon'					=> 'system/modules/dreebit_core/assets/images/icon_requirement.png'
            ),
            'snapshots' => array(
                'label'					=> &$GLOBALS['TL_LANG']['tl_core_project']['snapshots'],
                'href'					=> 'table=tl_core_project_snapshot',
                'icon'					=> 'system/modules/dreebit_core/assets/images/icon_history.png'
            ),
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
		'default'                     => '{title_legend},title,supplier,customer;'
	),

	// Subpalettes
	'subpalettes' => array
	(
        'includeChmod'                => 'cuser,cgroup,chmod'
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
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_core_project']['title'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
        'supplier' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_core_project']['supplier'],
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'select',
            'foreignKey'              => 'tl_user_group.name',
            'eval'                    =>  array(
                                            'multiple'=>false,
                                            'tl_class'=> 'w50'
                                          ),
            'sql'                     => "int(10) unsigned NULL",
            'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
        ),
        'customer' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_core_project']['customer'],
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'select',
            'foreignKey'              => 'tl_user_group.name',
            'eval'                    =>  array(
                                            'multiple'=>false,
                                            'tl_class'=> 'w50'
                                          ),
            'sql'                     => "int(10) unsigned NULL",
            'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
        )
    )
);

class tl_core_project extends Backend
{

}