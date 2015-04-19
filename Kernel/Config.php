<?php
	class Config{

		private static $_instance = null;
		private $_settings = [];


		/**
		 * Load Config/Config.ini|php file
		 */
		public function __construct(){
			if(file_exists(ROOT . 'App/Config/Config.ini')){
				$this->_settings = parse_ini_file(ROOT . 'App/Config/Config.ini', true);
			}elseif(file_exists(ROOT . 'App/Config/Config.php')){
				$this->_settings = require(ROOT . 'App/Config/Config.php');
			}else{
				die("No config file founded in Config directory.");
			}
		}

		/**
		 * Get a config data. Config file in Config/Config.php
		 * @param  string $prefix   Array prefix. See config file architecture
		 * @param  string $key      Key to get
		 * @return string           Data or null
		 */
		public static function get($prefix, $key){
			$prefix = strtoupper($prefix);
			$key = strtoupper($key);
			return isset(self::getInstance()->_settings[$prefix][$key]) ? self::getInstance()->_settings[$prefix][$key] : null;
		}

		/**
		 * Singleton
		 */
		private static function getInstance(){
			if(is_null(self::$_instance)){
				self::$_instance = new self();
			}
			return self::$_instance;
		}

	}