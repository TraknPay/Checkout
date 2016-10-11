<?php

/**
 * Your package routes would go here
 */

Route::post('/response',$this->app->config->get('traknpay_payment_gateway.response_handler', true)
)->name('response');