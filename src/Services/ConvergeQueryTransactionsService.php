<?php

namespace CITG\ConvergePayment\Services;

use CITG\ConvergePayment\Enums\TransactionTypes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Exception;

class ConvergeQueryTransactionsService extends ConvergeService
{

    private array $response = [];

    public function __construct()
    {
        parent::__construct();
        $this->setTransactionType(TransactionTypes::TX_TRANSACTION_QUERY); // Default transaction type
    }


    public function query(array $queryParameters): static
    {

        if (count($queryParameters) === 0) {
            throw new Exception('No parameters provided for transaction query.');
        }

        if($this->transactionType !== TransactionTypes::TX_TRANSACTION_QUERY->value) {
            throw new Exception('Transaction type must be TX_TRANSACTION_QUERY for querying transactions.');
        }

        $payload = Arr::collapse([
            [
                'ssl_merchant_id' => $this->merchantID,
                'ssl_user_id' => $this->userID,
                'ssl_pin' => $this->pin,
                'ssl_transaction_type' => $this->transactionType,
                'ssl_show_form' => 'false',
                'ssl_result_format' => 'ascii',
            ],
            $queryParameters,
        ]);


        $response = Http::asForm()->post($this->endpoint, $payload);

        $responseBody = $response->body();



        $this->response = ResponseParseService::parse($responseBody);

        return $this;
    }

    public function queryResponse(): array
    {
        return $this->response;
    }

    public function isSuccessful(): bool
    {
        return $this->response['ssl_txn_count'] != '0';
    }

    public function isPaymentComplete(): bool
    {
        return $this->response['ssl_result_message'] === 'APPROVAL' && $this->response['ssl_approval_code'] !== '';
    }
    
}
