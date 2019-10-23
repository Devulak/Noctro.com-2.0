<?php

use Persistence\Config;
use Presentation\LinkCollector;
use Presentation\AccessPoint;
use Presentation\Form;
use Presentation\Page;
use Presentation\TemplateEngine;

require_once 'php/init.php';

AccessPoint::Logout();

LinkCollector::addLink('login');
LinkCollector::addScript('dust');
LinkCollector::addLink('submit');
LinkCollector::addScript('ajax');
LinkCollector::addRemoteScript('https://www.google.com/recaptcha/api.js?render=' . Config::GetRecaptcha()["site_key"]);
LinkCollector::addScript('submit');

$doc = new Page();

$config = Config::GetInit();

$doc->setTitle('Register');

$doc->AppendToBody(new TemplateEngine("Register.php"));

$doc->Display();
