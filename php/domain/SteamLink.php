<?php

namespace Domain;

use ErrorException;
use Exception;
use Persistence\Config;

class SteamLink extends Link
{
	public function __construct(IProfileAccessor $ac, int $id, string $bind)
	{
		parent::__construct($ac, $id, $bind);
	}

	public function GetUsername(): string
	{
		$config = Config::GetSteam();
		$url = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" . $config['apikey'] . "&steamids=" . $this->bind);
		$content = json_decode($url);

		$content = $content->response->players{0};

		return $content->personaname;

		/*$this->steamid = $content->steamid;
		$this->communityvisibilitystate = $content->communityvisibilitystate;
		$this->profilestate = $content->profilestate;
		$this->personaname = $content->personaname;
		$this->lastlogoff = $content->lastlogoff;
		$this->commentpermission = $content->commentpermission;
		$this->profileurl = $content->profileurl;
		$this->avatar = $content->avatar;
		$this->avatarmedium = $content->avatarmedium;
		$this->avatarfull = $content->avatarfull;
		$this->personastate = $content->personastate;
		$this->primaryclanid = $content->primaryclanid;
		$this->timecreated = $content->timecreated;
		$this->personastateflags = $content->personastateflags;*/
	}

	public static function Create(IProfileAccessor $ac, Profile $profile, string $bind): Link
	{
		return $ac->CreateSteamLink($profile, $bind);
	}

	static function AttemptSteamInfo(): ?string
	{
		try
		{
			$openid = new LightOpenID($_SERVER["SERVER_NAME"]);

			if(!$openid->mode)
			{
				$openid->identity = 'https://steamcommunity.com/openid';
				header('Location: ' . $openid->authUrl());
			}
			elseif ($openid->mode == 'cancel')
			{
				throw new Exception("User has canceled authentication");
			}
			else
			{
				if($openid->validate())
				{
					$id = $openid->identity;
					$ptn = "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
					preg_match($ptn, $id, $matches);

					return $matches[1];
				}
				else
				{
					throw new Exception("User is not logged in");
				}
			}
		}
		catch(ErrorException $e)
		{
			echo $e->getMessage();
		}
		return null;
	}
}