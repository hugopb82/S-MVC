<?php
	namespace Storage;

	interface StorageInterface{
		public function get($key);
		public function set($key, $value);
		public function delete($key);
		public function exists($key);
	}
