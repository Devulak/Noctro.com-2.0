<?php

namespace Domain;

class Transaction
{
    private $ac;
    private $id;
    private $time;
    private $amount;
    private $token;
    private $profile;
    private $product;

    public function __construct(IAccessor $ac, int $id, int $time, int $amount, int $profile, ?string $token = null, ?int $product = null)
    {
        $this->ac = $ac;
        $this->id = $id;
        $this->time = $time;
        $this->amount = $amount;
        $this->token = $token;
        $this->profile = $profile;
        $this->product = $product;
    }

	public function GetAmount(): int
	{
		return $this->amount;
	}

	public function GetProduct(): ?Product
	{
		if ($this->product != null)
		{
			return $this->ac->GetProductById($this->product);
		}
		return null;
	}

	public function GetToken(): ?string
	{
		return $this->token;
	}

	public function GetTime(): ?string
	{
		return $this->time;
	}
}
