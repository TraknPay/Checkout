<?php

namespace TraknPay\Checkout;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class Checkout {

	protected $config;

	public function __construct()
	{
		$this->config = (object)Config::get('traknpay_payment_gateway');
	}

	/**
	 * function to post payment paramters to traknpay payment site
	 * @param $payment_parameters
	 */
	public function post($payment_parameters)
	{
		$default_parameters = $this->config->default_parameters;
		/* merge the payment array with default payment parameters */
		$payment_parameters = array_merge($default_parameters, $payment_parameters);

		/*Over riding the payment parameters from config file */
		$payment_parameters['api_key'] = $this->config->api_key;
		$payment_parameters['mode'] = $this->config->mode;
		$payment_parameters['return_url'] = $this->config->return_url;
		$payment_parameters['hash'] = $this->generateHash($payment_parameters);

		$payment_url = $this->config->biz_url;

		?>
		<html>
		<body OnLoad="OnLoadEvent();">
		<form name="form1" action="<?php echo $payment_url; ?>" method="post">
			<?php foreach ($payment_parameters as $key => $value) {
				echo '<input type="hidden" value="' . $value . '" name="' . $key . '"/>';
			} ?>
		</form>
		<script language="JavaScript">
			function OnLoadEvent() {
				document.form1.submit();
			}
		</script>
		</body>
		</html>
		<?php
	}

	/**
	 * function to generate hash value from payment parameters
	 * @param $input
	 * @return null
	 */
	public function generateHash($input)
	{

		/* Columns used for generating the hash value */
		$hash_columns = [
			'address_line_1',
			'address_line_2',
			'amount',
			'api_key',
			'city',
			'country',
			'currency',
			'description',
			'email',
			'mode',
			'name',
			'order_id',
			'phone',
			'return_url',
			'state',
			'udf1',
			'udf2',
			'udf3',
			'udf4',
			'udf5',
			'zip_code',
		];

		/*Sort the array before hashing*/
		ksort($hash_columns);

		/*Create a | (pipe) separated string of all the $input values which are available in $hash_columns*/
		$hash_data = $this->config->salt;;
		foreach ($hash_columns as $column) {
			if (isset($input[$column])) {
				if (strlen($input[$column]) > 0) {
					$hash_data .= '|' . $input[$column];
				}
			}
		}

		/* Convert the $hash_data to Upper Case and then use SHA512 to generate hash key */
		$hash = null;
		if (strlen($hash_data) > 0) {
			$hash = strtoupper(hash("sha512", $hash_data));
		}

		return $hash;

	}

	/**
	 * handle the response values from the payment gateway
	 * @param Request $request
	 * @return string
	 */
	public function handleResponse(Request $request)
	{
		$input = $request->all();
		/* if the response hash does not match the calculated hash then response message is tampered */
		if ($this->checkResponseHash($input)) {
			if ($input['response_code'] == 0) {
				return '<h3>Transaction is successful.</h3>';
			} else {
				return '<h3>Transaction failed.</h3>';
			}
		} else {
			return '<h3>Response message is tampered.</h3>';
		}

	}

	/**
	 * Function to calculate hash from the response parameter
	 * @param $input
	 * @return null
	 */
	public function checkResponseHash($input)
	{
		$response_hash = $input['hash'];
		unset($input['hash']);
		ksort($input);
		$secure_hash = null;
		$hash_data = $this->config->salt;
		foreach ($input as $key => $value) {
			if (strlen($value) > 0) {
				$hash_data .= '|' . $value;
			}
		}

		if (strlen($hash_data) > 0) {
			$secure_hash = strtoupper(hash('sha512', $hash_data));
		}
		return $secure_hash==$response_hash;
	}
}
