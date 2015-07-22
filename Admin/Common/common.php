<?php
function formatDate($time)
{
	if($time == 0)
	{
		$time =	'至今'; 
	}else{
		$time = date("Y-m-d", $time);
	}
	return $time;
}

function getDictKey($dict, $value)
{
	$value = trim($value);
	$dict = array_flip(C($dict));
	$key = isset($dict[$value]) ? $dict[$value] : 1;
	return $key;
}

function getDictValue($dict, $key)
{
	$dict = C($dict);
	$value = $dict[$key];
	return $value;
}

function getSex($sex)
{
	return $sex ? '男' : '女';
}

function getBirthday($time)
{
	return date("Y年m月d日", $time);
}

function getAge($time)
{
	$age = date('Y',time()) - date('Y',$time);
	return $age;
}
?>