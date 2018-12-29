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
}
