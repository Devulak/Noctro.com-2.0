<?php

namespace Persistence;

class Config
{
    private static $config;

    public static function GetInit()
    {
        self::GetConfig();
        return self::$config['init'];
    }

    public static function GetDatabase()
    {
        self::GetConfig();
        return self::$config['database'];
    }

    public static function GetSteam()
    {
        self::GetConfig();
        return self::$config['steam'];
    }

    public static function GetStripe()
    {
        self::GetConfig();
        return self::$config['stripe'];
    }

    public static function GetRecaptcha()
    {
        self::GetConfig();
        return self::$config['recaptcha'];
    }

	public static function GetPath(): string
	{
		return self::GetInit()["path"];
	}

    private static function GetConfig()
    {
        if (!self::$config)
        {
			self::$config = parse_ini_file(__DIR__ . '/../../../config.ini', true);
        }
    }
}
