<?php

require_once 'php/init.php';

use Presentation\Page;
use Presentation\LinkCollector;
use Presentation\TemplateEngine;

$doc = new Page();

LinkCollector::addLink('loading');
LinkCollector::addScript('loading');

$doc->setTitle('Loading');

$doc->AppendToBody(new TemplateEngine("Loading.php"));

$doc->Display();