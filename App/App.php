<?php
	require(ROOT . 'Core/Bootstrap.php');

	use \Core\Bootstrap;

	class App extends Bootstrap{

		private static $_instance = null;

		public static function boot(){
			$inst = self::getInstance();

			$inst->autoload();
			$inst->session();
			
			$inst->router();
		}

		public function autoload(){
			require(ROOT . 'App/Autoloader.php');
			\App\Autoloader::register();
			require(ROOT . 'Core/Autoloader.php');
			\Core\Autoloader::register();
		}
		
		public static function getInstance(){
			if(is_null(self::$_instance)){
				self::$_instance = new self();
			}
			return self::$_instance;
		}

	}