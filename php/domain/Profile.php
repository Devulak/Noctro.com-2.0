<?php

namespace Domain;

class Profile
{
    private $ac;
    private $id;
    private $email;

    public function __construct(IProfileAccessor $ac, int $id, string $email)
    {
        $this->ac = $ac;
        $this->id = $id;
        $this->email = $email;
    }

    public static function Create(IProfileAccessor $ac, string $email, string $hash)
    {
        return $ac-> CreateProfile($email, $hash);
    }

    public static function GetByToken(IProfileAccessor $ac, string $token)
    {
        return $ac->GetProfileByEmail($token);
    }

    public static function GetByEmail(IProfileAccessor $ac, string $email)
    {
        return $ac->GetProfileByEmail($email);
    }

    public function GetAllLinks()
    {
        return $this->ac->GetAllLinks($this->id);
    }

    public function GetId()
    {
        return $this->id;
    }

    public function GetEmail()
    {
        return $this->email;
    }
}
