<?php

namespace Domain;

class Product
{
    private $ac;
	private $id;
	private $title;
    private $gameServer;
	private $price;
	private $inherit;
	private $newPrice;

    public function __construct(IAccessor $ac, int $id, string $title, int $gameServer, int $price, ?int $inherit, ?int $newPrice)
    {
		$this->ac = $ac;
		$this->id = $id;
		$this->title = $title;
        $this->gameServer = $gameServer;
		$this->price = $price;
		$this->inherit = $inherit;
		$this->newPrice = $newPrice;
    }

	public function GetId(): int
	{
		return $this->id;
	}

	public function GetTitle(): string
	{
		return $this->title;
	}

    public function GetGameServer(): GameServer
    {
        return $this->ac->GetGameServerById($this->gameServer);
    }

	public function GetDefaultPrice(): int
	{
		return $this->price;
	}

    public function GetDiscountPrice(): int
    {
        if ($this->newPrice == null)
        {
            return $this->price;
        }
        return $this->newPrice;
    }

    public function IsDiscounted(): bool
    {
        return $this->GetDefaultPrice() > $this->GetDiscountPrice();
    }

    public function GetDiscountedPercentage(): int
    {
        return round((1 - $this->GetDiscountPrice() / $this->GetDefaultPrice()) * 100);
    }

	public function GetInfo(): string
	{
		return $this->GetGameServer()->GetTitle();
	}

	public function GetInherited(): ?Product
	{
		return $this->ac->GetProductById($this->inherit);
	}
}
