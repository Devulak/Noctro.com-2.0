<?php

namespace Presentation;

use Domain\Profile;
use Domain\Shop;
use Persistence\Accessor;
use Persistence\Config;

class DonatorShop extends TemplateEngine
{
    public function __construct(Profile $profile)
    {
        parent::__construct("../PresentationHTML/HTMLDonatorShop.php");

        LinkCollector::addLink('donatorshop');
        LinkCollector::addScript("payment");

        $this->assign("shop", new Shop(new Accessor(), $profile));
        $this->assign("profile", $profile);
        $this->assign("stripePublicKey", Config::GetStripe()["public_key"]);
    }
}
