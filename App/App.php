<?php
	require(ROOT . 'Core/Bootstrap.php');

	use \Core\Bootstrap;

	class App extends Bootstrap{

		private static $_instance = null;

		/**
		 * Boot the application. Called in the Public/index.php file
		 */
		public static function boot(){
			$inst = self::getInstance();

			$inst->autoload();
			$inst->session();
			
			$inst->router();
		}

		/**
		 * Load autoloaders...
		 */
		public function autoload(){
			// Composer power !
			require(ROOT . 'vendor/autoload.php');

			require(ROOT . 'App/Autoloader.php');
			\App\Autoloader::register();
			require(ROOT . 'Core/Autoloader.php');
			\Core\Autoloader::register();
			require(ROOT . 'Lib/Autoloader.php');
			\Lib\Autoloader::register();
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