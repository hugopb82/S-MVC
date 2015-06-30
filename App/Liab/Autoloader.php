<?php
	namespace App\Lib;

    class Autoloader{

		/**
		 * 	Call this method to register the autoloader
		 */
		public static function register(){
			spl_autoload_register(array(__CLASS__, 'autoload'));
		}
		/**
		 * Autoload a class (in App/ directory)
		 * @param  [string]  $class  name of the class to load
		 */
		public static function autoload($class){
			if(file_exists(ROOT . 'App/Lib/' . $class . '.php')){
				require_once(ROOT . 'App/Lib/' . $class . '.php');
			}
		}

	}
