<?php

require_once 'php/init.php';

use Domain\SteamLink;
use Presentation\AccessPoint;
use Persistence\ProfileAccessor;

$pac = new ProfileAccessor();

$profile = AccessPoint::GetProfile($pac);
if($profile == null)
{
	header("Location: login.php");
	die;
}

$steamUnique = SteamLink::AttemptSteamInfo();
if ($steamUnique != null)
{
	SteamLink::Create($pac, $profile, $steamUnique);
	header("Location: dashboard.php");
}
