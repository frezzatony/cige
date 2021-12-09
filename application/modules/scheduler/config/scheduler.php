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

$config['module_path'] = 'scheduler';
$config['log_schema'] = 'sistema';

$config['uri_segment'] = 'scheduler';

$config['url_new_element']     =   BASE_URL.'scheduler/view/';
$config['url_view_element']     =   BASE_URL.'scheduler/view/id/{id_element}';
