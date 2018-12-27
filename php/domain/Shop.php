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
        if ($this->ac->GetTransactionByProfileAndProduct($this->profile, $product) == null)
        {
            return false;
        }
        return true;
    }

    public function Donated(): int
    {
        $transactions = $this->ac->GetTransactionsByProfile($this->profile);

        $total = 0;

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

        foreach ($transactions as $transaction)
        {
            $total += $transaction->GetAmount();
        }

        return $total;
    }

    public function Price(Product $product): int
    {
        return $product->GetPrice();
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
