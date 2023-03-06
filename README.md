# Nagad payment gateway for Laravel 6.x+

[Nagad](https://nagad.com.bd) is one of the Mobile Financial Services in Bangladesh. This package is built for Nagad Payment Gateway for Laravel 6.x

## Contents
Installation

You can install the package via composer:

    composer require siddiquinoor/nagad-in-laravel:dev-main

Setting up your configuration
Extract the nagad config files:

    php artisan vendor:publish --provider="siddiquinoor\NagadLaravel\NagadServiceProvider"

- This will publish and config file in config_path() of your application. Eg. config/nagad.php
- Configure the configurations for the nagad merchant account. Use sandbox = true for development stage.
- Be sure to set the timezone of you application to Asia/Dhaka in order to work with Nagad PGW. To do this: go to config/app.php and set 'timezone' => 'Asia/Dhaka'

## Usage


## env setup
NAGAD_SANDBOX=true #for production use false
NAGAD_MERCHANT_ID=""
NAGAD_MERCHANT_NUMBER=""
NAGAD_PUBLIC_KEY=""
NAGAD_PRIVATE_KEY=""
NAGAD_CALLBACK_URL=""

## Create a controller for handlling Nagad

    php artisan make:controller NagadController

## Add routes

    Route::get('nagad/pay',[App\Http\Controllers\NagadController::class,'pay'])->name('nagad.pay');
    Route::get('nagad/callback', [App\Http\Controllers\NagadController::class,'callback']);
    Route::get('nagad/refund/{paymentRefId}', [App\Http\Controllers\NagadController::class,'refund']);


## The NagadController looks like the following

    <?php

    namespace siddiquinoor\NagadLaravel\Controllers;

    use Illuminate\Http\Request;
    use siddiquinoor\NagadLaravel\Facade\NagadPayment;

    class NagadPaymentController
    {
        public function callback(Request $request)
        {
            if (!$request->status && !$request->order_id) {
                return response()->json([
                    "error" => "Not found any status"
                ], 500);
            }

            if (config("nagad.response_type") == "json") {
                return response()->json($request->all());
            }

            $verify = NagadPayment::verify($request->payment_ref_id);

            if ($verify->status == "Success") {
                return redirect("/nagad-payment/{$verify->orderId}/success");
            } else {
                return redirect("/nagad-payment/{$verify->orderId}/fail");
            }

        }

        public function success($transId)
        {
            return view("nagad::success", compact('transId'));
        }

        public function fail($transId)
        {
            return view("nagad::failed", compact('transId'));
        }
    }

