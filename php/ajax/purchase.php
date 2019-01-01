<?php

require_once("../init.php");

use Ajax\Ajax;
use Domain\Shop;
use Persistence\Accessor;
use Presentation\AccessPoint;
use Persistence\ProfileAccessor;

header('Content-type: text/xml');
$ajax = new Ajax();
$input = $_POST ? $_POST : $_GET;
$productId = $input['product'];
$token = isset($input['token']) ? $input['token'] : null;

$pac = new ProfileAccessor();

$profile = AccessPoint::GetProfile($pac);
if($profile == null)
{
	$ajax->error("user", "You must be logged in");
}

$ac = new Accessor();

$shop = new Shop($ac, $profile);

$product = $shop->GetProductById($productId);

if ($product != null)
{
	if (!$shop->IsOwned($product))
	{
		$shop->Purchase($product, $token);
	}
	else
	{
		$ajax->error("product", "You already own this product!");
	}
}
else
{
	$ajax->error("product", "Specified product does not exist!");
}

echo $ajax->asXML();
