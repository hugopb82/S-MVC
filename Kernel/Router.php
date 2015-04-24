<?php
	namespace Kernel;

	use \Kernel\Request;
	use \Kernel\Dispatcher;

	class Router{

		private static $_routes = [];
		private static $_patterns = array(
			'/{int:([a-zA-Z0-9]*)}/'  => '(?<$1>[0-9]+)',
			'/{all:([a-zA-Z0-9]*)}/' => '(?<$1>.+)'
		);
		private static $_mode = 'mixed';

		private static $DEFAULT_CONTROLLER = 'index';
		private static $DEFAULT_METHOD = 'index';

		public static function __callstatic($name, $params){
			array_unshift($params, strtoupper($name));
			call_user_func_array(array(__CLASS__, 'add'), $params);
		}

		public static function add($type, $url, $tocall, $condition = null){
			self::$_routes[] = array($type, $url, $tocall, $condition);
		}

		public static function setMode($mode){
			$modes = array('routes', 'default', 'mixed');
			if(in_array($mode, $modes)){
				self::$_mode = $mode;
			}
		}

		public static function notFound($tocall){
			self::$_routes['notFound'] = $tocall;
		}

		public static function load(){
			$url = Request::getUrl();
			if(self::$_mode == 'routes' || self::$_mode == 'mixed'){
				foreach(self::$_routes as $v){
					if($v[0] == $_SERVER['REQUEST_METHOD'] || $v[0] == 'ANY'){
						// Create regex from an easy language
						foreach(self::$_patterns as $x => $y){
							$regex = preg_replace($x, $y, $v[1]);
							$v[1] = $regex;
						}
						$regex = '/^' . str_replace('/', '\/', $regex) . '$/';
						
						// If route match with url
						$match = preg_match($regex, $url, $matches);
						if($match == 1){
							// Save only associative array
							$params = array();
							foreach($matches as $x => $y){
								if(!is_numeric($x)){
									$params[$x] = $y;
								}
							}

							$condition = true;

							// If a condition exists, test it
							if(!is_null($v[3])){
								extract($params, EXTR_PREFIX_ALL, 'param');
								$str_condition = str_replace('$', '$param_', $v[3]);
								$condition = eval("return " . $str_condition . ";");
								if(!$condition){
									$condition = false;
								}
							}

							// If condition is tested, dispatch
							if($condition){
								if(is_callable($v[2])){
									call_user_func_array($v[2], $params);
									return true;
								}else{
									$split = self::splitString($v[2]);
									Dispatcher::dispatch(array(
										'controller' => $split['controller'],
										'method' => $split['method'],
										'params' => $params
									));	
									return true;
								}
							}
						}
					}
				}
			}
			
			if(self::$_mode == 'mixed' || self::$_mode == 'default'){
				$splitted_url = explode('/', trim($url, '/'));
				$controller = isset($splitted_url[0]) ? $splitted_url[0] . 'Controller' : self::$DEFAULT_CONTROLLER;
				$method = isset($splitted_url[1]) ? $splitted_url[1] : self::$DEFAULT_METHOD;
				$params = isset($splitted_url[2]) ? array_slice($splitted_url, 2) : [];
				if(Dispatcher::verify($controller, $method)){
					Dispatcher::dispatch(array(
						'controller' => $controller,
						'method' => $method,
						'params' => $params
					));	
					return true;
				}				
			}


			if(isset(self::$_routes['notFound'])){
				$split = self::splitString(self::$_routes['notFound']);
				Dispatcher::dispatch(array(
					'controller' => $split['controller'],
					'method' => $split['method'],
					'params' => array()
				));
			}
		}

		private static function splitString($string){
			$tocall_parts = explode('#', $string);
			$controller = $tocall_parts[0] . 'Controller';
			$method = substr($tocall_parts[1], 0, strpos($tocall_parts[1], '('));
			return array(
				'controller' => $controller,
				'method' => $method
			);
		}

	}