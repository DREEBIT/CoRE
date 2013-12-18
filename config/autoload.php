<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Dreebit_core
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Dreebit',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'Dreebit\BackendUserAcl'           => 'system/modules/dreebit_core/BackendUserAcl.php',
	// Models
	'Dreebit\CoreSubRequirementModel'  => 'system/modules/dreebit_core/models/CoreSubRequirementModel.php',
	'Dreebit\CoreProjectModel'         => 'system/modules/dreebit_core/models/CoreProjectModel.php',
	'Dreebit\CoreRequirementModel'     => 'system/modules/dreebit_core/models/CoreRequirementModel.php',
	'Dreebit\CoreProjectSnapshotModel' => 'system/modules/dreebit_core/models/CoreProjectSnapshotModel.php',

	// Widgets
	'Contao\Table'                     => 'system/modules/dreebit_core/widgets/Table.php',
	'Contao\Button'                    => 'system/modules/dreebit_core/widgets/Button.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'be_pdf_project_snapshot' => 'system/modules/dreebit_core/templates',
	'be_widget_table'         => 'system/modules/dreebit_core/templates',
));
