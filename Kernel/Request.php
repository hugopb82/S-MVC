<?php
	namespace Kernel;

	class Request{

		public static function getUrl(){
			$uri = $_SERVER['REQUEST_URI'];
			$dir = str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname(dirname(__FILE__)));
			$url =  str_replace($dir, '', $uri);
			return $url;
		}

	}
