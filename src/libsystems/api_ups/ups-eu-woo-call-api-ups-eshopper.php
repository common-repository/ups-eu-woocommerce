<?php namespace UpsEuWoocommerce\libsystems\api_ups;

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
 * ups-eu-woo-call-api-ups-eshopper.php - The core plugin class.
 *
 * This is used to define some methods to get information from Ups API for e-shopper.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_EShopper_Api_Ups');

class Ups_Eu_Woo_EShopper_Api_Ups extends Ups_Eu_Woo_Global_Api_Ups implements Ups_Eu_Woo_Interfaces_Api_Ups
{

    public function __construct()
    {
        parent::__construct();
    }

    public function ups_eu_woo_search_locator($data_array = [])
    {
        $object_call = new \stdClass();
        $object_call->check_api_all = false;
        call_user_func_array(
            [
            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Ups_Shipping_API(),
            "ups_eu_woo_input_params_ajax"
            ],
            [
            &$object_call
            ]
        );
        /* ---call lactor---- */
        $object_call->info_locator = call_user_func_array(
            [
            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Ups_Shipping_API(),
            "ups_eu_woo_process_data_locator"
            ],
            [
            $this->ups_eu_woo_call_locator($object_call, true), &$object_call, true
            ]
        );
        $object_call->html = call_user_func_array(
            [
            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Ups_Shipping_API(), "ups_eu_woo_process_html_search_locator"
            ],
            [
            &$object_call
            ]
        );
        return $object_call;
    }

    private function ups_eu_woo_check_update_type_ap(&$object_call, &$check_ap)
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_fallback_rates = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Fallback_Rates();
        $model_delivery_rates = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Delivery_Rates();

