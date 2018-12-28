<?php
	require_once 'php/init.php';

	$profile = Profile::getInstance();
	if(!$profile)
	{
		header('Location: ' . Init::getPath() . "login");
		die;
	}

	if (preg_match("#^[a-z0-9_]{3,16}$#i", $_POST['username']))
	{
		$profile->SetMinecraftID($_POST["username"]);
	}
	header('Location: dashboard');
?>