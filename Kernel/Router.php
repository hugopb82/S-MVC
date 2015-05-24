<?php
	namespace Kernel;

  class Router{

    private $url;
    private $routes = array();
    private $mode = 'default';
		private $routed = false;

    public function __construct($url, $mode = 'default'){
      $this->url = trim($url, '/');
			$this->mode = $mode;
    }

		public function setMode($mode){
			$this->mode = $mode;
		}

		public function add($type, $path, $to_call){
			$route = new Route($path, $to_call);
      $this->routes[$type][] = $route;
      return $route;
    }

    public function get($path, $to_call){
      return $this->add('GET', $path, $to_call);
    }

    public function post($path, $to_call){
      return $this->add('POST', $path, $to_call);
    }

    public function delete($path, $to_call){
      return $this->add('DELETE', $path, $to_call);
    }

    public function any($path, $to_call){
      $this->get($path, $to_call);
      $this->post($path, $to_call);
      return $this->delete($path, $to_call);
    }

    public function load(){
			switch($this->mode){
				case 'default':
					$this->loadUrl();
					break;
				case 'mixed':
					$this->loadDefined();
					$this->loadUrl();
					break;
				case 'defined':
					$this->loadDefined();
					break;
				default:
					break;
			}
    }

		private function loadDefined(){
			if($this->routed === true){
				return false;
			}
			$method = $_SERVER['REQUEST_METHOD'];
			if(!isset($this->routes[$method])){
				return false;
			}
			foreach($this->routes[$method] as $route){
				if($route->match($this->url)){
					$this->routed = true;
					return $route->call();
				}
			}
		}

		private function loadUrl(){
			if($this->routed === true){
				return false;
			}
			$url = !empty($this->url) ? explode('/', $this->url) : '';

			$controller = isset($url[0]) ? $url[0] . 'Controller' : 'indexController';
			$controller_path = ROOT . 'App/MVC/Controller/' . $controller . '.php';
			$method = isset($url[1]) ? $url[1] : 'index';
			$params = isset($url[2]) ? array_slice($url, 2) : array();

			if(file_exists($controller_path) && $controller != 'appController'){
				$controller_name = '\\App\\MVC\\Controller\\' . $controller;
				$controller = new $controller_name();
				if(method_exists($controller, $method)){
					$this->routed = true;
					call_user_func_array(array($controller, $method) , $params);
				}
			}
		}

  }
