<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Switcher_bsform extends Bsform_defaults
{

    protected $CI;

    function __construct()
    {

        parent::__construct();
        $this->CI = &get_instance();

    }

    function getInputDataHtml($arrInput = array()){

        return NULL;

    }

    function getInputValue($arrProp = array())
    {

    }

    /**
     * PRIVATES
     */
}

?>