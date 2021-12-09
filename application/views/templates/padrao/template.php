<?php 

/**
 * @author Tony Frezza
 */


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$pathTemplate = 'templates/padrao/';


$navigationDada = array(
    'mainMenu'  =>  $this->menus->getMainMenu(),
);

$breadcrumbData = array(
    'actionButtonsRight'    =>  $this->menus->getActionButtonsRight()
);

$this->load->view($pathTemplate.'header');
$this->load->view($pathTemplate.'navbar',$navigationDada);
$this->load->view($pathTemplate.'abre_main');
$this->load->view($pathTemplate.'breadcrumb',$breadcrumbData);
$this->load->view($pathTemplate.'abre_contents');
$this->load->view($pathTemplate.'contents');
$this->load->view($pathTemplate.'fecha_contents');
$this->load->view($pathTemplate.'fecha_main');
$this->load->view($pathTemplate.'footer');

?>