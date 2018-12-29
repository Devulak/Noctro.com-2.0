<?php

namespace Domain;

use Persistence\Config;

class Shop
{
    private $profile;
    private $ac;

    public function __construct(IAccessor $ac, Profile $profile)
    {
        $this->ac = $ac;
        $this->profile = $profile;
    }

	public function IsOwned(Product $product): bool
	{
		if ($this->ac->GetTransactionByProfileAndProduct($this->profile, $product) != null)
		{
			return true;
		}

		$productsInherited = $this->ac->GetAllInheritProductFromProduct($product);

		/** @var Product $productInherited */
		foreach	($productsInherited as $productInherited)
		{
			if ($this->IsOwned($productInherited))
			{
				return true;
			}
		}
		return false;
	}

    public function GetDonated(): int
    {
        $transactions = $this->ac->GetTransactionsByProfile($this->profile);

        $total = 0;

		/** @var Transaction $transaction */
		foreach ($transactions as $transaction)
        {
            if ($transaction->GetAmount() > 0)
            {
                $total += $transaction->GetAmount();
            }
        }

        return $total;
    }

    public function GetBalance(): int
    {
        $transactions = $this->ac->GetTransactionsByProfile($this->profile);

        $total = 0;

		/** @var Transaction $transaction */
        foreach ($transactions as $transaction)
        {
            $total += $transaction->GetAmount();
        }

        return $total;
    }

    public function GetPrice(Product $product): int
    {
    	// TODO: Get all inherited products and deduct the corresponding transactions from the price of this product
    	if ($product->GetInherited() == null) // Sets the price of all the first ones a bit down
		{
			return $product->GetDefaultPrice() * .5;
		}

    	$price = $product->GetDefaultPrice();

    	$inheritProduct = $product->GetInherited();
    	while ($inheritProduct != null)
		{
			if ($this->IsOwned($inheritProduct))
			{
				$transaction = $this->ac->GetTransactionByProfileAndProduct($this->profile, $inheritProduct);
				if ($transaction != null)
				{
					$price += $transaction->GetAmount();
				}
			}
			$inheritProduct = $inheritProduct->GetInherited();
		}



		// Default return
		return $price;
    }

	public function GetProductById(int $productId): ?Product
	{
		return $this->ac->GetProductById($productId);
	}

    public function GetAllTransactions(): array
    {
        return $this->ac->GetTransactionsByProfile($this->profile);
    }

    public function Purchase(Product $product): void
    {
		throw new NotImplementedException();
    }

    public function Donate(int $amount, string $token): void
    {
    	//TODO: Interface for a Charge()
		require_once("../stripe/init.php");
		\Stripe\Stripe::setApiKey(Config::GetStripe()["private_key"]);
		\Stripe\Charge::create(array(
			'card' => $token,
			'amount' => $amount,
			'currency' => 'EUR',
			'description' => $this->profile->GetEmail()
		));

		$this->ac->AddBalance($this->profile, $amount, $token);

		//TODO: Give announcement and activate transaction to that specific server
    }
}
