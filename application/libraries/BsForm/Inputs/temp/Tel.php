<?php

/**
 * @author Tony Frezza

 */


class Tel_bsform extends Bsform_defaults
{


    public function getDataHtml($arrProp = array())
    {

        $arrReturn = array('tag' => 'input', 'type' => 'tel');

        $arrReturn = array_merge($arrReturn, $arrProp);

        return $arrReturn;

    }
}

?>