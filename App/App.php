<?php
	require(ROOT . 'Kernel/Bootstrap.php');

	use \Kernel\Bootstrap;
	use \Kernel\Router;

	class App extends Bootstrap{

		/**
		 * Boot the application. Called in the Public/index.php file
		 */
		public function boot(){
			$this->autoload();
			$this->session();
		}

		/**
		 * Load autoloaders...
		 */
		public function autoload(){
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
