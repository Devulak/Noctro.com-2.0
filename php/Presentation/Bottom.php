<?php

namespace Presentation;

use SimpleXMLElement;

class Bottom extends XMLSnip
{
	function __construct()
	{
		LinkCollector::addLink('bottom');

        $template = new TemplateEngine("../PresentationHTML/HTMLBottom.php");

		$this->xml = new SimpleXMLElement($template->Compiled);
	}
}
