# S-MVC
**A simple, lightweight and customizable PHP MVC framwork**

### Requirements
This framwork has been tested on apache with php 5.5.9.
This framework uses **.htaccess** files. If you are on another web server (nginx, lighttpd) you must modify your webserver's config file to replace **.htaccess** role.

### Installation
1. Download the .zip file [here](https://github.com/hugopb82/S-MVC/archive/master.zip)
2. Extract it on your web server folder
3. Open your browser and go to your server adress. You will see an index page!

S-MVC is installed! You can now learn how to use it!

### Usage
To start a website you only need to create some files in *App/MVC* directory and change config file in *App/Config* directory.
You can also put your css, js files in *App/Public* directory.

####Configuration
####Set Config values

Once you have installed S-MVC, the first thing to do it's to configure your website.
**Config files are in the *App/Config* directory.**
You can use a **Config.ini** file or a **Config.php** file
##### With a .ini file
This file already exists and it contains some config values for example purpose.
Just modify what you want and add custom values :)
E.g :
```php
[DB]
	HOST = "yourhost"
	USER = "root"
	PASS = "root"
	TYPE = "mysql"
	NAME = "db_name"
[SITE]
	TITLE = "An amazing website"
```
##### With a .php file
/!\ This file doesn't exist by default.  If a **Config.ini** file exists the **Config.php** file will not be loaded! /!\

Create a **Config.php** file that return an array like this :
```php
<?php
	return array(
		"DB" => array(
			"HOST" => "localhost",
			"USER" => "root"
		)
	);
```
####Get Config values

In any file you can use this code :
```php
Config::get($prefix, $key);
// For e.g. :
Config::get('DB', 'HOST');
```

#### URL's and routing:
You can define some routes in the *App/Public/index.php* file
Examples of *App/Public/index.php* file :
```php
<?php
	require('../App.php');

	$app = new App();

	// Syntax :
	// $app->Router->method($path, $to_call);

	// Will call the index method of the index controller
	$app->Router->get('/', 'index@index');

	// Will call the index method of the index controller
	$app->Router->post('/', function(){
		echo 'Not allowed to do this sir';
	});

	// With parameters
	// Syntax : {type:name}
	// Types : int, all, slug
	$app->Router->get('/blog1/{int:id}','post@view');
	$app->Router->get('/blog2/{int:id}', function($id){
		echo 'article n' . $id;
	});

	//With conditions  
	$app->Router->get('/blog/{int:id}','post@view')->verify('$id > 0 && $id < 5');

	$app->boot();
```
You can also create an xml file like this one :
```xml
<routes>
    <route name="accueil">
        <method>GET</method>
        <url>/index</url>
        <action>index@index</action>
    </route>
    <route name="blog">
        <method>GET</method>
        <url>/blog</url>
        <action>post@index</action>
    </route>
</routes>
```
and load it in the *App/Public/index.php* file :
```
<?php
	require('../App.php');

	$app = new App();

	$app->Router->loadXML('path/to/your/xml.xml');

	$app->boot();
```
By default, if the router doesn't found any route it will try to load old url's style:
* yoursite.com/controller/method/param1/param2* ...
If the controller doesn't exists an error will appear.

If you don't want this behaviour and load only declared routes tou can change the router mode in the *App/Public/index.php* file:
```php
	// After $app = new App(); line

	// Only declared routes
	$app->Router->setMode('route');

	// Try routes, then try old style url's
	$app->Router->setMode('mixed');

	// Only old style url's
	$app->Router->setMode('old');
```


### Creating a new page :
You can create page in the *App/Public/index.php* file using closures in the Router but it's weird... I recommend you to use MVC file architecture !

To create a new page go to the *App/MVC/Controller* directory and create a new file called *nameController.php* where *name* is the name of your controller.

The basic structure for a controller is :
```php
<?php
	namespace App\MVC\Controller;

	use \Kernel\Controller;

	class indexController extends Controller{

		public function index(){
			echo 'index';
		}

	}
```
Then in the *App/Public/index.php* file you can add a route to call this controller :
```php
	$app->Router->get('/', 'index@index');
```

#### Passing parameters :

In your methods you can specify the parameters you want :
```php
<?php
	namespace App\MVC\Controller;

	use \Kernel\Controller;

	class indexController extends Controller{

		public function index($param){
			echo 'With param! ' . $param;
		}

	}
```
Then in the *App/Public/index.php* file you can add a route to call this controller :
```php
	$app->Router->get('/{int:id}', 'index@index');
```
**If you are using the router with old style url's put all your arguments with a default value because user can go to an url without passing parameters in this one!!!**

#### Rendering a view (with parameters) :

Quiet simple!

Create a file in *App/MVC/View*.
 E.g :
```php
<h1>Index view</h1>
<p>Today the message is : <?= $message ?></p>
```
In your controller :
```php
<?php
	namespace App\MVC\Controller;

	use \Kernel\Controller;

	class indexController extends Controller{

		public function index(){
			//Same variable name as in the view file
			$message = 'You are on the name Controller, calling the index method. Well Done!';

			//See documentation for compact function ;)
			$this->render('index', compact('message'));
		}

	}
```

#### Using models :

Models file are in *App/MVC/Model* and must be called with *Model* at the end.
E.g : *postModel.php*

The basic model structure is :
```php
<?php
	namespace App\MVC\Model;

	class nameModel{

		//Just a function for exemple purposes, create your own. Models are the part of website that retrieve data
		public function get(){
			return 'I am fine!!!!!!!';
		}

	}
```

For exemple, this model is called *nameModel.php*

Now, in your controller you can load models with *loadModel* method :
```php
<?php
	namespace App\MVC\Controller;

	use \Kernerl\Controller;

	class nameController extends Controller{

		public function index(){
			// Will create $this->name variable automatically
			$this->loadModel('name');

			//Same variable name as in the view file
			$message = $this->name->get();

			//See documentation for compact function ;)
			$this->render('index', compact('message'));
		}

	}
```

Easy right?

### Adding an html template :
Just modify the *default.php* file in *App/MVC/View/Template* and make your own template! Put the content with this line of code :
```php
<div id="content">
	<!-- Content generated by the framework wich add the view file into the div, don t worry ;) -->
	<?= $content ?>
</div>
```

### Adding librairies :
####With composer :

Edit the *App/composer.json* file adding your dependecies, the autoloader is loaded in *App/app.php* file so you can directly use the dependencies. Read more about composer at : https://getcomposer.org/

####Without composer :

Go in the *App/Lib/* folder and put all external librairies (like my form class : https://github.com/hugopb82/form).
**Delete all namespaces in those files and be sure that the filename is the same as the class name.**
Now you can load the librairy without requiring it, just do:
```php
$class = new Class();
```
E.g. with my form class in a view file, I put *form.php* in *App/Lib/* :
```php
	$form = new form('index.php');
	$form->add('textbox', 'title');
	echo $form->end();
```

##### More possibilities coming soon!

###Support
Email me at hugopb82@gmail.com

Follow me on twitter at https://twitter.com/hugopb82

I'm not a professionnal developper, I made it for fun but it was hard and long to do this framework. Download the source code with this link and watch an ad for 5 seconds to help me : http://adf.ly/4694918/s-mvc

You can also , if you want really help me, make a donation on paypal : https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=DYEEWGNMNZMCJ

###Copyright and License
This software is Copyright (c) 2015 by hugopb82

This is free software, licensed under the MIT License.
