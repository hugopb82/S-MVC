<?php
	class Router{

		public static $_routes = [];
		private static $_patterns = array(
			'/{int:([a-zA-Z0-9]*)}/'  => '(?<$1>[0-9]+)',
			'/{all:([a-zA-Z0-9]*)}/' => '(?<$1>.+)'
		);

		public static function __callstatic($name, $params){
			array_unshift($params, strtoupper($name));
			call_user_func_array(array(__CLASS__, 'add'), $params);
		}

		public static function add($type, $url, $tocall, $condition = null){
			self::$_routes[] = array($type, $url, $tocall, $condition);
		}

		public static function load($url){
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

						if(!is_null($v[3])){
							extract($params, EXTR_PREFIX_ALL, 'param');
							$str_condition = str_replace('$', '$param_', $v[3]);
							$condition = eval("return " . $str_condition . ";");
							if(!$condition){
								$condition = false;
							}
						}

						if($condition){
							if(is_callable($v[2])){
								return call_user_func_array($v[2], $params);
							}else{
								$tocall_parts = explode('#', $v[2]);
								$controller = $tocall_parts[0] . 'Controller';
								$method = substr($tocall_parts[1], 0, strpos($tocall_parts[1], '('));

								return array(
									'controller' => $controller,
									'method' => $method,
									'params' => $params
								);	
							}
						}
					}
				}
			}
			if(isset(self::$_routes['notFound'])){
				$tocall_parts = explode('#', self::$_routes['notFound']);
				$controller = $tocall_parts[0] . 'Controller';
				$method = substr($tocall_parts[1], 0, strpos($tocall_parts[1], '('));
				return array(
					'controller' => $controller,
					'method' => $method,
					'params' => array()
				);
			}
		}

		public static function notFound($tocall){
			self::$_routes['notFound'] = $tocall;
		}

	}