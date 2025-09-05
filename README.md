##### This Library is for Converge Payment Gateway **It's a Laravel Wrapper around XML endpoint of Converge Payment Gateway**

## Compatibility

This package will work with PHP >= 8.2 with CURL enabled.

## Installation

To install this library follow the following steps:
```bash
 composer require citg/laravel-converge-payment
```



## Publish Config File

* Execute the following command from the command-line to publish the configuration file config/converge-payment.php. this command will generate a file as above 

``` php
php artisan vendor:publish --provider="CITG\ConvergePayment\ConvergePaymentServiceProvider"
```
``` php
<?php

return [
    'merchant_id' => env('CONVERGE_ID', ''),
    'user_id' => env('CONVERGE_USER_ID', ''),
    'pin' => env('CONVERGE_PIN', ''),
    'endpoint' => env('CONVERGE_ENDPOINT', 'https://api.demo.convergepay.com/VirtualMerchantDemo/process.do'),
];
```

**Please Note: When you are deploying this application to live. You have to change the `endpoint` **

```php
return [
    'merchant_id' => env('CONVERGE_ID', ''),
    'user_id' => env('CONVERGE_USER_ID', ''),
    'pin' => env('CONVERGE_PIN', ''),
    'endpoint' => env('CONVERGE_ENDPOINT', 'https://api.convergepay.com/VirtualMerchant/process.do'),
];

```

## All Transaction Types


```php
    TransactionTypes::CC_AUTH_ONLY
    TransactionTypes::CC_AVS_ONLY
    TransactionTypes::CC_SALE
    TransactionTypes::CC_VERIFY
    TransactionTypes::CC_GET_TOKEN
    TransactionTypes::CC_CREDIT
    TransactionTypes::CC_FORCE
    TransactionTypes::CC_BAL_INQUIRY
    TransactionTypes::CC_RETURN
    TransactionTypes::CC_VOID
    TransactionTypes::CC_COMPLETE
    TransactionTypes::CC_DELETE
    TransactionTypes::CC_UPDATE_TIP
    TransactionTypes::CC_SIGNATURE
    TransactionTypes::CC_ADD_RECURRING
    TransactionTypes::CC_ADD_INSTALL
    TransactionTypes::CC_UPDATE_TOKEN
    TransactionTypes::CC_DELETE_TOKEN
    TransactionTypes::CC_QUERY_TOKEN
```

## Create a Customer

```php
    use CITG\ConvergePayment\Misc\Customer;
```

```php
    $customer = Customer::make(
        firstName: 'XXX',
        lastName: 'XXX',
        phone: 'XXXXX',
        email: 'XXXX@xxx.com',
        address: 'XXX XXX XX',
        city: 'XXX',
        state: 'XX',
        zip: 'XXX',
        customerCode: 'XXX',
        customerNumber: 'XX'
    );
```

## Create a Credit Crad

```php
    use CITG\ConvergePayment\Misc\CreditCard;
```

```php
    $creditCard = CreditCard::make(
        creditCardNumber: 'XXXXXXXXXXXXXXXXXXXXXX',
        expirationDate: 'XXX',
        cvv: 'XX'
    );
```

## Process a Payment 

```php
use CITG\ConvergePayment\Enums\TransactionTypes;
```
```php
use CITG\ConvergePayment\ConvergePaymentManager;
```

```php
    $paymentManager = ConvergePaymentManager::setTransactionType(TransactionTypes::CC_SALE)
        ->setCreditCard($creditCard)
        ->setCustomer($customer)
        ->setAmount(30.00)
        ->processPayment([
            'description' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXX'
        ]);
```

## Available Methods

