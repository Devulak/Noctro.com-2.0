<?php

namespace Presentation;

use Domain\Profile;
use Domain\Shop;
use Domain\Transaction;
use Persistence\Accessor;
use SimpleXMLElement;

class BalanceHistory extends XMLSnip
{
	public function __construct(Profile $profile)
	{
		LinkCollector::addLink("balancehistory");

		$shop = new Shop(new Accessor(), $profile);

		$transactions = $shop->GetAllTransactions();

		$xmlTransactions = "";

		/** @var Transaction $transaction */
		foreach ($transactions as $transaction)
		{
			$extra = "";
			if ($transaction->GetProduct() != null)
			{
				$product = $transaction->GetProduct();

				$productTitle = $product->GetTitle();

				$gameServer = $product->GetGameServer();

				$gameServerTitle = $gameServer->GetTitle();

				$extra = "<div class='extra'><span>$gameServerTitle</span> $productTitle</div>";
			}

			$token = "";
			if ($transaction->GetToken() != null)
			{
				$token = " | " . $transaction->GetToken();
			}

			$xmlTransactions .= "
				<div class='balanceMark " . ($transaction->GetAmount() < 0 ? "remove" : "") . "'>
					<h2>€ " . number_format($transaction->GetAmount() / 100, 2) . "</h2>
					<div class='infobar'>
						" . date('m/d/Y H:i:s', $transaction->GetTime()) . "
						" . $token . "
					</div>
					" . $extra . "
				</div>
			";
		}
		if (!count($transactions))
		{
			$xmlTransactions = "<div class='shrug'>¯\_(ツ)_/¯</div>";
		}

		$xml = "
			<div class='balanceHistory widthLimit'>
				" . $xmlTransactions . "
			</div>
		";

		$this->xml = new SimpleXMLElement($xml);
		$this->AddAllTransactions();
	}

	private function AddAllTransactions()
	{

	}
}
