<?php
	require('../App.php');

	$app = new App();

	$app->Router->get('/', 'index@index');

	$app->boot();
