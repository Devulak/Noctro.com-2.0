<?php

namespace Domain;

class Lottery
{
	private $ac;
	private $profile;
	private $shop;
	private $tokenPrice = 500;

	public function __construct(IAccessor $ac, Profile $profile)
	{
		$this->profile = $profile;
		$this->ac = $ac;
		$this->shop = new Shop($ac, $profile);
	}

	public function GetNextTokenPrice(): int
	{
		$price = $this->shop->GetDonated() - $this->tokenPrice * $this->GetTokensReceived();
		$price = $this->tokenPrice - $price;
		return $price;
	}

	public function HasTokensLeft(): bool
	{
		if ($this->GetTokensLeft() > 0)
		{
			return true;
		}
		return false;
	}

	public function GetTokensLeft(): int
	{
		return $this->GetTokensReceived() - count($this->GetClaimedGameCodes());
	}

	public function GetTokensReceived(): int
	{
		return floor($this->shop->GetDonated() / $this->tokenPrice);
	}

	public function GetUnclaimedGameCodes(): array
	{
		return $this->ac->GetUnclaimedGameCodes();
	}

	public function GetClaimedGameCodes(): array
	{
		return $this->ac->GetClaimedGameCodes($this->profile);
	}

	/**
	 * @throws NoTokensLeftException
	 * @throws NoGameCodesLeftException
	 */
	public function ClaimRandomGameCode(): void
	{
		if (!$this->HasTokensLeft())
		{
			throw new NoTokensLeftException();
		}

		if (count($this->GetUnclaimedGameCodes()) == 0)
		{
			throw new NoGameCodesLeftException();
		}

		$gameCodes = $this->GetUnclaimedGameCodes();
		shuffle($gameCodes);

		$this->ac->ClaimGameCode($gameCodes[0], $this->profile);
	}
}
