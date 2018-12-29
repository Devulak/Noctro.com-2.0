<?php

namespace Domain;

class Profile
{
    private $ac;
    private $id;
    private $email;
    private $hash;
    private $token;

    public function __construct(IProfileAccessor $ac, int $id, string $email, $hash, $token)
    {
        $this->ac = $ac;
        $this->id = $id;
        $this->email = $email;
        $this->hash = $hash;
        $this->token = $token;
    }

    public static function Create(IProfileAccessor $ac, string $email, string $password): void
    {
    	$ac->CreateProfile($email, password_hash($password, PASSWORD_DEFAULT));
    }

    public static function GetByToken(IProfileAccessor $ac, string $token): ?Profile
    {
        return $ac->GetProfileByToken($token);
    }

    public static function IsEmailAvailable(IProfileAccessor $ac, string $email): bool
    {
        if ($ac->GetProfileByEmail($email) == null)
        {
            return true;
        }
        return false;
    }

    public static function GetByEmailAndPassword(IProfileAccessor $ac, string $email, string $password): ?Profile
    {
		$profile = $ac->GetProfileByEmail($email);

		if (password_verify($password, $profile->hash))
		{
			return $profile;
		}
		return null;
    }

    public function GetAllLinks(): array
    {
        return $this->ac->GetAllLinksByProfile($this);
    }

	public function RemoveLink(Link $link): void
	{
		$this->ac->DeleteLink($link);
	}

    public function GetId(): int
    {
        return $this->id;
    }

	public function GetEmail(): string
	{
		return $this->email;
	}

	public function GetToken(): string
	{
		return $this->token;
	}
}
