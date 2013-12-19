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
 * Class Button
 *
 * Back end widget "Button".
 * @copyright  Dreebit GmbH
 * @author     Toni Moeckel
 */
class Button extends \Widget
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

        if (!$this->text){
            $this->text = "TEXT";
        }

        if (!$this->submit_value){
            $this->submit_value = "button";
        }

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

        return '<button type="submit" name="'.$this->strName.'" id="'.$this->strId.'" class="tl_submit" accesskey="s" value="'.$this->submit_value .'">'.$this->text.'</button>';
    }

}
