<?php

namespace Presentation;

use Domain\MojangLink;
use Domain\Profile;
use Domain\SteamLink;
use SimpleXMLElement;

class LinkAccount extends TemplateEngine
{
	private $profile;

	function __construct(Profile $profile)
	{
        parent::__construct("../PresentationHTML/HTMLLinkAccount.php");

		$this->profile = $profile;

		LinkCollector::addLink('formstyle');
		LinkCollector::addLink('blockhandle');

        $links = $this->profile->GetAllLinks();

        $this->assign("steamLink", null);
        $this->assign("mojangLink", null);

        $steamLink = null;
        foreach	($links as $link)
        {
            if ($link instanceof SteamLink)
            {
                $this->assign("steamLink", $link);
            }
            if ($link instanceof MojangLink)
            {
                $this->assign("mojangLink", $link);
            }
        }
	}
}
