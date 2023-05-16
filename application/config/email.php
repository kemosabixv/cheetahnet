<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'mail.codezuka.com', 
    'smtp_port' => 26,
    'smtp_user' => 'sync@codezuka.com',
    'smtp_pass' => '0@Ldiw)+rsN0',
    'smtp_crypto' => '', //can be 'ssl' or 'tls' for example
    'mailtype' => 'text', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4', //in seconds
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
);