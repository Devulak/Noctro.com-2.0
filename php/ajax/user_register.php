<?php
	require '../init.php';
	require 'Ajax.php';
	header('Content-type: text/xml');
	$ajax = new Ajax();
	$input = $_POST;
	$email = $input["email"];
	$password = $input["password"];



	$captcha = $ajax->GetRecaptcha($_POST['grecaptcha']);

	if (!$captcha->success)
	{
		$ajax->error('email', "We're not certain it's you, try again");
	}



	// Register init
	if ($email != "")
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			if (Profile::getProfileByEmail($email) != null)
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
		Profile::createProfile($email, $password);
		$profile = Profile::getProfileByEmail($email);
		Profile::login($profile);
		$ajax->redirect(Config::GetPath() . '/dashboard');
	}

	echo $ajax->asXML();
?>