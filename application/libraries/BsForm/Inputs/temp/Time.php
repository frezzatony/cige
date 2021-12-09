<?php

/**
 * @author Tony Frezza

 */


class Time_bsform extends Bsform_defaults
{


    public function getDataHtml($arrProp = array())
    {

        $arrReturn = array('tag' => 'input', 'type' => 'time');

        $arrReturn = array_merge($arrReturn, $arrProp);

        return $arrReturn;

    }
}

?>