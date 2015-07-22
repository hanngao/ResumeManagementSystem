<?php
if (!defined('THINK_PATH')) exit();
return array(
	'MENU'	=>	array(
		array(
			'name' 	=>	'简历管理',
			'module'=>	'Resume',
			'child'	=>	array(
				array(
					'name' 	=>	'搜索简历',
					'action'=>	'search'
				),
				array(
					'name' 	=>	'处理简历',
					'action'=>	'handle'
				),
			),
		),
	)
);
?>