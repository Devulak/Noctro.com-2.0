<?php

namespace Ajax;

use Persistence\Config;
use SimpleXMLElement;

class Ajax
{
	private $xml;

	public function __construct()
	{
		$this->xml = new SimpleXMLElement("<xml/>");
	}

	public function error($tag, $description)
	{
		$error = $this->xml->addChild('error', $description);
		$error->addAttribute("name", $tag);
	}

	public function hasErrors()
	{
		return $this->xml->error;
	}

	public function redirect($location)
	{
		$this->xml->addChild('redirect', $location);
	}

	public function GetRecaptcha($token)
	{
		if (!isset($token))
		{
			return null;
		}

		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$data = array(
			'secret' => Config::GetRecaptcha()["secret_key"],
			'response' => $token,
			'remoteip' => $_SERVER['REMOTE_ADDR']
		);

		$options = array(
			'http' => array(
				'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
				'method' => 'POST',
				'content' => http_build_query($data)
			)
		);

		$context = stream_context_create($options);
		$verify = file_get_contents($url, false, $context);
		return json_decode($verify);
	}

	public function asXML()
	{
		return $this->xml->asXML();
	}
}