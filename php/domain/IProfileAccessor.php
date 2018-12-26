<?php

namespace Domain;

interface IProfileAccessor
{
    function GetProfileByToken(string $token);

    function  CreateProfile(string $email, string $hash);

    function GetProfileByEmail(string $email);

    function GetAllLinks(int $id);
}
