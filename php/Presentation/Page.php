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
        $config = Config::GetInit();

		LinkCollector::addLink('init');
		LinkCollector::addLink('colours');
		LinkCollector::addScript('ogs');

		$template = new TemplateEngine("../PresentationHTML/HTMLPage.php");

        $template->Assign("Name", $config['name']);
        $template->Assign("Path", Config::GetPath());
        $template->Assign("StripePublicKey", Config::GetStripe()["public_key"]);
        $template->Assign("RecaptchaSiteKey", Config::GetRecaptcha()["site_key"]);

		$this->doc = new DOMDocument();
        $template->Assign("Body", "");
		$this->doc->loadHTML($template->Compiled);

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
