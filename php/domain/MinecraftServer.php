<?php

namespace Domain;

use Exception;
use SourceQuery\SourceQuery;

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
				$sq = new SourceQuery();

				$username = $link->GetUsername();

				try
				{
					$sq->Connect($this->rconIp, $this->rconPort);

					$sq->SetRconPassword($this->rconPassword);

					$sq->Rcon("broadcast &9&l$username&f $announcement &c&l$special&f.");
				}
				catch(Exception $e)
				{
					echo $e->getMessage();
				}
				finally
				{
					$sq->Disconnect();
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
				$sq = new SourceQuery();

				$username = $link->GetUsername();

				$productTitle = $product->GetTitle();

				try
				{
					$sq->Connect($this->rconIp, $this->rconPort);

					$sq->SetRconPassword($this->rconPassword);

					$sq->Rcon("upc setGroups $username $productTitle");
					$sq->Rcon("broadcast &9&l$username&f just purchased &c&l$productTitle&f rank!");
				}
				catch(Exception $e)
				{
					echo $e->getMessage();
				}
				finally
				{
					$sq->Disconnect();
				}
			}
		}
    }
}
