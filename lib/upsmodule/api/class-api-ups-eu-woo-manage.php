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
 * Manage.php - The core plugin class.
 * 
 * This is used to define and call to UPS Plugin Manager's API.
 */

class Ups_Eu_Woo_Manage
{
	private $_verion = '1.0.0';
	private $_key = 'key';
	private $_name = 'name';
	private $_tracking_number = 'trackingNumber';
	private $_shipment_status = 'shipmentStatus';

	private static $common;

	private function ups_eu_woo_api_load_library() {
		if (empty(self::$common)) {
			include_once("class-api-ups-eu-woo-common.php");
			self::$common = new Ups_Eu_Woo_Common();
		}
	}

	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_verify_merchant
     * Params: $license
     * Return: Token Key/False
     */
    public function ups_eu_woo_api_verify_merchant($license){
        $url = 'Merchant/VerifyMerchant';
        $token = '';
		$upsSecurity = $this->get_license_api($license);
        $dataFormat = array(
            "UPSSecurity" => $upsSecurity
        );
        $response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $token);
		$json_data = json_decode($response);
		//Response
		if (isset($json_data->data)) {
			return $json_data->data;
		} else {
			return false;
		}
	}
	
	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_update_merchant_status
     * Params: $data is {token,merchantKey,status,accountNumber=null}
     * Return: $response
     */
    public function ups_eu_woo_api_update_merchant_status($data){
		$url = 'Merchant/UpdateMerchantStatus';
		//Get Token
		$token = $data->token;
		$request = new \stdClass();
		$request->merchantKey = $data->merchantKey;
		if (isset($data->accountNumber)){
			$request->accountNumber = $data->accountNumber;
		}
		//Activated	10
		//Deactivated	20
		//Uninstalled	30
		$request->status = $data->status;
		//dataFormat
		$dataFormat[] = (array) $request;
		$response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $token);
		return $response;
	}

	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_transfer_accessorials
     * Params: $data is {token,merchantKey,accessorials}
     * Return: $response
     */
	public function ups_eu_woo_api_transfer_accessorials($data) {
		$url = 'Merchant/TransferAccessorials';
		$token = $data->token;
		$accessorials = $data->accessorials;
		//set Data
		$request = new \stdClass();
		$request->merchantKey = $data->merchantKey;
		if (!empty($accessorials)) {
			foreach ($accessorials as $item) {
				$request->accessorials[] = [
					$this->_key => $item->accessorial_key,
					$this->_name => $item->accessorial_name
				];
			}
		}
		//data Format
		$dataFormat[] = (array) $request;
		$response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $token);
		return $response;
	}

	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_transfer_default_package
     * Params: $data is {token,merchantKey,package:{name,weight,weightUnit,length,width,height,dimensionUnit}}
     * Return: $response
     */
	public function ups_eu_woo_api_transfer_default_package($data) {
		$url = 'Merchant/TransferDefaultPackage';
		//Token
		$token = $data->token;
		//Set Data
		$request = new \stdClass();
		$request->merchantKey = $data->merchantKey;
		//package
		$request->name = $data->package->package_name;
		$request->weight = $data->package->weight;
		$request->weightUnit = $this->transfer($data->package->unit_weight);
		$request->length = $data->package->length;
		$request->width = $data->package->width;
		$request->height = $data->package->height;
		$request->dimensionUnit = $data->package->unit_dimension;
		//data Format
		$dataFormat[] = (array) $request;
		$response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $token);
		return $response;
	}
	
	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_transfer_delivery_rates
     * Params: $data is {token,merchantKey,deliveryService}
     * Return: $response
     */
	public function ups_eu_woo_api_transfer_delivery_rates($data) {
		$url = 'Merchant/TransferDeliveryRates';
		//Token
		$token = $data->token;
		$request = new \stdClass();
		$request->merchantKey = $data->merchantKey;
		//data
		$deliveryService = $data->deliveryService;
		//Set delivery Rates
		if (!empty($deliveryService)) {
			foreach ($deliveryService as $item) {
				$arr_delivery = $this->ups_eu_woo_delivery_service($item);
				$request->deliveryRates[] = $arr_delivery;
			}
		}
		//dataFormat
		$dataFormat[] = (array) $request;
		$response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $token);
		return $response;
	}
	
	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_transfer_merchant_info_by_user
     * Params: $data is {token,merchantKey,account_list,platform,package,status}
     * Return: $response
     */
	public function ups_eu_woo_api_transfer_merchant_info_by_user($data) {
		$url = 'Merchant/TransferMerchantInfo';
		//Token
		$token = $data->token;
		$request = array();
		//Acount List
		$account_list = $data->account_list;
		$package = $data->package;
		$platform = $data->platform;
		$status = $data->status;
		//Info Account
		if (!empty($account_list)) {
			foreach($account_list as $item){
				$object_account = new \stdClass();
				$object_account = $this->ups_eu_woo_object_account($data->merchantKey, $item, $package, $platform, $status);
				$request[] = (array) $object_account;
			}
		}
		//dataFormat
		$dataFormat = (array) $request;
		$response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $token);
		return $response;
	}
	
	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_transfer_merchant_info
     * Params: $data is {token,merchantKey,accessorials,account_list,platform,package,service,deliveryService}
     * Return: $response
     */
	public function ups_eu_woo_api_transfer_merchant_info($data) {
		$url = 'Merchant/TransferMerchantInfo';
		//Token
		$token = $data->token;
		$request = array();
		//Acount List
		$account_list = $data->account_list;
		$accessorials = $data->accessorials;
		$package = $data->package;
		$platform = $data->platform;
		//Total accessorials
		// accessorial
		$arr_accessorials = array();
		if (!empty($accessorials)) {
			foreach ($accessorials as $item) {
				$arr_accessorials[] = [
					$this->_key => $item->accessorial_key,
					$this->_name => $item->accessorial_name
				];
			}
		}
		//service
		$shipping_service = $data->service;
		$arr_shipping_services = array();
		if (!empty($shipping_service)) {
			foreach ($shipping_service as $item) {
				$data_service = $this->ups_eu_woo_data_service($item);
				$arr_shipping_services[] = $data_service;
			}
		}
		//arrDeliveryRates
		$deliveryService = $data->deliveryService;
		$arr_delivery_rates = array();
		if (!empty($deliveryService)) {
			foreach ($deliveryService as $item) {
				$arr_delivery = $this->ups_eu_woo_delivery_service($item);
				$arr_delivery_rates[] = $arr_delivery;
			}
		}
		//Info Account
		if (!empty($account_list)) {
			foreach($account_list as $item){
				$object_account = new \stdClass();
				$object_account = $this->ups_eu_woo_object_account($data->merchantKey, $item, $package, $platform, 10);
				$object_account->accessorials = $arr_accessorials;
				$object_account->shippingServices = $arr_shipping_services;
				$object_account->deliveryRates = $arr_delivery_rates;
	
				$request[] = (array) $object_account;
			}
		}
		//dataFormat
		$dataFormat = (array) $request;
		$response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $token);
		return $response;
	}

	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_delivery_service
     * Params: $items is {rate_type,delivery_rate,rate_code,service_key_delivery,min_order_value,service_name}
     * Return: $array is service data
     */
	public function ups_eu_woo_delivery_service($items){
		$item = (object) $items;
		if ($item->service_type == 'AP') {
			$serviceType = 10;
		} else {
			$serviceType = 20;
		}
		//AP
		if ($item->rate_type == 'flat_rate') {
			$deliveryType = 10;
			$realtimeValue = 0;
			$delivery_rate = $item->delivery_rate;
		} else {//ADD
			$deliveryType = 20;
			$realtimeValue = $item->delivery_rate;
			$delivery_rate = 0;
		}
		//Service Name
		if ($item->service_id != 1) {
			$service_name = $item->service_name . 'u00ae';
		} else {
			$service_name = 'UPS Access Pointu2122 Economy' ;
		}
		//Response Data
		$array = [
			$this->_key => $item->service_key_delivery,
			'deliveryType' => $deliveryType,
			'serviceType' => $serviceType,
			'serviceName' => $service_name,
			'serviceCode' => $item->rate_code,
			'minimumOrderValue' => $item->min_order_value,
			'deliveryValue' => $delivery_rate,
			'realtimeValue' => $realtimeValue
		];
		return $array;
	}
	
	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_object_account
     * Params: $merchantKey, $package, $platform, $status, $items is account data
     * Return: $object is account data
     */
	public function ups_eu_woo_object_account($merchantKey, $items, $package, $platform, $status) {
		$object = new \stdClass();
		$item = (object) $items;

		$checkPostalCode = html_entity_decode($item->post_code);
		$postcode = preg_replace('/[^a-zA-Z0-9]/s', '', $checkPostalCode);

		//ACount Info
		$object->merchantKey = $merchantKey;
		$object->accountNumber = $item->ups_account_number;
		$object->companyName = $item->company;
		$object->joiningDate = date('d/m/Y');
		$object->website = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
		$object->currencyCode = $item->currency;
		$object->status = $status;
		$object->platform = $platform;
		$object->version = $this->_verion; //VERSION

		$address = '';
		if (!empty($item->address_1)) {
			$address .= $item->address_1;
		}
		if (!empty($item->address_2)) {
			$address .= ', '. $item->address_2;
		}
		if (!empty($item->address_3)) {
			$address .= ', '. $item->address_3;
		}

		$object->address = $address;

		$object->postalCode = $postcode;
		$object->city = $item->city;
		$object->country = $item->country;
		$object->isFirstAccount = (int) $item->account_default;
		//Package
		$object->defaultPackageName = $package->package_name;
		$object->weight = $package->weight;
		//Sub 2
		$object->weightUnit = $this->transfer($package->unit_weight);
		$object->length = $package->length;
		$object->width = $package->width;
		$object->height = $package->height;
		$object->dimensionUnit = $package->unit_dimension;
		return $object;
	}
	
	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_transfer_shipping_services
     * Params: $data is {token,merchantKey,deliveryService}
     * Return: $response
     */
	public function ups_eu_woo_api_transfer_shipping_services($data) {
        $url = 'Merchant/TransferShippingServices';
		//Token
		$token = $data->token;
		$request = new \stdClass();
		$request->merchantKey = $data->merchantKey;
		//service
		$shipping_service = $data->deliveryService;
		if (!empty($shipping_service)) {
			foreach ($shipping_service as $item) {
				$data_service = $this->ups_eu_woo_data_service($item);
				$request->shippingServices[] = $data_service;
			}
		}
		//dataFormat
		$dataFormat[] = (array) $request;
		$response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $token);
		return $response;
    }
	
	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_data_service
     * Params: $items is {service_type,service_name,service_key,service_key_val,rate_code}
     * Return: $data is service data
     */
	public function ups_eu_woo_data_service($items){
		$item = (object) $items;
		if ($item->service_type == 'AP') {
			$serviceType = 10;
		} else {
			$serviceType = 20;
		}
		if ($item->service_id != 1) {
			$service_name = $item->service_name . 'u00ae';
		} else {
			$service_name = 'UPS Access Pointu2122 Economy' ;
		}
		$data = [
				$this->_key => $item->service_key,
				'keyVal' => $item->service_key_val,
				'serviceType' => $serviceType,
				$this->_name => $service_name,
				'code' => $item->rate_code
			];
		return $data;
	}
	
	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_transfer_shipments
     * Params: $data is {token,merchantKey,accountNumber,shipmentId,fee,revenue,address,postalCode,city,country,
	 * serviceType,serviceCode,serviceName,isCashOnDelivery,products}
     * Return: $response
     */
    public function ups_eu_woo_api_transfer_shipments($data) {
        $url = 'Shipment/TransferShipments';
		//Token
		$token = $data->token;
		$request = new \stdClass();
		$request->merchantKey = $data->merchantKey;
		//create data API
		$request->accountNumber = $data->accountNumber;
		$request->shipmentId = $data->shipmentId;
		$request->fee = $data->fee;
		$request->revenue = $data->revenue;
		$request->orderDate = date('d/m/Y');
		$request->address = $data->address;
		$request->postalCode = $data->postalCode;
		$request->city = $data->city;
		$request->country = $data->country;
		$request->serviceType = $data->serviceType;
		$request->serviceCode = $data->serviceCode;
		$request->serviceName = $data->serviceName;
		$request->isCashOnDelivery = $data->isCashOnDelivery;
		$request->products = $data->products;
		//accessorials
		$accessorials = $data->accessorials;
		if (!empty($accessorials)) {
			foreach ($accessorials as $item) {
				$request->accessorials[] = [
					$this->_name => $item->accessorial_name
				];
			}
		}
		//packages
		$packages = $data->packages;
		if (!empty($packages)) {
			foreach ($packages as $item) {
				$request->packages[] = [
					$this->_tracking_number => $item->trackingNumber,
					$this->_shipment_status => $data->status,
					'weight' => (float)$item->weight,
					'weightUnit' => $this->transfer($item->unit_weight),
					'length' => (float)$item->length,
					'width' => (float)$item->width,
					'height' => (float)$item->height,
					'dimensionUnit' => $item->unit_dimension
				];
			}
		}
		//dataFormat
		$dataFormat[] = (array) $request;
		$response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $token);
		return $response;
	}

	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_update_shipment_status
     * Params: $data is {token,merchantKey,shipment:{shipmentId,shipmentStatus}}
     * Return: $response
     */
	public function ups_eu_woo_api_update_shipment_status($data) {
        $url = 'Shipment/UpdateShipmentStatus';
        $token = $data->token;
		$request = new \stdClass();

		$shipment = $data->shipment;
        $dataFormat = array();
		//shipment
		if (!empty($shipment)) {
			foreach ($shipment as $item) {
				$dataFormat[] = [
					'MerchantKey' => $data->merchantKey,
					$this->_tracking_number => $item->shipmentId,
					$this->_shipment_status => $item->shipmentStatus
				];
			}
		}
		//Call API
		$response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $token);
		return $response;
	}

	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_upgrade_plugin_version
     * Params: $data is {token,merchantKey}
     * Return: $response
     */
	public function ups_eu_woo_api_upgrade_plugin_version($data) {
        $url = 'Merchant/UpgradePluginVersion';
        $token = $data->token;
        $dataFormat = array(
            "merchantKey" => $data->merchantKey,
            "version" => VERSION
        );
		//Call API
        $response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $token);
		return $response;
	}
	
	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_send_request_to_manage
     * Params: $request_data, $url, $token
     * Return: $response
     */
	public function ups_eu_woo_send_request_to_manage($request_data, $url, $token) {
		$this->ups_eu_woo_api_load_library();
		$response = self::$common->call_api_to_plugin_manager($request_data, $url, $token);
		return $response;
	}

	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: get_license_api
     * Params: $license
     * Return: $response
     */
	public function get_license_api($license) {
		$this->ups_eu_woo_api_load_library();
		$response = self::$common->get_license($license);
		return $response;
	}
	
	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: transfer
     * Params: $key is lbs/kgs
     * Return: $response
     */
	function transfer($key){
		$array = array();
		$array['lbs'] = 'Pounds';
		$array['kgs'] = 'Kg';
		if(isset($array[$key])){
			return $array[$key];
		} else {
			return $key;
		}
	}

	/**
	 * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: get_information_all
     * Params: $col_url, $col_request, $col_response
     * Return: data info of url,request,response
     */
	public function get_information_all($col_url, $col_request, $col_response) {
		$this->ups_eu_woo_api_load_library();
		$api_info = self::$common->get_api_info();
		return [
            "{$col_url}" => $api_info->uri,
            "{$col_request}" => $api_info->request,
            "{$col_response}" => $api_info->response
        ];
	}
}
