<?php

namespace Presentation;

class Header extends XMLSnip
{
	public function Header()
	{
		LinkCollector::addLink('header');

		$xml = '
			<header class="container header change">
			</header>
		';

		$this->xml = new SimpleXMLElement($xml);
	}

	public function setSubject($subject)
	{
		$this->xml->addChild('h1', htmlspecialchars($subject));
		$this->setBackgroundText($subject);
	}

	public function setDescription($description, $secure = true)
	{
		if ($secure)
		{
			$description = htmlspecialchars($description);
			$description = $this->xml->addChild('div', $description);
			$description->addAttribute('class', 'description');
		}
		else
		{
			$toDom = dom_import_simplexml($this->xml);
			$fromDom = dom_import_simplexml(simplexml_load_string('<div class="description">' . $description . '</div>'));
			$toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
		}
	}

	public function setBackgroundText($text)
	{
		$attr = 'extra';

		if(!$this->xml->attributes()[$attr])
		{
			$this->xml->addAttribute($attr, $text);
		}
		else
		{
			$this->xml->attributes()[$attr] = $text;
		}
	}

	public function getXML()
	{
		return $this->saveXML($this->xml);
	}
}