Here is a function description table for the main public methods in `ConvergePaymentService`:

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `setMerchantID($merchantID)` | Set the merchant ID for the transaction. | `string $merchantID` | `static` |
| `setUserID($userID)` | Set the user ID for the transaction. | `string $userID` | `static` |
| `setPin($pin)` | Set the PIN for the transaction. | `string $pin` | `static` |
| `setEndpoint($endpoint)` | Set the API endpoint URL. | `string $endpoint` | `static` |
| `setTransactionType(TransactionTypes $transactionType)` | Set the transaction type (see TransactionTypes enum). | `TransactionTypes $transactionType` | `static` |
| `setCreditCard(CreditCard $creditCard)` | Set the credit card details for the transaction. | `CreditCard $creditCard` | `static` |
| `setCustomer(Customer $customer)` | Set the customer details for the transaction. | `Customer $customer` | `static` |
| `setAmount(float $amount)` | Set the transaction amount. | `float $amount` | `static` |
| `setFallbackErrorMessage(string $fallbackErroMessage): static` | Set fallback error message. | `string $fallbackErroMessage` | `static` |
| `processPayment(array $additionalParameters = [])` | Process the payment with the provided details. with an parameter of type array to send additional parameters | `array $additionalParameters` | `static` |
| `paymentResponse()` | Get the parsed response from the payment gateway. | None | `array` |
| `isSuccessful()` | Check if the request was successful. | None | `bool` |
| `errorMessage()` | Get the error message from the response, if any. | None | `string` |

```php
    $paymentManager->setMerchantID($merchantID);
    $paymentManager->setUserID($userID);
    $paymentManager->setPin($pin);
    $paymentManager->setEndpoint($endpoint);
    $paymentManager->setTransactionType(TransactionTypes::CC_SALE);
    $paymentManager->setCreditCard($creditCard);
    $paymentManager->setCustomer($customer);
    $paymentManager->setAmount(30.00);
    $paymentManager->processPayment([
        'description' => 'Payment for order #123'
    ]);
    $response = $paymentManager->paymentResponse();
    $success = $paymentManager->isSuccessful();
    $error = $paymentManager->errorMessage();
```


## Query a Payment 

```php
use CITG\ConvergePayment\Enums\TransactionTypes;
```
```php
use CITG\ConvergePayment\ConvergeQueryManager;
```

```php
    $queryManager = ConvergeQueryManager::setTransactionType(TransactionTypes::TX_TRANSACTION_QUERY)
        ->query([
            'ssl_search_start_date' => 'MM/DD/YYYY',
            'ssl_search_end_date' => 'MM/DD/YYYY',
            'ssl_search_card_type' => 'creditcard',
            'ssl_invoice_number' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXX'
        ]);
```

## Available Methods

Here is a function description table for the main public methods in `ConvergePaymentService`:

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `setMerchantID($merchantID)` | Set the merchant ID for the transaction. | `string $merchantID` | `static` |
| `setUserID($userID)` | Set the user ID for the transaction. | `string $userID` | `static` |
| `setPin($pin)` | Set the PIN for the transaction. | `string $pin` | `static` |
| `setEndpoint($endpoint)` | Set the API endpoint URL. | `string $endpoint` | `static` |
| `setTransactionType(TransactionTypes $transactionType)` | Set the transaction type (see TransactionTypes enum). | `TransactionTypes $transactionType` | `static` |
| `query(array $queryParameters)` | Search transactions | `array $queryParameters` | `array` |
| `isSuccessful()` | Check if the request was successful. | None | `bool` |
| `isPaymentComplete()()` | Check if the payment was successful. | None | `bool` |
| `queryResponse()` | Get the query response. | None | `string` |

```php
    $queryManager->setMerchantID($merchantID);
    $queryManager->setUserID($userID);
    $queryManager->setPin($pin);
    $queryManager->setEndpoint($endpoint);
    $paymentManager->setTransactionType(TransactionTypes::TX_TRANSACTION_QUERY);
    $paymentManager->query([
        'ssl_invoice_number' => 'XXX'
    ]);
    $success = $queryManager->isSuccessful();
    $success = $queryManager->isPaymentComplete();
    $response = $queryManager->queryResponse();
```