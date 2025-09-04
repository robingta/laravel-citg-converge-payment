<?php

namespace CITG\ConvergePayment\Services;

use Illuminate\Support\Str;

class ResponseParseService
{
    public static function parse($responseBody): array
    {
        $response = [];
        $lines = explode("\n", $responseBody);


        foreach ($lines as $line) {
            if(Str::of($line)->trim()->isEmpty()) {
                continue;
            }
            [$key, $value] = explode('=', $line, 2);
            $response[trim($key)] = trim($value);
        }

        dd($response);


        return $response;
    }
}
