<?php

namespace CITG\ConvergePayment\Services;

use CITG\ConvergePayment\Enums\TransactionTypes;
use CITG\ConvergePayment\Misc\CreditCard;
use CITG\ConvergePayment\Misc\Customer;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ConvergePaymentService extends ConvergeService
{

    private ?CreditCard $creditCard = null;

    private ?Customer $customer = null;

    private float $amount = 0.0;

    private array $response = [];

    private $fallbackErrorMessage = '';

    public function __construct()
    {
        parent::__construct();
        $this->setTransactionType(TransactionTypes::CC_SALE); // Default transaction type
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

    public function setErrorMessage(string $fallbackErrorMessage): static
    {
        $this->fallbackErrorMessage = $fallbackErrorMessage;

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
        return ! isset($this->response['errorCode']) && $this->response['ssl_result_message'] === 'APPROVAL' && $this->response['ssl_approval_code'] !== '';
    }

    public function errorMessage(): string
    {
        return $this->response['errorMessage'] ?? "{$this->fallbackErrorMessage} [{$this->response['ssl_result_message']}]";
    }
    
}
