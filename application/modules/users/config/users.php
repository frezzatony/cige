<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['modules_depends'] = array(
    'cadastros',
);


$config['actions'] = array(
    'viewItems'     =>  20,
    'editItems'     =>  21,
);


$config['module_path'] = 'users';
$config['schema'] = 'usuarios';

$config['uri_segment'] = 'users/users';

$config['url_new_element']     =   BASE_URL.'users/users/view';
$config['url_view_element']     =   BASE_URL.'users/users/view/id/{id_element}';