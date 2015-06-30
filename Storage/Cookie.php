<?php
	namespace Storage;

	class Cookie implements StorageInterface{

		public $expire = 3600;
		public $path = '';
		public $domain = '';
		public $secure = false;
		public $httponly = false;

		public function get($key){
			return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
		}

		public function set($key, $value){
			setcookie($key, $value, time() + $this->expire, $this->path, $this->domain, $this->secure, $this->httponly);
		}

		public function delete($key = null){
			if(is_null($key)){
				unset($_COOKIE);
			}else{
				unset($_COOKIE[$key]);
			}
		}

		public function exists($key){
			return isset($_COOKIE[$key]);
		}

		public function destroy(){
			$_COOKIE = array();
		}

	}
