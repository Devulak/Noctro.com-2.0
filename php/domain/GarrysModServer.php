<?php

namespace Domain;

use Exception;
use SourceQuery\SourceQuery;

class GarrysModServer extends GameServer
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
			if ($link instanceof SteamLink)
			{
				$sq = new SourceQuery();

				$username = $link->GetUsername();

				try
				{
					$sq->Connect($this->rconIp, $this->rconPort);

					$sq->SetRconPassword($this->rconPassword);

					$sq->Rcon("ev pa [$username] $announcement [$special].");
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

		$productTitle = $product->GetTitle();

		$links = $profile->GetAllLinks();

		foreach	($links as $link)
		{
			if ($link instanceof SteamLink)
			{
				$sq = new SourceQuery();

				$steamId64 = $link->GetBind();

				$accountID = bcsub($steamId64, '76561197960265728');
				$steamId2 = 'STEAM_0:' . bcmod($accountID, '2') . ':' . bcdiv($accountID, 2);

				try
				{
					$sq->Connect($this->rconIp, $this->rconPort);

					$sq->SetRconPassword($this->rconPassword);

					$sq->Rcon("ev rank \"$steamId2\" $productTitle");
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
