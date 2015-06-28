<?php
	namespace Kernel;

	class Request{

		public $url;

		/**
		 * Set the current url in the $url var
		 */
		public function __construct(){
			$uri = $_SERVER['REQUEST_URI'];
			$url =  str_replace(BASE_URL, '', $uri);
			$this->url = $url;
		}

	}
