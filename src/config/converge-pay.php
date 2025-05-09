<?php 

return [
    'merchant_id' => env('CONVERGE_ID', ''),
    'user_id' => env('CONVERGE_USER_ID', ''),
    'pin' => env('CONVERGE_PIN', ''),
    'endpoint' => env('CONVERGE_ENDPOINT', 'https://api.demo.convergepay.com/VirtualMerchantDemo/process.do'),
];