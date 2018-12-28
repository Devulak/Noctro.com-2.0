<?php

require_once 'php/init.php';

$profile = Profile::getInstance();
if(!$profile)
{
	header('Location: ' . Init::getPath() . "login");
	die;
}

$profile->setSteamID(null);

header('Location: dashboard');