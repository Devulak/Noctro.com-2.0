<?php

namespace Domain;

abstract class GameServer
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public abstract function Announce(string $announcement, Profile $profile): void;

    public abstract function Activate(Transaction $transaction): void;
}
