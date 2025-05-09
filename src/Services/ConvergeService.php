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

    public function __construct()
    {
        $this->merchantID = config('converge-pay.merchant_id');
        $this->userID = config('converge-pay.user_id');
        $this->pin = config('converge-pay.pin');
        $this->endpoint = config('converge-pay.endpoint');
        $this->transactionType = TransactionTypes::CC_SALE->value; // Default transaction type
    }

    public function setTransactionType(TransactionTypes $transactionType): static
    {
        $this->transactionType = $transactionType->value;

        return $this;
    }

    public function send(array $parameters): array
    {
        $payload = Arr::collapse([
            [
                'merchantID' => $this->merchantID,
                'userID' => $this->userID,
                'pin' => $this->pin,
                'transactionType' => $this->transactionType,
                'ssl_show_form' => 'false',
                'ssl_result_format' => 'ascii',
            ],
            $parameters,
        ]);
        $response = Http::asForm()->post($this->endpoint, $payload);

        $responseBody = $response->body();

        return ResponseParseService::parse($responseBody);
    }
}
