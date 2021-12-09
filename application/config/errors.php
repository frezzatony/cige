<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['errors'] = array(
    0=>null,
    1=>array(   //libraries\Token.php | checkToken()
        'message'           =>  'Tempo de vida do token',
        'security_threat'   =>  true,
    ),       
    2=>array(   //libraries\Token.php | checkToken()
        'message'           =>  'Token inexistente',
        'security_threat'   =>  true,
    ),            
    3=>array(   //models\form\Form_model.php | saveForm()
        'message'           =>  'Formulário inexistente',
        'security_threat'   =>  true,
    ),
    4=>array(   //models\form\Form_model.php | saveForm()
        'message'           =>  'O formulário requisita campos que não foram enviados',
        'security_threat'   =>  true,
    ),
);

?>