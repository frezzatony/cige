<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



$config['modules_depends'] = array(
    'cadastros',
);

$config['actions'] = array(
    'viewItems'     =>  20,
    'editItems'     =>  21,
);

$config['module_path'] = 'entidades';
$config['log_schema'] = 'entidade';

$config['uri_segment'] = 'entidades/entidades';

$config['url_new_element']     =   BASE_URL.'entidades/entidades/view/';
$config['url_view_element']     =   BASE_URL.'entidades/entidades/view/id/{id_element}';

$config['register_data'] = array(
    'entity' =>  array()
);


