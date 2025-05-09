<?php

namespace CITG\ConvergePayment;

use CITG\ConvergePayment\Services\ConvergePaymentService;
use Illuminate\Support\Facades\Facade;

class ConvergePaymentManager extends Facade
{
    /**
     * @method public function setMerchantID($merchantID): static
     * @method public function setUserID($userID): static
     * @method public function setPin($pin): static
     * @method public function setEndpoint($endpoint): static
     * @method public function setAmount(float $amount): static
     * @method public function setCreditCard(CreditCard $creditCard): static
     * @method public function setCustomer(Customer $customer): static
     * @method public function setTransactionType(TransactionTypes $transactionType): static
     * @method public function processPayment(array $parameters = []): static
     * @method public function paymentResponse(): array
     * @method public function isSuccessful(): bool
     *
     * @see CITG\ConvergePay\Enums\TransactionTypes
     * @see CITG\ConvergePay\Services\ConvergeService
     **/
    protected static function getFacadeAccessor()
    {
        return ConvergePaymentService::class;
    }
}
