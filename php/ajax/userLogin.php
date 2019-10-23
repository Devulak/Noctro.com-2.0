<?php

require_once("../init.php");

use Ajax\Ajax;
use Domain\Profile;
use Presentation\AccessPoint;
use Persistence\ProfileAccessor;

header('Content-type: text/xml');
$ajax = new Ajax();
$input = $_POST ? $_POST : $_GET;
$email = isset($input["email"]) ? $input["email"] : "";
$password = isset($input["password"]) ? $input["password"] : "";
$recaptcha = isset($input["grecaptcha"]) ? $input["grecaptcha"] : "";




$captcha = $ajax->GetRecaptcha($recaptcha);

if (!isset($captcha))
{
	$ajax->error('email', "No grecaptcha sent!");
}
else if (!$captcha->success)
{
	$ajax->error('email', "We're not certain you're human..");
}



// Login init
if (!$ajax->hasErrors())
{
	$pac = new ProfileAccessor();

	if(!Profile::IsEmailAvailable($pac, $email))
	{
		$profile = Profile::GetByEmailAndPassword($pac, $email, $password);
		if ($profile != null)
		{
			AccessPoint::Login($profile);
			$ajax->redirect('dashboard.php');
		}
		else
		{
			$ajax->error('password', 'Password did not match');
		}
	}
	else
	{
		$ajax->error('email', 'Could not find anything');
	}
}

// Echo response
echo $ajax->asXML();
