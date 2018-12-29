<?php

require_once("../init.php");

use Ajax\Ajax;
use Presentation\AccessPoint;
use Persistence\ProfileAccessor;
use Domain\Shop;
use persistence\Accessor;

header('Content-type: text/xml');
$ajax = new Ajax();
$input = $_POST ? $_POST : $_GET;
$amount = $input['amount'] ? $input['amount'] : "";
$token = $input['token'] ? $input['token'] : "";


$pac = new ProfileAccessor();

$profile = AccessPoint::GetProfile($pac);

if($profile == null)
{
	$ajax->error("user", "You must be logged in");
}

if(!$token)
{
	$ajax->error("token", "No token provided");
}

if(!is_numeric($amount))
{
	$ajax->error("amount", "Not a number");
}
if($amount < 100)
{
	$ajax->error("amount", "Below threshold");
}
if($amount > 133700)
{
	$ajax->error("amount", "Above threshold");
}

if (!$ajax->hasErrors())
{
	$ac = new Accessor();

	$shop = new Shop($ac, $profile);

	try
	{
		$shop->Donate($amount, $token);
	}
	catch(Stripe_CardError $e)
	{
		$ajax->error("token", $e);
	}
}

echo $ajax->asXML();
