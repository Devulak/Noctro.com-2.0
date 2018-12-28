<?php

namespace persistence;

use Domain\GameServer;
use Domain\IAccessor;
use Domain\NotImplementedException;
use Domain\Product;
use Domain\Profile;
use Domain\Transaction;

class Accessor extends Connection implements IAccessor
{
	function GetGameServerById(int $id): ?GameServer
	{
		// TODO: Implement GetGameServerById() method.
		throw new NotImplementedException();
	}

	function GetTransactionByProfileAndProduct(Profile $profile, Product $product): ?Transaction
	{
		$con = self::GetConnection();

		$profileId = $profile->GetId();

		$productId = $product->GetId();

		$results = $con->query("
            SELECT
                `id`,
                `user` as profile,
                `time`,
                `amount`,
                `product`,
                `token`
            FROM `balance`
			WHERE `user` = '$profileId'
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
                `user` as profile,
                `time`,
                `amount`,
                `product`,
                `token`
            FROM `balance`
			WHERE `user` = '$profileId'
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
                `game_server`
            FROM `shop_product`
			WHERE `id` = '$id'
        ");

		if ($results->num_rows > 0)
		{
			$result = $results->fetch_object();

			return new Product($this, $result->id, $result->title, $result->game_server, $result->price, $result->inherit);
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
                `game_server`
            FROM `shop_product`
        ");

		$products = array();

		while ($result = $results->fetch_object())
		{
			$products[] = new Product($this, $result->id, $result->title, $result->game_server, $result->price, $result->inherit);
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
                `game_server`
            FROM `shop_product`
			WHERE `inherit` = '$productId'
        ");

		$products = array();

		while ($result = $results->fetch_object())
		{
			$products[] = new Product($this, $result->id, $result->title, $result->game_server, $result->price, $result->inherit);
		}

		return $products;
	}
}
