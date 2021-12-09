<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');


$config['actions'] = array(
    'viewItems'     =>  20,
    'editItems'     =>  21,
);

$config['module_path'] = 'controllers';
$config['log_schema'] = 'sistema';

$config['uri_segment'] = 'controllers/tipos-controllers';
$config['uri_segment_item'] = 'item';

$config['url_new_element']     =   BASE_URL.'controllers/tipos-controllers/view';
$config['url_view_element']     =   BASE_URL.'controllers/tipos-controllers/view/id/{id_element}';