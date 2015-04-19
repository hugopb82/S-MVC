<?php
	define('ROOT', dirname(dirname(__DIR__)) . '/');
	define('BASE_URL', dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))) . '/');

	require(ROOT . 'App/App.php');
	App::boot();