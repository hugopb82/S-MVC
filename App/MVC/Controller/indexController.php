<?php
	namespace App\MVC\Controller;

	use \Kernel\Controller;

	class indexController extends Controller{

		public function index(){
			$this->render('index');
		}

	}
