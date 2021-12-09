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


$config['module_path'] = 'controllers';
$config['log_schema'] = 'sistema';

$config['uri_segment'] = 'controllers/permissoes-acoes-controllers';
$config['uri_segment_item'] = 'item';

$config['url_new_element']      =   BASE_URL.'controllers/permissoes-acoes-controllers/view';
$config['url_view_element']     =   BASE_URL.'controllers/permissoes-acoes-controllers/view/id/{id_element}';