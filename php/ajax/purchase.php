<?php
	// if no id, just make it a donation to the site.
	// if id, use the amount in the wallet first, then the rest on the card
	require_once("../init.php");
	require_once("Ajax.php");
	header('Content-type: text/xml');
	$ajax = new Ajax();
	$input = $_GET;
	if ($_POST)
	{
		$input = $_POST;
	}
	$productID = $input['product'];
	$amount = $input['amount'];
	$token = $input['token'];



	$profile = Profile::getInstance();
	if(!$profile)
	{
		$ajax->error("user", "You must be logged in");
	}


	if($productID) // product id provided, this is a product purchase!
	{
		// Check to see if it's a product
		$sa = new ShopAccessor();
		$results = $sa->GetProductById($productID, $profile->getId());
		if ($result = $results->fetch_object())
		{
			if (!$result->own)
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
						AttemptDonation($token, $amount - $profile->getBalance(), $profile, $ajax);
					}
				}
				AttemptProductPurchase($productID, $amount, $profile, $ajax);
			}
		}
		else
		{
			$ajax->error("product", "Specified product does not exist!");
		}
	}
	else // no product id provided, this is a donation!
	{
		if(!$token)
		{
			$ajax->error("token", "No token provided");
		}

		if(!is_numeric($amount))
		{
			$ajax->error("amount", "Not a number");
		}
		if($amount < 100)
		{
			$ajax->error("amount", "Below threshold");
		}
		if($amount > 133700)
		{
			$ajax->error("amount", "Above threshold");
		}

		if (!$ajax->hasErrors())
		{
			AttemptDonation($token, $amount, $profile, $ajax);
		}
	}

	function AttemptDonation($token, $amount, $profile, $ajax)
	{
		require_once("../stripe/init.php");
		\Stripe\Stripe::setApiKey(Config::GetStripe()["private_key"]);
		try
		{
			\Stripe\Charge::create(array(
				'card' => $token,
				'amount' => $amount,
				'currency' => 'EUR',
				'description' => $profile->getEmail()
			));

			$sa = new ShopAccessor();
			$sa->AddBalance($profile->getId(), $amount, $token);

			// Do fancy sheep
			if ($profile->GetMinecraftId())
			{
				$ancer = new Announcer(new AnnouncerAccessor());
				$ancer->Announce("&9&l" . $profile->GetMinecraftId() . " &fjust donated &c&l" . number_format($amount / 100, 2) . " &fEUR!");
			}
			// END fancy sheep
		}
		catch(Stripe_CardError $e)
		{
			$ajax->error("token", $e);
		}
	}

	function AttemptProductPurchase($productID, $amount, $profile, $ajax)
	{
		// Check to see if it's a product
		$sa = new ShopAccessor();
		$results = $sa->GetProductById($productID, $profile->getId());
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
					$sa->PurchaseProduct($profile->getId(), $amount, $productID);

					// Do fancy sheep
					if ($profile->GetMinecraftId())
					{
						$ancer = new Announcer(new AnnouncerAccessor());
						$ancer->Activate($profile, new Product($result->id, $result->title, $result->info, $result->price, $result->inherit, $result->game_server));
					}
					// END fancy sheep
				}
			}
		}
		else
		{
			$ajax->error("product", "Specified product does not exist!");
		}
	}

	echo $ajax->asXML();
?>