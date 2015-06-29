<?php
	namespace App\MVC\Controller;

	use \Kernel\Controller;

	class indexController extends Controller{

		public function index(){
			$this->loadModel('post');
			$post = $this->post->get();
			$this->render('index', compact('post'));
		}

	}
