<?php

require_once "php/init.php";

use Persistence\ProfileAccessor;
use Presentation\AccessPoint;
use Domain\MojangLink;

$pa = new ProfileAccessor();

$profile = AccessPoint::GetProfile($pa);

if($profile == null)
{
	header("Location: login");
	die;
}

$links = $profile->GetAllLinks();

foreach	($links as $link)
{
	if ($link instanceof MojangLink)
	{
		$profile->RemoveLink($link);
	}
}

header('Location: dashboard');