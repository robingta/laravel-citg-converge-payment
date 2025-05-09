<?php

namespace CITG\ConvergePay\Services;

class ResponseParseService
{
    public static function parse($responseBody): array
    {
        $response = [];
        $lines = explode("\n", $responseBody);

        foreach ($lines as $line) {
            [$key, $value] = explode('=', $line, 2);
            $response[trim($key)] = trim($value);
        }

        $response['success'] = !isset($response['errorCode']);

        return $response;
    }
}
