<?php

/**
 * _USER_TECHNICAL_AGREEMENT
 * 
 * @category  ups-shipping-for-woocommerce
 * @package   UPS Shipping and UPS Access Point™ : Official Plugin For WooCommerce
 * @author    United Parcel Service of America, Inc. <noreply@ups.com>
 * @license   This work is Licensed under the Apache License, version 2.0
 * https://www.apache.org/licenses/LICENSE-2.0
 * @copyright (c) 2019, United Parcel Service of America, Inc., all rights reserved
 * @link      https://www.ups.com/pl/en/services/technology-integration/ecommerce-plugins.page
 * 
 * _LICENSE_TAG
 *
 * Ups.php - The core plugin class.
 * 
 * This is used to define method and call to UPS's API.
 */

class Ups_Eu_Woo_UPS
{
	private static $license;
	private static $account;
	private static $shipment;
	private static $convert;
	private static $locator;
	private static $rate;
	private static $common;

	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* 0. list Object
	*/
	public function ups_eu_woo_api_list_object () {
		$object = new\ stdClass();
		$object->check = 'check';
		$object->message = 'message';
		$object->dev = 'DEV';
		$object->address_1 = 'address_1';
		$object->address_2 = 'address_2';
		$object->address_3 = 'address_3';
		$object->address = 'Address';
		$object->address_line = 'AddressLine';
		$object->shipper = 'Shipper';
		$object->shipfrom = 'ShipFrom';
		$object->shipto = 'ShipTo';
		$object->phone = 'Phone';
		$object->number = 'Number';
		$object->phone_number = 'phone_number';
		$object->name = 'Name';
		$object->attention_name = 'AttentionName';
		$object->alternate = 'AlternateDeliveryAddress';
		$object->post_code = 'post_code';
		$object->postal_code = 'PostalCode';

		$object->account = 'Ups_Eu_Woo_Account';
		$object->convert = 'Ups_Eu_Woo_ConvertToASCII';
		$object->license = 'Ups_Eu_Woo_License';
		$object->locator = 'Ups_Eu_Woo_Locator';
		$object->rate = 'Ups_Eu_Woo_Rate';
		$object->shipment = 'Ups_Eu_Woo_Shipment';
		$object->common = 'Ups_Eu_Woo_Common';

		return $object;
	}

	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* function load class
	*/
	private function ups_eu_woo_api_load_library($class_name) {
		$constants = $this->ups_eu_woo_api_list_object();
		switch ($class_name) {
			case $constants->license:
				if (empty(self::$license)) {
					include_once('ups/class-api-ups-eu-woo-license.php');
					self::$license = new Ups_Eu_Woo_License();
				}
				break;
			case $constants->account:
				if (empty(self::$account)) {
					include_once('ups/class-api-ups-eu-woo-account.php');
					self::$account = new Ups_Eu_Woo_Account();
				}
				break;
			case $constants->convert:
				if (empty(self::$convert)) {
					include_once('ups/class-api-ups-eu-woo-convert-to-ascii.php');
					self::$convert = new Ups_Eu_Woo_ConvertToASCII();
				}
				break;
			case $constants->locator:
				if (empty(self::$locator)) {
					include_once('ups/class-api-ups-eu-woo-locator.php');
					self::$locator = new Ups_Eu_Woo_Locator();
				}
				break;
			case $constants->rate:
				if (empty(self::$rate)) {
					include_once('ups/class-api-ups-eu-woo-rate.php');
					self::$rate = new Ups_Eu_Woo_Rate();
				}
				break;
			case $constants->shipment:
				if (empty(self::$shipment)) {
					include_once('ups/class-api-ups-eu-woo-shipment.php');
					self::$shipment = new Ups_Eu_Woo_Shipment();
				}
				break;
			case $constants->common:
				if (empty(self::$common)) {
					include_once("class-api-ups-eu-woo-common.php");
					self::$common = new Ups_Eu_Woo_Common();
				}
				break;
			default:
				break;
		}
	}

	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* 1. ups_eu_woo_license_access_1
	*/
    public function ups_eu_woo_api_termcondition($data) {
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->license);
		$this->ups_eu_woo_api_load_library($constants->common);
		$apiName = 'License';
		$developerLicenseNumber = Ups_Eu_Woo_Common::$UPS_EU_WOO_DEVELOPER_LICENSE_NUMBER;
        $request = self::$license->ups_eu_woo_license_access_1($data, $developerLicenseNumber);
		$response = $this->ups_eu_woo_send_request($request, $apiName, '');
		$jsonData =  json_decode($response);
		$accessLicenseText = '';
		if (isset($jsonData->AccessLicenseAgreementResponse->AccessLicenseText)) {
			$accessLicenseText = $jsonData->AccessLicenseAgreementResponse->AccessLicenseText;
		}
		return $accessLicenseText;
    }
	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* 2. Create Account Default
	*/
	public function ups_eu_woo_api_registration($data, $license) {
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->account);
		$this->ups_eu_woo_api_load_library($constants->convert);
        $upsSecurity = $this->get_license_api($license);
		$apiName = 'Registration';
		$constants = $this->ups_eu_woo_api_list_object();
		//address_1
		$data[$constants->address_1] = $this->resetup_address($data[$constants->address_1]);
		$data[$constants->address_2] = $this->resetup_address($data[$constants->address_2]);
		$data[$constants->address_3] = $this->resetup_address($data[$constants->address_3]);
		$data[$constants->phone_number] = $this->resetup_phone_number($data[$constants->phone_number]);
		$data[$constants->post_code] = $this->resetup_postal_code($data[$constants->post_code]);
		//Convert data input to Ascii
		self::$convert->ups_eu_woo_convert_transliterator($data);
		$response = self::$account->ups_eu_woo_api_account_registration($data, $upsSecurity);
		//Call Curl
		$responseData = $this->ups_eu_woo_send_request($response['request'], $apiName, '');
		$arrayResponse  = array();
		$json = json_decode($responseData);
		if (isset($data['account_type']) && $data['account_type'] == 3) {
			if (isset($json->RegisterResponse->Response->ResponseStatus->Code) &&
			$json->RegisterResponse->Response->ResponseStatus->Code == 1) {
				$arrayResponse[$constants->check] = $json->RegisterResponse->Response->ResponseStatus->Code;
				$arrayResponse['description'] = $json->RegisterResponse->Response->ResponseStatus->Description;
				$check_api_response = self::$account->ups_eu_woo_account_check_success_api($json->RegisterResponse->ShipperAccountStatus);
				$arrayResponse[$constants->message] = $check_api_response[1];
			} else {
				$arrayResponse[$constants->check] = false;
				$arrayResponse[$constants->message] =
					$json->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description;
			}
		} else {
			if (isset($json->RegisterResponse->Response->ResponseStatus->Code) &&
			$json->RegisterResponse->Response->ResponseStatus->Code == 1) {
				$check_api_response = self::$account->ups_eu_woo_account_check_success_api($json->RegisterResponse->ShipperAccountStatus);
				$arrayResponse[$constants->check] = $check_api_response[0];
				$arrayResponse[$constants->message] = $check_api_response[1];
			} else {
				$arrayResponse[$constants->check] = false;
				$arrayResponse[$constants->message] =
					$json->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description;
			}
		}
		$arrayResponse['username'] = $response['username'];
		$arrayResponse['password'] = $response['password'];
		return $arrayResponse;
    }

	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* 3 ups_eu_woo_license_access_2
	*/
	public function ups_eu_woo_api_access_2($data, $licenseUps) {
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->license);
		$this->ups_eu_woo_api_load_library($constants->convert);
		$this->ups_eu_woo_api_load_library($constants->common);

		$upsSecurity = $this->get_license_api($licenseUps);
		$apiName = 'License';
		$data['developerLicenseNumber'] = Ups_Eu_Woo_Common::$UPS_EU_WOO_DEVELOPER_LICENSE_NUMBER;
		$data['accessLicenseText'] =  $licenseUps['AccessLicenseText'];
		$data[$constants->address_1] = $this->resetup_address($data[$constants->address_1]);
		$data[$constants->address_2] = $this->resetup_address($data[$constants->address_2]);
		$data[$constants->address_3] = $this->resetup_address($data[$constants->address_3]);
		$data[$constants->phone_number] = $this->resetup_phone_number($data[$constants->phone_number]);
		$data[$constants->post_code] = $this->resetup_postal_code($data[$constants->post_code]);
		//Convert data input to Ascii
		self::$convert->ups_eu_woo_convert_transliterator($data);
		$request = self::$license->ups_eu_woo_license_access_2($data, $upsSecurity);

		$response = $this->ups_eu_woo_send_request($request, $apiName, '');
		return $response;
	}

	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* 4 Account Success
	*/

    public function ups_eu_woo_api_registration_success($data, $license) {
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->account);
		$this->ups_eu_woo_api_load_library($constants->convert);

        $upsSecurity = $this->get_license_api($license);
		$apiName = 'Registration';
		$data[$constants->post_code] = $this->resetup_postal_code($data[$constants->post_code]);
		//Convert data input to Ascii
		self::$convert->ups_eu_woo_convert_transliterator($data);
        $request =  self::$account->ups_eu_woo_api_account_registration_success($data, $upsSecurity);
		$response = $this->ups_eu_woo_send_request($request, $apiName, '');
		$arrayResponse  = array();
		$json = json_decode($response);
		if (isset($json->ManageAccountResponse->Response->ResponseStatus->Code) &&
			$json->ManageAccountResponse->Response->ResponseStatus->Code == 1
		) {
			$check_api_response = self::$account->ups_eu_woo_account_check_success_api($json->ManageAccountResponse->ShipperAccountStatus);
			$arrayResponse[$constants->check] = $check_api_response[0];
			$arrayResponse[$constants->message] = $check_api_response[1];
		} else {
			$arrayResponse[$constants->check] = false;
			$arrayResponse[$constants->message] =
				$json->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description;
		}
		return $arrayResponse;
    }

	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* 4.1 Open Account
	*/

	public function license($data, $license){
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->account);
		$this->ups_eu_woo_api_load_library($constants->convert);

		$upsSecurity = $this->get_license_api($license);

		$apiName = $constants->license;
		//Convert data input to Ascii
		self::$convert->ups_eu_woo_convert_transliterator($data);
		//resetup data (address, phone number, postal code)
        $request =  self::$account->ups_eu_woo_account_license($data, $upsSecurity);
		$response = $this->ups_eu_woo_send_request($request, $apiName, '');
		return $response;
	}

	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* 4.1 Open Account
	*/

	public function ups_eu_woo_api_promo_discount_agreement($data, $license){
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->account);
		$this->ups_eu_woo_api_load_library($constants->convert);

		$upsSecurity = $this->get_license_api($license);

		$apiName = 'PromoDiscount';
		//Convert data input to Ascii
		self::$convert->ups_eu_woo_convert_transliterator($data);
		//resetup data (address, phone number, postal code)
        $request =  self::$account->ups_eu_woo_api_account_promo_discount_agreement($data, $upsSecurity);
		$response = $this->ups_eu_woo_send_request($request, $apiName, '');
		return $response;
	}

	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* 4.1 Open Account
	*/

	public function ups_eu_woo_api_promo($data, $license){
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->account);
		$this->ups_eu_woo_api_load_library($constants->convert);

		$upsSecurity = $this->get_license_api($license);

		$apiName = 'PromoDiscount';
		//Convert data input to Ascii
		self::$convert->ups_eu_woo_convert_transliterator($data);
		//resetup data (address, phone number, postal code)
        $request =  self::$account->ups_eu_woo_api_account_promo($data, $upsSecurity);
		$response = $this->ups_eu_woo_send_request($request, $apiName, '');
		return $response;
	}

	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* 4.1 Open Account
	*/

	public function ups_eu_woo_api_open_account($data, $license){
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->account);
		$this->ups_eu_woo_api_load_library($constants->convert);

		$upsSecurity = $this->get_license_api($license);
		$apiName = 'OpenAccount';
		//Convert data input to Ascii
		self::$convert->ups_eu_woo_convert_transliterator($data);
		//resetup data (address, phone number, postal code)
        $request =  self::$account->ups_eu_woo_api_account_open_account($data, $upsSecurity);
		$response = $this->ups_eu_woo_send_request($request, $apiName, '');
		return $response;
	}

	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* 5 Shipment
	*/

    public function ups_eu_woo_api_create_shipment($data, $license) {
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->shipment);

        $upsSecurity = $this->get_license_api($license);
		$apiName = 'Ship';
		//reset address
		$shipper_address_line = $data[$constants->shipper][$constants->address][$constants->address_line];
		$shipfrom_address_line = $data[$constants->shipfrom][$constants->address][$constants->address_line];
		$shipto_address_line = $data[$constants->shipto][$constants->address][$constants->address_line];
		if (!empty($data[$constants->alternate][$constants->name])) {
			$alternate_name = $data[$constants->alternate][$constants->name];
			$alternate_attention_name = $data[$constants->alternate][$constants->attention_name];
			$alternate_address = $data[$constants->alternate][$constants->address][$constants->address_line];
			$data[$constants->alternate][$constants->name] = $this->resetup_address($alternate_name);
			$data[$constants->alternate][$constants->attention_name] = $this->resetup_address($alternate_attention_name);
			$data[$constants->alternate][$constants->address][$constants->address_line] =
				$this->resetup_address($alternate_address);
			$alternate_postal_code = $data[$constants->alternate][$constants->address][$constants->postal_code];
			$data[$constants->alternate][$constants->address][$constants->postal_code] =
				$this->resetup_postal_code($alternate_postal_code);
		}

		$data[$constants->shipper][$constants->address][$constants->address_line] =
			$this->resetup_address($shipper_address_line);
		$data[$constants->shipfrom][$constants->address][$constants->address_line] =
			$this->resetup_address($shipfrom_address_line);
		$data[$constants->shipto][$constants->address][$constants->address_line] =
			$this->resetup_address($shipto_address_line);
		//reset phone number
		$data[$constants->shipper][$constants->phone][$constants->number] = $this->resetup_phone_number(
			$data[$constants->shipper][$constants->phone][$constants->number]
		);
		$data[$constants->shipfrom][$constants->phone][$constants->number] = $this->resetup_phone_number(
			$data[$constants->shipfrom][$constants->phone][$constants->number]
		);
		$data[$constants->shipto][$constants->phone][$constants->number] = $this->resetup_phone_number(
			$data[$constants->shipto][$constants->phone][$constants->number]
		);
		//reset postal code
		$data[$constants->shipper][$constants->address][$constants->postal_code] = $this->resetup_postal_code(
			$data[$constants->shipper][$constants->address][$constants->postal_code]
		);
		$data[$constants->shipfrom][$constants->address][$constants->postal_code] = $this->resetup_postal_code(
			$data[$constants->shipfrom][$constants->address][$constants->postal_code]
		);
		$data[$constants->shipto][$constants->address][$constants->postal_code] = $this->resetup_postal_code(
			$data[$constants->shipto][$constants->address][$constants->postal_code]
		);

		$request = self::$shipment->ups_eu_woo_shipment_create_shipments($data, $upsSecurity);
		$response = $this->ups_eu_woo_send_request($request, $apiName, '');
		return $response;
    }

	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* 6 Status Shipment
	*/

    public function ups_eu_woo_api_status_shipment($data, $license) {
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->shipment);
		$this->ups_eu_woo_api_load_library($constants->common);

		$upsSecurity = $this->get_license_api($license);
		if (Ups_Eu_Woo_Common::$UPS_EU_WOO_ENV == $constants->dev) {
			$data['InquiryNumber'] = '1Z12345E0205271688';
		}
		$apiName = 'Track';
		$request = self::$shipment->ups_eu_woo_shipment_tracking($data, $upsSecurity);
		$response = $this->ups_eu_woo_send_request($request, $apiName, '');
		return $response;
	}

	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* 6.1. Cancel Shipment
	*/

    public function ups_eu_woo_api_cancel_shipment($data, $license) {
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->common);
		$this->ups_eu_woo_api_load_library($constants->shipment);

        $upsSecurity = $this->get_license_api($license);
		if (Ups_Eu_Woo_Common::$UPS_EU_WOO_ENV == $constants->dev) {
			$data['ShipmentIdentificationNumber'] = '1ZISDE016691676846';
		}
		$apiName = 'Void';
		$request = self::$shipment->ups_eu_woo_shipment_cancel_shipments($data, $upsSecurity);
		$response = $this->ups_eu_woo_send_request($request, $apiName, '');
		return $response;
	}

	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* 7 Print  Label
	*/

    public function ups_eu_woo_api_print_label($data, $license) {
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->shipment);
		$this->ups_eu_woo_api_load_library($constants->common);
        $upsSecurity = $this->get_license_api($license);
		if (Ups_Eu_Woo_Common::$UPS_EU_WOO_ENV == $constants->dev) {
			$data['TrackingNumber'] = '1Z12345E8791315509';
		}
		$apiName = 'LBRecovery';
		$request = self::$shipment->ups_eu_woo_shipment_label_recovery($data, $upsSecurity);
		$response = $this->ups_eu_woo_send_request($request, $apiName, '');
		return $response;
	}


	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* 8 Locator
	*/

    public function ups_eu_woo_api_locator($data, $license) {
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->locator);

        $upsSecurity = $this->get_license_api($license);
		$apiName = 'Locator';
		$request = self::$locator->ups_eu_woo_locator_load_address($data, $upsSecurity);
		$response = $this->ups_eu_woo_send_request($request, $apiName, '');
		return $response;
    }

	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* 9 Rate
	*/

    public function ups_eu_woo_api_get_rate($data, $license) {
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->rate);
        $upsSecurity = $this->get_license_api($license);
		$apiName = 'Rate';
		//resetup address
		$shipper_address_line = $data[$constants->shipper][$constants->address][$constants->address_line];
		$shipfrom_address_line = $data[$constants->shipfrom][$constants->address][$constants->address_line];
		$shipto_address_line = $data[$constants->shipto][$constants->address][$constants->address_line];
		if (!empty($data[$constants->alternate][$constants->name])) {
			$alternate_name = $data[$constants->alternate][$constants->name];
			$alternate_attention_name = $data[$constants->alternate][$constants->attention_name];
			$alternate_address = $data[$constants->alternate][$constants->address][$constants->address_line];
			$data[$constants->alternate][$constants->name] = $this->resetup_address($alternate_name);
			$data[$constants->alternate][$constants->attention_name] = $this->resetup_address($alternate_attention_name);
			$data[$constants->alternate][$constants->address][$constants->address_line] =
				$this->resetup_address($alternate_address);
			$alternate_postal_code = $data[$constants->alternate][$constants->address][$constants->postal_code];
			$data[$constants->alternate][$constants->address][$constants->postal_code] =
				$this->resetup_postal_code($alternate_postal_code);
		}

		$data[$constants->shipper][$constants->address][$constants->address_line] =
			$this->resetup_address($shipper_address_line);
		$data[$constants->shipfrom][$constants->address][$constants->address_line] =
			$this->resetup_address($shipfrom_address_line);
		$data[$constants->shipto][$constants->address][$constants->address_line] =
			$this->resetup_address($shipto_address_line);
		//reset postal code
		$data[$constants->shipper][$constants->address][$constants->postal_code] = $this->resetup_postal_code(
			$data[$constants->shipper][$constants->address][$constants->postal_code]
		);
		$data[$constants->shipfrom][$constants->address][$constants->postal_code] = $this->resetup_postal_code(
			$data[$constants->shipfrom][$constants->address][$constants->postal_code]
		);
		$data[$constants->shipto][$constants->address][$constants->postal_code] = $this->resetup_postal_code(
			$data[$constants->shipto][$constants->address][$constants->postal_code]
		);

		$request = self::$rate->ups_eu_woo_rate_get_rates($data, $upsSecurity);
		$response = $this->ups_eu_woo_send_request($request, $apiName, '');
		return $response;
	}

	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* function common create CURL
	* @param request_data
	* @param url
	* @param token
	*/
	public function ups_eu_woo_send_request($request_data, $url, $token) {
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->common);
		$response = self::$common->call_api_to_ups($request_data, $url, $token);
		return $response;
	}

	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* function common get license
	* @param license
	*/
	public function get_license_api($license) {
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->common);
		$response = self::$common->get_license($license);
		return $response;
	}

	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: resetup_address
     * Params: $address_line
     * Return: split address data to 35 characters and clear some decode key
     */
	private function resetup_address($address_line) {
		if (!empty($address_line) && is_array($address_line)) {
			foreach ($address_line as $key => $value) {
				$add = str_replace(array('amp;', '&lt;', '&gt;'), array('', '<', '>'), $value);
				$address_line[$key] = $this->string_split($add);
			}
		} else {
			$address = str_replace(array('amp;', '&lt;', '&gt;'), array('', '<', '>'), $address_line);
			$address_line = $this->string_split($address);
		}
		return $address_line;
	}
	
	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: string_split
     * Params: $string
     * Return: split string data to 35 characters
     */
	private function string_split($string) {
		$str_decode = utf8_decode($string);
		if (strlen($str_decode) > 35) {
			$result = utf8_encode(substr($str_decode, 0, 35));
		} else {
			$result = $string;
		}
		return $result;
	}
	
	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: resetup_phone_number
     * Params: $phone_number
     * Return: get only number in phone number data
     */
	private function resetup_phone_number($phone_number) {
		$pattern = '/\D/';
		$phone_number = preg_replace($pattern, '', $phone_number);
		return $phone_number;
	}
	
	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: resetup_postal_code
     * Params: $postal_code
     * Return: postal code data after clear special key
     */
	private function resetup_postal_code($postal_code) {
		$pattern = '/[^A-Za-z0-9]/';
		$postal_code = str_replace(array('amp;', '&lt;', '&gt;'), array('', '<', '>'), $postal_code);
		$postal_code_new = preg_replace($pattern, '', $postal_code);
		return $postal_code_new;
	}

	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: get_information_all
     * Params: $col_url, $col_method, $col_request, $col_response
     * Return: data info of url,request,response
     */
	public function get_information_all($col_url, $col_request, $col_response) {
		$constants = $this->ups_eu_woo_api_list_object();
		$this->ups_eu_woo_api_load_library($constants->common);
		$api_info = self::$common->get_api_info();
		return [
            "{$col_url}" => $api_info->uri,
            "{$col_request}" => $api_info->request,
            "{$col_response}" => $api_info->response
        ];
	}
}
