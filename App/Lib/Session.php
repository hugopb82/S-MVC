<?php
	namespace Storage;

	class Session implements StorageInterface{

		public function __construct($name = null){
			if(session_status() == PHP_SESSION_NONE){
			    if($name){
					session_name($name);
				}
				session_start();
			}
		}

		public function getSessionId(){
			return session_id();
		}

		public function get($key){
			return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
		}

		public function set($key, $value){
			$_SESSION[$key] = $value;
		}

		public function delete($key = null){
			if(is_null($key)){
				unset($_SESSION);
			}else{
				unset($_SESSION[$key]);
			}
		}

		public function exists($key){
			return isset($_SESSION[$key]);
		}

		public function destroy(){
			session_unset();
			session_destroy();
		}

	}
