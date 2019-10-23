<?php

namespace Presentation;

class Bottom extends TemplateEngine
{
	function __construct()
	{
	    parent::__construct("../PresentationHTML/HTMLBottom.php");

		LinkCollector::addLink('bottom');
	}
}
