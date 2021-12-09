<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['modules_depends'] = array(
    'cadastros',
);

/*
$config['actions'] = array(
    'viewItems'     =>  20,
    'editItems'     =>  21,
);
*/

$config['module_path'] = 'users';
$config['log_schema'] = 'usuarios';

$config['uri_segment'] = 'users/profiles';

$config['url_new_element']     =   BASE_URL.'users/profiles/view';
$config['url_view_element']     =   BASE_URL.'users/profiles/view/id/{id_element}';