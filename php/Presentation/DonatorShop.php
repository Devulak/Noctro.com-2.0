<?php

namespace Presentation;

use Domain\Product;
use Domain\Profile;
use Domain\Shop;
use Persistence\Accessor;
use Persistence\Config;
use SimpleXMLElement;

class DonatorShop extends XMLSnip
{
    private $xmlItems;
    private $profile;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;

        LinkCollector::addLink('donatorshop');
        LinkCollector::addScript("payment");

        $xml = "
            <div class='shop'>
                <div class='items'>
                </div>
            </div>
        ";

        $this->xml = new SimpleXMLElement($xml);

        $this->xmlItems = $this->xml->div;

        $this->AddAllProducts();
    }

    private function AddAllProducts()
    {
        $sa = new Accessor();
        $products = $sa->GetAllProducts();

        foreach ($products as $product)
		{
			$this->AddProduct($product);
		}
    }

    private function AddProduct(Product $product)
    {
    	$shop = new Shop(new Accessor(), $this->profile);

        $item = $this->xmlItems->addChild("div");

        $item->addChild("sub", $product->GetInfo());
        $item->addChild("h2", $product->GetTitle());

        if ($shop->IsOwned($product))
        {
            $item->addAttribute("class", "item own");

            $option = $item->addChild("div", "Owned");
            $option->addAttribute("class", "option");
        }
        else
        {
        	if ($product->GetDefaultPrice() > $product->GetDiscountPrice())
			{
				$item->addAttribute("class", "item discount");
				$item->addAttribute("discountprocent", round((1 - $product->GetDiscountPrice() / $product->GetDefaultPrice()) * 100));
			}
        	else
        	{
				$item->addAttribute("class", "item");
			}

            $form = $item->addChild("form");
            $form->addAttribute("action", "php/Ajax/purchase.php");
            $form->addAttribute("method", "post");
            $form->addAttribute("class", "donate payment");

            $public_key = $form->addChild("input");
            $public_key->addAttribute("type", "hidden");
            $public_key->addAttribute("name", "public_key");
            $public_key->addAttribute("value", Config::GetStripe()["public_key"]);

            $email = $form->addChild("input");
            $email->addAttribute("type", "hidden");
            $email->addAttribute("name", "email");
            $email->addAttribute("value", $this->profile->GetEmail());

            $formTitle = $form->addChild("input");
            $formTitle->addAttribute("type", "hidden");
            $formTitle->addAttribute("name", "title");
            $formTitle->addAttribute("value", $product->GetTitle());

            $description = $form->addChild("input");
            $description->addAttribute("type", "hidden");
            $description->addAttribute("name", "description");
            $description->addAttribute("value", $product->GetInfo());

            $amount = $form->addChild("input");
            $amount->addAttribute("type", "hidden");
            $amount->addAttribute("name", "amount");
            $amount->addAttribute("value", $shop->GetPrice($product) - $shop->GetBalance());

            $productInput = $form->addChild("input");
			$productInput->addAttribute("type", "hidden");
			$productInput->addAttribute("name", "product");
			$productInput->addAttribute("value", $product->GetId());

			$submitLabel = $form->addChild("label", "€ " . number_format($shop->GetPrice($product) / 100, 2) . " ");
			$submitLabel->addAttribute("for", "submit" . $product->GetId());
			$submitLabel->addAttribute("class", "option buy");

			if ($shop->GetPrice($product) != $product->GetDefaultPrice())
			{
				$submitLabel->addChild("span", "(€ " . number_format($product->GetDefaultPrice() / 100, 2) . ")");
			}

			$submit = $form->addChild("input");
			$submit->addAttribute("type", "submit");
			$submit->addAttribute("id", "submit" . $product->GetId());
			$submit->addAttribute("hidden", "true");
        }
    }
}
