<?php

return [

    /**
     * Nagad Payment Gateway configuration
     */

   'domain' => [

        /**
         * Live and Sandbox Mode URL
         */
        'sandbox'   => env('NAGAD_BASEURL', "http://sandbox.mynagad.com:10080/remote-payment-gateway-1.0/api/dfs"),
        'live'      => env('NAGAD_BASEURL', "https://api.mynagad.com/api/dfs")
    ],
    'endpoints' => [
        /**
         * Live and Sandbox Mode endpoints
         */
        'checkout-init'         => '/check-out/initialize/',
        'checkout-complete'     => '/check-out/complete/',
        'payment-verify'        => '/verify/payment/',
    ],

];