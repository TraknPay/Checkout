# Checkout
Traknpay/Checkout is a Laravel package to integrate traknpay payment gateway in your laravel 5.X package

This package is used to integrate with traknpay api payment request.

## Requirements ##
 *PHP 5.4.0 or later
 *Laravel 5.3
 
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
    'salt'
    'mode'
    'return_handler'

'api_key' and 'salt' values are provided by Traknpay.

'mode' value can be either TEST or LIVE.

'return_handler' will be controller function which will handle the 
response parameter sent back from traknpay payment gateway. Nampsapce\Of\Controller\TestController@responseHandler

For the rest of the parameters that need to be sent , refer the traknpay payment document.


## Usage  ##
To post the payment parameters to traknpay gateway.

```php
   
    Checkout::post($parameters);

```