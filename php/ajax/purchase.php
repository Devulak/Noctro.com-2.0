<?php

require_once("../init.php");

use Ajax\Ajax;
use Domain\Shop;
use persistence\Accessor;
use Presentation\AccessPoint;
use Persistence\ProfileAccessor;

header('Content-type: text/xml');
$ajax = new Ajax();
$input = $_POST ? $_POST : $_GET;
$productId = $input['product'];
$amount = $input['amount'];
$token = $input['token'];

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
		$amount = $result->price;
		if ($amount > $profile->getBalance()) // Insufficient funds
		{
			if(!$token)
			{
				$ajax->error("token", "No token provided");
			}
			else
			{
				$shop->Donate($amount - $profile->getBalance(), $token);
			}
		}
		AttemptProductPurchase($productId, $amount, $profile, $ajax);
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

function AttemptProductPurchase(int $productID, int $amount, Profile $profile, Ajax $ajax)
{
	// Check to see if it's a product
	$sa = new ShopAccessor();
	$results = $sa->GetProductById($productID, $profile->GetId());
	if ($result = $results->fetch_object())
	{
		if ($result->own)
		{
			$ajax->error("product", "You already own the product");
		}
		else
		{
			$amount = $result->price;
			if ($amount > $profile->getBalance()) // Insufficient funds
			{
				$ajax->error("product", "Insufficient funds");
			}
			else
			{
				$sa = new ShopAccessor();
				$sa->Purchase($profile->GetId(), $amount, $productID);
			}
		}
	}
	else
	{
		$ajax->error("product", "Specified product does not exist!");
	}
}

echo $ajax->asXML();
