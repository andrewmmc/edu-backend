<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol'] = 'smtp';
$config['mailpath'] = '/usr/sbin/sendmail';
$config['charset'] = 'iso-8859-1';
$config['wordwrap'] = TRUE;

$config['smtp_host'] = 'localhost';
$config['smtp_port'] = 25;
$config['smtp_timeout'] = '5';

$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['mailtype'] = 'html'; // or html
$config['send_multipart'] = FALSE;
$config['parameter_spacing'] = FALSE;

//$config['validation'] = TRUE; // bool whether to validate email or not
?>
