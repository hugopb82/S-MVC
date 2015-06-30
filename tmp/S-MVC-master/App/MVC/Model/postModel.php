<?php
	namespace App\MVC\Model;

	class postModel{

		public function get(){
			return array(
				'title' => 'An article',
				'content' => 'made with',
				'autor' => 'S MVC'
			);
		}

	}