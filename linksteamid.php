<?php
	require_once 'php/init.php';

	$profile = Profile::getInstance();
	if(!$profile)
	{
		header('Location: ' . Init::getPath() . "login");
		die;
	}

	$steamInfo = SteamInfo::AttemptSteamInfo();
	if ($steamInfo)
	{
		$profile->setSteamID($steamInfo->steamid);
		header('Location: dashboard');
	}
?>