<?php
	namespace Kernel;

	use \DomDocument;

  	class Router{

		public $mode = 'mixed';
		public $url;

		private $request;
		private $routes = array();

		public function __construct(Request $request, $mode = 'default'){
			$url = $request->url;
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
			$this->delete($path, $to_call);
			return true;
		}

		public function load(){
			$method = $_SERVER['REQUEST_METHOD'];
			foreach($this->routes[$method] as $route){
				if($route->match($this->url)){
					return $route->call();
				}
			}
			if($this->mode == "mixed" || $this->mode == "old"){
				$parts = explode('/', $this->url);

				$controller = isset($parts[0]) ? $parts[0] : 'index';
				$method = isset($parts[1]) ? $parts[1] : 'index';
				$args  = isset($parts[2]) ? array_slice($parts, 2) : array();

				$route = new Route($this->url, $controller . '@' . $method);
				$route->args = $args;
				return $route;
			}else{
				return false;
			}
		}

		public function loadXML($path){
			$dom = new DomDocument();
			$dom->load($path);

			if($dom->schemaValidate(ROOT . 'Kernel/routes.xsd')){
				$routes = $dom->getElementsByTagName('route');

				foreach($routes as $route){
					$method = $route->getElementsByTagName('method')->item(0)->nodeValue;
					$url = $route->getElementsByTagName('url')->item(0)->nodeValue;
					$action = $route->getElementsByTagName('action')->item(0)->nodeValue;
					$this->add($method, $url, $action);
				}
			}else{
				die('Your xml file is incorrect');
				return false;
			}
		}

  	}
