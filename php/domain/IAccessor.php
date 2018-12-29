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

	public function ClaimGameCode(GameCode $gameCode, Profile $profile): void;

	public function AddBalance(Profile $profile, int $amount, string $token): void;

	public function CreatePurchase(Profile $profile, Product $product, int $amount): Transaction;

	public function GetProfileById(int $profileId): ?Profile;

	public function GetAllGameServers(): array;
}