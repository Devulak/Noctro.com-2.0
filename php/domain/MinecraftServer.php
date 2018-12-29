<?php

namespace Domain;

class MinecraftServer extends GameServer
{
	private $rconIp;
	private $rconPort;
	private $rconPassword;

	public function __construct(int $id, string $title, string $rconIp, int $rconPort, string $rconPassword)
	{
		parent::__construct($id, $title);
		$this->rconIp = $rconIp;
		$this->rconPort = $rconPort;
		$this->rconPassword = $rconPassword;
	}

	public function Announce(string $announcement, Profile $profile): void
    {
        throw new NotImplementedException();
    }

    public function Activate(Transaction $transaction): void
    {
        throw new NotImplementedException();
    }
}
