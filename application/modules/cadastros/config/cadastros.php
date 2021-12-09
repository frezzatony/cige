<?php

/**
 * @author Tony Frezza

 */

$config['modules_depends'] = array(
    'logger',
);

$config['module_path'] = 'cadastros';

$config['uri_segment'] = 'cadastros';
$config['uri_segment_item'] = 'item';

$config['icon'] = 'list-alt';
$config['plural_description']   = 'Cadastros';
$config['singular_description']   = 'Cadastro';



$config['db_schema'] = 'cadastros';
$config['table_control'] = 'sistema.controllers';
$config['table_permissions'] = 'sistema.permissoes_controllers';

$config['table_control_pk_column'] = 'id';
$config['table_control_active_column'] = 'ativo';
$config['table_control_columns'] = array(
    'id','descricao_singular','descricao_plural','abreviatura','ativo','form::json','javascript'
);

    
$config['table_values_pk_column'] = 'id';
$config['table_values_column_fk_table_sections'] = 'entidade_secoes_id';
$config['table_permissions_column_fk_table_control'] = 'sistema_cadastros_id';
$config['table_permissions_column_fk_table_groups'] = 'usuarios_grupos_id';
$config['table_permissions_column_fk_table_sections'] = 'entidade_secoes_id';
$config['table_permissions_column_fk_table_permissions'] = 'sistema_permissoes_id';

$config['db_log_schema'] = 'cadastros';
$config['db_log_sufix'] = 'logs';


$config['url_view_element']     =   BASE_URL.'{modulo}/{url_cadastro}/view/id/{id_element}';
$config['url_save_element']     =   BASE_URL.'{modulo}/{url_cadastro}/save';


?>