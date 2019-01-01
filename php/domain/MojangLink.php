<?php

namespace Domain;

class MojangLink extends Link
{
	public function __construct(IProfileAccessor $ac, int $id, string $bind)
	{
		parent::__construct($ac, $id, $bind);
	}

	public function GetUsername(): string
    {
    	return $this->bind;
    }

	public static function Create(IProfileAccessor $ac, Profile $profile, string $bind): Link
	{
		return $ac->CreateMojangLink($profile, $bind);
	}
}
