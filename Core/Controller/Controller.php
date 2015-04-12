<?php
	namespace Core\Controller;

	use \Core\View\View;
	use \Core\Model\Model;

	class Controller{
		
		protected $VIEW_PATH = 'App/View/';
		protected $LAYOUT    = 'default';

		/**
		 * Render a view
		 * @param  string $view  view file
		 * @param  array  $vars  array of vars created with compact() method
		 */
		public function render($view, $vars = null){
			new View($view, $vars);
		}

		/**
		 * Load a model
		 * @param  string $model  model name
		 */
		public function loadModel($model){
			$this->$model = Model::loadModel($model);
		}

	}