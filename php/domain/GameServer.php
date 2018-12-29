<?php

namespace Domain;

abstract class GameServer
{
	private $id;
	private $title;

    public function __construct(int $id, string $title)
    {
		$this->id = $id;
		$this->title = $title;
    }

    public static function AnnounceToAllServers(): void
	{
		throw new NotImplementedException();
	}

    public abstract function Announce(string $announcement, Profile $profile): void;

    public abstract function Activate(Transaction $transaction): void;
}
