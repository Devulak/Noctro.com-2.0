<?php

namespace Domain;

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

    public function Donated(): int
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

    public function Balance(): int
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
    	/*if ($product->GetInherited() == null)
		{
			return $product->GetDefaultPrice() * .9;
		}*/

    	$inheritProduct = $product->GetInherited();
    	while ($inheritProduct != null)
		{
			if ($this->IsOwned($inheritProduct))
			{
				return $product->GetDefaultPrice() - $inheritProduct->GetDefaultPrice();
			}
			$inheritProduct = $inheritProduct->GetInherited();
		}
		return $product->GetDefaultPrice();
    }

    public function PersonalPrice(Product $product): int
    {
        throw new NotImplementedException();
    }

    public function GetAllTransactions(): array
    {
        return $this->ac->GetTransactionsByProfile($this->profile);
    }

    public function Purchase(Product $product): void
    {
        throw new NotImplementedException();
    }

    public function Donate(int $amount): void
    {
        throw new NotImplementedException();
    }
}
