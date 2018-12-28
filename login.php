<?php
	require_once 'php/init.php';

	Profile::logout();

	LinkCollector::addLink('login');
	LinkCollector::addScript('dust');

	$doc = new Page();

	$doc->setTitle('Login');

	$doc->appendXML('
		<canvas id="background" />
		<script>
			var dust = Dust(document.getElementById("background"), 1);
		</script>
	');

	$form = new Form("user_login");
	
	$form->addTitle("Welcome");
	$form->addDescription("How's it going?");
	$form->addInput("Email", "email", "email");
	$form->addInput("Password", "password", "password");
	$form->addSub("Lost your password? <a href=\"/lost\">Find it!</a>");
	$form->addSubmit("Login");
	$form->addSub("Need an account? <a href=\"/register\">Register</a>");


	$doc->appendXML($form->getXML());

	$doc->print();
?>