<?php
    namespace Kernel;

    class DIC{

        private $vars = array();
        private $instances = array();

        public function set($name, $value){
            $this->vars[$name] = $value;
        }

        public function get($name){
            if(isset($this->vars[$name])){
                if(is_callable($this->vars[$name])){
                    if(!isset($this->instances[$name])){
                        $this->instances[$name] = $this->vars[$name]($this);
                    }
                    return $this->instances[$name];
                }else{
                    return $this->vars[$name];
                }
            }
            return false;
        }

        public function __set($name, $value){
            $this->set($name, $value);
        }

        public function __get($name){
            return $this->get($name);
        }

    }
