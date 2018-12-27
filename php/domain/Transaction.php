<?php

namespace Domain;

class Transaction
{
    private $ac;
    private $id;
    private $time;
    private $amount;
    private $token;
    private $profile;
    private $product;

    public function __construct(IAccessor $ac, int $id, int $time, int $amount, int $token, int $profile, int $product = null)
    {
        $this->ac = $ac;
        $this->id = $id;
        $this->time = $time;
        $this->amount = $amount;
        $this->token = $token;
        $this->profile = $profile;
        $this->product = $product;
    }

    public function GetAmount(): int
    {
        return $this->amount;
    }
}
