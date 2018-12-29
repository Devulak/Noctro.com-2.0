<?php

require_once "php/init.php";

$profile = \Presentation\AccessPoint::GetProfile(new \Persistence\ProfileAccessor());

if($profile == null)
{
	header("Location: login.php");
	die;
}

$lottery = new \domain\Lottery(new \Persistence\Accessor(), $profile);

try
{
	$lottery->ClaimRandomGameCode();
}
catch (\domain\NoTokensLeftException $e)
{
	echo "You don't have enough tokens!";
}
catch (\domain\NoGameCodesLeftException $e)
{
	echo "Sorry, but it doesn't seem that there's more games available!";
}

header("Location: dashboard.php");
