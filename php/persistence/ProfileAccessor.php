<?php

namespace Persistence;

use Domain\IProfileAccessor;
use Domain\Link;
use Domain\MojangLink;
use Domain\Profile;

class ProfileAccessor extends Connection implements IProfileAccessor
{

    function GetProfileByToken(string $token): ?Profile
    {
        $con = self::GetConnection();

        $token = $con->real_escape_string($token);

        $results = $con->query("
            SELECT
                `id`,
                `email`,
                `hash`,
                `token`
            FROM `Profile`
			WHERE `token` = '$token'
        ");

        if ($results->num_rows > 0)
		{
			$result = $results->fetch_object();

			return new Profile($this, $result->id, $result->email, $result->hash, $result->token);
		}
        else
        {
        	return null;
		}
    }

    public function CreateProfile(string $email, string $hash): void
    {
		$con = self::GetConnection();

		$email = $con->real_escape_string($email);

		$hash = $con->real_escape_string($hash);

		$con->query("
			INSERT INTO `Profile` (email, hash) VALUES
			('$email', '$hash')
		");

		$insertId = $con->insert_id;
		$token = sha1($insertId . microtime() . mt_rand());
		$token = $con->real_escape_string($token);

		$con->query("
				UPDATE Profile
				SET token = '$token'
				WHERE id = '$insertId' 
			");
    }

    function GetProfileByEmail(string $email): ?Profile
    {
		$con = self::GetConnection();

		$email = $con->real_escape_string($email);

		$results = $con->query("
            SELECT
                `id`,
                `email`,
                `hash`,
                `token`
            FROM `Profile`
			WHERE `email` = '$email'
        ");

		if ($results->num_rows > 0)
		{
			$result = $results->fetch_object();

			return new Profile($this, $result->id, $result->email, $result->hash, $result->token);
		}
		else
		{
			return null;
		}
    }

	function GetAllLinksByProfile(Profile $profile): array
	{
		return $this->GetAllMojangLinks($profile);
	}

	private function GetAllMojangLinks(Profile $profile): array
	{
		$con = self::GetConnection();

		$profileId = $profile->GetId();

		$results = $con->query("
            SELECT
                `id`,
                `bind`
            FROM `Link`
            
            INNER JOIN `MojangLink`
            ON MojangLink.link = Link.id
            
			WHERE `profile` = $profileId
        ");

		$mojangLinks = array();

		while ($result = $results->fetch_object())
		{
			$mojangLinks[] = new MojangLink($this, $result->id, $result->bind);
		}

		return $mojangLinks;
	}

	public function DeleteLink(Link $link): void
	{
		$con = self::GetConnection();

		$linkId = $link->GetId();

		$con->query("
			DELETE FROM Link
			WHERE id = $linkId
		");
	}
}