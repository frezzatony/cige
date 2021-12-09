<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['smtp'] = array(

    'smtp_auth'     =>  TRUE, //TRUE: Habilita login por SMTP Server,
    'domain'        =>  '',
    'server'        =>  '',
    'port'          =>  '',
    'tls'           =>  FALSE,
    'connection'    =>  'IMAP', //IMAP, POP, ...
    'ssl'           =>  FALSE,
    'seccure'       =>  FALSE,
);