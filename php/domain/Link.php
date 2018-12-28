<?php

namespace Domain;

abstract class Link
{
	protected $id;
	protected $bind;

	protected function __construct(int $id, string $bind)
	{
		$this->id = $id;
		$this->bind = $bind;
	}

	public abstract function GetUsername(): string;
}
