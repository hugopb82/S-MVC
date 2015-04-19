<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?= Config::get('site', 'title'); ?></title>
		<!--[if IE]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
	 	<h1>Another MVC framework</h1>
	 	
	 	<?= $content ?>
	</body>
</html>