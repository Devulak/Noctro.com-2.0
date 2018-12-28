<?php
	require_once 'php/init.php';

	Profile::logout();

	LinkCollector::addLink('login');
	LinkCollector::addScript('dust');

	$doc = new Page();

	$doc->setTitle('Register');

	$doc->appendXML('
		<canvas id="background" />
		<script>
			var dust = Dust(document.getElementById("background"), 1);
		</script>
	');

	$form = new Form("user_register");
	
	$form->addTitle("Create an account");
	$form->addInput("Email", "email", "email");
	$form->addInput("Password", "password", "password");
	$form->addSubmit("Continue");
	$config = Config::GetInit();
	$form->addSub("By continuing you accept to have read and agree to " . $config['name'] . "'s <a href=\"#\">Terms of Service</a> and <a href=\"#\">Privacy Policy</a>");
	$form->addSub("Already have an account? <a href=\"/login\">Login</a>");


	$doc->appendXML($form->getXML());

	$doc->print();
?>