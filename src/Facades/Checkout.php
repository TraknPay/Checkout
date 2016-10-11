<?php

namespace TraknPay\Checkout\Facades;


use Illuminate\Support\Facades\Facade;

Class Checkout extends  Facade{


	protected static function getFacadeAccessor()
	{
		return 'checkout';
	}
}