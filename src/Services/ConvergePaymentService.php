<?php

namespace CITG\ConvergePayment\Services;

use CITG\ConvergePayment\Enums\TransactionTypes;
use CITG\ConvergePayment\Misc\CreditCard;
use CITG\ConvergePayment\Misc\Customer;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ConvergePaymentService
{
    private string $merchantID;

    private string $userID;

    private string $pin;

    private string $endpoint;

    private string $transactionType;

    private ?CreditCard $creditCard = null;

    private ?Customer $customer = null;

    private float $amount = 0.0;

    private array $response = [];

    public function __construct()
    {
        $this->merchantID = config('converge-payment.merchant_id');
        $this->userID = config('converge-payment.user_id');
        $this->pin = config('converge-payment.pin');
        $this->endpoint = config('converge-payment.endpoint');
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

    public function setCreditCard(CreditCard $creditCard): static
    {
        $this->creditCard = $creditCard;

        return $this;
    }

    public function setCustomer(Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function processPayment(array $additionalParameters = []): static
    {

        if (is_null($this->creditCard)) {
            throw new Exception('Credit card information is required.');
        }

        if (is_null($this->customer)) {
            throw new Exception('Customer information is required.');
        }

        if ($this->amount <= 0) {
            throw new Exception('Amount must be greater than zero.');
        }

        $payload = Arr::collapse([
            [
                'ssl_merchant_id' => $this->merchantID,
                'ssl_user_id' => $this->userID,
                'ssl_pin' => $this->pin,
                'ssl_transaction_type' => $this->transactionType,
                'ssl_show_form' => 'false',
                'ssl_result_format' => 'ascii',
                'ssl_amount' => $this->amount,
            ],
            $this->creditCard->toArray(),
            $this->customer->toArray(),
            $additionalParameters,
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

    public function isSuccessfulTransaction(): bool
    {
        $approvalCode = trim($this->response['ssl_approval_code'] ?? '');
        $avsResponse = trim($this->response['ssl_avs_response'] ?? '');

        return !empty($approvalCode) && $avsResponse === 'A';
    }

    public function errorMessage(): string
    {
        return $this->response['errorMessage'] ?? '';
    }
}
