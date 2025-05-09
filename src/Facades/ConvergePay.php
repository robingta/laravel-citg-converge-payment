<?php

namespace CITG\ConvergePay\Facades;

use CITG\ConvergePay\Services\ConvergeService;
use Illuminate\Support\Facades\Facade;

class ConvergePay extends Facade
{
    /**
     * @method public function setTransactionType(TransactionTypes $transactionType): static
     * @method public send(array $parameters): array
     *
     * @see CITG\ConvergePay\Enums\TransactionTypes
     * @see CITG\ConvergePay\Services\ConvergeService
     **/
    protected static function getFacadeAccessor()
    {
        return ConvergeService::class;
    }
}
