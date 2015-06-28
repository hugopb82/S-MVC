<?php
	require('../App.php');

	$app = new App();

	$app->Router->setMode('mixed');

	$app->Router->get('/', function(){
		echo "hello world ";
	});
	$app->Router->get('/home', 'index@index');
	$app->Router->loadXML('../routes.xml');

	$app->boot();
