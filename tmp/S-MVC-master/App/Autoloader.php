<?php
	namespace App;

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
			if(strpos($class, __NAMESPACE__ . '\\') === 0){
				$class = str_replace( __NAMESPACE__ . '\\', '', $class);
				$class = str_replace('\\', '/', $class);
				require_once(ROOT . 'App/' . $class . '.php');
			}
		}
		
	}