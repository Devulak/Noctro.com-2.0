<?php

require_once 'php/init.php';

use Presentation\Page;
use Presentation\TemplateEngine;

$doc = new Page();
$doc->setTitle('Terms of Service and Privacy Policy');

$template = new TemplateEngine("Terms.php");

$doc->AppendToBody($template);

$doc->Display();
