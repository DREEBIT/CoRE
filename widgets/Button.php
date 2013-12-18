<?php

/**
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2009-2012 Isotope eCommerce Workgroup
 *
 * @package    Isotope
 * @link       http://www.isotopeecommerce.com
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 */

namespace Contao;


/**
 * Class DcaWizard
 *
 * Back end widget "dca wizard".
 * @copyright  Isotope eCommerce Workgroup 2009-2012
 * @author     Yanick Witschi <yanick.witschi@terminal42.ch>
 * @author     Andreas Schempp <andreas.schempp@terminal42.ch>
 * @author     Christian de la Haye <service@delahaye.de>
 * @author     Kamil Kuzminski <kamil.kuzminski@codefog.pl>
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
//        echo '<pre>'; var_dump($this);die;

    }


    /**
     * Add specific attributes
     * @param string
     * @param mixed
     */
    public function __set($strKey, $varValue)
    {
        parent::__set($strKey, $varValue);
    }


    /**
     * Return a parameter
     * @return string
     * @throws Exception
     */
    public function __get($strKey)
    {
        return parent::__get($strKey);
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
