<?php

require_once "php/init.php";

use Presentation\AccessPoint;
use Persistence\ProfileAccessor;
use Domain\Lottery;
use Persistence\Accessor;
use Domain\NoTokensLeftException;
use Domain\NoGameCodesLeftException;

$profile = AccessPoint::GetProfile(new ProfileAccessor());

if($profile == null)
{
	header("Location: login.php");
	die;
}

$lottery = new Lottery(new Accessor(), $profile);

$lottery->ClaimRandomGameCode();

header("Location: dashboard.php");
