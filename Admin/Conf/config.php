<?php
$dbconfig	=	require './Config/dbconfig.inc.php';
$dictconfig	=	require './Config/dictconfig.inc.php';
$menuconfig	=	require './Config/menuconfig.inc.php';

$config	= array(
	'DOMAIN'				=>	'http://localhost/job/',
	'TMPL_ACTION_ERROR'		=>	'Public:error',
	'TMPL_ACTION_SUCCESS'	=>	'Public:success',
	'SESSION_AUTO_START' 	=> 	true,
	'SESSION_PREFIX'		=>	'Admin',
	'DEFAULT_AJAX_RETURN'	=>	'JSON',
	'TMPL_PARSE_STRING'		=>	array(
		 '__JS__'			=> 	__ROOT__.'/Public/Js/',
		 '__CSS__' 			=>	__ROOT__.'/Public/Css/',
		 '__IMAGE__'		=>	__ROOT__.'/Public/Images/',
		 '__UPLOAD__'		=>	__ROOT__.'/Upload/',
	),
	'UPLOAD_PATH'			=>	'./Upload/',
);
return array_merge($config,$dbconfig,$menuconfig,$dictconfig);
?>?>