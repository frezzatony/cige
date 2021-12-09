<?php

/**
 * @author Tony Frezza

 */


class Url_bsform extends Bsform_defaults
{


    public function getDataHtml($arrProp = array())
    {

        $arrReturn = array('tag' => 'input', 'type' => 'url');

        $arrReturn = array_merge($arrReturn, $arrProp);

        return $arrReturn;

    }
}

?>