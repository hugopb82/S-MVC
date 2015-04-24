<?php
	define('ROOT', dirname(dirname(__DIR__)) . '/');
	define('BASE_URL', dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))) . '/');

	require(ROOT . 'App/App.php');
	
	// If you don't want to use the router delete those 3 lines...
	require(ROOT . 'Kernel/Router.php');
	Router::any('/view', 'post#view()');
	Router::notFound('error#error()');
	
	App::boot();