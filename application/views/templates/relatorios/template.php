<?php 

/**
 * @author Tony Frezza
 */


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$pathTemplate = 'templates/relatorios/';

$this->load->view($pathTemplate.'header');

echo $contents;

$this->load->view($pathTemplate.'footer');

?>