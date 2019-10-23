<?php

namespace Presentation;

use Persistence\Config;

class Page
{
	private $template;
    private $bodyParts = array();

	public function __construct()
	{
        $config = Config::GetInit();

		LinkCollector::addLink('init');
		LinkCollector::addLink('colours');
		LinkCollector::addScript('ogs');

		$this->template = new TemplateEngine("../PresentationHTML/HTMLPage.php");

        $this->template->assign("name", $config['name']);
        $this->template->assign("path", Config::GetPath());
        $this->template->assign("stripePublicKey", Config::GetStripe()["public_key"]);
        $this->template->assign("recaptchaSiteKey", Config::GetRecaptcha()["site_key"]);
	}

	public function setTitle($subject)
	{
        $this->template->assign("title", $subject);
	}

    public function AppendToBody(TemplateEngine $appending): void
    {
        $this->bodyParts[] = $appending;
    }

    public function Display(): void
    {
        $this->template->assign("links", LinkCollector::getLinks());

        $body = "";
        /** @var TemplateEngine $bodyPart */
        foreach ($this->bodyParts as $bodyPart)
        {
            $body .= $bodyPart->Compile();
        }

        $this->template->assign("body", $body);
        //$this->template->Assign("body", implode($this->bodyParts));

        echo $this->template->Compile();
    }
}
