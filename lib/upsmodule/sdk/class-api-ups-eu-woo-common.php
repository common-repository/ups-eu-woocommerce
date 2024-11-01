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
    //define variables
    protected $_request;
    protected $_response;
    protected $_uri;
    protected $_token;
    protected $_method;
    private static $config;
    public static $UPS_EU_WOO_DEVELOPER_LICENSE_NUMBER = "4DA3EC9F1A667475";
   // public static $UPS_EU_WOO_DEVELOPER_LICENSE_NUMBER = "ED466785DB641E6C";

    private function ups_eu_woo_common_loader()
    {
        if (empty(self::$config)) {
            include_once("config/class-api-ups-eu-woo-config.php");
            self::$config = new Ups_Eu_Woo_Config();
        }
    }

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

    /**
     * $option = 0 => Plugin Manager Tools
     * $option = 1 => Plugin Manager Analytics
     */
    public function set_api_url_manage($method_name, $option)
    {
        $this->ups_eu_woo_common_loader();
        $plugin_manage_url = "";
        if (strtolower($_SERVER['HTTP_HOST']) !== self::$config->ups_eu_woo_domain_host_uri) {
            $plugin_manage_url = self::$config->ups_eu_woo_apiurltool[self::$config->ups_eu_woo_pro];
            if ($option == 1) {
                $plugin_manage_url = self::$config->ups_eu_woo_apiurlanalytic[self::$config->ups_eu_woo_pro];
            }
            if ($option == 2) {
                $plugin_manage_url = self::$config->ups_eu_woo_apiurlups[self::$config->ups_eu_woo_pro];
            }
        } else {
            $plugin_manage_url = self::$config->ups_eu_woo_apiurltool[self::$config->ups_eu_woo_env];
            if ($option == 1) {
                $plugin_manage_url = self::$config->ups_eu_woo_apiurlanalytic[self::$config->ups_eu_woo_env];
            }
            if ($option == 2) {
                $plugin_manage_url = self::$config->ups_eu_woo_apiurlups[self::$config->ups_eu_woo_env];
            }
        }
        $this->_method = $method_name;
        $this->_uri = $plugin_manage_url . $method_name;
    }

    public function set_api_url_ups($method_name)
    {
        $this->ups_eu_woo_common_loader();
        $this->_method = $method_name;
        $this->_uri = self::$config->ups_eu_woo_apiurlups[self::$config->ups_eu_woo_pro] . $method_name;
        if (strtolower($_SERVER['HTTP_HOST']) === self::$config->ups_eu_woo_domain_host_uri) {
            $this->_uri = self::$config->ups_eu_woo_apiurlups[self::$config->ups_eu_woo_env] . $method_name;
        }

        if ($method_name == "Locator") {    //Locator: Exception only run in product
            $this->_uri = self::$config->ups_eu_woo_apiurlups[self::$config->ups_eu_woo_pro] . $method_name;
        }
    }

    /**
     * Manager Plugin
     */
    public function call_api_to_plugin_manager($data, $method_name, $bearer_token, $option)
    {
        $this->set_api_url_manage($method_name, $option);
        $this->set_token($bearer_token);
        $this->set_request_data_by_object($data);
        $response = $this->ups_eu_woo_send_request();
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
        $response = $this->ups_eu_woo_send_request();
        return $response;
    }

    public function ups_eu_woo_send_request()
    {
        $request_data = $this->_request;
        $this->_response = $this->ups_eu_woo_send($this->_uri, $this->_token, $request_data);
        return $this->_response;
    }

    public function get_license($data = '')
    {
        if (!empty($data) && isset($data->Username)) {
            $usernameToken = new \stdClass();
            $usernameToken->Username = $data->Username;
            $usernameToken->Password = $data->Password;
            $serviceAccessToken = new \stdClass();
            $serviceAccessToken->AccessLicenseNumber = $data->AccessLicenseNumber;

            $dataFormat = new \stdClass();
            $dataFormat->UsernameToken = $usernameToken;
            $dataFormat->ServiceAccessToken = $serviceAccessToken;

            return $dataFormat;
        }
    }

    public function ups_eu_woo_send($url = 'nul', $token = 'nul', $data = '')
    {
        ob_start();
        $this->ups_eu_woo_common_loader();
        if ($url != 'nul') {
            $this->_url = $url;
        }

        if ($token != 'nul') {
            $this->_token = $token;
        }

        $header = [
            'Authorization' => 'Bearer ' . $token,
            'Cache-Control'    => 'no-cache',
            'Content-Type'    => 'application/json'
        ];

        if (empty($token)) {
            $header = [
                'Cache-Control'    => 'no-cache',
                'Content-Type'    => 'application/json'
            ];
        }

        $post_data = [
            'method' => 'POST',
            'headers' => $header,
            'timeout' => self::$config->ups_eu_woo_timeout,
            'body' => $data
        ];
        ob_end_clean();
        $response = wp_remote_post($this->_url, $post_data);
        if (!empty($response->errors)) {
            $result = json_encode($response);
        } else {
            $result = $response['body'];
        }
        return $result;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
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
