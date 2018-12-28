<?php

namespace Domain;

interface IAccessor
{
	public function GetGameServerById(int $id): ?GameServer;

	public function GetTransactionByProfileAndProduct(Profile $profile, Product $product): ?Transaction;

    public function GetTransactionsByProfile(Profile $profile): array;

	public function GetProductById(?int $id): ?Product;

	public function GetAllProducts(): array;

	public function GetAllInheritProductFromProduct(Product $product): array;

	public function GetUnclaimedGameCodes(): array;

	public function GetClaimedGameCodes(Profile $profile): array;
}