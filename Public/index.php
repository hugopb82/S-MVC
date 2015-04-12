<?php
	define('ROOT', dirname(__DIR__) . '/');
	define('BASE_URL',dirname(dirname($_SERVER['SCRIPT_NAME'])) . '/');

	require(ROOT . 'App/App.php');
	App::boot();