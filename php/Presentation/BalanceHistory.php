<?php

namespace Presentation;
	class BalanceHistory extends XMLSnip
	{
		public function BalanceHistory($profile = Profile)
		{
			LinkCollector::addLink("balancehistory");

			$transactions = $profile->GetAllTransactions();
			$transactions = array_reverse($transactions);

			$xmlTransactions = "";
			foreach ($transactions as $transaction)
			{
				$extra = "";
				if ($transaction->product)
				{
					$extra = "<div class='extra'>" . $transaction->product . "</div>";
				}

				$token = "";
				if ($transaction->token)
				{
					$token = " | " . $transaction->token;
				}

				$xmlTransactions .= "
					<div class='balanceMark " . ($transaction->amount < 0 ? "remove" : "") . "'>
						<h2>€ " . number_format($transaction->amount / 100, 2) . "</h2>
						<div class='infobar'>
							" . date('m/d/Y H:i:s', $transaction->time) . "
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
?>