<?php

/**
 * @author Tony Frezza

 */


class Week_bsform extends Bsform_defaults
{


    public function getDataHtml($arrProp = array())
    {

        $arrReturn = array('tag' => 'input', 'type' => 'week');

        $arrReturn = array_merge($arrReturn, $arrProp);

        return $arrReturn;

    }
}

?>