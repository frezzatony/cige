<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['uri_segment'] = 'entidade';

$config['register_data'] = array(
    'entity' =>  array()
);

$config['table_entities'] = 'entidade.entidades';
$config['column_pk']  = 'id';
$config['column_parent'] = 'entidade_entidades_id';
$config['table_permissions_column_pk']  = 'id';
$config['table_permissions_column_description']  = 'descricao';

