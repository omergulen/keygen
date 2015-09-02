<?php

function make($name)
{
	global $generators;
	
	return $generators[$name]['function']();
}

function random($length = 9, $add_dashes = false, $available_sets = 'luds')
{
	$sets = array();
	if(strpos($available_sets, 'l') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'd') !== false)
		$sets[] = '23456789';
	if(strpos($available_sets, 's') !== false)
		$sets[] = '!@#$%&*?';
	$all = '';
	$password = '';
	foreach($sets as $set)
	{
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}
	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
		$password .= $all[array_rand($all)];
	$password = str_shuffle($password);
	if(!$add_dashes)
		return $password;
	$dash_len = floor(sqrt($length));
	$dash_str = '';
	while(strlen($password) > $dash_len)
	{
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}
	$dash_str .= $password;
	return $dash_str;
}

$generators = [
	'password' => [
		'name' => 'Decent Password',
		'function' => function() {
			return random(10, false, 'lud');
		},
	],
	'strongpassword' => [
		'name' => 'Strong Password',
		'function' => function() {
			return random(15);
		},
	],
	'codeigniter' => [
		'name' => 'CodeIgniter Encryption Key',
		'function' => function() {
			return random(32);
		},
	],
	'laravel' => [
		'name' => 'Laravel Encryption Key',
		'function' => function() {
			return random(32);
		},
	],
];
