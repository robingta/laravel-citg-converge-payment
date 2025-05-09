<?php

namespace CITG\ConvergePayment\Misc;


class Customer
{
    private $customerCode;
    private $customerNumber;
    private $firstName;
    private $lastName;
    private $email;
    private $phone;
    private $address;
    private $city;
    private $state;
    private $zip;


    private function __construct($customerCode, $customerNumber, $firstName, $lastName, $email, $phone, $address, $city, $state, $zip)
    {
        $this->customerCode = $customerCode;
        $this->customerNumber = $customerNumber;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
    }

    public static function make($customerCode, $customerNumber, $firstName, $lastName, $email, $phone, $address, $city, $state, $zip)
    {
        return new static($customerCode, $customerNumber, $firstName, $lastName, $email, $phone, $address, $city, $state, $zip);
    }

    public function toArray()
    {
        return [
            'ssl_customer_code' => $this->customerCode,
            'ssl_customer_number' => $this->customerNumber,
            'ssl_first_name' => $this->firstName,
            'ssl_last_name' => $this->lastName,
            'ssl_email' => $this->email,
            'ssl_phone' => $this->phone,
            'ssl_avs_address' => $this->address,
            'ssl_city' => $this->city,
            'ssl_state' => $this->state,
            'ssl_avs_zip' => $this->zip,
        ];
    }

}