<?php

function make($name)
{
	global $generators;
	
	if (!isset($generators[$name])) return;
	
	return $generators[$name]['function']();
}

function random($length = 9, $add_dashes = false, $available_sets = 'luds', $special_chars = '!@#$%&*?')
{
	$sets = array();
	if(strpos($available_sets, 'l') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'd') !== false)
		$sets[] = '23456789';
	if(strpos($available_sets, 's') !== false)
		$sets[] = $special_chars;
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

function generateRandomWPAKey($bits) {
	$in_bits = array('160', '504');
    if (in_array($bits, $in_bits)) {
	    $buytes = $bits/8;
	    $WPAKey = 'NipPBM4AQkqCI5ThDOxJ6GocFKzjsd9SLbWXfR8Z1ywV72t3UmvEa0HeugnrlY';
		$key = substr(str_shuffle($WPAKey), 0, $buytes);
	    return $key;
    }else{
    	return null;
    }
}
function generateRandomWEPKey($bits) {
	$in_bits = array('64', '128','152', '256');
    if (in_array($bits, $in_bits)) {
		$buytes = $bits/8;
	    $WEPKey = 'APWNZFpn8VYU5aOiMj9mvkH37hXd4T0btIgzf6JGeRBDCQ2rEs1lSwyKuoqLcx';
		return substr(str_shuffle($WEPKey), 0, $buytes);
    }else{
    	return null;   
    }
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
	'verystrongpassword' => [
		'name' => 'Very Strong Password',
		'function' => function() {
			return random(30);
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
			return random(32, false, 'lud');
		},
	],
	'wordpress' => [
		'name' => 'Wordpress Key',
		'function' => function() {
			return random(64, false, 'luds', '$!#%&/()=*@-_.:,; <>');
		}
	],
	'wpa160' => [
		'name' => 'WPA 160-bit Key',
		'function' => function() {
			return generateRandomWPAKey(160);
		}
	],
	'wpa504' => [
		'name' => 'WPA 504-bit Key',
		'function' => function() {
			return generateRandomWPAKey(504);
		}
	],
	'wep64' => [
		'name' => 'WEP 64-bit Key',
		'function' => function() {
			return generateRandomWEPKey(64);
		}
	],
	'wep128' => [
		'name' => 'WEP 128-bit Key',
		'function' => function() {
			return generateRandomWEPKey(128);
		}
	],
	'wep152' => [
		'name' => 'WEP 152-bit Key',
		'function' => function() {
			return generateRandomWEPKey(152);
		}
	],
	'wep256' => [
		'name' => 'WEP 256-bit Key',
		'function' => function() {
			return generateRandomWEPKey(256);
		}
	],
];
