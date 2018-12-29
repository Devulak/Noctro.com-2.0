<?php

namespace Presentation;

use Domain\MojangLink;
use Domain\Profile;
use SimpleXMLElement;

class LinkAccount extends XMLSnip
{
	private $profile;

	function __construct(Profile $profile)
	{
		$this->profile = $profile;

		LinkCollector::addLink('formstyle');
		LinkCollector::addLink('blockhandle');

		$this->xml = new SimpleXMLElement("<div />");
		$this->xml->addAttribute("class", "blocks");

		//$this->IncludeSteam();
		$this->IncludeMinecraft();
		//$this->IncludeDiscord();
	}

	private function IncludeSteam()
	{
		/*$block = $this->xml->addChild("div");
		$block->addAttribute("class", "block");

		$header = $block->addChild("h2", "Steam");

		if ($this->profile->getSteamID())
		{
			$steamInfo = new SteamInfo($this->profile->getSteamID());
			$description = $block->addChild("p", $steamInfo->personaname);
		}

		if (!$this->profile->getSteamID())
		{
			$link = $block->addChild("a", "Link Steam account");
			$link->addAttribute("href", "linksteamid.php");
		}
		else
		{
			$link = $block->addChild("a", "Unlink Steam account");
			$link->addAttribute("href", "unlinksteam.php");
		}
		$link->addAttribute("class", "buttonstyle");*/
	}

	private function IncludeMinecraft(): void
	{
		$block = $this->xml->addChild("div");
		$block->addAttribute("class", "block");

		$header = $block->addChild("h2", "Minecraft");

		$links = $this->profile->GetAllLinks();

		$mojangLink = null;
		foreach	($links as $link)
		{
			if ($link instanceof MojangLink)
			{
				$mojangLink = $link;
				break;
			}
		}

		if ($mojangLink != null)
		{
			$description = $block->addChild("p", $mojangLink->GetUsername());
			$link = $block->addChild("a", "Unlink Minecraft username");
			$link->addAttribute("href", "unlinkminecraft.php");
			$link->addAttribute("class", "buttonstyle");
		}
		else
		{
			$form = $block->addChild("form");
			$form->addAttribute("method", "post");
			$form->addAttribute("action", "linkminecraft.php");

			$username = $form->addChild("input");
			$username->addAttribute("type", "text");
			$username->addAttribute("class", "inputstyle");
			$username->addAttribute("name", "username");

			$submit = $form->addChild("input");
			$submit->addAttribute("type", "submit");
			$submit->addAttribute("class", "buttonstyle");
			$submit->addAttribute("value", "Link Minecraft username");
		}
	}
}
