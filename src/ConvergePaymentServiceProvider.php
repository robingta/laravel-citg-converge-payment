<?php

namespace CITG\ConvergePayment;

use Illuminate\Support\ServiceProvider;

class ConvergePaymentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/converge-payment.php' => config_path('converge-payment.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/converge-payment.php', 'converge-payment');
    }
}
