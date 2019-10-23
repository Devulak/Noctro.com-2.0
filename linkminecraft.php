<?php

require_once 'php/init.php';

use Presentation\AccessPoint;
use Persistence\ProfileAccessor;
use Domain\MojangLink;

$pac = new ProfileAccessor();

$profile = AccessPoint::GetProfile($pac);
if($profile == null)
{
	header("Location: login");
	die;
}

if (preg_match("#^[a-z0-9_]{3,16}$#i", $_POST['username']))
{
	MojangLink::Create($pac, $profile, $_POST["username"]);
}

header("Location: dashboard");