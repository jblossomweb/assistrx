<?php
if (!isset($_SERVER['argc'])){
	$domain_pieces = explode('.',$_SERVER['HTTP_HOST']);
	switch($domain_pieces[0]){
		case 'local':
			define('ENVIRONMENT', 'local');
			break;
		case 'dev':
			define('ENVIRONMENT', 'development');
			break;
		case 'qa':
			define('ENVIRONMENT', 'qa');
			break;
		case 'www':
			define('ENVIRONMENT', 'production');
			break;
		case 'demo':
			define('ENVIRONMENT', 'demo');
			break;
		default:
			define('ENVIRONMENT', 'local');
	}
} else {
	//this is coming from CLI, and we have no HTTP_HOST
	$pwd_pieces = array_reverse(explode(DIRECTORY_SEPARATOR,$_SERVER['PWD']));
	switch($pwd_pieces[0]){
		case 'assistrx':
			define('ENVIRONMENT', 'local');
			$_SERVER['CLI_HTTP_HOST'] = 'local.arxtest.com';
			break;
		case 'dev':
			define('ENVIRONMENT', 'development');
			$_SERVER['CLI_HTTP_HOST'] = 'dev.arxtest.com';
			break;
		case 'qa':
			define('ENVIRONMENT', 'qa');
			$_SERVER['CLI_HTTP_HOST'] = 'qa.arxtest.com';
			break;
		case 'arxtest':
			define('ENVIRONMENT', 'production');
			$_SERVER['CLI_HTTP_HOST'] = 'www.arxtest.com';
			break;
		case 'demo':
			define('ENVIRONMENT', 'demo');
			$_SERVER['CLI_HTTP_HOST'] = 'demo.arxtest.com';
			break;
		default:
			define('ENVIRONMENT', 'local');
			$_SERVER['CLI_HTTP_HOST'] = 'local.arxtest.com';
	}
}

// jblossom: need to fudge webserver variable REMOTE_ADDR for graceful CLI
// CodeIgniter core bug: http://ellislab.com/forums/viewthread/227672/

if(!array_key_exists('REMOTE_ADDR', $_SERVER)){
	$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
}