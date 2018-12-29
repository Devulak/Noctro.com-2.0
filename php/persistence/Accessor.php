<?php

namespace persistence;

use domain\GameCode;
use Domain\GameServer;
use Domain\IAccessor;
use Domain\MinecraftServer;
use Domain\NotImplementedException;
use Domain\Product;
use Domain\Profile;
use Domain\Transaction;

class Accessor extends Connection implements IAccessor
{
	function GetTransactionByProfileAndProduct(Profile $profile, Product $product): ?Transaction
	{
		$con = self::GetConnection();

		$profileId = $profile->GetId();

		$productId = $product->GetId();

		$results = $con->query("
            SELECT
                `id`,
                `profile`,
                `time`,
                `amount`,
                `product`,
                `token`
            FROM `Transaction`
			WHERE `profile` = '$profileId'
            AND `product` = '$productId'
			ORDER BY `id` DESC
        ");

		if ($results->num_rows > 0)
		{
			$result = $results->fetch_object();

			return new Transaction($this, $result->id, $result->time, $result->amount, $result->profile, $result->token, $result->product);
		}
		return null;
	}

	function GetTransactionsByProfile(Profile $profile): array
	{
		$con = self::GetConnection();

		$profileId = $profile->GetId();

		$results = $con->query("
            SELECT
                `id`,
                `profile`,
                `time`,
                `amount`,
                `product`,
                `token`
            FROM `Transaction`
			WHERE `profile` = '$profileId'
			ORDER BY `id` DESC
        ");

		$transactions = array();

		while ($result = $results->fetch_object())
		{
			$transactions[] = new Transaction($this, $result->id, $result->time, $result->amount, $result->profile, $result->token, $result->product);
		}

		return $transactions;
	}

	public function GetProductById(?int $id): ?Product
	{
		$con = self::GetConnection();

		$results = $con->query("
            SELECT
                `id`,
                `title`,
                `info`,
                `price`,
            	`inherit`,
                `gameServer`
            FROM `Product`
			WHERE `id` = '$id'
        ");

		if ($results->num_rows > 0)
		{
			$result = $results->fetch_object();

			return new Product($this, $result->id, $result->title, $result->gameServer, $result->price, $result->inherit);
		}
		else
		{
			return null;
		}
	}

	public function GetAllProducts(): array
	{
		$con = self::GetConnection();

		$results = $con->query("
            SELECT
                `id`,
                `title`,
                `info`,
                `price`,
            	`inherit`,
                `gameServer`
            FROM `Product`
        ");

		$products = array();

		while ($result = $results->fetch_object())
		{
			$products[] = new Product($this, $result->id, $result->title, $result->gameServer, $result->price, $result->inherit);
		}

		return $products;
	}

	public function GetAllInheritProductFromProduct(Product $product): array
	{
		$con = self::GetConnection();

		$productId = $product->GetId();

		$results = $con->query("
            SELECT
                `id`,
                `title`,
                `info`,
                `price`,
            	`inherit`,
                `gameServer`
            FROM `Product`
			WHERE `inherit` = '$productId'
        ");

		$products = array();

		while ($result = $results->fetch_object())
		{
			$products[] = new Product($this, $result->id, $result->title, $result->gameServer, $result->price, $result->inherit);
		}

		return $products;
	}

	public function GetUnclaimedGameCodes(): array
	{
		$con = self::GetConnection();

		$results = $con->query("
            SELECT
                `id`,
                `title`,
                `code`,
                `profile`,
            	`time`
            FROM `GameCode`
			WHERE `profile` IS NULL
        ");

		$gameCodes = array();

		while ($result = $results->fetch_object())
		{
			$gameCodes[] = new GameCode($result->id, $result->title, $result->code, $result->profile, $result->time);
		}

		return $gameCodes;
	}

	public function GetClaimedGameCodes(Profile $profile): array
	{
		$con = self::GetConnection();

		$profileId = $profile->GetId();

		$results = $con->query("
            SELECT
                `id`,
                `title`,
                `code`,
                `profile`,
            	`time`
            FROM `GameCode`
			WHERE `profile` = '$profileId'
        ");

		$gameCodes = array();

		while ($result = $results->fetch_object())
		{
			$gameCodes[] = new GameCode($result->id, $result->title, $result->code, $result->profile, $result->time);
		}

		return $gameCodes;
	}

	public function ClaimGameCode(GameCode $gameCode, Profile $profile): void
	{
		$con = self::GetConnection();

		$profileId = $profile->GetId();

		$gameCodeId = $gameCode->GetId();

		$time = time();

		$con->query("
			UPDATE `GameCode`
			SET `profile` = $profileId,
			    `time` = $time
			WHERE id = $gameCodeId
		");
	}

	public function AddBalance(Profile $profile, int $amount, string $token): void
	{
		$con = self::GetConnection();

		$profileId = $profile->GetId();

		$time = time();

		$token = $con->real_escape_string($token);

		$con->query("
			INSERT INTO Transaction (profile, time, amount, token) VALUES
			($profileId, $time, $amount, '$token')
		");
	}

	public function CreatePurchase(Profile $profile, Product $product, int $amount): Transaction
	{
		$con = self::GetConnection();

		$profileId = $profile->GetId();

		$time = time();

		$productId = $product->GetId();

		$con->query("
			INSERT INTO Transaction (profile, time, amount, product) VALUES
			($profileId, $time, -$amount, $productId)
		");

		return $this->GetTransactionByProfileAndProduct($profile, $product);
	}

	public function GetProfileById(int $profileId): ?Profile
	{
		$con = self::GetConnection();

		$results = $con->query("
            SELECT
                `id`,
                `email`,
                `hash`,
                `token`
            FROM `Profile`
			WHERE `id` = '$profileId'
        ");

		if ($results->num_rows > 0)
		{
			$result = $results->fetch_object();

			return new Profile(new ProfileAccessor(), $result->id, $result->email, $result->hash, $result->token);
		}
		else
		{
			return null;
		}
	}

	public function GetGameServerById(int $gameServerId): ?GameServer
	{
		$con = self::GetConnection();

		$results = $con->query("
            SELECT
                `id`,
                `title`,
                `rconIp`,
                `rconPort`,
                `rconPassword`
            FROM `GameServer`
            
            INNER JOIN MinecraftServer
            ON MinecraftServer.gameServer = GameServer.id
            
			WHERE `id` = '$gameServerId'
        ");

		if ($results->num_rows > 0)
		{
			$result = $results->fetch_object();

			return new MinecraftServer($result->id, $result->title, $result->rconIp, $result->rconPort, $result->rconPassword);
		}
		return null;
	}

	public function GetAllGameServers(): array
	{
		$con = self::GetConnection();

		$results = $con->query("
            SELECT
                `id`,
                `title`,
                `rconIp`,
                `rconPort`,
                `rconPassword`
            FROM `GameServer`
            
            INNER JOIN MinecraftServer
            ON MinecraftServer.gameServer = GameServer.id
        ");

		$gameServers = array();

		while ($result = $results->fetch_object())
		{
			$gameServers[] = new MinecraftServer($result->id, $result->title, $result->rconIp, $result->rconPort, $result->rconPassword);
		}

		return $gameServers;
	}
}
