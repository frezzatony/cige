<?php

/**
 * @author Tony Frezza

 */


class Month_bsform extends Bsform_defaults
{


    public function getDataHtml($arrProp = array())
    {

        $arrReturn = array('tag' => 'input', 'type' => 'month');

        $arrReturn = array_merge($arrReturn, $arrProp);

        return $arrReturn;

    }
}

?>