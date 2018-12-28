<?php

namespace Presentation;

use SimpleXMLElement;

abstract class XMLSnip
{
	protected $xml;

	protected function saveXML(SimpleXMLElement $xml)
	{
		$dom = dom_import_simplexml($xml);
		return $dom->ownerDocument->saveXML($dom->ownerDocument->documentElement);
	}

	public function getXML()
	{
		return $this->saveXML($this->xml);
	}
}