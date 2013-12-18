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
$GLOBALS['TL_DCA']['tl_core_requirement'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'enableVersioning'            => true,
        'ptable'                      => 'tl_core_project',
        'ctable'                      => array('tl_core_sub_requirement'),
        'onload_callback'             => array(array("tl_core_requirement","onLoad")),
        'onsubmit_callback'           => array(array("tl_core_requirement","onSubmit")),
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
        'default'                     => \Dreebit\BackendUserAcl::getInstance()->getPalletsForUser()
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
            'foreignKey'              => 'tl_core_project.id',
            'relation'                => array("type"=>"belongsTo","load"=>"lazy"),
            'sql'                     => "int(10) unsigned NOT NULL"
        ),
        'title' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_core_requirement']['title'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array
            (
                'mandatory'           => true,
                'maxlength'           => 255,
                'critical'            => true
            ),
            'sql'                     => "varchar(255) NOT NULL default ''",
//            'save_callback'           => array(array('tl_core_requirement','onTitleFieldChange'))
        ),
        'description' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_core_requirement']['description'],
            'exclude'                 => true,
            'eval'                    => array
            (
                'mandatory'           => false,
                'style'               => 'height: 100px',
                'critical'            => true
            ),
            'inputType'               => 'textarea',
            'sql'                     => "text NOT NULL",
//            'save_callback'           => array(array('tl_core_requirement','onDescriptionFieldChange'))
        ),
        'category' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_core_requirement']['category'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'eval'                    => array
            (
                'mandatory'           => false,
                'tl_class'            => 'w50',
                'includeBlankOption'  => true,
                'critical'            => true
            ),
            'foreignKey'              => 'tl_core_category.title',
            'relation'                => array("type"=>"hasOne","load"=>"lazy"),
            'sql'                     => "int(10) unsigned NOT NULL",
//            'save_callback'           => array(array('tl_core_requirement','onCategoryFieldChange'))
        ),
        'state' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_core_requirement']['state'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'options'                 => array('open','waiting_for_supplier','waiting_for_customer','approved','valid','rejected'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_core_requirement']['states'],
            'eval'                    => array
            (
                'tl_class'            => 'w50',
                'disabled'            => !BackendUser::getInstance()->isAdmin
            ),
            'sql'                     => "enum('open','waiting_for_supplier','waiting_for_customer','approved','valid','rejected') NOT NULL default 'open'"
        ),
        'acceptButton' => array
        (
            'input_field_callback'    => array('tl_core_requirement','onAcceptButtonRender')
        ),
        'steakholder' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_core_requirement']['steakholder'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array
            (
                'mandatory'           => false,
                'maxlength'           => 255,
                'tl_class'            => 'w50',
                'critical'            => true
            ),
            'sql'                     => "varchar(255) NULL",
//            'save_callback'           => array(array('tl_core_requirement','onSteakholderFieldChange'))
        ),
        'testCases' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_core_requirement']['testCases'],
            'inputType'               => 'listWizard',
            'eval'                    => array
            (
                'critical'            => true
            ),
            'sql'                     => "blob NULL",
//            'save_callback'           => array(array('tl_core_requirement','onTestCasesFieldChange'))
        ),
        'prerequisite' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_core_requirement']['prerequisite'],
            'inputType'               => 'checkboxWizard',
            'options_callback'        => array("tl_core_requirement","getPrerequisiteOptions"),
            'eval'                    => array
            (
                'mandatory'           => false,
                'multiple'            => true,
                'tl_class'            => 'w50',
                'critical'            => true
            ),
            'sql'                     => "blob NULL",
//            'save_callback'           => array(array('tl_core_requirement','onPrerequisiteFieldChange'))
        ),
        'influenceTo' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_core_requirement']['influenceTo'],
            'inputType'               => 'checkboxWizard',
            'options_callback'        => array("tl_core_requirement","getInfluenceToOptions"),
            'eval'                    => array
            (
                'mandatory'           => false,
                'multiple'            => true,
                'tl_class'            => 'w50',
                'critical'            => true
            ),
            'sql'                     => "blob NULL",
