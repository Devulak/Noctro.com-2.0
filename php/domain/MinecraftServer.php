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

	public function Announce(string $announcement, Profile $profile, string $special): void
    {
		$links = $profile->GetAllLinks();

		foreach	($links as $link)
		{
			if ($link instanceof MojangLink)
			{
				$rcon = new Rcon($this->rconIp, $this->rconPort, $this->rconPassword);

				if ($rcon->connect())
				{
					$username = $link->GetUsername();

					$rcon->sendCommand("broadcast &9&l$username&f $announcement &c&l$special&f.");
					$rcon->disconnect();
				}
			}
		}
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
					$username = $link->GetUsername();

					$productTitle = $product->GetTitle();

					$rcon->sendCommand("upc setGroups $username $productTitle");
					$rcon->sendCommand("broadcast &9&l$username&f just purchased &c&l$productTitle&f rank!");
					$rcon->disconnect();
				}
			}
		}
    }
}
