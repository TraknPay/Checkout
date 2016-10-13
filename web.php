<?php

/**
 * Your package routes would go here
 */

Route::post('/response','TraknPay\Checkout\Checkout@handleResponse')->name('response');