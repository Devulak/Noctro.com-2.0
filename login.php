<?php

use Persistence\Config;
use Presentation\LinkCollector;
use Presentation\Page;
use Presentation\TemplateEngine;
use Presentation\AccessPoint;

require_once 'php/init.php';

AccessPoint::Logout();

LinkCollector::addLink('login');
LinkCollector::addScript('dust');
LinkCollector::addLink('submit');
LinkCollector::addScript('ajax');
LinkCollector::addRemoteScript('https://www.google.com/recaptcha/api.js?render=' . Config::GetRecaptcha()["site_key"]);
LinkCollector::addScript('submit');

$doc = new Page();

$doc->setTitle('Login');

$template = new TemplateEngine("Login.php");

$doc->AppendToBody($template);

$doc->Display();
