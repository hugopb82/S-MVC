<?php
	namespace App\MVC\Controller;

	class postController extends appController{

		public function index(){
			$message = 'called by postController';
			$this->render('index', compact('message'));
		}

		public function view($id){
			$this->loadModel('post');
			$post = $this->post->get();
			echo $id;
			$this->render('post.view', compact('post'));
		}

	}