        $object_call->info_rateShopAP = call_user_func_array(
            [
            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Ups_Shipping_API(), $this->call_user_method_shoptint
            ],
            [
            $this->ups_eu_woo_get_rate_shop($object_call, "AP"), &$object_call, "AP"
            ]
        );
        $package_setting_option = 1;
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->PACKAGE_SETTING_OPTION}") === true) {
            $package_setting_option = $model_config->value;
        }
        $package_setting_option *= 1;
        if ($object_call->info_rateShopAP->check_api_response == "{$this->status_cal_api_ok}" &&
            count($object_call->info_rateShopAP->list_services) > 0) {
            foreach ($object_call->info_rateShopAP->list_services as $item_service) {
                $service_id = intval($item_service->Service->ID_Local);
                if ($service_id > 0) {
                    $shipping_country =WC()->customer->get_shipping_country();
                    $skiped = false;
                    $list_delivery_by_service = $model_delivery_rates->ups_eu_woo_get_min_max_delivery_by_service_id($service_id);
                    foreach ($list_delivery_by_service as $item_delivery){
                        if ($item_delivery->rate_type == "1" && !empty(array_column($list_delivery_by_service, "rate_country")) && !empty(array_column($list_delivery_by_service, "rate_rule"))){
                            if(array_search($shipping_country, array_column($list_delivery_by_service, "rate_country")) === false && array_search("all", array_column($list_delivery_by_service, "rate_country")) === false){
                                unset($object_call->info_rateShopAP->list_services[$service_id]);
                                $skiped = true;
                                break;
                            }
                        }
                    }
                    if($skiped){
                        continue;
                    }
                    $object_call->RateTimeInTransit[$service_id] = call_user_func_array(
                        [
                            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Ups_Shipping_API(),
                            $this->call_user_method_shopservice
                        ],
                        [$item_service, &$object_call, $service_id]
                    );
                }
            }
        }
    }

    private function ups_eu_woo_check_update_type_add(&$object_call, $check_ap)
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_fallback_rates = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Fallback_Rates();
        $model_delivery_rates = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Delivery_Rates();

        $object_call->info_rateShopADD = call_user_func_array(
            [
            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Ups_Shipping_API(), $this->call_user_method_shoptint
            ],
            [
            $this->ups_eu_woo_get_rate_shop($object_call, "ADD"), &$object_call, "ADD"
            ]
        );
        $package_setting_option = 1;
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->PACKAGE_SETTING_OPTION}") === true) {
            $package_setting_option = $model_config->value;
        }
        $package_setting_option *= 1;
        if ($object_call->info_rateShopADD->check_api_response == "{$this->status_cal_api_ok}" &&
            count($object_call->info_rateShopADD->list_services) > 0) {
            foreach ($object_call->info_rateShopADD->list_services as $item_service) {
                $service_id = intval($item_service->Service->ID_Local);
                    $shipping_country =WC()->customer->get_shipping_country();
                    $skiped = false;
                    $list_delivery_by_service = $model_delivery_rates->ups_eu_woo_get_min_max_delivery_by_service_id($service_id);
                    foreach ($list_delivery_by_service as $item_delivery){
                        if ($item_delivery->rate_type == "1" && !empty(array_column($list_delivery_by_service, "rate_country")) && !empty(array_column($list_delivery_by_service, "rate_rule"))){
                            if(array_search($shipping_country, array_column($list_delivery_by_service, "rate_country")) === false && array_search("all", array_column($list_delivery_by_service, "rate_country")) === false){
                                unset($object_call->info_rateShopAP->list_services[$service_id]);
                                $skiped = true;
                                break;
                            }
                        }
                    }
                    if($skiped){
                        continue;
                    }
                $object_call->RateTimeInTransit[$service_id] = call_user_func_array(
                    [
                        new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Ups_Shipping_API(),
                        $this->call_user_method_shopservice
                    ],
                    [$item_service, &$object_call, $service_id]
                );

                if (empty($object_call->RateTimeInTransit[$service_id])){
                   unset($object_call->RateTimeInTransit);
                }
            }
            
        } else { // The Weight = 0, get Add shipping services from Package dimension
            $error_check_api = ['110548','111030','111031','111035','111036','111050','111055','111056','111057','111546','111547','111548','112117','112118','112119','112120','9110054','9110055','9110056','9110057', '9110023'];
            $api_error_code = "000";
            if (!empty($object_call->info_rateShopADD->error_code->PrimaryErrorCode->Code)) {
                $api_error_code = trim($object_call->info_rateShopADD->error_code->PrimaryErrorCode->Code);
            }
            if (isset($object_call->info_rateShopADD->error_code) && is_array($object_call->info_rateShopADD->error_code)) {
                foreach ($object_call->info_rateShopADD->error_code as $tmp_error_api) {
                    if (in_array($tmp_error_api->PrimaryErrorCode->Code, $error_check_api)) {
                        $api_error_code = trim($tmp_error_api->PrimaryErrorCode->Code);
                        break;
                    }
                }
            }
            if (in_array($api_error_code, $error_check_api) && (2 == $package_setting_option)) {
                $arrayADDPackage = $model_fallback_rates->get_list_data_by_condition(
                    [
                    "`{$model_fallback_rates->col_service_type}` = 'ADD'"
                    ]
                );
                $list_all_service_names = $this->getAllServiceNames();
                $object_call->info_rateShopADD->check_api_response = "{$this->status_cal_api_ok}";
                $object_call->info_rateShopADD->list_services = $arrayADDPackage;
                if (count($object_call->info_rateShopADD->list_services) > 0) {
                    foreach ($object_call->info_rateShopADD->list_services as $item_service) {
                        $service_id = $item_service->service_id;
                        $item_service->service_name = (!empty($list_all_service_names[$item_service->service_id])) ? $list_all_service_names[$item_service->service_id] : '';
                        $object_call->RateTimeInTransit[$service_id] = call_user_func_array(
                            [
                                new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Ups_Shipping_API(),
                                $this->call_user_method_shopservice_package
                            ],
                            [$item_service, &$object_call, $service_id]
                        );
                    }
                }
            }
        }
    }

    public function ups_eu_woo_checkout_load($data_array = [])
    {
        $object_call = new \stdClass();
        $object_call->check_api_all = false;
        call_user_func_array(
            [
            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Ups_Shipping_API(), "ups_eu_woo_input_params_ajax"
            ],
            [
            &$object_call
            ]
        );
        
        /* ---call lactor---- */
        $object_call->info_locator = call_user_func_array(
            [
            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Ups_Shipping_API(), "ups_eu_woo_process_data_locator"
            ],
            [
            $this->ups_eu_woo_call_locator($object_call), &$object_call
            ]
        );

        if ($object_call->info_locator->check === "{$this->status_cal_api_ok}") {
            $check_ap = 1;
            $this->ups_eu_woo_check_update_type_ap($object_call, $check_ap);
            $this->ups_eu_woo_check_update_type_add($object_call, $check_ap);
        } else {
            $check_ap = 0;
            $this->ups_eu_woo_check_update_type_add($object_call, $check_ap);
        }
        
        $object_call->html = call_user_func_array(
            [
            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Ups_Shipping_API(), "ups_eu_woo_process_html"
            ],
            [
            &$object_call
            ]
        );
        return $object_call;
    }

    private function ups_eu_woo_call_locator(&$object_call, $type_search = false)
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $ap_enabled = 0;
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->DELIVERY_TO_ACCESS_POINT}") === true) {
            $ap_enabled = $model_config->value;
        }
        if ($ap_enabled == 0) {
            return false;
        }
        $api_request_entity = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Api_Request_Entity();
        $this->ups_eu_woo_load_lib_api_ups();
        $data_params = call_user_func_array(
            [
            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Ups_Shipping_API(), "ups_eu_woo_init_params_locator"
            ],
            [
            &$object_call, $type_search
            ]
        );
        $shipping_packages =  WC()->cart->get_shipping_packages();
        $shipping_zone = wc_get_shipping_zone(reset($shipping_packages));
        $get_data  = $shipping_zone->get_data();
        $array_country_codes_locator = [];
        if (!empty($get_data['zone_locations'])) {
            foreach ($get_data['zone_locations'] as $country) {
                if (!empty($country->code)) {
                    $array_country_codes_locator[] = trim($country->code);
                }
            }
        }elseif (!empty($get_data['zone_name']) && $get_data['zone_name'] == "Locations not covered by your other zones"){
            $array_country_codes_locator[] =$data_params['countryCode'];
        }

        $addressSearch = trim($data_params["fullAddress"]);
        $postcodeString = '';
        $postcodeString2 = '';
        $postcodeStringMiss = '';
        $postcodeString2Miss = '';
        $postcodeStringFull = '';
        if (!empty($addressSearch)) {
            $arrAddressSearch = explode(',', $addressSearch);
            $countString = count($arrAddressSearch) - 1;
            if ($countString > 0) {
                $postcodeStringFull = trim($arrAddressSearch[$countString]);
            }

            if (!empty($postcodeStringFull)) {
                $postcodeStringMiss = substr($postcodeStringFull, 0, -1);
                $postcodeString2Miss = substr($postcodeStringFull, 0, -2);
                $postcodeString = $postcodeStringMiss . '*';
                $postcodeString2 = $postcodeString2Miss . '*';
            }
        }
        $arrString = implode(", ", $array_country_codes_locator);
        if (in_array($postcodeString, $array_country_codes_locator) || in_array($postcodeString2, $array_country_codes_locator)
            || in_array($postcodeStringMiss, $array_country_codes_locator)
            || in_array($postcodeString2Miss, $array_country_codes_locator) || in_array($postcodeStringFull, $array_country_codes_locator)
            || (!empty($postcodeString) && strpos($arrString, $postcodeString) > -1)
            || (!empty($postcodeStringMiss) && strpos($arrString, $postcodeStringMiss) > -1)
            || (!empty($postcodeString2) && strpos($arrString, $postcodeString2) > -1)
            || (!empty($postcodeString2Miss) && strpos($arrString, $postcodeString2Miss) > -1)
            || (!empty($postcodeString2) && strpos($arrString, $postcodeString2) > -1)
        ) {
            if (!empty($data_params['countryCode'])) {
                $array_country_codes_locator[] = $data_params['countryCode'];
            }
        }

        if (in_array('ES:GC', $array_country_codes_locator) || in_array('ES:TF', $array_country_codes_locator)) {
            $array_country_codes_locator[] = 'IC';
        }
        //$all_methods  = get_class_methods($shipping_zone);
        $address_string_country = 'no country';
        if (!empty($data_params['countryCode'])) {
            $address_string_country = $data_params['countryCode'];
        }

        // Continent = luc dia
        $country = new \WC_Countries();
        $continent_code = $country->get_continent_code_for_country($address_string_country);
        $method_rate_id = 'ups_eu_shipping';
        $shipping_zones = $this->get_shipping_zone_from_method_rate_id($method_rate_id);

        if (!empty($address_string_country) && in_array($address_string_country, $array_country_codes_locator)
            || (in_array($continent_code, $shipping_zones)) || (in_array('IC', $array_country_codes_locator))
        ) {
            $data_search = new \stdClass();
            $data_search->address = $data_params["fullAddress"];
            $data_search->country_code = $data_params[$api_request_entity->countryCode];
            $data_search->locale = $data_params[$api_request_entity->Locale];
            $data_search->unit_of_measurement = $data_params[$api_request_entity->UnitOfMeasurement];
            $data_search->maximum_list_size = $data_params[$api_request_entity->MaximumListSize];
            $data_search->nearby = $data_params[$api_request_entity->nearby];

            if ($data_params[$this->check_call] === "{$this->status_cal_api_ok}") {
                $license = $this->get_license();
                /* ---Log before cal api--- */
                $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
                $model_logsApi->ups_eu_woo_before_log_api("Locator");
                /* ---End before call log api */
                $response = $this->lib_api_ups->ups_eu_woo_api_locator($data_search, $license);
                /* ---Log after call api--- */
                $this->ups_eu_woo_after_log_api($model_logsApi);
                /* ----End after call api--- */
                if ($response) {
                    $result = json_decode($response);
                } else {
                    $result = false;
                }
                return $result;
            }
        }
        return false;
    }

    /**
     * Rate ups_eu_woo_get_rate_shop type ADD, AP
     */
    private function ups_eu_woo_get_rate_shop(&$object_call, $service_type = 'AP')
    {
        $this->ups_eu_woo_load_lib_api_ups();
        $data_params = call_user_func_array(
            [
            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Ups_Shipping_API(), "ups_eu_woo_init_params_get_rate_shop"
            ],
            [
            &$object_call,
            $service_type
            ]
        );
        $shipping_packages =  WC()->cart->get_shipping_packages();
        $shipping_zone = wc_get_shipping_zone(reset($shipping_packages));
        $get_data  = $shipping_zone->get_data();
        $array_country_codes = [];
        if (!empty($get_data['zone_locations'])) {
            foreach ($get_data['zone_locations'] as $country) {
                if (!empty($country->code)) {
                    $array_country_codes[] = trim($country->code);
                }
            }
        }elseif (!empty($get_data['zone_name']) && $get_data['zone_name'] == "Locations not covered by your other zones"){
            $array_country_codes[] =$data_params->shipto->country_code;
        }
        if (!empty($data_params->shipto->post_code)) {
            $addressSearch = trim($data_params->shipto->post_code);
            $postcodeString = '';
            $postcodeString2 = '';
            $postcodeStringMiss = '';
            $postcodeString2Miss = '';
            $postcodeStringFull = $addressSearch;
            if (!empty($addressSearch)) {
                if (!empty($postcodeStringFull)) {
                    $postcodeStringMiss = substr($postcodeStringFull, 0, -1);
                    $postcodeString2Miss = substr($postcodeStringFull, 0, -2);
                    $postcodeString = $postcodeStringMiss . '*';
                    $postcodeString2 = $postcodeString2Miss . '*';
                }
            }
            $arrString = implode(", ", $array_country_codes);
            if (in_array($postcodeString, $array_country_codes) || in_array($postcodeString2, $array_country_codes)
                || in_array($postcodeStringMiss, $array_country_codes)
                || in_array($postcodeString2Miss, $array_country_codes) || in_array($postcodeStringFull, $array_country_codes)
                || (!empty($postcodeString) && strpos($arrString, $postcodeString) > -1)
                || (!empty($postcodeStringMiss) && strpos($arrString, $postcodeStringMiss) > -1)
                || (!empty($postcodeString2) && strpos($arrString, $postcodeString2) > -1)
                || (!empty($postcodeString2Miss) && strpos($arrString, $postcodeString2Miss) > -1)
                || (!empty($postcodeString2) && strpos($arrString, $postcodeString2) > -1)
            ) {
                if (!empty($data_params->shipto->country_code)) {
                    $array_country_codes[] = $data_params->shipto->country_code;
                }
            }
        }
        if (in_array('ES:GC', $array_country_codes) || in_array('ES:TF', $array_country_codes)) {
            $array_country_codes[] = 'IC';
        }

        //$all_methods  = get_class_methods($shipping_zone);
        $address_string_country = 'no country';
        if (!empty($data_params->shipto->country_code)) {
            $address_string_country = $data_params->shipto->country_code;
        }

        // Continent = luc dia
        $country = new \WC_Countries();
        $continent_code = $country->get_continent_code_for_country($address_string_country);
        $method_rate_id = 'ups_eu_shipping';
        $shipping_zones = $this->get_shipping_zone_from_method_rate_id($method_rate_id);

        if ((!empty($address_string_country) && in_array($address_string_country, $array_country_codes))
            || (in_array($continent_code, $shipping_zones)) || ('IC' == trim($address_string_country))
        ) {
            if ($data_params->{$this->check_call} === "{$this->status_cal_api_ok}") {
                $license = $this->get_license();
                /* ---Log before cal api--- */
                $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
                $model_logsApi->ups_eu_woo_before_log_api("_getRateShop{$service_type}");
                /* ---End before call log api */
                $response = $this->lib_api_ups->ups_eu_woo_api_get_rate($data_params, $license);
                /* ---Log after call api--- */
                $this->ups_eu_woo_after_log_api($model_logsApi);
                /* ----End after call api--- */
                $result = false;
                if ($response) {
                    $result = json_decode($response);
                }
                return $result;
            }
        }
        return false;
    }

    /**
     * Skip
     * Rate RATETIMEINTRANSIT
     */
    private function ups_eu_woo_rate_time_in_transit(&$object_call, $service_id)
    {
        $this->ups_eu_woo_load_lib_api_ups();
        $data_params = call_user_func_array(
            [
            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Ups_Shipping_API(), "ups_eu_woo_init_params_rate_time_in_transit"
            ],
            [
            &$object_call, $service_id
            ]
        );
        if ($data_params->{$this->check_call} === "{$this->status_cal_api_ok}") {
            $license = $this->get_license();
            /* ---Log before cal api--- */
            $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
            $model_logsApi->ups_eu_woo_before_log_api("_RateTimeInTransit-{$service_id}");
            /* ---End before call log api */
            $response = $this->lib_api_ups->ups_eu_woo_api_get_rate($data_params, $license);
            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api($model_logsApi);
            /* ----End after call api--- */
            $result = false;
            if ($response) {
                $result = json_decode($response);
            }
            return $result;
        }
        return false;
    }

    /**
     * Rate getAllServiceNames
     */
    private function getAllServiceNames()
    {
        $model_services = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Services();
        $allServiceNames = [];
        $list_all_shipping_services = $model_services->ups_eu_woo_get_all();
        if (count($list_all_shipping_services) > 0) {
            foreach ($list_all_shipping_services as $item) {
                $allServiceNames[$item->id] = $item->service_name;
            }
        }
        return $allServiceNames;
    }

    /**
     * Rate get_shipping_zone_from_method_rate_id
     */
    function get_shipping_zone_from_method_rate_id($method_rate_id)
    {
        global $wpdb;

        $method_id = $method_rate_id;

        // The first SQL query
        $zone_id = $wpdb->get_col("
            SELECT wszm.zone_id
            FROM {$wpdb->prefix}woocommerce_shipping_zone_methods as wszm
            WHERE wszm.method_id LIKE '$method_id'
        ");
        $str_zone_id = implode(", ", $zone_id);
        $location_code = $wpdb->get_col("
            SELECT wszl.location_code
            FROM {$wpdb->prefix}woocommerce_shipping_zone_locations as wszl
            WHERE wszl.zone_id IN ($str_zone_id) AND wszl.location_type = 'continent'
        ");
        return $location_code; // converting to string and returning the value
    }
}
