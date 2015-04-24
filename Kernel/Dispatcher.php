<?php
	namespace Kernel;

	class Dispatcher{

		public static function dispatch($tocall){
			extract($tocall);
			$controller_path = ROOT . 'App/MVC/Controller/' . $controller . '.php';
			if(file_exists($controller_path) && $controller != 'appController'){
				$controller_name = '\\App\\MVC\\Controller\\' . $controller;
				$controller = new $controller_name();
				if(method_exists($controller, $method)){
					call_user_func_array(array($controller, $method) , $params);
				}else{
					echo 'Error';
				}
			}else{
				echo 'Error';
			}
		}

		public static function verify($controller, $method){
			$controller_path = ROOT . 'App/MVC/Controller/' . $controller . '.php';
			$controller_name = '\\App\\MVC\\Controller\\' . $controller;
			if(file_exists($controller_path) && $controller != 'appController'){
				if(method_exists($controller_name, $method)){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

	}