//            'save_callback'           => array(array('tl_core_requirement','onInfluenceToFieldChange'))
        ),
        'files' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_core_requirement']['files'],
            'inputType'               => 'fileTree',
            'eval'                    => array
            (
                'mandatory'            =>false,
                'multiple'             =>true,
                'fieldType'            => 'checkbox',
                'files'                => true,
                'filesOnly'            => true,
                'critical'            => true
            ),
            'sql'                     => "blob NULL",
//            'save_callback'           => array(array('tl_core_requirement','onFilesFieldChange'))
        ),
        'sub_requirements' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_core_requirement']['sub_requirements'],
            'inputType'             => 'dcaWizard',
            'foreignTable'          => 'tl_core_sub_requirement',
            'eval'                  => array
            (
                'fields' => array('title','description'),
                'headerFields' => array('Title','Beschreibung'),
                // Use a custom label for the edit button
                'editButtonLabel' => $GLOBALS['TL_LANG']['tl_core_requirement']['edit'],
                // Use a custom label for the apply button
                'applyButtonLabel' => $GLOBALS['TL_LANG']['tl_core_requirement']['apply'],
                'orderField' => "title DESC"
            )
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

if (\Input::get('act') == 'edit' && \Input::get('id')){
    $GLOBALS['TL_DCA']['tl_core_requirement']['input_cache'] = \Dreebit\CoreRequirementModel::findOneBy('id',intval(\Input::get('id')));
}


class tl_core_requirement extends Backend
{
    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function onLoad(DC_Table $container)
    {

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


    }


    public function onSubmit(DC_Table $container){

        $requirement = \Dreebit\CoreRequirementModel::findOneBy('id',$container->id);
        if (\Input::post('acceptButton')){
            /**
             * Änderung des Status einer Anforderung durch Kunden oder Zulieferer
             * Welcher Status gesetzt wird, wird aus dem Übergabeparameter des Buttons gelesen
             */

            $requirement->state = \Input::post('acceptButton');

        }

        //Check ob sich kritische Felder verändert haben

        $preRequirement = $GLOBALS['TL_DCA']['tl_core_requirement']['input_cache'];
        foreach ($_POST as $key => $value) {
            $compare = $preRequirement->{$key};
            if ($key == "testCases" || $key == "prerequisite" || $key == "influenceTo"){
                $compare = unserialize($compare);

            }
            if ($key == 'files'){

                $compare = unserialize($compare);
                foreach ($compare as &$item){
                    $item = String::binToUuid($item);
                }

                $value = explode(',',$value);
            }

            if ($GLOBALS['TL_DCA']['tl_core_requirement']['fields'][$key]['eval']['critical']){
                if ($value != $compare){
                    $requirement->state = 'open';
                }
            }


        }
        //

        $requirement->save();
    }

    public function onTitleFieldChange($var, DC_Table $container){

        $requirement = \Dreebit\CoreRequirementModel::findOneBy('id',$container->id);
        if ($var != $requirement->title){
            $this->onCriticalFieldChange($container);
        }
        return $var;
    }

    public function onDescriptionFieldChange($var, DC_Table $container){

        $requirement = \Dreebit\CoreRequirementModel::findOneBy('id',$container->id);
        if ($var != $requirement->description){
            $this->onCriticalFieldChange($container);
        }
        return $var;
    }

    public function onCategoryFieldChange($var, DC_Table $container){

        $requirement = \Dreebit\CoreRequirementModel::findOneBy('id',$container->id);
        if ($var != $requirement->category){
            $this->onCriticalFieldChange($container);
        }
        return $var;

    }

    public function onSteakholderFieldChange($var, DC_Table $container){

        $requirement = \Dreebit\CoreRequirementModel::findOneBy('id',$container->id);
        if ($var != $requirement->steakholder){
            $this->onCriticalFieldChange($container);
        }
        return $var;

    }

    public function onTestCasesFieldChange($var, DC_Table $container){

        $requirement = \Dreebit\CoreRequirementModel::findOneBy('id',$container->id);
        if ($var != $requirement->testCases){
            $this->onCriticalFieldChange($container);
        }
        return $var;

    }

