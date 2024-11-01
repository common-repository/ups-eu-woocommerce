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
 * Common.php - The core plugin class.
 * 
 * This is used to define and call to UPS's API.
 */

class Ups_Eu_Woo_Common
{
    //define constants
    public static $UPS_EU_WOO_ENV = "PRO";
    public static $UPS_EU_WOO__MAXREDIRECTS = 4;
    public static $UPS_EU_WOO_TIMEOUT = 600;
    public static $UPS_EU_WOO_APIURLMANAGER = [
        'DEV' => "https://plugins-management-server.fsoft.com.vn/api",
        'PRO' => "https://plugins-management-server.fsoft.com.vn/api"
    ];
    public static $UPS_EU_WOO_APIURLUPS = [
        'DEV' => "https://wwwcie.ups.com/rest",
        'PRO' => "https://onlinetools.ups.com/rest"
    ];
    public static $UPS_EU_WOO_DEVELOPER_LICENSE_NUMBER = "ED466785DB641E6C";
    //define variables
    protected $_request;
    protected $_response;
    protected $_uri;
    protected $_token;
    protected $_method;
    private $_username = 'Username';
    private $_pass_username_data = 'Password';
    private $_access_license_number = 'AccessLicenseNumber';

    public function set_request_data_by_object($request_data)
    {
        $this->_request = json_encode($request_data);
    }

    public function set_request_data($request_data)
    {
        $this->_request = $request_data;
    }

    public function set_uri($uri)
    {
        $this->_uri = $uri;
    }

    public function set_token($token)
    {
        $this->_token = $token;
    }

    public function set_api_url_manage($method_name)
    {
        $this->_method = $method_name;
        $this->_uri = self::$UPS_EU_WOO_APIURLMANAGER[self::$UPS_EU_WOO_ENV] . "/" . $method_name;
    }

    public function set_api_url_ups($method_name)
    {
        $this->_method = $method_name;
        $this->_uri = self::$UPS_EU_WOO_APIURLUPS[self::$UPS_EU_WOO_ENV] . "/" . $method_name;

        if ($method_name == "Locator") {    //Locator: Exception only run in product
            $this->_uri = self::$UPS_EU_WOO_APIURLUPS['PRO'] . "/" . $method_name;
        }
    }

    /**
     * Manager Plugin
     */
    public function call_api_to_plugin_manager($data, $method_name, $bearer_token)
    {
        $this->set_api_url_manage($method_name);
        $this->set_token($bearer_token);
        $this->set_request_data_by_object($data);
        $response = $this->send_request(1);
        return $response;
    }

    /**
     * UPS
     */
    public function call_api_to_ups($data, $method_name, $bearer_token)
    {
        $this->set_api_url_ups($method_name);
        $this->set_token($bearer_token);
        $this->set_request_data_by_object($data);
        $response = $this->send_request(0);
        return $response;
    }

    public function send_request($option)
    { // option = 0 UPS API, option = 1 UPS manager.
        if ($option == 0) {
            $request_data = $this->_request;
        } else {
            $data = base64_encode($this->_request);
            $request_data = "{\"data\":\"$data\"}";
        }
        $this->_response = $this->ups_eu_woo_send($this->_uri, $this->_token, $request_data);
        return $this->_response;
    }

    public function get_license($data = '')
    {
        if (self::$UPS_EU_WOO_ENV == "DEV") {
            $username_token = array();
            $username_token[$this->_username] = "TuChu0103";
            $username_token[$this->_pass_username_data] = "T!@#052018";
            $access_license_number = array();
            $access_license_number[$this->_access_license_number] = "0D46678E86A9D038";
            $license_data = [
                "UsernameToken" => $username_token,
                "ServiceAccessToken" => $access_license_number
            ];
        } else {
            $username_token = array();
            $username_token[$this->_username] = $data[$this->_username];
            $username_token[$this->_pass_username_data] = $data[$this->_pass_username_data];
            $access_license_number = array();
            $access_license_number[$this->_access_license_number] = $data[$this->_access_license_number];
            $license_data = [
                "UsernameToken" => $username_token,
                "ServiceAccessToken" => $access_license_number
            ];
        }
        return $license_data;
    }

    public function ups_eu_woo_send($url = 'nul', $token = '', $data = '') {
        if ($url != 'nul') {
            $this->_url = $url;
        }

        if ($token != 'nul') {
            $this->_token = $token;
        }

        $header = array(
            'Authorization' => 'Bearer ' . $token,
            'Cache-Control'	=> 'no-cache',
            'Content-Type'	=> 'application/json'
        );

        if (empty($token)) {
            $header = array(
                'Cache-Control'	=> 'no-cache',
				'Content-Type'	=> 'application/json'
            );
        }

		$post_data = array(
			'method' => 'POST',
			'headers' => $header,
			'timeout' => self::$UPS_EU_WOO_TIMEOUT,
			'body' => $data
		);

        $response = wp_remote_post($this->_url, $post_data);
        if (!empty($response->errors)) {
            $result = json_encode($response);
        } else {
			$result = $response['body'];
		}
        return $result;
    }

    /**
     * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: get_api_info
     * Params: empty
     * Return: data info of url,request,response
     */
    public function get_api_info()
    {
        $object = new \stdClass();
        $object->uri = $this->_uri;
        $object->request = $this->_request;
        $object->response = $this->_response;
        return $object;
    }
}
