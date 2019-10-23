<?php

use Presentation\LinkCollector;
use Presentation\Page;
use Presentation\TemplateEngine;

require_once 'php/init.php';

http_response_code(404);

LinkCollector::addLink('login');
LinkCollector::addScript('dust');

$doc = new Page();

$doc->setTitle('Oh no, something went wrong!');

$doc->AppendToBody(new TemplateEngine("Error.php"));

$doc->Display();