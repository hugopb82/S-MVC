<p>This is the index page</p>
<?= isset($message) ? $message : '' ?>
<?php 
	$form = new Form('');
	$form->add('text', 'title', null);
    $form->add('password', 'password');
     echo($form->end());
?>