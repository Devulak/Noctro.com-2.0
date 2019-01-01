<?php

namespace Domain;

abstract class Link
{
	protected $ac;
	protected $id;
	protected $bind;

	protected function __construct(IProfileAccessor $ac, int $id, string $bind)
	{
		$this->ac = $ac;
		$this->id = $id;
		$this->bind = $bind;
	}

	public function GetId(): int
	{
		return $this->id;
	}

	public abstract static function Create(IProfileAccessor $ac, Profile $profile, string $bind): Link;

	public abstract function GetUsername(): string;
}
