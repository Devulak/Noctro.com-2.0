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
LinkCollector::addScript("ajax");
LinkCollector::addRemoteScript("https://checkout.stripe.com/checkout.js");

$doc = new Page();

$doc->setTitle("Dashboard");

$doc->AppendToBody(new Navigation($profile));

$doc->AppendToBody(new LinkAccount($profile));

$doc->AppendToBody(new DonatorShop($profile));

$doc->AppendToBody(new GameLottery($profile));

$doc->AppendToBody(new BalanceHistory($profile));

$doc->AppendToBody(new Bottom());

$doc->Display();
