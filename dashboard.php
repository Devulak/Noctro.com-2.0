<?php

require_once "php/init.php";

$pa = new \Persistence\ProfileAccessor();

$profile = \Presentation\AccessPoint::GetProfile($pa);

if($profile == null)
{
	header("Location: login.php");
	die;
}
echo \Persistence\Config::GetPath();

\Presentation\LinkCollector::addLink("dashboard");
\Presentation\LinkCollector::addScript("dust");
\Presentation\LinkCollector::addScript("ajax");
\Presentation\LinkCollector::addRemoteScript("https://checkout.stripe.com/checkout.js");

$doc = new \Presentation\Page();

$doc->setTitle("Dashboard");

// Navigation
$nav = new \Presentation\Navigation($profile);
$doc->appendXMLSnip($nav);

/*$doc->appendXML("<h1>Link your accounts</h1>");
$link = new \Presentation\LinkAccount($profile);
$doc->appendXML($link->getXML());

$doc->appendXML("<h1>Donation shop</h1>");
$donatorShop = new \Presentation\DonatorShop($profile);
$doc->appendXML($donatorShop->getXML());

$doc->appendXML("<h1>Game lottery</h1>");
$gameLottery = new \Presentation\GameLottery($profile);
$doc->appendXML($gameLottery->getXML());

$doc->appendXML("<h1>Account purchase history</h1>");
$balanceHistory = new \Presentation\BalanceHistory($profile);
$doc->appendXML($balanceHistory->getXML());

$bottom = new \Presentation\Bottom();
$doc->appendXMLSnip($bottom);*/

$doc->Print();
