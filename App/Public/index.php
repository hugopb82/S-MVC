<?php
	define('ROOT', dirname(dirname(__DIR__)) . '/');
	define('BASE_URL', dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))) . '/');

	require(ROOT . 'App/App.php');

	$app = new App();
	$app->boot();

	// If you don't want to use the router delete those 3 lines...
	$router = new \Kernel\Router(\Kernel\Request::getUrl(), 'mixed');
  $router->get('/', function(){
    echo "hello world ";
  });
	$router->get('/post/{int:id}', 'post#view')->verify('$id > 4');
  $router->load();
