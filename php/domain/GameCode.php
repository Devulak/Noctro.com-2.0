<?php

namespace Domain;

class GameCode
{
	private $id;
	private $title;
	private $code;
	private $profile;
	private $time;

	public function __construct(int $id, string $title, string $code, ?int $profile = null, ?int $time = null)
	{
		$this->id = $id;
		$this->title = $title;
		$this->code = $code;
		$this->profile = $profile;
		$this->time = $time;
	}

	public function GetId(): int
	{
		return $this->id;
	}

	public function GetTitle(): string
	{
		return $this->title;
	}

	public function GetCode(Profile $profile): ?string
	{
		if ($profile->GetId() == $this->profile)
		{
			return $this->code;
		}
		return null;
	}

	public function GetTime(): int
	{
		return $this->time;
	}
}
