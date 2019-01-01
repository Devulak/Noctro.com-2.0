<?php

require_once "php/init.php";

use Domain\SteamLink;
use Persistence\ProfileAccessor;
use Presentation\AccessPoint;

$pa = new ProfileAccessor();

$profile = AccessPoint::GetProfile($pa);

if($profile == null)
{
	header("Location: login.php");
	die;
}

$links = $profile->GetAllLinks();

foreach	($links as $link)
{
	if ($link instanceof SteamLink)
	{
		$profile->RemoveLink($link);
	}
}

header('Location: dashboard.php');