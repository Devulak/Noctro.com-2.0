<?php

namespace Presentation;

use Domain\IProfileAccessor;
use Domain\Profile;

class AccessPoint
{
    private static $profile;

    public static function GetProfile(IProfileAccessor $ac)
    {
        if(!self::$profile)
        {
            if (isset($_COOKIE["token"]))
            {
                $_SESSION["token"] = $_COOKIE["token"];
            }
            if (isset($_SESSION["token"]))
            {
				self::$profile = Profile::GetByToken($ac, $_SESSION['token']);
				if (self::$profile != null)
				{
					self::Login(self::$profile);
				}
            }
        }
        return self::$profile;
    }

    public static function Login(Profile $profile)
    {
        setcookie("token", $profile->GetToken(), time()+60*60*24*365, "/");
    }

    public static function Logout()
    {
        setcookie("token", "", time()-60*60*24*365, "/");
        $_SESSION["token"] = false;
    }
}
