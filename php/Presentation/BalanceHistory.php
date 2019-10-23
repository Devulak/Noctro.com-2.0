<?php

namespace Presentation;

use Domain\Profile;
use Domain\Shop;
use Persistence\Accessor;

class BalanceHistory extends TemplateEngine
{
	public function __construct(Profile $profile)
	{
        parent::__construct("../PresentationHTML/HTMLBalanceHistory.php");

		LinkCollector::addLink("balancehistory");

		$shop = new Shop(new Accessor(), $profile);

		$this->assign("transactions", $shop->GetAllTransactions());
	}
}
