<?php

/**
 * @author Tony Frezza

 */

/**
 * CodeIgniter PHPMailer Class
 *
 * This class enables SMTP email with PHPMailer
 *
 * @category    Libraries
 * @author      CodexWorld
 * @link        https://www.codexworld.com
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once APPPATH.'third_party/PHPMailer/Exception.php';
require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
require_once APPPATH.'third_party/PHPMailer/SMTP.php';

class PHPMailer_Lib extends PHPMailer
{
    public function __construct(){
        
                
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load(){
        
        // Include PHPMailer library files
        
        
        $mail = new PHPMailer;
        
        return $mail;
    }
}
?>