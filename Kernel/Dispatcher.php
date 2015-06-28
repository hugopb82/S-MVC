<?php
	namespace Kernel;

	class Dispatcher{

		private $route;
		private $mode;

		private $controller;
		private $method;
		private $args;

		public function __construct(Router $router){
			$this->mode = $router->mode;
			if($router->load()){
				$this->route = $router->load();
				$this->dispatch();
			}else{
				echo 'Error';
				die();
			}
		}

		public function dispatch(){
			$this->args = $this->route->args;

			if(is_callable($this->route->to_call)){
				call_user_func_array($this->route->to_call, $this->args);
			}else{
				$this->split();
				$controller_path = ROOT . 'App/MVC/Controller/' . $this->controller . 'Controller.php';
				if(file_exists($controller_path)){
					$controller_name = '\\App\\MVC\\Controller\\' . $this->controller . 'Controller';
					$controller = new $controller_name();
					if(method_exists($controller, $this->method)){
						call_user_func_array(array($controller, $this->method) , $this->args);
					}else{
						echo 'Error';
					}
				}else{
					echo 'Error';
				}
			}
		}

		public function split(){
			$splitted = explode('@',$this->route->to_call);
			$this->controller = $splitted[0];
			$this->method = $splitted[1];
		}

	}
