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

try
{
	$lottery->ClaimRandomGameCode();
}
catch (NoTokensLeftException $e)
{
	echo "You don't have enough tokens!";
}
catch (NoGameCodesLeftException $e)
{
	echo "Sorry, but it doesn't seem that there's more games available!";
}

header("Location: dashboard.php");
