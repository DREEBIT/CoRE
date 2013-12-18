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
$GLOBALS['TL_DCA']['tl_core_project_snapshot'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
        'ptable'                      => 'tl_core_project',
        'onload_callback'           => array(array('tl_core_project_snapshot','onLoad')),
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
            'fields'                  => array('tstamp'),
            'headerFields'            => array('title'),
            'panelLayout'             => 'filter;sort,search,limit',
            'child_record_callback'   => array('tl_core_project_snapshot', 'listSnapshots'),
			'mode'                    => 4
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
            'download' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_core_project_snapshot']['download'],
                'href'                => 'act=download',
                'icon'                => 'system/modules/dreebit_core/assets/images/icon_pdf.png'
            ),
            'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['core_project']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
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
		'default'                     => '{title_legend},title,tstamp,dump;'
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
        'pid' => array
        (
            'foreignKey'              => 'tl_core_project.id',
            'relation'                => array("type"=>"belongsTo","load"=>"lazy"),
            'sql'                     => "int(10) unsigned NOT NULL"
        ),
		'tstamp' => array
		(
            'label'                   => &$GLOBALS['TL_LANG']['tl_core_project_snapshot']['created'],
            'inputType'               => 'text',
            'eval'                    => array
            (
                'rgxp'                => 'date',
                'readonly'            => true,
                'tl_class'            => 'w50',

            ),
            'exclude'                 => true,
            'filter'                  => true,
            'sorting'                 => true,
            'flag'                    => 8,
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_core_project_snapshot']['title'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array
            (
                'mandatory'           => true,
                'maxlength'           => 255,
                'tl_class'            => 'w50'
            ),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
        'dump' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_core_project_snapshot']['dump'],
            'inputType'               => 'table',
            'eval'                  => array
            (
                // A list of fields to be displayed in the table
                'fields' => array('title', 'description'),

                // Header fields of the table (leave empty to use labels)
                'headerFields' => array('Name', 'Beschreibung'),

                // Use the callback to generate the list
                'listCallback' => array('tl_core_project_snapshot', 'generateList'),
            ),
            'sql'                     => 'blob NULL'
        )
	)
);


class tl_core_project_snapshot extends Backend
{

    public function onLoad(DC_Table $container){

        $isAllowed = false;
        $act = \Input::get('act');
        if (!$act || $act=="create"){
            $isAllowed = \Dreebit\BackendUserAcl::getInstance()->isAllowedForProject(Input::get('id'));
        }else {
            $isAllowed = \Dreebit\BackendUserAcl::getInstance()->isAllowedForRequirement(Input::get('id'));
        }


//        echo '<pre>'; var_dump($isAllowed);die;
        if (!$isAllowed){
            Backend::redirect('contao/main.php?act=error');
        }


        if (\Input::get('act')=='edit'){
            $snapshot = \Dreebit\CoreProjectSnapshotModel::findOneBy('id',$container->id);
            if (!$snapshot->dump){
                //Initialisierung
                $pid = NULL;
                if (!$snapshot){
                    $pid = \Input::get('pid');
                }else {
                    $pid = $snapshot->pid;
                }
                $requirements = CoreRequirementModel::findByProject($pid)->fetchAll();
                foreach ($requirements as &$requirement) {
                    $requirement['testCases'] = unserialize($requirement['testCases']);
                    $requirement['prerequisite'] = unserialize($requirement['prerequisite']);
                    $requirement['influenceTo'] = unserialize($requirement['influenceTo']);
                    $requirement['files'] = unserialize($requirement['files']);
                }
                $snapshot->dump = serialize($requirements);
                $snapshot->tstamp = time();
                $snapshot->save();
            }
            else {
//                echo '<pre>'; var_dump($snapshot);die;
            }
        } elseif (\Input::get('act')=='download'){

            $this->download(\Dreebit\CoreProjectSnapshotModel::findByPk($container->id));
        }


    }

    public function generateList(){

        $strReturn = '';

        $snapshot = \Dreebit\CoreProjectSnapshotModel::findOneBy('id',\Input::get('id'));
        $requirements = unserialize($snapshot->dump);
        return $requirements;
        echo '<pre>'; var_dump($requirements);die();
        while ($objRecords->next()) {
            $strReturn .= '<li>' . $objRecords->name . ' (ID: ' . $objRecords->id . ')' . '</li>';
        }

        return '<ul id="sort_' . $strId . '">' . $strReturn . '</ul>';

    }

    /**
     * Add the type of input field
     * @param array
     * @return string
     */
    public function listSnapshots($arrRow)
    {

        $date = Date::parse($GLOBALS['TL_CONFIG']['dateFormat'], $arrRow['tstamp']);

        return '<div class="tl_content_left">' . $arrRow['title'] . ' <span style="color:#b3b3b3;padding-left:3px">[' . $date . ']</span></div>';
    }

    /**
     * @param \Dreebit\CoreProjectSnapshotModel $snapshot
     */
    private function download(\Dreebit\CoreProjectSnapshotModel $snapshot){

        $project = $snapshot->getRelated('pid',array('return'  => 'Collection'));
        $snapshotArray = $snapshot->row();
        $snapshotArray["requirements"] = unserialize($snapshot->dump);
        $snapshotArray["date"] = $date = Date::parse($GLOBALS['TL_CONFIG']['dateFormat'], $snapshot->tstamp);

        $params = array
        (
            "project"   => $project->row(),
            "snapshot"  => $snapshotArray
        );

//        echo '<pre>'; var_dump($params);die;

        $template = new \TwigTemplate("be_pdf_project_snapshot");
        $template->setFileExtension('html5');
        $strBuffer = $template->parse($params);

//        echo $strBuffer;die;
        $dompdf = new \ContaoDOMPDF();
        $dompdf->load_html($strBuffer);
        $dompdf->render();
        $dompdf->stream("snapshot.pdf");
//        echo '<pre>'; var_dump($dompdf);die;

    }
}