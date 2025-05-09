<?php

namespace CITG\ConvergePay\Services;

use CITG\ConvergePay\Enums\TransactionTypes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ConvergeService
{
    private $merchantID;

    private $userID;

    private $pin;

    private $endpoint;

    private $transactionType;

    private $response = [];

    public function __construct()
    {
        $this->merchantID = config('converge-pay.merchant_id');
        $this->userID = config('converge-pay.user_id');
        $this->pin = config('converge-pay.pin');
        $this->endpoint = config('converge-pay.endpoint');
        $this->transactionType = TransactionTypes::CC_SALE->value; // Default transaction type
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

    public function processPayment(array $parameters): static
    {
        $payload = Arr::collapse([
            [
                'ssl_merchant_id' => $this->merchantID,
                'ssl_user_id' => $this->userID,
                'ssl_pin' => $this->pin,
                'ssl_transaction_type' => $this->transactionType,
                'ssl_show_form' => 'false',
                'ssl_result_format' => 'ascii',
            ],
            $parameters,
        ]);
        
        $response = Http::asForm()->post($this->endpoint, $payload);

        $responseBody = $response->body();

        $this->response = ResponseParseService::parse($responseBody);
        return $this;
    }

    public function paymentResponse(): array
    {
        return $this->response;
    }
    
    public function isSuccessful(): bool
    {
        return $this->response['success'];
    }
}
