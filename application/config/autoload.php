<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$autoload['packages'] = array();

/*
$autoload['libraries'] = array(
    ATENÇÃO!!!!!!
    TODAS AS LIBRARIES DEVEM SER CARREGADAS NO MAIN_MODEL!!!!!!
);
*/


$autoload['drivers'] = array(
    'cache'
);


$autoload['helper'] = array(
    'array',
    'url',
    'string',
    'database',
    'common',
    'text',
    //'file'
);


$autoload['config'] = array(
    'sistema',
    'errors',   
    'db_errors', 
);


$autoload['language'] = array();


$autoload['model'] = array(
    'database',
    'main_model',
    'auth_model',
);