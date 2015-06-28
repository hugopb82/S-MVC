<?php
	namespace App\MVC\Controller;

	use \Kernel\Controller;

	class postController extends Controller{

		public function index(){
			$message = 'called by postController';
			$this->render('index', compact('message'));
		}

		public function view($id){
			$this->loadModel('post');
			$post = $this->post->get();
			$this->render('post.view', compact('post'));
		}

	}
