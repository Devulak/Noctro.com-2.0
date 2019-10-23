<?php

namespace Presentation;

use Domain\Lottery;
use Domain\Profile;
use Persistence\Accessor;

class GameLottery extends TemplateEngine
{
	public function __construct(Profile $profile)
	{
        parent::__construct("../PresentationHTML/HTMLGameLottery.php");

		LinkCollector::addLink('gamelottery');

		$ac = new Accessor();

		$lottery = new Lottery($ac, $profile);

		$tokenPrice = $lottery->GetNextTokenPrice() / 100;

        $gameCodes = $lottery->GetClaimedGameCodes();

        $gameCodesShuffled = $lottery->GetUnclaimedGameCodes();
        shuffle($gameCodesShuffled);

        $this->assign("tokenPrice", number_format($tokenPrice, 2));
        $this->assign("tokensLeft", $lottery->GetTokensLeft());
        $this->assign("tokensRecieved", $lottery->GetTokensReceived());
        $this->assign("gamesToClaim", count($lottery->GetUnclaimedGameCodes()));
        $this->assign("gameCodes", $gameCodes);
        $this->assign("gameCodesShuffled", $gameCodesShuffled);
        $this->assign("profile", $profile);
	}
}