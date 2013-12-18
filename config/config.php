<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package   dreebit_core
 * @author    Toni Möckel
 * @license   Copyright
 * @copyright DREEBIT GmbH
 */

/**
 * Backend form fields
 */
$GLOBALS['BE_FFL']['button'] = 'Button';
$GLOBALS['BE_FFL']['table'] = 'Table';

/**
 * Back end modules
 */
$GLOBALS['BE_MOD']['core']['projects'] = array(
    'tables'    => array('tl_core_project','tl_core_requirement','tl_core_category','tl_core_sub_requirement','tl_core_project_snapshot'),
    'icon' 		=> 'system/modules/dreebit_core/assets/images/icon_project.png',
    'stylesheet'=> 'system/modules/dreebit_core/assets/stylesheets/core.css'
);

$GLOBALS['BE_MOD']['core']['categories'] = array(
    'tables'    => array('tl_core_category'),
    'icon' 		=> 'system/modules/dreebit_core/assets/images/icon_category.png'
);