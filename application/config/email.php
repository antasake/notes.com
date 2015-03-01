<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$config['charset'] = 'iso-8859-1';
$config['wordwrap'] = TRUE;
*/
/*
$config['protocol'] = 'smtp';
$config['smtp_host']='ssl://smtp.gmail.com';
$config['smtp_user']='anta.sakellariou@gmail.com';
$config['smtp_pass']='ir0nmaiden';
$config['smtp_port']='465';
*/

$config = Array(
		'protocol' => 'smtp',
		'smtp_host' => 'ssl://smtp.googlemail.com',
		'smtp_port' => 465,
		'smtp_user' => 'demiantests@gmail.com',
		'smtp_pass' => 'demian123',
		'mailtype' => 'html',
		'charset'	 => 'utf-8',
		'wordwrap'	 => TRUE,
		'wrapchars'	=> "152",
		'newline'	=> "\r\n",
		'crlf'		=> "\r\n"
);
/* End of file config.php */
/* Location: ./application/config/config.php */ 