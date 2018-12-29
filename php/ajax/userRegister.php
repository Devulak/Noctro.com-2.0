<?php

require '../init.php';

use Ajax\Ajax;
use Domain\Profile;
use Persistence\ProfileAccessor;

header('Content-type: text/xml');
$ajax = new Ajax();
$input = $_POST;
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



// Register init
if ($email != "")
{
	if (filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		if (!Profile::IsEmailAvailable(new ProfileAccessor(), $email))
		{
			$ajax->error('email', 'Already in use');
		}
	}
	else
	{
		$ajax->error('email', 'Not an email');
	}
}
else
{
	$ajax->error('email', 'Empty');
}

if (strlen($password) < 6)
{
	$ajax->error('password', 'Must be 6 characters or longer');
}

if (!$ajax->hasErrors())
{
	$pac = new ProfileAccessor();
	Profile::Create($pac, $email, $password);
	$profile = Profile::GetByEmailAndPassword($pac, $email, $password);
	\Presentation\AccessPoint::Login($profile);
	$ajax->redirect("dashboard.php");
}

echo $ajax->asXML();