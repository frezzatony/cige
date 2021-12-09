<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['modules_depends'] = array(
    'permissions',
    'cadastros',
    'logger'
);

$config['actions'] = array(
    'viewItems'     =>  20,
    'editItems'     =>  21,
);

$config['module_path'] = 'modulos';
$config['log_schema'] = 'sistema';

$config['uri_segment'] = 'modulos/modulos';
$config['uri_segment_item'] = 'item';

$config['url_new_element']     =   BASE_URL.'modulos/modulos/view/';
$config['url_view_element']     =   BASE_URL.'modulos/modulos/view/id/{id_element}';