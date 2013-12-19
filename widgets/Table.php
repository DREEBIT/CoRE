<?php

/**
 * DREEBIT CoRE for Contao Open Source CMS
 *
 * Copyright (C) 2013-1014 DREEBIT GmbH
 *
 * @package    Dreebit
 */

namespace Contao;


/**
 * Class Table
 *
 * Back end widget "Table".
 * @copyright  Dreebit GmbH
 * @author     Toni Moeckel
 */



class Table extends \Widget
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'be_widget';


    /**
     * Initialize the object
     * @param array
     */
    public function __construct($arrAttributes = false)
    {
        parent::__construct($arrAttributes);

    }


    /**
     * Generate the widget
     * @return string
     */
    public function generate()
    {

        if ($this->doNotShow){
            return '';
        }

        $items = \System::importStatic($this->listCallback[0])->{$this->listCallback[1]}();
        if (is_array($items)){

            $params = array(
                "headers"   => $this->headerFields,
                "fields"    => $this->fields,
                "items"     => $items
            );

            $template = new \TwigTemplate("be_widget_table");
            $template->setFileExtension('html5');
            $strBuffer = $template->parse($params);

            return $strBuffer;
        }else {
            return "Keine Daten vorhanden";
        }

        return '';
    }

}
