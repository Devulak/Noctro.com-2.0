<?php

require_once "php/init.php";

$pa = new \Persistence\ProfileAccessor();

$profile = \Presentation\AccessPoint::GetProfile($pa);

if ($profile == null)
{
	// TODO: Remove ".php" in production
	header("Location: login.php");
	die;
}