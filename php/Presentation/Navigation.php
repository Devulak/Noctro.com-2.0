<?php

namespace Presentation;

use Domain\Profile;
use Domain\Shop;
use Persistence\Accessor;
use Persistence\Config;
use SimpleXMLElement;

class Navigation extends TemplateEngine
{
	public function __construct(Profile $profile)
	{
        parent::__construct("../PresentationHTML/HTMLNavigation.php");

		LinkCollector::addLink("navigation");
		LinkCollector::addScript("inputStrictNumber");
		LinkCollector::addScript("payment");

        $this->assign("email", $profile->GetEmail());

        $this->assign("stripePublicKey", Config::GetStripe()["public_key"]);

		$shop = new Shop(new Accessor(), $profile);

		list($balanceInt) = sscanf($shop->GetBalance() / 100, '%d.%d');

        $this->assign("balanceInt", $balanceInt);

		$balanceDecimal = substr(number_format($shop->GetBalance() / 100, 2), -3);

        $this->assign("balanceDecimal", $balanceDecimal);

		list($donatedInt) = sscanf($shop->GetDonated() / 100, '%d.%d');

        $this->assign("donatedInt", $donatedInt);

		$donatedDecimal = substr(number_format($shop->GetDonated() / 100, 2), -3);

        $this->assign("donatedDecimal", $donatedDecimal);
	}
}
