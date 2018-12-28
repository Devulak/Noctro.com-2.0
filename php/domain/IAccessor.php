<?php

namespace Domain;

interface IAccessor
{
    function GetGameServerById(int $id): ?GameServer;

    function GetTransactionByProfileAndProduct(Profile $profile, Product $product): ?GameServer;

    function GetTransactionsByProfile(Profile $profile): array;
}