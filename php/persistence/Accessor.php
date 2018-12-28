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

	function GetTransactionByProfileAndProduct(Profile $profile, Product $product): ?GameServer
	{
		// TODO: Implement GetTransactionByProfileAndProduct() method.
		throw new NotImplementedException();
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
        ");

		$transactions = array();

		while ($result = $results->fetch_object())
		{
			$transactions[] = new Transaction($this, $result->id, $result->time, $result->amount, $result->token, $result->profile);
		}

		return $transactions;
	}
}
