<?php
  namespace Kernel;

  class Route{

    private $path;
    private $to_call;
    private $args = array();
    private $types = array(
      '/{int:([a-zA-Z0-9^\/]+)}/' => '(?<$1>[0-9]+)',
      '/{slug:([a-zA-Z0-9^\/]+)}/' => '(?<$1>[a-zA-Z0-9\-]+)',
      '/{all:([a-zA-Z0-9^\/]+)}/' => '(?<$1>[.]+)'
    );
    private $condition;

    public function __construct($path, $to_call){
      $this->path = trim($path, '/');
      $this->to_call = $to_call;
    }

    public function match($url){
      $regex = preg_replace(array_keys($this->types), array_values($this->types), $this->path);
      $regex = str_replace('/', '\/', $regex);
      $regex = "/^$regex$/i";

      if(preg_match($regex, $url, $matches)){
        array_shift($matches);
        $this->args = $matches;

        if($this->condition != null){
          extract($matches, EXTR_PREFIX_ALL, 'param');
          $condition = str_replace('$', '$param_', $this->condition);
          if(!eval("return " . $condition . ";")){
            return false;
          }
        }

        return true;
      }
      return false;
    }

    public function call(){
      if(is_callable($this->to_call)){
        return call_user_func_array($this->to_call, $this->args);
      }else{
        $parts = explode('#', $this->to_call);
        $controller = $parts[0] . 'Controller';
        $controller_path = ROOT . 'App/MVC/Controller/' . $controller . '.php';
        $method = $parts[1];
        if(file_exists($controller_path) && $controller != 'appController'){
          $controller_name = '\\App\\MVC\\Controller\\' . $controller;
  				$controller = new $controller_name();
  				if(method_exists($controller, $method)){
            $this->routed = true;
  					call_user_func_array(array($controller, $method) , $this->args);
  				}
  			}
      }
    }

    public function verify($condition){
      $this->condition = $condition;
    }

  }
