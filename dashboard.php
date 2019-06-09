<?php

require_once "php/init.php";

use Persistence\ProfileAccessor;
use Presentation\AccessPoint;
use Presentation\LinkCollector;
use Presentation\Page;
use Presentation\LinkAccount;
use Presentation\Navigation;
use Presentation\Bottom;
use Presentation\GameLottery;
use Presentation\BalanceHistory;
use Presentation\DonatorShop;

$pa = new ProfileAccessor();

$profile = AccessPoint::GetProfile($pa);

if($profile == null)
{
	header("Location: login");
	die;
}

LinkCollector::addLink("dashboard");
LinkCollector::addScript("dust");
LinkCollector::addScript("ajax");
LinkCollector::addRemoteScript("https://checkout.stripe.com/checkout.js");

$doc = new Page();

$doc->setTitle("Dashboard");

// Navigation
$nav = new Navigation($profile);
$doc->appendXMLSnip($nav);

$doc->appendXML("<h1>Link your accounts</h1>");
$link = new LinkAccount($profile);
$doc->appendXML($link->getXML());

$doc->appendXML("<h1>Donation shop</h1>");
$donatorShop = new DonatorShop($profile);
$doc->appendXML($donatorShop->getXML());

$doc->appendXML("<h1>Game lottery</h1>");
$gameLottery = new GameLottery($profile);
$doc->appendXML($gameLottery->getXML());

$doc->appendXML("<h1>Account purchase history</h1>");
$balanceHistory = new BalanceHistory($profile);
$doc->appendXML($balanceHistory->getXML());

$bottom = new Bottom();
$doc->appendXMLSnip($bottom);

$doc->Print();
