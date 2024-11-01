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
    private static $common;
    private static $convert;
    private static $manage_account;
    private static $promo_discount;
    private static $locator;
    private static $rate;
    private static $tracking;
    private static $manage_shipment;
    private static $cancel_shipment;

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * 0. list Object
     */
    public function ups_eu_woo_api_list_object()
    {
        $object = new \stdClass();
        $object->dev = 'DEV';
        $object->check = 'check';
        $object->message = 'message';

        $object->common = 'Ups_Eu_Woo_Common';
        $object->convert = 'Ups_Eu_Woo_ConvertToASCII';
        $object->manage_account = 'Ups_Eu_Woo_Manage_Account';
        $object->promo_discount = 'Ups_Eu_Woo_Promo_Discount';
        $object->locator = 'Ups_Eu_Woo_Locator';
        $object->rate = 'Ups_Eu_Woo_Rate';
        $object->tracking = 'Ups_Eu_Woo_Tracking';
        $object->manage_shipment = 'Ups_Eu_Woo_Manage_Shipment';
        $object->cancel_shipment = 'Ups_Eu_Woo_Void_Shipment';

        return $object;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * function load class
     */
    private function ups_eu_woo_api_load_library($class_name)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        switch ($class_name) {
            case $constants->common:
                if (empty(self::$common)) {
                    include_once("class-api-ups-eu-woo-common.php");
                    self::$common = new Ups_Eu_Woo_Common();
                }
                break;
            case $constants->convert:
                if (empty(self::$convert)) {
                    include_once('common/class-api-ups-eu-woo-convert-to-ascii.php');
                    self::$convert = new Ups_Eu_Woo_ConvertToASCII();
                }
                break;
            case $constants->manage_account:
                if (empty(self::$manage_account)) {
                    include_once('ups/class-api-ups-eu-woo-manage-account.php');
                    self::$manage_account = new Ups_Eu_Woo_Manage_Account();
                }
                break;
            case $constants->promo_discount:
                if (empty(self::$promo_discount)) {
                    include_once('ups/class-api-ups-eu-woo-promo-discount.php');
                    self::$promo_discount = new Ups_Eu_Woo_Promo_Discount();
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
            case $constants->tracking:
                if (empty(self::$tracking)) {
                    include_once('ups/class-api-ups-eu-woo-tracking.php');
                    self::$tracking = new Ups_Eu_Woo_Tracking();
                }
                break;
            case $constants->manage_shipment:
                if (empty(self::$manage_shipment)) {
                    include_once('ups/class-api-ups-eu-woo-manage-shipment.php');
                    self::$manage_shipment = new Ups_Eu_Woo_Manage_Shipment();
                }
                break;
            case $constants->cancel_shipment:
                if (empty(self::$cancel_shipment)) {
                    include_once('ups/class-api-ups-eu-woo-void-shipment.php');
                    self::$cancel_shipment = new Ups_Eu_Woo_Void_Shipment();
                }
                break;
            default:
                break;
        }
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * 4 Account Success
     */

    public function ups_eu_woo_api_registration_success($data, $license)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->manage_account);
        $this->ups_eu_woo_api_load_library($constants->convert);

        $upsSecurity = $this->get_license_api($license);
        $apiName = 'Registration';

        $data->post_code = $this->resetup_postal_code($data->post_code);

        //Convert data input to Ascii
        self::$convert->ups_eu_woo_convert_transliterator($data);
        $request =  self::$manage_account->ups_eu_woo_api_account_registration_success($data, $upsSecurity);
        $response = $this->ups_eu_woo_send_request($request, $apiName, '');
        $arrayResponse  = [];
        $json = json_decode($response);
        if (isset($json->ManageAccountResponse->Response->ResponseStatus->Code) &&
            $json->ManageAccountResponse->Response->ResponseStatus->Code == 1
        ) {
            $check_api_response = self::$manage_account->ups_eu_woo_account_check_success_api($json->ManageAccountResponse->ShipperAccountStatus);
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
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * 4.1 Open Account
     */

    public function ups_eu_woo_api_promo_discount_agreement($data, $license)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->promo_discount);
        $this->ups_eu_woo_api_load_library($constants->convert);

        $upsSecurity = $this->get_license_api($license);

        $apiName = 'PromoDiscount';
        //Convert data input to Ascii
        self::$convert->ups_eu_woo_convert_transliterator($data);
        //resetup data (address, phone number, postal code)
        $request =  self::$promo_discount->ups_eu_woo_api_account_promo_discount_agreement($data, $upsSecurity);
        $response = $this->ups_eu_woo_send_request($request, $apiName, '');
        return $response;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * 4.1 Open Account
     */

    public function ups_eu_woo_api_promo($data, $license)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->promo_discount);
        $this->ups_eu_woo_api_load_library($constants->convert);

        $upsSecurity = $this->get_license_api($license);

        $apiName = 'PromoDiscount';
        //Convert data input to Ascii
        self::$convert->ups_eu_woo_convert_transliterator($data);
        //resetup data (address, phone number, postal code)
        $request =  self::$promo_discount->ups_eu_woo_api_account_promo($data, $upsSecurity);
        $response = $this->ups_eu_woo_send_request($request, $apiName, '');
        return $response;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * 5 Shipment
     */

    public function ups_eu_woo_api_create_shipment($data, $license)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->manage_shipment);

        $upsSecurity = $this->get_license_api($license);
        $apiName = 'Ship';
        //resetup address
        $shipper_address_line = $data->shipper->address_line;
        $shipfrom_address_line = $data->shipfrom->address_line;
        $shipto_address_line = $data->shipto->address_line;
        if (!empty($data->alternate_delivery_address->name)) {
            $alternate_name = $data->alternate_delivery_address->name;
            $alternate_attention_name = $data->alternate_delivery_address->attention_name;
            $alternate_address = $data->alternate_delivery_address->address_line;
            $data->alternate_delivery_address->name = $this->resetup_address($alternate_name);
            $data->alternate_delivery_address->attention_name = $this->resetup_address($alternate_attention_name);
            $data->alternate_delivery_address->address_line = $this->resetup_address($alternate_address);
            $alternate_postal_code = $data->alternate_delivery_address->post_code;
            $data->alternate_delivery_address->post_code = $this->resetup_postal_code($alternate_postal_code);
        }

        $data->shipper->address_line = $this->resetup_address($shipper_address_line);
        $data->shipfrom->address_line = $this->resetup_address($shipfrom_address_line);
        $data->shipto->address_line = $this->resetup_address($shipto_address_line);

        //reset phone number
        $data->shipper->phone_number = $this->resetup_phone_number($data->shipper->phone_number);
        $data->shipfrom->phone_number = $this->resetup_phone_number($data->shipfrom->phone_number);
        $data->shipto->phone_number = $this->resetup_phone_number($data->shipto->phone_number);
        //reset postal code
        $data->shipper->post_code = $this->resetup_postal_code($data->shipper->post_code);
        $data->shipfrom->post_code = $this->resetup_postal_code($data->shipfrom->post_code);
        $data->shipto->post_code = $this->resetup_postal_code($data->shipto->post_code);

        global $wpdb;
        $table_name = $wpdb->prefix . "ups_shipping_config";
        $result = $wpdb->get_results( "SELECT value FROM $table_name WHERE `key` = 'UPS_ACCEPT_PACKAGE_TYPE'" );
        $package_type = isset($result[0]->value) ? $result[0]->value : "02";
        $data->package_type = $package_type;

        $request = self::$manage_shipment->ups_eu_woo_create_shipments($data, $upsSecurity);
        $response = $this->ups_eu_woo_send_request($request, $apiName, '');
        return $response;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * 6 Status Shipment
     */

    public function ups_eu_woo_api_status_shipment($data, $license)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->tracking);
        $this->ups_eu_woo_api_load_library($constants->common);

        $upsSecurity = $this->get_license_api($license);
        $apiName = 'Track';
        $request = self::$tracking->ups_eu_woo_shipment_tracking($data, $upsSecurity);
        $response = $this->ups_eu_woo_send_request($request, $apiName, '');
        return $response;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * 6.1. Cancel Shipment
     */

    public function ups_eu_woo_api_cancel_shipment($data, $license)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->common);
        $this->ups_eu_woo_api_load_library($constants->cancel_shipment);

        $upsSecurity = $this->get_license_api($license);
        $apiName = 'Void';
        $request = self::$cancel_shipment->ups_eu_woo_cancel_shipment($data, $upsSecurity);
        $response = $this->ups_eu_woo_send_request($request, $apiName, '');
        return $response;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * 7 Print  Label
     */

    public function ups_eu_woo_api_print_label($data, $license)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->manage_shipment);
        $this->ups_eu_woo_api_load_library($constants->common);
        $upsSecurity = $this->get_license_api($license);
        $apiName = 'LBRecovery';
        $request = self::$manage_shipment->ups_eu_woo_label_recovery($data, $upsSecurity);
        $response = $this->ups_eu_woo_send_request($request, $apiName, '');
        return $response;
    }


    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * 8 Locator
     */

    public function ups_eu_woo_api_locator($data, $license)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->locator);

        $upsSecurity = $this->get_license_api($license);
        $apiName = 'Locator';
        $request = self::$locator->ups_eu_woo_locator_load_address($data, $upsSecurity);
        $response = $this->ups_eu_woo_send_request($request, $apiName, '');
        return $response;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * 9 Rate
     */

    public function ups_eu_woo_api_get_rate($data, $license)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->rate);
        $upsSecurity = $this->get_license_api($license);
        $apiName = 'Rate';
        //resetup address
        $shipper_address_line = $data->shipper->address_line;
        $shipfrom_address_line = $data->shipfrom->address_line;
        $shipto_address_line = $data->shipto->address_line;
        if (!empty($data->alternate_delivery_address->name)) {
            $alternate_name = $data->alternate_delivery_address->name;
            $alternate_attention_name = $data->alternate_delivery_address->attention_name;
            $alternate_address = $data->alternate_delivery_address->address_line;
            $data->alternate_delivery_address->name = $this->resetup_address($alternate_name);
            $data->alternate_delivery_address->attention_name = $this->resetup_address($alternate_attention_name);
            $data->alternate_delivery_address->address_line = $this->resetup_address($alternate_address);
            $alternate_postal_code = $data->alternate_delivery_address->post_code;
            $data->alternate_delivery_address->post_code = $this->resetup_postal_code($alternate_postal_code);
        }

        $data->shipper->address_line = $this->resetup_address($shipper_address_line);
        $data->shipfrom->address_line = $this->resetup_address($shipfrom_address_line);
        $data->shipto->address_line = $this->resetup_address($shipto_address_line);

        //reset postal code
        $data->shipper->post_code = $this->resetup_postal_code($data->shipper->post_code);
        $data->shipfrom->post_code = $this->resetup_postal_code($data->shipfrom->post_code);
        $data->shipto->post_code = $this->resetup_postal_code($data->shipto->post_code);

        global $wpdb;
        $table_name = $wpdb->prefix . "ups_shipping_config";
        $result = $wpdb->get_results( "SELECT value FROM $table_name WHERE `key` = 'UPS_ACCEPT_PACKAGE_TYPE'" );
        $package_type = isset($result[0]->value) ? $result[0]->value : "02";
        $data->package_type = $package_type;

        $request = self::$rate->ups_eu_woo_rate_get_rates($data, $upsSecurity);
        $response = $this->ups_eu_woo_send_request($request, $apiName, '');
        return $response;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * function common create CURL
     * @param request_data
     * @param url
     * @param token
     */
    public function ups_eu_woo_send_request($request_data, $url, $token)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->common);
        $response = self::$common->call_api_to_ups($request_data, $url, $token);
        return $response;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * function common get license
     * @param license
     */
    public function get_license_api($license)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->common);
        $response = self::$common->get_license($license);
        return $response;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: resetup_address
     * Params: $address_line
     * Return: split address data to 35 characters and clear some decode key
     */
    private function resetup_address($address_line)
    {
        if (!empty($address_line) && is_array($address_line)) {
            foreach ($address_line as $key => $value) {
                $add = str_replace(['amp;', '&lt;', '&gt;'], ['', '<', '>'], $value);
                $address_line[$key] = $this->string_split($add);
            }
        } else {
            $address = str_replace(['amp;', '&lt;', '&gt;'], ['', '<', '>'], $address_line);
            $address_line = $this->string_split($address);
        }
        return $address_line;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: string_split
     * Params: $string
     * Return: split string data to 35 characters
     */
    private function string_split($string)
    {
        $str_decode = utf8_decode($string);
        if (strlen($str_decode) > 35) {
            $result = utf8_encode(substr($str_decode, 0, 35));
        } else {
            $result = $string;
        }
        return $result;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: resetup_phone_number
     * Params: $phone_number
     * Return: get only number in phone number data
     */
    private function resetup_phone_number($phone_number)
    {
        $pattern = '/\D/';
        $phone_number = preg_replace($pattern, '', $phone_number);
        return $phone_number;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: resetup_postal_code
     * Params: $postal_code
     * Return: postal code data after clear special key
     */
    private function resetup_postal_code($postal_code)
    {
        $pattern = '/[^A-Za-z0-9]/';
        $postal_code = str_replace(['amp;', '&lt;', '&gt;'], ['', '<', '>'], $postal_code);
        $postal_code_new = preg_replace($pattern, '', $postal_code);
        return $postal_code;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: get_information_all
     * Params: $col_url, $col_method, $col_request, $col_response
     * Return: data info of url,request,response
     */
    public function get_information_all($col_url, $col_request, $col_response)
    {
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