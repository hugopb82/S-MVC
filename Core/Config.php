<?php
	class Config{

		private static $_instance = null;
		private $_settings = [];

		public function __construct(){
			$this->_settings = require(ROOT . 'Config/Config.php');
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