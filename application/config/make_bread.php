<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// $config['include_home'] will tell the library if the first element should be the homepage. You only put the title of the first crumb. If you leave it blank it will not put homepage as first crumb
$config['href_class']   =   'load-page';
$config['include_home'] = '<i class="fa fa-home"></i>';
// $config['divider'] is the divider you want between the crumbs. Leave blank if you don't want a divider;
$config['divider'] = '';
// $config['container_open'] is the opening tag of the breadcrumb container
$config['container_open'] = '<ol class="breadcrumb2 ">';
// $config['container_close'] is the closing tag of the breadcrumb container
$config['container_close'] = '</ol>';
// $config['crumb_open'] is the opening tag of the crumb container
$config['crumb_open'] = '<li class="breadcrumb-item">';
// $config['crumb_close'] is the closing tag of the crumb container
$config['crumb_close'] = '</li>';