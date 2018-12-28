<?php

namespace Presentation;

use domain\GameCode;
use domain\Lottery;
use Domain\Profile;
use persistence\Accessor;
use SimpleXMLElement;

class GameLottery extends XMLSnip
{
	private $lottery;
	private $profile;

	public function __construct(Profile $profile)
	{
		LinkCollector::addLink('gamelottery');

		$this->profile = $profile;

		$ac = new Accessor();

		$this->lottery = new Lottery($ac, $profile);

		$tokenPrice = $this->lottery->GetNextTokenPrice() / 100;

		if ($this->lottery->HasTokensLeft())
		{
			$spin = "<a class='spin available' href='spin.php'>Spin (1 token)</a>";
		}
		else
		{
			$spin = "<div class='spin' >Spin (1 token)</div>";
		}

		$xml = "
			<div class='widthLimit'>
				<div class='gameLottery'>
					<div class='brick'>
						<div class='enlarge'>€ " . number_format($tokenPrice, 2) . "</div>
						<div class='sub'>to go for another token</div>
					</div>
					<div class='brick'>
						<div class='enlarge'>" . $this->lottery->GetTokensLeft() . " <span class='alt'>/ " . $this->lottery->GetTokensReceived() . "</span></div>
						<div class='sub'>tokens left</div>
					</div>
					<div class='brick'>
						<div class='enlarge'>" . count($this->lottery->GetUnclaimedGameCodes()) . "</div>
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

		$gameCodes = $this->lottery->GetClaimedGameCodes();

		foreach ($gameCodes as $game)
		{
			$this->addGameWon($game);
		}
	}

	private function addGameWon(GameCode $game)
	{
		$gameElement = $this->xml->addChild("div");
		$gameElement->addAttribute("class", "gameWon");

		$gameContainer = $gameElement->addChild("div");
		$gameContainer->addAttribute("class", "container");

		$gameHeader = $gameContainer->addChild("h2", $game->GetTitle());

		$gameCode = $gameContainer->addChild("div", $game->GetCode($this->profile));
		$gameCode->addAttribute("class", "code");

		$gameInfobar = $gameElement->addChild("div", date('m/d/Y H:i:s', $game->GetTime()));
		$gameInfobar->addAttribute("class", "infobar");
	}

	private function addScript()
	{
		$gamesStringArray = "var gamesArray = [];\n";

		$gameCodes = $this->lottery->GetUnclaimedGameCodes();
		shuffle($gameCodes);

		/** @var GameCode $gameCode */
		foreach ($gameCodes as $gameCode)
		{
			$gamesStringArray .= "gamesArray.push('" . str_replace("'", "\\'", $gameCode->GetTitle()) . "');\n";
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