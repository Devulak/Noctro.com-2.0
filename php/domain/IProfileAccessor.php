<?php

namespace Domain;

interface IProfileAccessor
{
    function GetProfileByToken(string $token): ?Profile;

    function  CreateProfile(string $email, string $hash): Profile;

    function GetProfileByEmail(string $email): ?Profile;

    function GetAllLinks(int $id): array;
}
