<?php

/**
 * Your package config would go here
 */

return [

	/**
	 * Your server URL
	 */
	'app_url'            => 'http://localhost:8000',

	/**
	 * api key given to the merchant by traknpay
	 */
	'api_key'            => '',

	/**
	 * salt value given to the merchant by traknpay
	 */
	'salt'               => '',

	/**
	 * return url to which payment response from the traknpay will be posted. replace localhost:8000 with your server URL
	 */
	'return_url'         => '/response',

	/**
	 * biz url to which payment request will be posted.
	 */
	'biz_url'            => 'https://biz.traknpay.in/v1/paymentrequest',

	/**
	 * mode type , either TEST or LIVE
	 */
	'mode'               => 'TEST',

	/**
	 * default value for payment parameters
	 */
	'default_parameters' => [
		/**
		 * currency value should be equal to 'INR'
		 */
		'currency'       => 'INR',
		/**
		 * description field
		 */
		'description'    => 'Payment by traknpay',
		/**
		 * name field is mandatory
		 */
		'name'           => 'Payer name',
		/**
		 * email field is mandatory
		 */
		'email'          => 'Payer@email.com',
		/**
		 * phone field is mandatory
		 */
		'phone'          => '9876543210',
		/**
		 * address field 1
		 */
		'address_line_1' => '',
		/**
		 * address field 2
		 */
		'address_line_2' => '',
		/**
		 * city field is mandatory
		 */
		'city'           => 'Payer city',
		/**
		 * state field
		 */
		'state'          => '',
		/**
		 * country value should be equal to 'IND'
		 */
		'country'        => 'IND',
		/**
		 * zip code field is mandatory
		 */
		'zip_code'       => '000000',
		/**
		 * user defined fields
		 */
		'udf1'           => '',
		'udf2'           => '',
		'udf3'           => '',
		'udf4'           => '',
		'udf5'           => '',
	],
	/**
	 * function name which will handle the response parameters from traknpay payment.
	 */
	'response_handler'   => 'TraknPay\Checkout\Checkout@handleResponse',
];