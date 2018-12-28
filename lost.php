<?php
	require_once 'php/init.php';

	Profile::logout();

	LinkCollector::addLink('login');
	LinkCollector::addScript('dust');

	$doc = new Page();

	$doc->setTitle('Lost password');

	$doc->appendXML('
		<canvas id="background" />
		<script>
			var dust = Dust(document.getElementById("background"), 1);
		</script>
	');

	$form = new Form("user_lost");
	
	$form->addTitle("Lost password");
	$form->addDescription("Don't worry, we got your back!");
	$form->addInput("Email", "email", "email");
	$form->addSub("We'll send you a little retriever");
	$form->addSubmit("Send", "submit");
	$form->addSub("Remembered it anyway? <a href=\"/login\">Login</a>");


	$doc->appendXML($form->getXML());

	$doc->print();
?>