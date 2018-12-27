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

    public static function Create(IProfileAccessor $ac, string $email, string $hash): Profile
    {
        return $ac-> CreateProfile($email, $hash);
    }

    public static function GetByToken(IProfileAccessor $ac, string $token): Profile
    {
        return $ac->GetProfileByEmail($token);
    }

    public static function IsEmailAvailable(IProfileAccessor $ac, string $email): bool
    {
        if ($ac->GetProfileByEmail($email) == null)
        {
            return true;
        }
        return false;
    }

    public static function Login(IProfileAccessor $ac, string $email, string $password): Profile
    {
        throw new NotImplementedException();
		//return password_verify($password, $this->hash);
    }

    public function GetAllLinks(): array
    {
        return $this->ac->GetAllLinks($this->id);
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
