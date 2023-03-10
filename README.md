# Nagad (Bangladesh) payment gateway for Laravel 6.x+, 7.x+, 8.x+

Nagad is one of the Mobile Financial Services in Bangladesh. This package is built for Nagad Payment Gateway for Laravel 6.x, 7.x and 8.x+

## Contents

- [Installation](#installation)
  - [Configuration](#configuration)
- [Usage](#usage)
- [License](#license)

## Installation

Install the package via composer:

```bash
composer require siddiquinoor/nagad-in-laravel:dev-master
```

### Configuration

Add config file in your `config` directory:

```bash
php artisan vendor:publish --tag=nagad-config
```

- This will publish and config file in `config_path()` of your application. e.g `config/nagad.php`

- Configure the Nagad merchant account. Use `sandbox = true` for development stage.

- Be sure to set the **timezone** of you application to `Asia/Dhaka` in order to work with Nagad Payment Gate Way. To do this:
  go to `config/app.php` and set `'timezone' => 'Asia/Dhaka'`

## Usage

Set Nagad call back to our route

```php
    // in routes/web.php
    Route::get('/nagad/callback', 'NagadController@callback')->name('nagad.callback');
```

Name the route in the nagad config file.

```
    //in config/nagad.php
    'callback' => 'nagad.callback' // or use env variable to store
```

# env setup

```bash
NAGAD_METHOD=sandbox
NAGAD_MERHCANT_ID=YOUR_MERCHANTID
NAGAD_MERHCANT_PHONE=YOUR_PHONE_NUMBER
NAGAD_KEY_PUBLIC=YOUR_PUBLIC_KEY
NAGAD_KEY_PRIVATE=YOUR_PRIVATE_KEY
NAGAD_CALLBACK_URL=nagad.callback
```

To Start payment, in your NagadController:

```php
    use NagadLaravel\Nagad;
    use Illuminate\Http\Request;

    public function createPayment()
    {
        /**
         * Method 1: Quickest
         * This will automatically redirect you to the Nagad PG Page
         * */

        return Nagad::setOrderID('ORDERID123')
            ->setAmount('540')
            ->checkout()
            ->redirect();

        /**
         * Method 2: Manual Redirection
         * This will return only the redirect URL and manually redirect to the url
         * */

        $url = Nagad::setOrderID('ORDERID123')
            ->setAmount('540')
            ->checkout()
            ->getRedirectUrl();

        return ['url' => $url];


        /**
         * Method 3: Advanced
         * You set additional params which will be return at the callback
         * */

        return Nagad::setOrderID('ORDERID123')
            ->setAmount('540')
            ->setAddionalInfo(['pid' => 9, 'myName' => 'DG'])
            ->checkout()
            ->redirect();


        /**
         * Method 4: Advanced Custom Callabck
         * You can set/override callback url while creating payment
         * */

        return Nagad::setOrderID('ORDERID123')
            ->setAmount('540')
            ->setAddionalInfo(['pid' => 9, 'myName' => 'DG'])
            ->setCallbackUrl("https://manual-callback.url/callback")
            ->checkout()
            ->redirect();
    }


	//To receive the callback response use this method:

    /**
     * This is the routed callback method
     * which receives a GET request.
     *
     * */

    public function callback(Request $request)
    {
        $verified = Nagad::callback($request)->verify();
        if($verified->success()) {

            // Get Additional Data
            dd($verified->getAdditionalData());

            // Get Full Response
            dd($verified->getVerifiedResponse());
        } else {
            dd($verified->getErrors());
        }
    }
```

To receive error response use this in App/Exceptions/Handler.php:

```php
public function render($request, Exception $exception)
{
    if($exception instanceof NagadException) {
    //return custom error page when custom exception is thrown
    return response()->view('errors.nagad', compact('exception'));
    }

    return parent::render($request, $exception);
}
```

## Available Methods

### For Checking-out

- `setOrderID(string $orderID)` : `$orderID` to be any unique AlphaNumeric String
- `setAmount(string $amount)` : `$amount` to be any valid currency numeric String
- `setAddionalInfo(array $array)` : `$array` to be any array to be returned at callback
- `setCallbackUrl(string $url)` : `$url` to be any url string to be overidden the defualt callback url set in config
- `checkout()` : to initiate checkout process.
- `redirect()` : to direct redirect to the NagadPG Web Page.
- `getRedirectUrl()` : instead of redirecting, getting the redirect url manually.

### For Callback

- `callback($request)` : `$request` to be `Illuminate\Http\Request` instance
- `verify()` : to verify the response.
- `success()` : to check if transaction is succeed.
- `getErrors()` : to get the error and errorCode if fails transactions | <kbd>returns</kbd> `array[]`
- `getVerifiedResponse()` : to get the full verified response | <kbd>returns</kbd> `array[]`
- `getAdditionalData(bool $object)` : to get the additional info passed during checkout. `$object` is to set return object or array.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
