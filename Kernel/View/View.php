<?php
	namespace Kernel\View;

	class View{
		
		protected $VIEW_PATH = 'App/MVC/View/';
		protected $LAYOUT    = 'default';

		/**
		 * Render a view
		 * @param  string $view  view file
		 * @param  array  $vars  array of vars created with compact() method
		 */
		public function __construct($view, $vars = null){
			if(!is_null($vars)){
				extract($vars);
			}

			$view = str_replace('.', '/', $view);
			ob_start();
			require(ROOT . $this->VIEW_PATH . $view . '.php');
			$content = ob_get_clean();

			require(ROOT. $this->VIEW_PATH . 'Template/' . $this->LAYOUT . '.php');
		}

	}