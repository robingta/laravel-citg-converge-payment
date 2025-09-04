<?php

namespace CITG\ConvergePayment\Services;

use CITG\ConvergePayment\Enums\TransactionTypes;

abstract class ConvergeService
{
    protected string $merchantID;

    protected string $userID;

    protected string $pin;

    protected string $endpoint;

    protected string $transactionType;


    public function __construct()
    {
        $this->merchantID = config('converge-payment.merchant_id');
        $this->userID = config('converge-payment.user_id');
        $this->pin = config('converge-payment.pin');
        $this->endpoint = config('converge-payment.endpoint');
    }

    public function setMerchantID($merchantID): static
    {
        $this->merchantID = $merchantID;

        return $this;
    }

    public function setUserID($userID): static
    {
        $this->userID = $userID;

        return $this;
    }

    public function setPin($pin): static
    {
        $this->pin = $pin;

        return $this;
    }

    public function setEndpoint($endpoint): static
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function setTransactionType(TransactionTypes $transactionType): static
    {
        $this->transactionType = $transactionType->value;

        return $this;
    }
    
}
