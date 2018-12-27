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



	// Login init
	if (!$ajax->hasErrors())
	{
		$profile = Profile::getProfileByEmail($email);
		if($profile != null)
			if($profile->comparePassword($password))
			{
				Profile::login($profile);
				$ajax->redirect(Config::GetPath() . '/dashboard');
			}
			else
			{
				$ajax->error('password', 'Password did not match');
			}
		else
		{
			$ajax->error('email', 'Could not find anything');
		}
	}

	// Echo response
	echo $ajax->asXML();
?>