    public function onCriticalFieldChange(DC_Table $container){


        $requirement = \Dreebit\CoreRequirementModel::findOneBy('id',$container->id);
        if ($requirement->state != 'rejected' && $requirement->state != 'valid'){
            $requirement->state = 'open';
        }
        $requirement->save();

    }

    /**
     * Rendert den Submit Button und übermittelt den neuen Status als form Submit
     * @param DC_Table $container
     * @param $name
     * @return string
     */
    public function onAcceptButtonRender(DC_Table $container, $name){

        if (\BackendUser::getInstance()->isAdmin){
            return '<div class="w50"></div>';
        }

        $requirement = \Dreebit\CoreRequirementModel::findOneBy('id',$container->id);
        $project = \Dreebit\CoreProjectModel::findOneBy('id',$requirement->pid);
//        echo '<pre>'; var_dump($project);die;

        $textIdentifier = $requirement->state;  // Definiert den Key für Übersetzungen
        $value = "";                            // Wert, der über submit versendet wird (zu setztender Status)
        $disabled = "disabled";                 // Verhindert submit des Buttons
        $class = $requirement->state;

        if (\BackendUser::getInstance()->isMemberOf($project->supplier) AND ($requirement->state == "open" || $requirement->state == "waiting_for_supplier")){

            $value = $requirement->state == "open" ? "waiting_for_customer" : "approved";
            $disabled = "";
            $textIdentifier = 'open';

        }else if (\BackendUser::getInstance()->isMemberOf($project->customer) AND ($requirement->state == "open" || $requirement->state == "waiting_for_customer")){

            $value = $requirement->state == "open" ? "waiting_for_supplier" : "approved";
            $disabled = "";
            $textIdentifier = 'open';

        }

        $label = &$GLOBALS['TL_LANG']['tl_core_requirement']['acceptButton'][$textIdentifier][0];
        $description = &$GLOBALS['TL_LANG']['tl_core_requirement']['acceptButton'][$textIdentifier][1];
        $text = &$GLOBALS['TL_LANG']['tl_core_requirement']['acceptButton'][$textIdentifier][2];


        return '
            <div class="w50">
              <h3><label>'.$label.'</label></h3>
              <button type="submit" name="acceptButton" id="acceptButton" class="tl_submit button '.$class.' '.$disabled.'" accesskey="s" value="'.$value.'" '.$disabled.'>'.$text.'</button>
              <p class="tl_help tl_tip" title="">'.$description.'</p>
            </div>
        ';
    }

    public function getInfluenceToOptions(){
        return $this->getProjectRequirements();
    }

    public function getPrerequisiteOptions(){
        return $this->getProjectRequirements();
    }

    /**
     * Generate a list of prices for a wizard in products
     * @param object
     * @param string
     * @return string
     */
    public function generateWizardList($objRecords, $strId)
    {
        $strReturn = '';

        while ($objRecords->next()) {
            $strReturn .= '<li>' . $objRecords->title . ' (ID: ' . $objRecords->id . ')' . '</li>';
        }

        return '<ul id="sort_' . $strId . '">' . $strReturn . '</ul>';
    }

    private function getProjectRequirements(){

        $values = array();


        $requirement = $this->Database->prepare("SELECT id, pid FROM tl_core_requirement WHERE id=?")
            ->execute(intval(\Input::get('id')))
            ->first();

        $objPages = $this->Database->prepare("SELECT tl_core_requirement.id, tl_core_requirement.title FROM tl_core_project INNER JOIN tl_core_requirement ON tl_core_project.id =tl_core_requirement.pid WHERE tl_core_requirement.pid=? AND tl_core_requirement.id!=?")
            ->execute($requirement->pid,$requirement->id);
        if ($objPages->numRows < 1)
        {
            return $values;
        }

        //Array erzeugen
        while($objPages->next())
        {
            $values[$objPages->id] = '<a href="contao/main.php?do=projects&table=tl_core_requirement&act=edit&id='.$objPages->id.'&rt='.\Input::get('rt').'">'.$objPages->title.'</a>';
        }



        return $values;
    }

    public function onReleaseButtonCallback(DataContainer $container){
        //echo '<pre>'; var_dump($container);die;
    }

}