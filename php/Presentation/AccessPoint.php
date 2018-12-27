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
            if($_COOKIE["token"] != null)
            {
                $_SESSION["token"] = $_COOKIE["token"];
            }
            if($_SESSION["token"] != null)
            {
				self::$profile = Profile::GetByToken($ac, $_SESSION['token']);
            }
        }
        return self::$profile;
    }

    public static function login(Profile $profile)
    {
        setcookie("token", $profile->GetToken(), time()+60*60*24*365, "/");
    }

    public static function logout()
    {
        setcookie("token", "", time()-60*60*24*365, "/");
        $_SESSION["token"] = false;
    }
}
