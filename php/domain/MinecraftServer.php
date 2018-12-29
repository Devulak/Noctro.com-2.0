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
		$profile = $transaction->GetProfile();

		$product = $transaction->GetProduct();

		$links = $profile->GetAllLinks();
		foreach	($links as $link)
		{
			if ($link instanceof MojangLink)
			{
				$rcon = new Rcon($this->rconIp, $this->rconPort, $this->rconPassword);

				if ($rcon->connect())
				{
					$rcon->sendCommand("upc setGroups " . $link->GetUsername() . " " . $product->GetTitle());
					$rcon->sendCommand("broadcast &9&l" . $link->GetUsername() . "&f just purchased &c&l" . $product->GetTitle() . "&f rank!");
				}
			}
		}
    }
}
