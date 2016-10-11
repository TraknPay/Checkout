# Checkout
Traknpay/Checkout is a Laravel package to integrate traknpay payment gateway in your laravel 5.X package

This package is used to integrate with traknpay api payment request.

## Requirements ##
 1. PHP 5.4.0 or later
 2. Laravel 5.3
 
## Quick Installation ##

    composer require traknpay/checkout

### Service Provider ###
    TraknPay\Checkout\CheckoutServiceProvider::class

### Facade ###
    'Checkout'=>TraknPay\Checkout\Facades\Checkout::class

### Configuration ###

    $ php artisan vendor:publish

**config/traknpay_payment_gateway.php**

This is the configuration file that Laravel will publish into it's config directory.

Open this file and provide values in following parameters

    'api_key'
    'app_url'
    'salt'
    'mode'
    'return_handler'

**'app_url'** is to be set to your server url, by default it is set to http://localhost:8000, do not add '/' at end of this url

**'api_key'** and 'salt' values are provided by Traknpay.

**'mode'** value can be either TEST or LIVE.

**'return_handler'** will be controller function which will handle the 
response parameter sent back from traknpay payment gateway. Nampsapce\Of\Controller\TestController@responseHandler

For the rest of the parameters that need to be sent , refer the traknpay payment document.

## Usage  ##
To post the payment parameters to traknpay gateway.

```php
    Checkout::post([
        'order_id'       => '10',
        'amount'         => '201.00',
        'name'           => 'Payer Name',
        'email'          => 'Payer@example.com',
        'phone'          => '9876543210',
    ]);
```