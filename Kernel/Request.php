<?php
	namespace Kernel;

	class Request{

		public static function getUrl(){
			$exp = explode(dirname($_SERVER['PHP_SELF']), $_SERVER['REDIRECT_URL'],2);
			$url_array = explode('/', $exp[0]);
			$url = count($exp) > 1 ? $exp[1] : '/' . end($url_array);
			return $url;
		}

	}