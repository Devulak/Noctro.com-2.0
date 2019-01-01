<?php

use Persistence\Config;
use Presentation\LinkCollector;
use Presentation\AccessPoint;
use Presentation\Form;
use Presentation\Page;

require_once 'php/init.php';

AccessPoint::Logout();

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

$form = new Form("php/Ajax/userRegister.php");

$form->addTitle("Create an account");
$form->addInput("Email", "email", "email");
$form->addInput("Password", "password", "password");
$form->addSubmit("Continue");
$config = Config::GetInit();
$form->addSub("By continuing you accept to have read and agree to the <a href='terms.php'>Terms of Service</a> and <a href='terms.php'>Privacy Policy</a>");
$form->addSub("Already have an account? <a href='login.php'>Login</a>");


$doc->appendXML($form->getXML());

$doc->print();
