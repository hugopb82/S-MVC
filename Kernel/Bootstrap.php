<?php
	namespace Kernel;

	class Bootstrap{
		
		protected $_url = NULL;
		protected $_controller;
		protected $_method;
		protected $_params;

		protected $DEFAULT_CONTROLLER = 'indexController';
		protected $DEFAULT_METHOD     = 'index';

		public function url(){
			if(isset($_GET['url'])){
				$this->_url = rtrim($_GET['url'], '/');
				$this->_url = explode('/', $this->_url);
			}
		}

		public function request(){
			$this->url();

			$url = $this->_url;
			$this->_controller = isset($url[0]) ? $url[0] . 'Controller' : $this->DEFAULT_CONTROLLER;
			$this->_method = isset($url[1]) ? $url[1] : $this->DEFAULT_METHOD;
			$this->_params = isset($url[2]) ? array_slice($url, 2) : [];
		}

		public function router($router){
			if(is_array($router)){
				$this->_controller = $router['controller'];
				$this->_method = $router['method'];
				$this->_params = $router['params'];
			}else{
				$this->url();
				$this->request();
			}

			$controller_path = ROOT . 'App/MVC/Controller/' . $this->_controller . '.php';
			if(file_exists($controller_path) && $this->_controller != 'appController'){
				$controller_name = '\\App\\MVC\\Controller\\' . $this->_controller;
				$controller = new $controller_name();
				if(method_exists($controller, $this->_method)){
					call_user_func_array(array($controller, $this->_method) , $this->_params);
				}else{
					echo 'Error';
				}
			}else{
				echo 'Error';
			}
		}

		public function session(){
			session_start();
		}
	}