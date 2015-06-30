<?php
	define('ROOT', dirname(__DIR__) . '/');
	define('BASE_URL', dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))) . '/');

	require(ROOT . 'Kernel/Bootstrap.php');

	use \Kernel\Bootstrap;
	use \Kernel\Request;
	use \Kernel\Router;
	use \Kernel\Dispatcher;
	use \Kernel\Updater;

	class App extends Bootstrap{

		/**
		 * Called in the Public/index.php file
		 */
		public function __construct(){
			$this->autoload();
			$this->session();
			$this->Request = new Request();
			$this->Router = new Router($this->Request);
			$this->Updater = new Updater();
			die();
		}

		/**
		 * Dispatch
		 */
		public function boot(){
			$this->Dispatcher = new Dispatcher($this->Router);
		}

		/**
		 * Load autoloaders...
		 */
		private function autoload(){
			if(file_exists(ROOT . 'vendor/autoload.php')){
				// Composer power !
				require(ROOT . 'vendor/autoload.php');
			}else{
				require(ROOT . 'App/Autoloader.php');
				\App\Autoloader::register();
				require(ROOT . 'Kernel/Autoloader.php');
				\Kernel\Autoloader::register();
				require(ROOT . 'App/Lib/Autoloader.php');
				App\Lib\Autoloader::register();
			}

		}

	}
