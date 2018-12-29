<?php

namespace Domain;

class SteamLink extends Link
{
	public function __construct(IProfileAccessor $ac, int $id, string $bind)
	{
		parent::__construct($ac, $id, $bind);
	}

    public function GetUsername(): string
    {
        throw new NotImplementedException();
    }
}