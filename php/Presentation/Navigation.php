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

        $template = new TemplateEngine("../PresentationHTML/HTMLNavigation.php");

        $template->Assign("EMAIL", $profile->GetEmail());

        $template->Assign("StripePublicKey", Config::GetStripe()["public_key"]);

		$shop = new Shop(new Accessor(), $profile);

		list($balanceInt) = sscanf($shop->GetBalance() / 100, '%d.%d');

        $template->Assign("balanceInt", $balanceInt);

		$balanceDecimal = substr(number_format($shop->GetBalance() / 100, 2), -3);

        $template->Assign("balanceDecimal", $balanceDecimal);

		list($donatedInt) = sscanf($shop->GetDonated() / 100, '%d.%d');

        $template->Assign("donatedInt", $donatedInt);

		$donatedDecimal = substr(number_format($shop->GetDonated() / 100, 2), -3);

        $template->Assign("donatedDecimal", $donatedDecimal);

		$this->xml = new SimpleXMLElement($template->Compiled);
	}
}
