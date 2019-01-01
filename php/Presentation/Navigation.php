<?php

namespace Presentation;

use Domain\Profile;
use Domain\Shop;
use Persistence\Accessor;
use Persistence\Config;
use SimpleXMLElement;

class Navigation extends XMLSnip
{
	public function __construct(Profile $profile)
	{
		LinkCollector::addLink("navigation");
		LinkCollector::addScript("inputStrictNumber");
		LinkCollector::addScript("payment");

		$shop = new Shop(new Accessor(), $profile);

		list($balanceInt, $balanceDecimal) = sscanf($shop->GetBalance() / 100, '%d.%d');

		list($donatedInt, $donatedDecimal) = sscanf($shop->GetDonated() / 100, '%d.%d');

		$xml = "
			<nav>
				<div class='logo'><img src='images/logo.svg' /></div>
				<div class='spread'></div>
				<form class='donate payment' method='post' action='php/Ajax/donate.php'>
					<div class='valuta'>€</div>
					<input type='hidden' name='public_key' value='" . Config::GetStripe()["public_key"] . "' />
					<input type='hidden' name='email' value='" . $profile->getEmail() . "' />
					<input type='hidden' name='title' value='Donation' />
					<input type='text' name='amountCustom' class='strictNumber' min='1' max='1337' value='10' />
					<input type='submit' value='Donate' />
				</form>
				<div class='balance'>
					€ " . number_format($balanceInt) . "<span class='small'>." . sprintf('%02d', $balanceDecimal) . "</span>
					<span class='alt small'> / " . number_format($donatedInt) . "<span class='small'>." . sprintf('%02d', $donatedDecimal) . "</span></span></div>
				<div class='email'>" . $profile->getEmail() . "</div>
				<a class='logout end' href='login.php'>Logout</a>
			</nav>
		";

		$this->xml = new SimpleXMLElement($xml);
	}
}
