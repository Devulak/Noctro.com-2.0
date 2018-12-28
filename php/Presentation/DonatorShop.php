<?php

namespace Presentation;

class DonatorShop extends XMLSnip
{
    private $xmlItems;
    private $profile;

    public function DonatorShop($profile = Profile)
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
        $sa = new ShopAccessor();
        $results = $sa->GetAllItems($this->profile->getId());

        while ($result = $results->fetch_object())
        {
            $this->AddProduct($result->id, $result->price, $result->info, $result->title, $result->own);
        }
    }

    private function AddProduct($id, $price, $info, $title, $own)
    {
        $item = $this->xmlItems->addChild("div");

        $item->addChild("sub", $info);
        $item->addChild("h2", $title);

        if ($own)
        {
            $item->addAttribute("class", "item own");

            $option = $item->addChild("div", "Owned");
            $option->addAttribute("class", "option");
        }
        else
        {
            $item->addAttribute("class", "item");

            $form = $item->addChild("form");
            $form->addAttribute("action", Config::GetPath() . "/php/ajax/purchase.php");
            $form->addAttribute("method", "post");
            $form->addAttribute("class", "donate payment");

            $public_key = $form->addChild("input");
            $public_key->addAttribute("type", "hidden");
            $public_key->addAttribute("name", "public_key");
            $public_key->addAttribute("value", Config::GetStripe()["public_key"]);

            $email = $form->addChild("input");
            $email->addAttribute("type", "hidden");
            $email->addAttribute("name", "email");
            $email->addAttribute("value", $this->profile->getEmail());

            $formTitle = $form->addChild("input");
            $formTitle->addAttribute("type", "hidden");
            $formTitle->addAttribute("name", "title");
            $formTitle->addAttribute("value", $title);

            $description = $form->addChild("input");
            $description->addAttribute("type", "hidden");
            $description->addAttribute("name", "description");
            $description->addAttribute("value", $info);

            $amount = $form->addChild("input");
            $amount->addAttribute("type", "hidden");
            $amount->addAttribute("name", "amount");
            $amount->addAttribute("value", $price - $this->profile->getBalance());

            $product = $form->addChild("input");
            $product->addAttribute("type", "hidden");
            $product->addAttribute("name", "product");
            $product->addAttribute("value", $id);

            $submit = $form->addChild("input");
            $submit->addAttribute("type", "submit");
            $submit->addAttribute("class", "option buy");
            $submit->addAttribute("value", "€ " . number_format($price / 100, 2));
        }
    }
}