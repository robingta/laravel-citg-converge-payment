<?php

namespace CITG\ConvergePayment\Parsers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class QueryResponse
{
    public static function parse($responseBody): array
    {
        
        $lines = explode("\n", $responseBody);

        [$countKey, $CountValue] = explode('=', $lines[1], 2);

        $transactionalLines = array_slice($lines, 2);
        $transactions = [];
        $transaction = [];

        foreach ($transactionalLines as $index => $line) {

            [$key, $value] = explode('=', $line, 2);

            if (Arr::has($transaction, 'ssl_txn_id') && $key === 'ssl_txn_id') {
                $transactions[] = $transaction;
                $transaction = [];
            }
            $transaction[trim($key)] = trim($value);

            if($index === count($transactionalLines)-1) {
                $transactions[] = $transaction;
            }
        }


        return [
            $countKey => $CountValue,
            'transactions' => $transactions,
        ];
    }
}
