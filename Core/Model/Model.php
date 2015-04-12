<?php
	namespace Core\Model;

	class Model{
		
		/**
		 * Load a model
		 * @param  string $model  model name
		 */
		public static function loadModel($model){
			$model_name = '\\App\\Model\\' . $model . 'Model';
			return new $model_name();
		}

	}