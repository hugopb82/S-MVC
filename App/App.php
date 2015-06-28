<?php
	define('ROOT', dirname(__DIR__) . '/');
	define('BASE_URL', dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))) . '/');
	
	require(ROOT . 'Kernel/Bootstrap.php');

	use \Kernel\DIC;
	use \Kernel\Bootstrap;
	use \Kernel\Request;
	use \Kernel\Router;
	use \Kernel\Dispatcher;

	class App extends Bootstrap{

		/**
		 * Boot the application. Called in the Public/index.php file
		 */
		public function __construct(){
			$this->autoload();
			$this->session();
			$this->container = new DIC();
			$this->container->Request = function($c){
				return new Request();
			};
			$this->container->Router = function($c){
				return new Router($c->Request);
			};
			$this->container->Dispatcher = function($c){
				return new Dispatcher($c->Router);
			};
			// To use with $app->Router syntax
			$this->Router = $this->container->Router;
		}

		public function boot(){
			$d = $this->container->Dispatcher;
		}

		/**
		 * Load autoloaders...
		 */
		private function autoload(){
			// Composer power !
			require(ROOT . 'App/vendor/autoload.php');

			require(ROOT . 'App/Autoloader.php');
			\App\Autoloader::register();
			require(ROOT . 'Kernel/Autoloader.php');
			\Kernel\Autoloader::register();
			require(ROOT . 'App/Lib/Autoloader.php');
			App\Lib\Autoloader::register();
		}

	}
