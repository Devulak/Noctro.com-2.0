<?php

namespace Presentation;

use DOMDocument;
use DOMElement;
use Persistence\Config;

class Page
{
	private $doc;
	private $head;
	private $body;
	private $title;

	public function __construct()
	{
		LinkCollector::addLink('init');
		LinkCollector::addLink('colours');
		LinkCollector::addScript('ogs');

		$this->doc = new DOMDocument();
		$config = Config::GetInit();
		$this->doc->loadHTML('
			<!DOCTYPE html>
			<html lang="uk">
				<head>
					<meta charset="utf-8">
					<title>' . htmlspecialchars($config['name']) . '</title>
					<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
					<meta name="description" content="For beauty, for glory and for friends. ' . $config['name'] . ' is a place for people to play together as a community sharing the love of games.">
					<meta property="og:image" content="' . Config::GetPath() . '/images/logo.svg">
					<script>var stripePublicKey = "' . Config::GetStripe()["public_key"] . '";</script>
					<script>var recaptchaSiteKey = "' . Config::GetRecaptcha()["site_key"] . '";</script>
				</head>
				<body>
				</body>
			</html>
		');

		$this->head = $this->doc->documentElement->getElementsByTagName('head')[0];

		$this->title = $this->doc->documentElement->getElementsByTagName('title')[0];

		$this->body = $this->doc->documentElement->getElementsByTagName('body')[0];
	}

	public function setTitle($subject)
	{
		$config = Config::GetInit();
		$this->title->nodeValue = htmlspecialchars($subject . ' - ' . $config['name']);
	}

	private function appendXMLToElement($xml, DOMElement $element, DOMDocument $document)
	{
		$fragment = $document->createDocumentFragment();
		$fragment->appendXML($xml);
		$element->appendChild($fragment);
	}

	public function appendXML($xml)
	{
		$this->appendXMLToElement($xml, $this->body, $this->doc);
	}

	public function appendXMLSnip(XMLSnip $snip)
	{
		$this->appendXMLToElement($snip->getXML(), $this->body, $this->doc);
	}

	public function Print(): void
	{
		// Clone the DOM so it doesn't mess with the constructed DOM
		$doc = clone $this->doc;

		// Get cloned head
		$head = $doc->documentElement->getElementsByTagName('head')[0];

		// Add LinkCollector to the mix
		$links = LinkCollector::getLinks();
		foreach ($links as $key => $value)
		{
			$this->appendXMLToElement($value, $head, $doc);
		}

		echo $doc->saveHTML();
	}
}
