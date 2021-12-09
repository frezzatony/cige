<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['clauses'] = array(
    'contains','not_contains','equal','equal_date','equal_number','not_equal','less','less_or_equal','greater','greater_or_equal','between','not_between',
    'before_date','after_date','between_dates','not_between_dates',
    'begins_with','not_begins_with','ends_with','not_ends_with','is_empty','is_not_empty','is_null','notnull','in','not_in',
    'equal_bool','not_equal_bool'
);

$config['input_type_forms'] = array('bool','integer','textbox','number','date','year');
$config['input_type_forms_with_data'] = array('dropdown','externallist'); 
$config['input_type_forms_with_optgroup'] = array('grid','json');

?>