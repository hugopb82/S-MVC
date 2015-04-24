<?php
	require(ROOT . 'Kernel/Bootstrap.php');

	use \Kernel\Bootstrap;
	use \Kernel\Router;

	class App extends Bootstrap{

		private static $_instance = null;

		/**
		 * Boot the application. Called in the Public/index.php file
		 */
		public static function boot(){
			$inst = self::getInstance();

			$inst->autoload();
			$inst->session();
			
			Router::load();
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
		
		/**
		 * Singleton
		 */
		private static function getInstance(){
			if(is_null(self::$_instance)){
				self::$_instance = new self();
			}
			return self::$_instance;
		}

	}