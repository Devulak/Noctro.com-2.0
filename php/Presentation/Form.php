<?php

namespace Presentation;

use Persistence\Config;
use SimpleXMLElement;

class Form
{
    private $xml;

    public function __construct(string $action)
    {
        LinkCollector::addLink('submit');
        LinkCollector::addScript('ajax');
        LinkCollector::addRemoteScript('https://www.google.com/recaptcha/api.js?render=' . Config::GetRecaptcha()["site_key"]);
        LinkCollector::addScript('submit');


        $xml = "<form class='submit' method='post' action='$action'/>";

        $this->xml = new SimpleXMLElement($xml);
    }

    public function addTitle($title)
    {
        $this->xml->addChild('h1', $title);
    }

    public function addDescription($description)
    {
        $this->xml->addChild('h2', $description);
    }

    public function addInput($label, $type, $name)
    {
        // Label
        $label = $this->xml->addChild("label", $label);
        $label->addAttribute("data-error", $name);

        // Input
        $input = $this->xml->addChild("input");
        $input->addAttribute("type", $type);
        $input->addAttribute("name", $name);
    }

    public function addSubmit($name)
    {
        /*$input = $this->xml->addChild("button", $name);
        $input->addAttribute("class", "g-recaptcha");
        $input->addAttribute("data-sitekey", "6LfpZXQUAAAAAJy_PNRYX1AO2hiOdACK1oX9cygA");
        $input->addAttribute("data-callback", "YourOnSubmitFn");*/



        $input = $this->xml->addChild("input");
        $input->addAttribute("type", "submit");
        $input->addAttribute("value", $name);
    }

    public function addSub($description)
    {
        $toDom = dom_import_simplexml($this->xml);
        $fromDom = dom_import_simplexml(simplexml_load_string('<sub>' . $description . '</sub>'));
        $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
    }

    public function getXML()
    {
        return $this->saveXML($this->xml);
    }
}
