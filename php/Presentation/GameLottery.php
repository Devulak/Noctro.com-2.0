<?php

namespace Presentation;
	class GameLottery extends XMLSnip
	{
		public function GameLottery(Profile $profile)
		{
			LinkCollector::addLink('gamelottery');

			$GLB = new GameLotteryBase($profile);

			$forAnotherToken = $profile->GetDonated() - $GLB->GetTokenLimit() * floor($profile->GetDonated() / $GLB->GetTokenLimit());
			$forAnotherToken = $GLB->GetTokenLimit() - $forAnotherToken;
			$forAnotherToken /= 100;

			if ($GLB->GetTokensAvailable() >= 1)
			{
				$spin = "<a class='spin available' href='" . Config::GetPath() . "/spin.php'>Spin (1 token)</a>";
			}
			else
			{
				$spin = "<div class='spin' >Spin (1 token)</div>";
			}

			$xml = "
				<div class='widthLimit'>
					<div class='gameLottery'>
						<div class='brick'>
							<div class='enlarge'>€ " . number_format($forAnotherToken, 2) . "</div>
							<div class='sub'>to go for another token</div>
						</div>
						<div class='brick'>
							<div class='enlarge'>" . $GLB->GetTokensAvailable() . " <span class='alt'>/ " . $GLB->GetTokensTotal() . "</span></div>
							<div class='sub'>tokens left</div>
						</div>
						<div class='brick'>
							<div class='enlarge'>" . $GLB->GetNumberOfGamesAvailable() . "</div>
							<div class='sub'>games to claim</div>
						</div>
						<div class='brick'>
							<div id='spinList' class='spinList'></div>
							" . $spin . "
						</div>
					</div>
				</div>
			";

			$this->xml = new SimpleXMLElement($xml);

			$this->addScript();

			$games = $GLB->GetGamesByProfile();

			foreach ($games as $game)
			{
				$this->addGameWon($game);
			}
		}

		private function addGameWon($game = Game)
		{
			$gameElement = $this->xml->addChild("div");
			$gameElement->addAttribute("class", "gameWon");

			$gameContainer = $gameElement->addChild("div");
			$gameContainer->addAttribute("class", "container");

			$gameHeader = $gameContainer->addChild("h2", $game->subject);

			$gameCode = $gameContainer->addChild("div", $game->code);
			$gameCode->addAttribute("class", "code");

			$gameInfobar = $gameElement->addChild("div", date('m/d/Y H:i:s', $game->time));
			$gameInfobar->addAttribute("class", "infobar");
		}

		private function addScript()
		{
			$gamesStringArray = "var gamesArray = [];\n";

			$games = GameLotteryBase::GetGamesAvailable($this->profile);
			shuffle($games);

			foreach ($games as $game)
			{
				$gamesStringArray .= "gamesArray.push('" . str_replace("'", "\\'", $game->subject) . "');\n";
			}

			$script = $this->xml->addChild("script", "
				var currentNumber = 0;
				function rollSpinList()
				{
					" . $gamesStringArray . "
					var spinList = document.getElementById('spinList');

					var game = document.createElement('div');
					game.innerHTML = gamesArray[currentNumber];

					currentNumber++;
					if (currentNumber >= gamesArray.length)
					{
						currentNumber = 0;
					}


					var games = spinList.getElementsByClassName('out');
					for (var i = games.length - 1; i >= 0; i--)
					{
						spinList.removeChild(games[i]);
					}


					var games = spinList.getElementsByClassName('in');
					for (var i = games.length - 1; i >= 0; i--)
					{
						games[i].classList.add('out');
					}


					var games = spinList.getElementsByClassName('absolute');
					for (var i = games.length - 1; i >= 0; i--)
					{
						games[i].classList.add('in');
					}


					game.classList.add('game');
					game.classList.add('absolute');
					spinList.appendChild(game);
				}
				rollSpinList();
				rollSpinList();
				setInterval(rollSpinList, 2000);
			");
		}
	}
?>