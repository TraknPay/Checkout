[![Laravel 5.x](https://img.shields.io/badge/Laravel-5.x-orange.svg)](http://laravel.com)
[![Latest Stable Version](https://poser.pugx.org/traknpay/checkout/version)](https://packagist.org/packages/traknpay/checkout)
[![Latest Unstable Version](https://poser.pugx.org/traknpay/checkout/v/unstable)](//packagist.org/packages/traknpay/checkout)
[![Total Downloads](https://poser.pugx.org/traknpay/checkout/downloads)](https://packagist.org/packages/traknpay/checkout)
[![License](https://poser.pugx.org/yajra/laravel-datatables-oracle/license)](https://packagist.org/packages/yajra/laravel-datatables-oracle)

# Checkout
Traknpay/Checkout is a Laravel package to integrate traknpay payment gateway in your laravel 5.X package

This package is used to integrate with traknpay api payment request.

## Requirements ##
The Checkout package is working fine in Laravel 5.1 and 5.3.However , in laravel 5.2, there is a minor issue when response is not handled.If response is handled as described in the below steps then there would be no issue.

 1. PHP 5.4.0 or later
 2. Laravel 5.1 or 5.3
 
## Quick Installation ##

To get started, install Checkout via the Composer package manager:

    composer require traknpay/checkout

### Service Provider ###

Next,register the Checkout service provider in the providers array of your config/app.php configuration file:

    TraknPay\Checkout\CheckoutServiceProvider::class

### Facade ###

Add 'Checkout' facade in the aliases array of your config/app.php configuration file:

    'Checkout'=>TraknPay\Checkout\Facades\Checkout::class

### Configuration ###

Publish the configuration:

    php artisan vendor:publish

**config/traknpay_payment_gateway.php**

This is the configuration file that Laravel will publish into your config directory.

Open this file and provide values in following parameters

    'api_key'
    'app_url'
    'salt'
    'mode'

**'app_url'** is to be set to your server url, by default it is set to `http://localhost:8000`, do not add `'/'` at end of this url

**'api_key'** and **'salt'** values are provided by Traknpay.

**'mode'** value can be either `TEST` or `LIVE`.

For the rest of the parameters that need to be sent , please refer the traknpay integration document [TraknPay_Integration_Guide_Ver1.4.1](https://bitbucket.org/OmniwareIntegrationTeam/traknpay_integrations_plugins/downloads/Trak%20'n%20Pay%20Integration%20Guide%20Ver1.4.1.pdf).

## Usage  ##
To post the payment parameters to traknpay gateway, on clicking checkout button do following.

```php
    Checkout::post([
        'order_id'       => '10',
        'amount'         => '201.00',
        'name'           => 'Payer Name',
        'email'          => 'Payer@example.com',
        'phone'          => '9876543210',
    ]);
```
### Handling Response ###
There is an inbuilt response handler but that does not do much, apart from showing if the transaction was `Successful` or `Failed`.
 To handle the response on your own, use the following steps.

1. Create a controller (e.g. `PaymentController`)

2. Create a function within this controller(e.g. `handleResponse`)

3. In `handleResponse` function, perform hash check and then update your payment status.

    ```php
    
        use TraknPay\Checkout\Facades\Checkout;
    
        class PaymentController extends Controller
        {
            public  function handleResponse(Request $request) {
                if(Checkout::checkResponseHash($request->all())){
                    // if checkResponseHash returns true, continue to save the response.
                } else {
                    // if checkResponseHash returns false , then it means that response might be tampered
                }
            }
        }
    ```

4. Add the new route to `web.php` file.
    ```php
        Route::post('/paymentresponse','PaymentController@handleResponse');
    ```
5. Add this route in exception list of VerifyCsrfToken in the middleware.

6. Update `app_url` and `return_url` in `config/traknpay_payment_gateway.php`.
    ```php
        'app_url'    => 'http://your-site.com'
        'return_url' => '/paymentresponse'
    ```
