<?php

namespace Presentation;

use Persistence\Config;

class LinkCollector
{
	private static $collector = array();

	public static function addLink($name)
	{
		self::add('<link rel="stylesheet" href="' . Config::GetPath() . 'css/' . htmlspecialchars($name) . '.css" />');
	}

	public static function addRemoteLink($path)
	{
		self::add('<link rel="stylesheet" href="' . htmlspecialchars($path) . '" />');
	}

	public static function addScript($name)
	{
		self::add('<script src="' . Config::GetPath() . 'js/' . htmlspecialchars($name) . '.js"></script>');
	}

	public static function addRemoteScript($path)
	{
		self::add('<script src="' . htmlspecialchars($path) . '"></script>');
	}

	private static function add($link)
	{
		if (!in_array($link, self::$collector))
		{
			self::$collector[] = $link;
		}
	}

	public static function getLinks()
	{
		return self::$collector;
	}
}
