<?php

namespace Domain;

class Product
{
    private $ac;
    private $gameServer;
    private $price;

    public function __construct(IAccessor $ac, int $gameServer, int $price)
    {
        $this->ac = $ac;
        $this->gameServer = $gameServer;
        $this->price = $price;
    }

    public function GetGameServer(): GameServer
    {
        return $this->ac->GetGameServerById($this->gameServer);
    }

    public function GetPrice(): int
    {
        return $this->price;
    }
}
