<?php

namespace CITG\ConvergePayment\Misc;


class CreditCard
{
    private $creditCardNumber;
    private $expirationDate;
    private $cvv;


    private function __construct($creditCardNumber, $expirationDate, $cvv)
    {
        $this->creditCardNumber = $creditCardNumber;
        $this->expirationDate = $expirationDate;
        $this->cvv = $cvv;
    }

    public static function make($creditCardNumber, $expirationDate, $cvv){
        return new static($creditCardNumber, $expirationDate, $cvv);
    }

    public function toArray()
    {
        return [
            'ssl_card_number' => $this->creditCardNumber,
            'ssl_exp_date' => $this->expirationDate,
            'ssl_cvv2cvc2' => $this->cvv,
        ];
    }

}