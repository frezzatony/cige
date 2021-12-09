<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['modules_depends'] = array(
    'permissions',
    'cadastros',
    'logger'
);

$config['actions'] = array(
    'viewItems'     =>  2,
    'editItems'     =>  1,
);

$config['module_path'] = 'controllers';
$config['log_schema'] = 'sistema';

$config['uri_segment'] = 'controllers';

$config['url_new_element']     =   BASE_URL.'controllers/view/';
$config['url_view_element']     =   BASE_URL.'controllers/view/id/{id_element}';
