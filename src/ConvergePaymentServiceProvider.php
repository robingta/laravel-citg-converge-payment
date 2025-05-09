<?php

namespace CITG\ConvergePayment;

use Illuminate\Support\ServiceProvider;

class ConvergePaymentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/converge-pay.php' => config_path('converge-pay.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/converge-pay.php', 'converge-pay');
    }
}
