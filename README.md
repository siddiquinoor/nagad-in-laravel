# Nagad payment gateway for Laravel 6.x+

[Nagad](https://nagad.com.bd) is one of the Mobile Financial Services in Bangladesh. This package is built for Nagad Payment Gateway for Laravel 6.x

## Contents
Installation

You can install the package via composer:

    composer require siddiquinoor/nagad-in-laravel:dev-main

Setting up your configuration
Extract the nagad config files:

    php artisan vendor:publish --tag=nagad-config

- This will publish and config file in config_path() of your application. Eg. config/nagad.php
- Configure the configurations for the nagad merchant account. Use sandbox = true for development stage.
- Be sure to set the timezone of you application to Asia/Dhaka in order to work with Nagad PGW. To do this: go to config/app.php and set 'timezone' => 'Asia/Dhaka'

## Usage


## env setup
NAGAD_METHOD=sandbox
NAGAD_MERHCANT_ID=YOUR_MERCHANT_ID
NAGAD_MERHCANT_PHONE=YOUR_PHONE_NUMBER
NAGAD_KEY_PUBLIC=YOUR_PUBLIC_KEY
NAGAD_KEY_PRIVATE=YOUR_PRIVATE_KEY
NAGAD_CALLBACK_URL=nagad.callback

## Create a controller for handlling Nagad

    php artisan make:controller NagadController

