<?php

namespace Presentation;

use SimpleXMLElement;

class Bottom extends XMLSnip
{
	function __construct()
	{
		LinkCollector::addLink('bottom');

		$this->xml = new SimpleXMLElement("<div />");
		$this->xml->addAttribute("class", "bottom");
		$image = $this->xml->addChild("img");
		$image->addAttribute("src", "images/kelvin.svg");
	}
}
