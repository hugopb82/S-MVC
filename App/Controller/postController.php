<?php
	namespace App\Controller;

	class postController extends appController{

		public function index(){
			$message = 'called by postController';
			$this->render('index', compact('message'));
		}

		public function view(){
			$this->loadModel('post');
			$post = $this->post->get();
			$this->render('post.view', compact('post'));
		}

	}