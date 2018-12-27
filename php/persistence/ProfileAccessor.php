<?php

namespace Persistence;

use Domain\IProfileAccessor;
use Domain\NotImplementedException;
use Domain\Profile;

class ProfileAccessor extends Connection implements IProfileAccessor
{

    function GetProfileByToken(string $token): Profile
    {
        $con = self::GetConnection();

        $results = $con->query("
            SELECT
                `id`,
                `email`,
                `hash`,
                `token`
            FROM `user_users`
        ");

        $result = $results->fetch_object("Profile");
        
        return $result;
    }

    function  CreateProfile(string $email, string $hash): Profile
    {
        throw new NotImplementedException();
        // TODO: Implement  CreateProfile() method.
    }

    function GetProfileByEmail(string $email): Profile
    {
        throw new NotImplementedException();
        // TODO: Implement GetProfileByEmail() method.
    }

    function GetAllLinks(int $id): array
    {
        throw new NotImplementedException();
        // TODO: Implement GetAllLinks() method.
    }
}