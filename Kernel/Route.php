<?php
    namespace Kernel;

    class Route{

        public $to_call;
        public $args = array();
        
        private $path;
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
            return $this;
        }

        public function verify($condition){
            $this->condition = $condition;
        }

    }
