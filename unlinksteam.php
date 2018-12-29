<?php

require_once "php/init.php";

$pa = new \Persistence\ProfileAccessor();

$profile = \Presentation\AccessPoint::GetProfile($pa);

if($profile == null)
{
	header("Location: login.php");
	die;
}

$links = $profile->GetAllLinks();

foreach	($links as $link)
{
	if ($link instanceof \Domain\SteamLink)
	{
		$profile->RemoveLink($link);
	}
}

header('Location: dashboard.php');