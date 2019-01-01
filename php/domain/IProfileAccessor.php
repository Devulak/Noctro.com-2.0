<?php

namespace Domain;

interface IProfileAccessor
{
	public function GetProfileByToken(string $token): ?Profile;

	public function CreateProfile(string $email, string $hash): void;

	public function GetProfileByEmail(string $email): ?Profile;

    public function GetAllLinksByProfile(Profile $profile): array;

	public function DeleteLink(Link $link): void;

	public function CreateMojangLink(Profile $profile, string $bind): MojangLink;
}
