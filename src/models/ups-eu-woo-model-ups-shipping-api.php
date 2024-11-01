<?php namespace UpsEuWoocommerce\models;

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
 * ups-eu-woo-model-ups-shipping-api.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Model_Ups_Shipping_API Model.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Model_Ups_Shipping_API');

class Ups_Eu_Woo_Model_Ups_Shipping_API
{
    private $show_params_call_api = false;
    private $fee_shipping = '_fee_shipping';
    private $descriptions_package_default = [
        'kgs' => "kilograms",
        'lbs' => "Pounds",
        'cm' => "centimeter",
        'inch' => "inch"
    ];
    /* status call api */
    private $status_cal_api_ok = "ok";
    private $status_cal_api_no = "no";
    private $have_country = "no";
    private $replace_key = '&#xD;';
    private $min_contants_price = 100000000000000;
    private $list_country_cash_on_dilevery = ["BE", "NL", "FR", "ES", "PL", "IT", "DE", "UK", "AT", "BG", "HR", "CY", "CZ", "DK", "EE", "FI", "GR", "HU", "IE", "LV", "LT", "LU", "MT", "PT",  "RO", "SK", "SI", "SE", "IS", "JE", "TR"];

    /*
     * Name function: ups_eu_woo_input_params_ajax
     * Params:
     *  @object_call: type object
     * Return: void
     * * */

    public function ups_eu_woo_input_params_ajax(&$object_call)
    {
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $model_config = new Ups_Eu_Woo_Model_Config();
        $object_call->input_params_ajax = new \stdClass();

        $fullAddress = "";
        if (!empty($_REQUEST[$model_config->fullAddress])) {
            $fullAddress = strip_tags($_REQUEST[$model_config->fullAddress]);
        }

        $satDeliFlg = false;
        if (!empty($_REQUEST[$model_config->selectedService]) && strpos($_REQUEST[$model_config->selectedService], $model_config->satDeli) !== false) {
            $satDeliFlg = true;
        }
        $object_call->input_params_ajax->SatDeliFlg = $satDeliFlg;

        // if (!empty($_REQUEST[$model_config->billing_email])) {
        //     $object_call->input_params_ajax->billing_email = str_replace("&", "@", trim(strip_tags($_REQUEST[$model_config->billing_email])));
        // } else {
        //     $object_call->input_params_ajax->billing_email = "";
        // }

        if (!empty($_REQUEST[$model_config->billing_address_1])) {
            $object_call->input_params_ajax->billing_address_1 = trim(strip_tags($_REQUEST[$model_config->billing_address_1]));
        } else {
            $object_call->input_params_ajax->billing_address_1 = "";
        }

        if (!empty($_REQUEST[$model_config->billing_address_2])) {
            $object_call->input_params_ajax->billing_address_2 = trim(strip_tags($_REQUEST[$model_config->billing_address_2]));
        } else {
            $object_call->input_params_ajax->billing_address_2 = "";
        }

        if (!empty($_REQUEST[$model_config->billing_country])) {
            $object_call->input_params_ajax->billing_country = trim(strip_tags($_REQUEST[$model_config->billing_country]));
        } else {
            $object_call->input_params_ajax->billing_country = "";
        }

        if (!empty($_REQUEST[$model_config->billing_city])) {
            $object_call->input_params_ajax->billing_city = trim(strip_tags($_REQUEST[$model_config->billing_city]));
        } else {
            $object_call->input_params_ajax->billing_city = "";
        }

        if (!empty($_REQUEST[$model_config->billing_postcode])) {
            $object_call->input_params_ajax->billing_postcode = trim(strip_tags($_REQUEST[$model_config->billing_postcode]));
        } else {
            $object_call->input_params_ajax->billing_postcode = "";
        }

        if (!empty($_REQUEST[$model_config->billing_state])) {
            $object_call->input_params_ajax->billing_state = trim(strip_tags($_REQUEST[$model_config->billing_state]));
        } else {
            $object_call->input_params_ajax->billing_state = "";
        }

        if (!empty($_REQUEST[$model_config->get_cart_total])) {
            $object_call->input_params_ajax->get_cart_total = trim(strip_tags($_REQUEST[$model_config->get_cart_total]));
        } else {
            $object_call->input_params_ajax->get_cart_total = "";
        }

        if (!empty($_REQUEST[$model_config->get_woocommerce_currency_symbol])) {
            $object_call->input_params_ajax->get_woocommerce_currency_symbol = trim(strip_tags($_REQUEST[$model_config->get_woocommerce_currency_symbol]));
        } else {
            $object_call->input_params_ajax->get_woocommerce_currency_symbol = "";
        }

        if (!empty($_REQUEST[$model_config->get_woocommerce_currency])) {
            $object_call->input_params_ajax->get_woocommerce_currency = trim(strip_tags($_REQUEST[$model_config->get_woocommerce_currency]));
        } else {
            $object_call->input_params_ajax->get_woocommerce_currency = "";
        }

        if (!empty($_REQUEST[$model_config->ups_shipping_text_search])) {
            $object_call->input_params_ajax->ups_shipping_text_search = trim(strip_tags($_REQUEST[$model_config->ups_shipping_text_search]));
        } else {
            $object_call->input_params_ajax->ups_shipping_text_search = "";
        }

        if (!empty($_REQUEST[$model_config->ups_shipping_select_search_country])) {
            $object_call->input_params_ajax->ups_shipping_select_search_country = trim(strip_tags($_REQUEST[$model_config->ups_shipping_select_search_country]));
        } else {
            $object_call->input_params_ajax->ups_shipping_select_search_country = "";
        }

        if (!empty($_REQUEST[$model_config->MaximumListSize])) {
            $object_call->input_params_ajax->MaximumListSize = trim(strip_tags($_REQUEST[$model_config->MaximumListSize]));
        } else {
            $object_call->input_params_ajax->MaximumListSize = "";
        }

        if (empty($object_call->input_params_ajax->MaximumListSize)) {
            $object_call->input_params_ajax->MaximumListSize = 1;
        } else {
            $object_call->input_params_ajax->MaximumListSize = intval($object_call->input_params_ajax->MaximumListSize);
        }

        if ($object_call->input_params_ajax->MaximumListSize !== 1) {
            $NUMBER_OF_ACCESS_POINT_AVAIABLE = false;
            if ($model_config->ups_eu_woo_get_by_key("{$model_config->NUMBER_OF_ACCESS_POINT_AVAIABLE}") === true) {
                $NUMBER_OF_ACCESS_POINT_AVAIABLE = $model_config->value;
            }
            if (empty($NUMBER_OF_ACCESS_POINT_AVAIABLE)) {
                $NUMBER_OF_ACCESS_POINT_AVAIABLE = 5;
            }
            $object_call->input_params_ajax->MaximumListSize = $NUMBER_OF_ACCESS_POINT_AVAIABLE;
        }

        if (!empty($_REQUEST[$model_config->ups_eu_woocommerce_key])) {
            $object_call->input_params_ajax->ups_eu_woocommerce_key = trim(strip_tags($_REQUEST[$model_config->ups_eu_woocommerce_key]));
        } else {
            $object_call->input_params_ajax->ups_eu_woocommerce_key = "";
        }

        $COUNTRY_CODE = false;
        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            $COUNTRY_CODE = $model_config->value;
        }
        if ($COUNTRY_CODE === false) {
            $COUNTRY_CODE = "en_GB";
        } else {
            if ($COUNTRY_CODE == 'PL') {
                $COUNTRY_CODE = "pl_PL";
            } else {
                $COUNTRY_CODE = "en_GB";
            }
        }

        $object_call->input_params_ajax->Locale = "{$COUNTRY_CODE}";

        $object_call->input_params_ajax->UnitOfMeasurement = ($COUNTRY_CODE == 'en_US') ? 'MI' : 'KM';

        if ($model_config->ups_eu_woo_get_by_key("{$model_config->DISPLAY_ALL_ACCESS_POINT_IN_RANGE}") === true) {
            $DISPLAY_ALL_ACCESS_POINT_IN_RANGE = $model_config->value;
        } else {
            $DISPLAY_ALL_ACCESS_POINT_IN_RANGE = false;
        }
        if (! empty($DISPLAY_ALL_ACCESS_POINT_IN_RANGE)) {
            $DISPLAY_ALL_ACCESS_POINT_IN_RANGE = $DISPLAY_ALL_ACCESS_POINT_IN_RANGE;
        } else {
            $DISPLAY_ALL_ACCESS_POINT_IN_RANGE = 1;
        }
        $object_call->input_params_ajax->nearby = $DISPLAY_ALL_ACCESS_POINT_IN_RANGE;
    }
    /*
     * Name function: ups_eu_woo_init_params_locator
     * Params:
     * @object_call: type object
     * Return: type array
     * * */

    public function ups_eu_woo_init_params_locator(&$object_call, $type_search = false)
    {
        $api_request_entity = new entities\Ups_Eu_Woo_Api_Request_Entity();
        $model_config = new Ups_Eu_Woo_Model_Config();
        $data_params = [];
        $data_params[$model_config->check_call] = "{$this->status_cal_api_ok}";
        if (intval($object_call->input_params_ajax->MaximumListSize) === 5) {
            $data_params[$model_config->fullAddress] = "{$object_call->input_params_ajax->ups_shipping_text_search}";
            $data_params[$api_request_entity->countryCode] = "{$object_call->input_params_ajax->ups_shipping_select_search_country}";
        } else {
            $tmp_array = [];
            if (strlen($object_call->input_params_ajax->billing_address_1) > 0) {
                $tmp_array[] = $object_call->input_params_ajax->billing_address_1;
            }
            if (strlen($object_call->input_params_ajax->billing_address_2) > 0) {
                $tmp_array[] = $object_call->input_params_ajax->billing_address_2;
            }
            if (strlen($object_call->input_params_ajax->billing_city) > 0) {
                $tmp_array[] = $object_call->input_params_ajax->billing_city;
            }
            if (strlen($object_call->input_params_ajax->billing_state) > 0) {
                $tmp_array[] = $object_call->input_params_ajax->billing_state;
            }
            if (strlen($object_call->input_params_ajax->billing_postcode) > 0) {
                $tmp_array[] = $object_call->input_params_ajax->billing_postcode;
            }
            $strlen_search = implode(", ", $tmp_array);
            $data_params[$model_config->fullAddress] = "{$strlen_search}";
            $data_params[$api_request_entity->countryCode] = "{$object_call->input_params_ajax->billing_country}";
        }
        $data_params[$api_request_entity->Locale] = "{$object_call->input_params_ajax->Locale}";
        $data_params[$api_request_entity->UnitOfMeasurement] = "{$object_call->input_params_ajax->UnitOfMeasurement}";
        $data_params[$api_request_entity->MaximumListSize] = "{$object_call->input_params_ajax->MaximumListSize}";
        if ($object_call->input_params_ajax->MaximumListSize === 1) {
            $data_params[$api_request_entity->nearby] = "100";
        } else {
            $data_params[$api_request_entity->nearby] = "{$object_call->input_params_ajax->nearby}";
        }

        // the US: MI
        if ('US' == $data_params[$api_request_entity->countryCode]) {
            $data_params[$api_request_entity->UnitOfMeasurement] = "MI";
        }

        $this->ups_eu_woo_update_cash_on_and_saturday_delivery($data_params, $object_call, $model_config, $type_search, $api_request_entity);
        $object_call->init_params_Locator = $data_params;
        return $data_params;
    }
    /*
     * Name function: ups_eu_woo_update_cash_on_and_saturday_delivery
     * Params:
     *  @data_params: type array
     *  @result: type object
     * Return: void
     * * */

    private function ups_eu_woo_update_cash_on_and_saturday_delivery(&$data_params, $object_call, $model_config, $type_search, $api_request_entity)
    {
        if ($type_search === true) {
            $maximumListSize = intval($object_call->input_params_ajax->MaximumListSize);
            /* check the case  accept is cash on delivery  get setup */
            $ups_accept_cash_on_delivery = false;
            if ($model_config->ups_eu_woo_get_by_key($model_config->UPS_ACCEPT_CASH_ON_DELIVERY) === true) {
                $ups_accept_cash_on_delivery = $model_config->value;
            }
            $adult_signature = "0";
            if ($model_config->ups_eu_woo_get_by_key("{$model_config->ADULT_SIGNATURE}") === true) {
                $adult_signature = $model_config->value;
            }
            /* Check country code depend list  on delivery  */
            if ((1 === intval($ups_accept_cash_on_delivery) && in_array($object_call->input_params_ajax->billing_country, $this->list_country_cash_on_dilevery))
                || 1 == intval($adult_signature)) {
                $maximumListSize *= 2;
            }
            if (true === $object_call->input_params_ajax->SatDeliFlg) {
                $maximumListSize *= 2;
            }
            $data_params[$api_request_entity->MaximumListSize] = "{$maximumListSize}";
            $nearby = intval($object_call->input_params_ajax->nearby);
            $data_params[$api_request_entity->nearby] = "{$nearby}";
        }
    }
    /*
     * Name function: ups_eu_woo_update_value_array
     * Params:
     *  @result: type object
     * Return: array
     * * */

    private function ups_eu_woo_update_value_array($result)
    {
        $tmp_array = [];
        foreach ($result->list_locator as $value) {
            $LocationID = $value->LocationID;
            $value_save = $value->AddressKeyFormat;
            $value_save->PublicAccessPointID = "";
            if (!empty($value->AccessPointInformation) &&
                !empty($value->AccessPointInformation->PublicAccessPointID)) {
                $value_save->PublicAccessPointID = $value->AccessPointInformation->PublicAccessPointID;
            }
            $tmp_array[$LocationID] = $value_save;
        }
        return $tmp_array;
    }
    /*
     * Name function: ups_eu_woo_process_data_locator
     * Params:
     *  @responseObject: type object
     *  @object_call: type object
     * Return: object
     * * */

    public function ups_eu_woo_process_data_locator($responseObject, &$object_call, $type_search_locator = false)
    {
        $result = new \stdClass();
        $result->check = false;
        if (is_object($responseObject)) {
            if (!empty($responseObject->LocatorResponse->Response->ResponseStatusDescription)) {
                if ($responseObject->LocatorResponse->Response->ResponseStatusDescription === "Success") {
                    $model_LogFrontend = new Ups_Eu_Woo_Model_Log_Frontend();
                    if (is_array($responseObject->LocatorResponse->SearchResults->DropLocation)) {
                        $result->Geocode = $responseObject->LocatorResponse->SearchResults->DropLocation[0]->Geocode;
                        $result->AddressKeyFormat = $responseObject->LocatorResponse->SearchResults->DropLocation[0]->AddressKeyFormat;
                        $result->LocationID = $responseObject->LocatorResponse->SearchResults->DropLocation[0]->LocationID;
                        $result->check = "{$this->status_cal_api_ok}";
                        $result->list_locator = $responseObject->LocatorResponse->SearchResults->DropLocation;
                        /* get  tmp_array */
                        $tmp_array = $this->ups_eu_woo_update_value_array($result);
                        /* get update_data_content_by_woocommerce_key */
                        $this->ups_eu_woo_log_data_process_data_locator($tmp_array, $object_call);
                    } else {
                        $result->Geocode = $responseObject->LocatorResponse->SearchResults->DropLocation->Geocode;
                        $result->AddressKeyFormat = $responseObject->LocatorResponse->SearchResults->DropLocation->AddressKeyFormat;
                        $result->LocationID = $responseObject->LocatorResponse->SearchResults->DropLocation->LocationID;
                        $result->check = "{$this->status_cal_api_ok}";
                        $this->ups_eu_woo_check_locator_response_one_ap($type_search_locator, $result, $responseObject, $object_call);
                    }
                    $model_LogFrontend->update_data_content_by_woocommerce_key(
                        $object_call->input_params_ajax->ups_eu_woocommerce_key,
                        ["LocationID" => $result->LocationID]
                    );
                } else {
                    $object_call->api_message_error = $responseObject->LocatorResponse->Response->Error;
                }
            } else {
                $object_call->api_message_error = $responseObject->LocatorResponse->Response->Error;
            }
        }
        return $result;
    }
    /*
     * Name function: ups_eu_woo_check_locator_response_one_ap
     * Params:
     *  @tmp_array: type array
     *  @object_call: type object
     * Return: void
     * * */

    private function ups_eu_woo_check_locator_response_one_ap($type_search_locator, &$result, $responseObject, $object_call)
    {
        if ($type_search_locator == true) {
            if (is_object($responseObject->LocatorResponse->SearchResults->DropLocation)) {
                $result->list_locator[] = $responseObject->LocatorResponse->SearchResults->DropLocation;
                $tmp_array = $this->ups_eu_woo_update_value_array($result);
                /* get update_data_content_by_woocommerce_key */
                $this->ups_eu_woo_log_data_process_data_locator($tmp_array, $object_call);
            }
        }
    }
    /*
     * Name function: ups_eu_woo_log_data_process_data_locator
     * Params:
     *  @tmp_array: type array
     *  @object_call: type object
     * Return: void
     * * */

    private function ups_eu_woo_log_data_process_data_locator($tmp_array, $object_call)
    {
        if (is_array($tmp_array)) {
            $model_LogFrontend = new Ups_Eu_Woo_Model_Log_Frontend();
            $string_update = json_encode($tmp_array);
            $string_update_replace = str_replace($this->replace_key, '', $string_update);
            $model_LogFrontend->update_data_content_by_woocommerce_key(
                $object_call->input_params_ajax->ups_eu_woocommerce_key,
                ["list_locator" => base64_encode($string_update_replace)]
            );
        }
    }
    /*
     * Name function: load_params_basic
     * Params:
     *  @object_call: type object
     *  @service_type: type string
     * Return: object
     * * */

    private function ups_eu_woo_load_params_basic($object_call, $service_type)
    {
        $model_config  = new Ups_Eu_Woo_Model_Config();
        $model_package = new Ups_Eu_Woo_Model_Package_Default();
        $model_account = new Ups_Eu_Woo_Model_Account();
        $object_params = new \stdClass();
        $system_entity = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Systems_Entity();
        $object_params->check_call = "{$this->status_cal_api_ok}";
        $data_params = new \stdClass();
        if (strtoupper(trim($service_type)) === "AP") {
            if ($model_config->ups_eu_woo_get_by_key("{$model_config->DELIVERY_TO_ACCESS_POINT}") === true) {
                $DELIVERY_TO_ACCESS_POINT = $model_config->value;
            } else {
                $DELIVERY_TO_ACCESS_POINT = "";
            }

            if (intval($DELIVERY_TO_ACCESS_POINT) !== 1) {
                $object_params->check_call = "{$this->status_cal_api_no}";
                return $object_params;
            }

            if ($model_config->ups_eu_woo_get_by_key("{$model_config->CHOOSE_ACCOUNT_NUMBER_AP}") === true) {
                $CHOOSE_ACCOUNT_NUMBER_AP = $model_config->value;
            } else {
                $CHOOSE_ACCOUNT_NUMBER_AP = "";
            }

            if (intval($CHOOSE_ACCOUNT_NUMBER_AP) > 0) {
                $model_account->ups_eu_woo_get_by_id($CHOOSE_ACCOUNT_NUMBER_AP);
            } else {
                $object_params->check_call = "{$this->status_cal_api_no}";
                return $object_params;
            }

            $data_params->alternate_delivery_address = new \stdClass();
            $data_params->alternate_delivery_address->name = "{$object_call->info_locator->AddressKeyFormat->ConsigneeName}";
            $data_params->alternate_delivery_address->attention_name = " ";
            $address_line = str_replace(
                $this->replace_key,
                '',
                $object_call->info_locator->AddressKeyFormat->AddressLine
            );
            $data_params->alternate_delivery_address->address_line = "{$address_line}";
            $data_params->alternate_delivery_address->city = "{$object_call->info_locator->AddressKeyFormat->PoliticalDivision2}";

            $StateProvinceCode = "XX";
            /** list country StateProvinceCode not set XX */
            $arr_not_xx = ['CA', 'US', 'IE'];

            if (! empty($object_call->info_locator->AddressKeyFormat->PoliticalDivision1) && in_array(strtoupper($object_call->info_locator->AddressKeyFormat->CountryCode), $arr_not_xx)) {
                $StateProvinceCode = $object_call->info_locator->AddressKeyFormat->PoliticalDivision1;
            }

            $data_params->alternate_delivery_address->state_code   = "{$StateProvinceCode}";
            $data_params->alternate_delivery_address->post_code    = "{$object_call->info_locator->AddressKeyFormat->PostcodePrimaryLow}";
            $data_params->alternate_delivery_address->country_code = "{$object_call->info_locator->AddressKeyFormat->CountryCode}";

        } else {
            if ($model_config->ups_eu_woo_get_by_key("{$model_config->DELIVERY_TO_SHIPPING_ADDRESS}") === true) {
                $DELIVERY_TO_SHIPPING_ADDRESS = $model_config->value;
            } else {
                $DELIVERY_TO_SHIPPING_ADDRESS = "";
            }

            if (intval($DELIVERY_TO_SHIPPING_ADDRESS) !== 1) {
                $object_params->check_call = "{$this->status_cal_api_no}";
                return $object_params;
            }

            if ($model_config->ups_eu_woo_get_by_key("{$model_config->CHOOSE_ACCOUNT_NUMBER_ADD}") === true) {
                $CHOOSE_ACCOUNT_NUMBER_ADD = $model_config->value;
            } else {
                $CHOOSE_ACCOUNT_NUMBER_ADD = "";
            }

            if (intval($CHOOSE_ACCOUNT_NUMBER_ADD) > 0) {
                $model_account->ups_eu_woo_get_by_id($CHOOSE_ACCOUNT_NUMBER_ADD);
            } else {
                $object_params->check_call = "{$this->status_cal_api_no}";
                return $object_params;
            }
        }
        $data_params->shipper = new \stdClass();
        $data_params->shipper->name = "";
        $data_params->shipper->shipper_number = "{$model_account->ups_account_number}";
        $data_params->shipper->address_line = ["{$model_account->address_1}", "{$model_account->address_2}", "{$model_account->address_3}"];
        $data_params->shipper->city = "{$model_account->city}";
        $data_params->shipper->state_code = "{$model_account->state}";// "XX";
        $data_params->shipper->post_code = "{$model_account->postal_code}";
        $data_params->shipper->country_code = "{$model_account->country}";

        $data_params->shipfrom = new \stdClass();
        $data_params->shipfrom->name = "";
        $data_params->shipfrom->shipper_number = "{$model_account->ups_account_number}";
        $data_params->shipfrom->address_line = ["{$model_account->address_1}", "{$model_account->address_2}", "{$model_account->address_3}"];
        $data_params->shipfrom->city = "{$model_account->city}";
        $data_params->shipfrom->state_code = "{$model_account->state}"; //"XX";
        $data_params->shipfrom->post_code = "{$model_account->postal_code}";
        $data_params->shipfrom->country_code = "{$model_account->country}";

        $billing_address_1 = str_replace(
            $this->replace_key,
            '',
            "{$object_call->input_params_ajax->billing_address_1}"
        );
        $billing_address_2 = str_replace(
            $this->replace_key,
            '',
            "{$object_call->input_params_ajax->billing_address_2}"
        );

        $state_code = "XX";
        if (! empty($object_call->input_params_ajax->billing_state)) {
            $state_code = $object_call->input_params_ajax->billing_state;
        }

        $data_params->shipto = new \stdClass();
        $data_params->shipto->name = "";
        $data_params->shipto->shipper_number = "0W73E6";
        $data_params->shipto->address_line = ["{$billing_address_1}", "{$billing_address_2}", ""];
        $data_params->shipto->city = "{$object_call->input_params_ajax->billing_city}";
        $data_params->shipto->state_code = $state_code;
        $data_params->shipto->post_code = "{$object_call->input_params_ajax->billing_postcode}";
        $data_params->shipto->country_code = "{$object_call->input_params_ajax->billing_country}";
        $allowState = ['GC', 'TF'];
        if ($data_params->shipto->country_code == 'ES') {
            if (in_array($data_params->shipto->state_code, $allowState)) {
                $data_params->shipto->country_code = 'IC';
            }
        }
        $data_params->account_number = "{$model_account->ups_account_number}";

        $model_LogFrontend = new Ups_Eu_Woo_Model_Log_Frontend();
        $model_LogFrontend->update_data_content_by_woocommerce_key(
            $object_call->input_params_ajax->ups_eu_woocommerce_key,
            [$system_entity->ShipTo => base64_encode(json_encode($data_params->shipto))]
        );

        /**
         * 1) Select Package Size Based on Number of Items option: select Package by number of items at shop
         * 2) Select Product Level Rating: sum dimension of all item call API with the return value:
         *      + The weight == 0 get rate from Package (no return time)
         *      + The Weight > 0 as old prpccess
         */
        $package_default_item = false;
        $package_dimension = new \stdClass();
        $package_setting_option = 1;
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->PACKAGE_SETTING_OPTION}") === true) {
            $package_setting_option = $model_config->value;
        }

        $item_dimension = [];
        $item_dimension['setting'] = $package_setting_option;
        // case: Default package rating
        if ($package_setting_option == 1) {
            $list_package = $model_package->get_list_data_by_condition();
            $package_default_item = $this->get_package_valid($list_package);

            $item_dimension['length'] = $length_dimension = (string)$package_default_item->length;
            $item_dimension['width'] = $width_dimension = (string)$package_default_item->width;
            $item_dimension['height'] = $height_dimension = (string)$package_default_item->height;
            $item_dimension['weight'] = $weight_dimension = (string)$package_default_item->weight;


            $item_dimension['dimension_unit'] = $package_dimension->unit_dimension = $package_default_item->unit_dimension;
            $package_dimension->length = $length_dimension;
            $package_dimension->width = $width_dimension;
            $package_dimension->height = $height_dimension;
            $item_dimension['weight_unit'] = $package_dimension->unit_weight = $package_default_item->unit_weight;
            $package_dimension->weight = $weight_dimension;
            if ('KG' == $item_dimension['weight_unit']) {
                $item_dimension['weight_unit'] = 'KGS';
            }
            if ('kg' == $item_dimension['weight_unit']) {
                $item_dimension['weight_unit'] = 'kgs';
            }

            $item_dimension['include'] = -1;
            if ($package_default_item) {
                $dimension_description = "";
                if (!empty($this->descriptions_package_default["{$package_default_item->unit_dimension}"])) {
                    $dimension_description = $this->descriptions_package_default["{$package_default_item->unit_dimension}"];
                }
                $weight_description = "";
                if (!empty($this->descriptions_package_default["{$package_default_item->unit_weight}"])) {
                    $weight_description = $this->descriptions_package_default["{$package_default_item->unit_weight}"];
                }

                $package_include_dimension = 1;
                if ($model_config->ups_eu_woo_get_by_key("{$model_config->ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS}") === true) {
                    $package_include_dimension = $model_config->value;
                }
                $item_dimension['include'] = $package_include_dimension;
                // case: Default package rating
                if ($package_setting_option == 1) {
                    $package_include_dimension = 1;
                }
                $package = new \stdClass();
                if (0 != $package_include_dimension) {
                    $package->dimension = new \stdClass();
                    $package->dimension->code = strtoupper($package_default_item->unit_dimension);
                    $package->dimension->description = $dimension_description;
                    $package->dimension->length = "{$package_default_item->length}";
                    $package->dimension->width = "{$package_default_item->width}";
                    $package->dimension->height = "{$package_default_item->height}";
                }

                $package->package_weight = new \stdClass();
                $package->package_weight->code = strtoupper($package_default_item->unit_weight);
                $package->package_weight->description = $weight_description;
                $package->package_weight->weight = "{$package_default_item->weight}";

                $data_params->package[] = $package;
                \WC()->session->set('package_type', $item_dimension);
            }
        } else {
            $ups_packages = $this->ups_eu_woo_pack_cart_items();
            // echo "<pre>";print_r($ups_packages);die();
            $list_package_api_param = [];
            $order_package_type = [];
            foreach ($ups_packages as $key => $ups_pack) {
                $package_api_param = new \stdClass();
                $package_item = new \stdClass();
                if (isset($ups_pack['unit_dimension']) && isset($ups_pack['length']) && isset($ups_pack['width']) && isset($ups_pack['height'])) {
                    // Set dimension info
                    $package_api_param->dimension = new \stdClass();
                    $package_api_param->dimension->code = strtoupper($ups_pack['unit_dimension']);
                    $package_api_param->dimension->description = $this->descriptions_package_default[$ups_pack['unit_dimension']];
                    $package_api_param->dimension->length = $package_item->length = substr(sprintf('%0.4f', $ups_pack['length']), 0, 6);
                    $package_api_param->dimension->width = $package_item->width = substr(sprintf('%0.4f', $ups_pack['width']), 0, 6);
                    $package_api_param->dimension->height = $package_item->height = substr(sprintf('%0.4f', $ups_pack['height']), 0, 6);
                    $package_item->unit_dimension = $ups_pack['unit_dimension'];
                }
                // Set weight info
                $package_api_param->package_weight = new \stdClass();
                $package_api_param->package_weight->code = strtoupper($ups_pack['unit_weight']);
                $package_api_param->package_weight->description = $this->descriptions_package_default[$ups_pack['unit_weight']];
                $package_api_param->package_weight->weight = $package_item->weight = substr(sprintf('%0.4f', $ups_pack['weight']), 0, 6);
                $package_item->unit_weight = $ups_pack['unit_weight'];
                // Set package to api request param
                $list_package_api_param[] = $package_api_param;
                $order_package_type[] = $package_item;
            }
            // echo "<pre>";print_r($ups_packages);die();
            // echo "<pre>";print_r($list_package_api_param);print_r($order_package_type);die();
            
            // Set data to session for order processing
            \WC()->session->set('package_type', $order_package_type);
            $data_params->package = $list_package_api_param;
        }

        $object_params->data_params = $data_params;
        return $object_params;
    }

    /*
     * Name function: ups_eu_woo_select_package_dimension
     * Return: object
     * * */
    private function ups_eu_woo_select_package_dimension()
    {
        // Get defined package from smallest to largest
        $list_defined_package = $this->ups_eu_woo_get_defined_package_dimension();
        // Calculate package dimension from cart item info
        $cart_package = $this->ups_eu_woo_get_cart_package();
        // Get config package include dimension
        $model_config  = new Ups_Eu_Woo_Model_Config();
        $package_include_dimension = 1;
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS}") === true) {
            $package_include_dimension = intval($model_config->value);
        }
        $selected_package = new \stdClass();
        $selected_package->package_id = null;
        $selected_package->length = 0;
        $selected_package->width  = 0;
        $selected_package->height = 0;
        $selected_package->unit_dimension = trim(get_option('woocommerce_dimension_unit'));
        $selected_package->weight = 0;
        $selected_package->unit_weight = trim(get_option('woocommerce_weight_unit'));
        $selected_package->number_of_package = 1;
        if ('in' == strtolower($selected_package->unit_dimension)) {
            $selected_package->unit_dimension = 'inch';
        }
        if ('kg' == strtolower($selected_package->unit_weight)) {
            $selected_package->unit_weight = 'kgs';
        }
        if ($package_include_dimension == 0) {
            $defined_package_heaviest = new \stdClass();
            $defined_package_heaviest->weight = 0;
            foreach ($list_defined_package as $defined_package) {
                // In case weight is compatible
                if ($cart_package->weight <= $defined_package->weight) {
                    $selected_package->package_id = $defined_package->package_id;
                    $selected_package->length = $defined_package->length;
                    $selected_package->width  = $defined_package->width;
                    $selected_package->height = $defined_package->height;
                    $selected_package->weight = $cart_package->weight;
                    $selected_package->description = "Not include dimension and weight is compatible (get smallest box)";
                    return $selected_package;
                }
                // Set package heaviest
                if ($defined_package_heaviest->weight < $defined_package->weight) {
                    $defined_package_heaviest = $defined_package;
                }
            }
            // In case weight is not compatible
            if ($defined_package_heaviest->weight > 0) {
                $selected_package->package_id = $defined_package_heaviest->package_id;
                $selected_package->length = $defined_package_heaviest->length;
                $selected_package->width  = $defined_package_heaviest->width;
                $selected_package->height = $defined_package_heaviest->height;
                $selected_package->number_of_package = ceil($cart_package->weight / $defined_package_heaviest->weight);
            }
            $selected_package->weight = round($cart_package->weight / $selected_package->number_of_package, 2);
            $selected_package->description = "Include dimension and weight is not compatible (get heaviest box)";
            if (empty($list_defined_package)) {
                if ('kg' == strtolower($selected_package->unit_weight) && $cart_package->weight > 70) {
                    $selected_package->number_of_package = ceil($cart_package->weight / 70);
                    $selected_package->weight = round($cart_package->weight / $selected_package->number_of_package, 2);
                }
                if ('lbs' == strtolower($selected_package->unit_weight) && $cart_package->weight > 150) {
                    $selected_package->number_of_package = ceil($cart_package->weight / 150);
                    $selected_package->weight = round($cart_package->weight / $selected_package->number_of_package, 2);
                }
                $selected_package->description = "Not include dimension and weight is heavier then 70kgs (150 pounds)";
            }
        } else {
            $defined_package_weight_chk_flg = false;
            foreach ($list_defined_package as $defined_package) {
                if ($cart_package->weight <= $defined_package->weight) {
                    $defined_package_weight_chk_flg = true;
                    // In case weight and dimension is compatible
                    if ($cart_package->min_side <= $defined_package->min_side && $cart_package->median_side <= $defined_package->median_side
                        && $cart_package->max_side <= $defined_package->max_side && $cart_package->volume <= $defined_package->volume) {
                        $selected_package->package_id = $defined_package->package_id;
                        $selected_package->length = $defined_package->length;
                        $selected_package->width = $defined_package->width;
                        $selected_package->height = $defined_package->height;
                        $selected_package->weight = $cart_package->weight;
                        $selected_package->description = "Weight and dimension are compatible (get smallest box)";
                        return $selected_package;
                    }
                }
            }
            // In case weight is compatible, dimension is not compatible
            if ($defined_package_weight_chk_flg === true) {
                $selected_package->length = $cart_package->max_side;
                $selected_package->width = $cart_package->median_side;
                $selected_package->height = $cart_package->min_side;
                $selected_package->weight = $cart_package->weight;
                $selected_package->description = "Weight is compatible and dimension is not compatible (get custom dimension)";
                return $selected_package;
            }
            $defined_package_heaviest = 0;
            foreach ($list_defined_package as $defined_package) {
                // In case weight is not compatible, dimension is compatible
                if ($cart_package->min_side <= $defined_package->min_side && $cart_package->median_side <= $defined_package->median_side
                    && $cart_package->max_side <= $defined_package->max_side && $cart_package->volume <= $defined_package->volume) {
                    $selected_package->package_id = $defined_package->package_id;
                    $selected_package->length = $defined_package->length;
                    $selected_package->width = $defined_package->width;
                    $selected_package->height = $defined_package->height;
                    $selected_package->number_of_package = ceil($cart_package->weight / $defined_package->weight);
                    $selected_package->weight = round($cart_package->weight / $selected_package->number_of_package, 2);
                    $selected_package->description = "Weight is not compatible and dimension is compatible (get smallest box with multi package)";
                    return $selected_package;
                }
                // Set package heaviest
                if ($defined_package_heaviest < $defined_package->weight) {
                    $defined_package_heaviest = $defined_package->weight;
                }
            }
            // In case weight and dimension is not compatible
            $selected_package->package_id = 1;
            $selected_package->length = $cart_package->max_side;
            $selected_package->width = $cart_package->median_side;
            $selected_package->height = $cart_package->min_side;
            if ($defined_package_heaviest > 0) {
                $selected_package->number_of_package = ceil($cart_package->weight / $defined_package_heaviest);
            }
            $selected_package->weight = round($cart_package->weight / $selected_package->number_of_package, 2);
            $selected_package->description = "Weight and dimension are not compatible (get custom dimension with multi package which one package is compatible with heaviest box)";
            if (empty($list_defined_package)) {
                if ('kg' == strtolower($selected_package->unit_weight) && $cart_package->weight > 70) {
                    $selected_package->number_of_package = ceil($cart_package->weight / 70);
                    $selected_package->weight = round($cart_package->weight / $selected_package->number_of_package, 2);
                }
                if ('lbs' == strtolower($selected_package->unit_weight) && $cart_package->weight > 150) {
                    $selected_package->number_of_package = ceil($cart_package->weight / 150);
                    $selected_package->weight = round($cart_package->weight / $selected_package->number_of_package, 2);
                }
                $selected_package->length = $cart_package->max_side;
                $selected_package->width = $cart_package->median_side;
                $selected_package->height = $cart_package->min_side;

                $selected_package->description = "Not include dimension and weight is heavier then 70kgs (150 pounds)";
            }
        }

        return $selected_package;
    }

    /*
     * Name function: ups_eu_woo_get_defined_package_dimension
     * Return: object defined package from smallest to largest
     * * */
    private function ups_eu_woo_get_defined_package_dimension()
    {
        // Determine smallest package size to largest of user defined package
        $model_product_dimension = new Ups_Eu_Woo_Model_Product_Dimension();
        $list_product_dimension = $model_product_dimension->ups_eu_woo_get_all();
        $list_defined_package = [];
        foreach ($list_product_dimension as $product_dimension) {
            $defined_package = new \stdClass();
            $defined_package->package_id = $product_dimension->package_id;
            // Set package volume
            $defined_package->volume = $product_dimension->length * $product_dimension->width * $product_dimension->height;
            $defined_package->length  = $product_dimension->length;
            $defined_package->width  = $product_dimension->width;
            $defined_package->height  = $product_dimension->height;
            // Set package side (min, median, max)
            $product_dimension_sides = [$product_dimension->length, $product_dimension->width, $product_dimension->height];
            asort($product_dimension_sides);
            $defined_package->min_side  = $product_dimension_sides[0];
            $defined_package->median_side = $product_dimension_sides[1];
            $defined_package->max_side = $product_dimension_sides[2];
            // Set package weight
            $defined_package->weight = $product_dimension->weight;
            $list_defined_package[] = $defined_package;
        }
        // Sort ascending by package volume
        usort($list_defined_package, function ($obj1, $obj2) {
            if ($obj1->volume == $obj2->volume) {
                return 0;
            }
            return $obj1->volume < $obj2->volume ? -1 : 1;
        });
        return $list_defined_package;
    }

    /*
     * Name function: ups_eu_woo_get_cart_package
     * Return: object
     * * */
    private function ups_eu_woo_get_cart_package()
    {
        $cart_package = new \stdClass();
        $cart_package_min_side = 0;
        $cart_package_median_side = 0;
        $cart_package_max_side = 0;
        $cart_package_volume = 0;
        $cart_package_weight = 0;
        // Get product item in cart
        $cart = WC()->cart->get_cart();
        foreach ($cart as $cart_item) {
            if (!empty($cart_item['variation_id'])) {
                $product = wc_get_product($cart_item['variation_id']);
            } else {
                $product = wc_get_product($cart_item['product_id']);
            }
            $product_length = is_numeric($product->get_length()) ? $product->get_length() : 0;
            $product_width  = is_numeric($product->get_width())  ? $product->get_width()  : 0;
            $product_height = is_numeric($product->get_height()) ? $product->get_height() : 0;
            $product_weight = is_numeric($product->get_weight()) ? $product->get_weight() : 0;
            if (!empty($product)) {
                $cart_item_quantity = $cart_item['quantity'];
                $cart_item_volume = $product_length * $product_width * $product_height;
                // Get package side (min, median, max)
                $cart_item_sides = [$product_length, $product_width, $product_height];
                asort($cart_item_sides);
                $cart_item_min_side = $cart_item_sides[0];
                $cart_item_median_side = $cart_item_sides[1];
                $cart_item_max_side = $cart_item_sides[2];
                if ($cart_package_min_side < $cart_item_min_side) {
                    $cart_package_min_side = $cart_item_min_side;
                }
                if ($cart_package_median_side < $cart_item_median_side) {
                    $cart_package_median_side = $cart_item_median_side;
                }
                if ($cart_package_max_side < $cart_item_max_side) {
                    $cart_package_max_side = $cart_item_max_side;
                }
                if ($cart_item_quantity > 1) {
                    $cart_package_volume += $cart_item_quantity * $cart_item_volume;
                    $cart_package_weight += $cart_item_quantity * $product_weight;
                } else {
                    $cart_package_volume += $cart_item_volume;
                    $cart_package_weight += $product_weight;
                }
            }
        }
        $cart_package->min_side = $cart_package_min_side;
        $cart_package->median_side = $cart_package_median_side;
        $cart_package->max_side = $cart_package_max_side;
        $cart_package->volume = $cart_package_volume;
        $cart_package->weight = $cart_package_weight;

        return $cart_package;
    }

    private function ups_eu_woo_pack_cart_items()
    {
        // Get config package include dimension
        $model_config  = new Ups_Eu_Woo_Model_Config();
        $selected_pac_algo = 3;
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->UPS_PACK_ALGO}") === true) {
            $selected_pac_algo = intval($model_config->value);
        }
        if ($selected_pac_algo == 1) {
            return $this->ups_eu_woo_pack_cart_items_individually();
        }
        if ($selected_pac_algo == 2) {
            return $this->ups_eu_woo_pack_cart_items_with_weight();
        }
        if ($selected_pac_algo == 3) {
            return $this->ups_eu_woo_pack_cart_items_with_box();
        }
    }

    private function ups_eu_woo_pack_cart_items_individually()
    {
        // Get config package include dimension
        $model_config  = new Ups_Eu_Woo_Model_Config();
        $selected_pac_dim_unit = "";
        $selected_pac_weg_unit = "";
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->UPS_PACK_DIM_UNIT}") === true) {
            $selected_pac_dim_unit = $model_config->value;
        }
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->UPS_PACK_WEG_UNIT}") === true) {
            $selected_pac_weg_unit = $model_config->value;
        }

        // Get product item in cart
        $cart = WC()->cart->get_cart();
        if (empty($cart)) {
            return;
        }
        $final_out = [];
        $pack_id = 1;
        
        foreach ($cart as $cart_item) {
            if (!empty($cart_item['variation_id'])) {
                $product = wc_get_product($cart_item['variation_id']);
            } else {
                $product = wc_get_product($cart_item['product_id']);
            }
            if (!empty($product)) {
                $reformed_box_data = [];
                $reformed_box_data['length'] = (is_numeric($product->get_length()) && ($product->get_length() > 0)) ? wc_get_dimension($product->get_length(), "cm") : 0.5;
                $reformed_box_data['width'] = (is_numeric($product->get_width()) && ($product->get_width() > 0))  ? wc_get_dimension($product->get_width(), "cm") : 0.5;
                $reformed_box_data['height'] = (is_numeric($product->get_height()) && ($product->get_height() > 0)) ? wc_get_dimension($product->get_height(), "cm") : 0.5;
                $reformed_box_data['weight'] = (is_numeric($product->get_weight()) && ($product->get_weight() > 0)) ? wc_get_weight($product->get_weight(), "kg") : 0.5;
                $reformed_box_data['unit_dimension'] = $selected_pac_dim_unit;
                $reformed_box_data['unit_weight'] = $selected_pac_weg_unit;
                for ($i=0; $i < $cart_item['quantity']; $i++) {
                    $reformed_box_data['package_id'] = $pack_id;
                    $final_out[] = $reformed_box_data;
                    $pack_id++;
                }
            }
        }
        return $final_out;
    }

    private function ups_eu_woo_pack_cart_items_with_weight()
    {
        // Get config package include dimension
        $model_config  = new Ups_Eu_Woo_Model_Config();
        $pac_max_weight = 1;
        $selected_pac_weg_unit = "";
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->UPS_PACK_MAX_WEIGHT}") === true) {
            $pac_max_weight = $model_config->value;
        }
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->UPS_PACK_WEG_UNIT}") === true) {
            $selected_pac_weg_unit = $model_config->value;
        }

        // Get product item in cart
        $cart = WC()->cart->get_cart();
        if (empty($cart)) {
            return;
        }

        if ( ! class_exists( 'WeightPack' ) ) {
            include_once(dirname(__FILE__, 1) . '/weight_pack/class-hit-weight-packing.php');
        }
        $weight_pack = new pack\WeightPack('pack_descending');
        $weight_pack->set_max_weight($pac_max_weight);

        foreach ($cart as $cart_item) {
            if (!empty($cart_item['variation_id'])) {
                $product = wc_get_product($cart_item['variation_id']);
            } else {
                $product = wc_get_product($cart_item['product_id']);
            }
            if (!empty($product)) {
                $prod_data = [];
                $prod_data['product_name'] = $product->get_name();
                $prod_data['product_weight'] = (is_numeric($product->get_weight()) && $product->get_weight() > 0) ? wc_get_weight($product->get_weight(), "kg") : 0.5;
                $prod_data['product_quantity'] = $cart_item['quantity'];
                $weight_pack->add_item($prod_data['product_weight'], $prod_data, $cart_item['quantity']);
            }
        }
        $pack = $weight_pack->pack_items();
        $errors =   $pack->get_errors();
        $final_out = [];
        $pack_id = 1;
        if (!empty($errors)) {
            //do nothing
            return;
        } else {
            $boxes = $pack->get_packed_boxes();
            $unpacked_items = $pack->get_unpacked_items();
            $packages = array_merge($boxes, $unpacked_items); // merge items if unpacked are allowed
            if (!empty($packages)) {
                foreach ($packages as $pack) {
                    $reformed_box_data = [];
                    $reformed_box_data['weight'] = ( isset($pack['weight']) && is_numeric($pack['weight']) && ($pack['weight'] > 0) ) ? $pack['weight'] : 0.5;
                    $reformed_box_data['unit_weight'] = $selected_pac_weg_unit;
                    $reformed_box_data['package_id'] = $pack_id;
                    $final_out[] = $reformed_box_data;
                    $pack_id++;
                }
            }
        }
        return $final_out;
    }

    // Packing from boxpacker.io

    // private function ups_eu_woo_pack_cart_items_with_box()
    // {
    //     $packer = new InfalliblePacker();
    //     $model_product_dimension = new Ups_Eu_Woo_Model_Product_Dimension();
    //     $all_saved_boxes = $model_product_dimension->ups_eu_woo_get_all();

    //     if (empty($all_saved_boxes)) {
    //         return;
    //     }
    //     foreach ($all_saved_boxes as $box) {
    //         $packer->addBox(new TestBox($box->package_id, $box->width, $box->length, $box->height, 0, $box->width, $box->length, $box->height, $box->weight));  //ref, width, length, depth, box weight, width, length, depth, max weight capacity
    //     }
    //     // Get product item in cart
    //     $cart = WC()->cart->get_cart();
    //     if (empty($cart)) {
    //         return;
    //     }
    //     foreach ($cart as $cart_item) {
    //         if (!empty($cart_item['variation_id'])) {
    //             $product = wc_get_product($cart_item['variation_id']);
    //         } else {
    //             $product = wc_get_product($cart_item['product_id']);
    //         }
    //         if (!empty($product)) {
    //             $product_name = $product->get_name();
    //             $product_length = (is_numeric($product->get_length()) && $product->get_length() > 0) ? $product->get_length() : 1;
    //             $product_width  = (is_numeric($product->get_width()) && $product->get_width() > 0)  ? $product->get_width() : 1;
    //             $product_height = (is_numeric($product->get_height()) && $product->get_height() > 0) ? $product->get_height() : 1;
    //             $product_weight = (is_numeric($product->get_weight()) && $product->get_weight() > 0) ? $product->get_weight() : 1;
    //             $product_quantity = $cart_item['quantity'];
    //             $packer->addItem(new TestItem($product_name, $product_width, $product_length, $product_height, $product_weight, true), $product_quantity); // item, quantity
    //         }
    //     }

    //     $packedBoxes = $packer->pack();
    //     $unpackedItems = $packer->getUnpackedItems();

    //     $final_out = [];
    //     if (!empty($packedBoxes)) {
    //         foreach ($packedBoxes as $packed_box) {
    //             $box_data = $packed_box->getBox();
    //             $pack_id = $box_data->getReference();
    //             $key_on_all_box = array_search($pack_id, array_column($all_saved_boxes, 'package_id'));
    //             $reformed_box_data = [];
    //             $reformed_box_data['package_id'] = $pack_id;
    //             $reformed_box_data['length'] = $box_data->getOuterLength();
    //             $reformed_box_data['width'] = $box_data->getOuterWidth();
    //             $reformed_box_data['height'] = $box_data->getOuterDepth();
    //             $reformed_box_data['weight'] = $packed_box->getWeight();
    //             $reformed_box_data['unit_dimension'] = isset($all_saved_boxes[$key_on_all_box]) ? $all_saved_boxes[$key_on_all_box]->unit_dimension : "";
    //             $reformed_box_data['unit_weight'] = isset($all_saved_boxes[$key_on_all_box]) ? $all_saved_boxes[$key_on_all_box]->unit_weight : "";
    //             $final_out[] = $reformed_box_data;
    //         }
    //     }
    //     if (!empty($unpackedItems)) {
    //         $pack_id_unpacked = count($final_out) + 1;
    //         foreach ($unpackedItems as $unpacked_item) {
    //             $reformed_box_data = [];
    //             $reformed_box_data['package_id'] = "UnPacked_".$pack_id_unpacked;
    //             $reformed_box_data['length'] = $unpacked_item->getLength();
    //             $reformed_box_data['width'] = $unpacked_item->getWidth();
    //             $reformed_box_data['height'] = $unpacked_item->getDepth();
    //             $reformed_box_data['weight'] = $unpacked_item->getWeight();
    //             $reformed_box_data['unit_dimension'] = isset($all_saved_boxes[0]->unit_dimension) ? $all_saved_boxes[0]->unit_dimension : "cm";
    //             $reformed_box_data['unit_weight'] = isset($all_saved_boxes[0]->unit_weight) ? $all_saved_boxes[0]->unit_weight : "kgs";
    //             $final_out[] = $reformed_box_data;
    //             $pack_id_unpacked++;
    //         }
    //     }
    //     // echo "<pre>";print_r($final_out);die();
    //         return $final_out;
    // }

    private function ups_eu_woo_pack_cart_items_with_box()
    {
        $model_product_dimension = new Ups_Eu_Woo_Model_Product_Dimension();
        $all_saved_boxes = $model_product_dimension->ups_eu_woo_get_all();

        if (empty($all_saved_boxes)) {
            return;
        }
        if ( ! class_exists( 'UPS_Eu_Boxpack' ) ) {
            include_once(dirname(__FILE__, 1) . '/box_pack/class-ups-eu-box-packing.php');
        }
        $packer = new pack\UPS_Eu_Boxpack();
        foreach ($all_saved_boxes as $box) {
            $newbox = $packer->add_box( $box->length, $box->width, $box->height );
            $newbox->set_id($box->package_id);
            $newbox->set_inner_dimensions( $box->length, $box->width, $box->height );
            $newbox->set_max_weight( $box->weight );
        }
        
        // Get product item in cart
        $cart = WC()->cart->get_cart();
        if (empty($cart)) {
            return;
        }
        foreach ($cart as $cart_item) {
            if (!empty($cart_item['variation_id'])) {
                $product = wc_get_product($cart_item['variation_id']);
            } else {
                $product = wc_get_product($cart_item['product_id']);
            }
            if (!empty($product)) {
                $product_name = $product->get_name();
                $product_price = $product->get_price();
                $product_length = (is_numeric($product->get_length()) && $product->get_length() > 0) ? number_format(wc_get_dimension($product->get_length(), "cm"), 4, '.', '') : 0.5;
                $product_width  = (is_numeric($product->get_width()) && $product->get_width() > 0)  ? number_format(wc_get_dimension($product->get_width(), "cm"), 4, '.', '') : 0.5;
                $product_height = (is_numeric($product->get_height()) && $product->get_height() > 0) ? number_format(wc_get_dimension($product->get_height(), "cm"), 4, '.', '') : 0.5;
                $product_weight = (is_numeric($product->get_weight()) && $product->get_weight() > 0) ? number_format(wc_get_weight($product->get_weight(), "kg"), 4, '.', '') : 0.5;
                $product_quantity = $cart_item['quantity'];
                for ($i=0; $i < $product_quantity; $i++) {
                    // length, width, heoght, weight, price, meta data
                    $packer->add_item($product_length, $product_width, $product_height, $product_weight, $product_price, array($product_name, $product_price, $product_length, $product_width, $product_height, $product_weight));
                }
            }
        }

        $packer->pack();
        $packedBoxes = $packer->get_packages();
        // $unpackedItems = $packer->getUnpackedItems();
        $final_out = [];
        if (!empty($packedBoxes)) {
            foreach ($packedBoxes as $box_key => $box_data) {
                $reformed_box_data = [];
                $reformed_box_data['package_id'] = $box_key+1;
                $reformed_box_data['length'] = $box_data->length;
                $reformed_box_data['width'] = $box_data->width;
                $reformed_box_data['height'] = $box_data->height;
                $reformed_box_data['weight'] = $box_data->weight;
                $reformed_box_data['unit_dimension'] = ( isset($all_saved_boxes[$box_data->id]) && !empty($all_saved_boxes[$box_data->id]) ) ? $all_saved_boxes[$box_data->id]->unit_dimension : $all_saved_boxes[0]->unit_dimension;
                $reformed_box_data['unit_weight'] = ( isset($all_saved_boxes[$box_data->id]) && !empty($all_saved_boxes[$box_data->id]) ) ? $all_saved_boxes[$box_data->id]->unit_weight : $all_saved_boxes[0]->unit_weight;
                $final_out[] = $reformed_box_data;
            }
        }
        // echo "<pre>";print_r($final_out);die();
        return $final_out;
    }

    /*
     * Name function: ups_eu_woo_init_params_get_rate_shop
     * Params:
     *  @object_call: type object
     *  @service_type: type string
     * Return: object
     * * */

    public function ups_eu_woo_init_params_get_rate_shop(&$object_call, $service_type = 'AP')
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $data_params = new \stdClass();
        $data_params->{$model_config->check_call} = "{$this->status_cal_api_ok}";
        $data_params->shipping_type = "{$service_type}";
        $data_params->typerate = "createshipment";
        $data_params->request_option = "SHOPTIMEINTRANSIT";
        $data_params->pickup_date = $model_config->ups_eu_woo_get_cut_off_time();

        $load_params_basic = $this->ups_eu_woo_load_params_basic($object_call, $service_type);
        if ($load_params_basic->check_call === "{$this->status_cal_api_no}") {
            $data_params->{$model_config->check_call} = "{$this->status_cal_api_no}";
            return $data_params;
        }

        $data_params->shipper = $load_params_basic->data_params->shipper;
        $data_params->shipfrom = $load_params_basic->data_params->shipfrom;
        $data_params->shipto = $load_params_basic->data_params->shipto;
        $data_params->account_number = $load_params_basic->data_params->account_number;
        $data_params->package = $load_params_basic->data_params->package;

        if (isset($object_call->input_params_ajax->get_cart_total) &&
            isset($object_call->input_params_ajax->get_woocommerce_currency)
        ) {
            $data_params->invoice_line_total = new \stdClass();
            $data_params->invoice_line_total->currency_code = $object_call->input_params_ajax->get_woocommerce_currency;
            $data_params->invoice_line_total->monetary_value = $object_call->input_params_ajax->get_cart_total;
        }

        if ($service_type === 'AP') {
            $data_params->alternate_delivery_address = $load_params_basic->data_params->alternate_delivery_address;
        }

        $params_name = "init_params_getRateShop_{$service_type}";
        if ($this->show_params_call_api === true) {
            $object_call->{$params_name} = $data_params;
        }
        return $data_params;
    }
    /*
     * Name function: ups_eu_woo_process_data_shop_time_in_transit
     * Params:
     *  @responseObject: type object
     *  @object_call: type object
     *  @service_type: type string
     * Return: object
     * * */

    public function ups_eu_woo_process_data_shop_time_in_transit($responseObject, &$object_call, $service_type = 'AP')
    {
        $model_services = new Ups_Eu_Woo_Model_Services();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $result = new \stdClass();
        $result->check_api_response = false;
        $result->list_services = [];
        if (is_object($responseObject) && !empty($responseObject->RateResponse->Response->ResponseStatus) &&
            !empty($responseObject->RateResponse->Response->ResponseStatus->Code) &&
            intval($responseObject->RateResponse->Response->ResponseStatus->Code) === 1) {
            $list_api_services = $responseObject->RateResponse->RatedShipment;
            $model_config->ups_eu_woo_get_by_key("COUNTRY_CODE");
            $country_code = $model_config->value;

            $list_config_services = $model_services->get_list_data_by_condition(
                [
                  $model_services->col_country_code => $country_code,
                  $model_services->col_service_selected => '1',
                  $model_services->col_service_type => $service_type
                ]
            );
            foreach ($list_config_services as $item_config) {
                $config_rate_code = $item_config->rate_code;
                $countListApi = isset($list_api_services->Service) ? 1 : count($list_api_services);
                if ($countListApi < 2) {
                    $item_api = $list_api_services;
                    $api_rate_code = $item_api->Service->Code;
                    if (intval($config_rate_code) === intval($api_rate_code)) {
                        if(isset($item_api->TimeInTransit)){
                            if ((strpos($item_config->service_key, $model_config->satDeli) && intval($item_api->TimeInTransit->ServiceSummary->SaturdayDelivery) == 1)
                            || (strpos($item_config->service_key, $model_config->satDeli) === false && intval($item_api->TimeInTransit->ServiceSummary->SaturdayDelivery) == 0)) {
                                $item_api->Service->Description = $item_config->service_key;
                                $item_api->Service->ID_Local = $item_config->id;
                                $item_api->Service->service_type = $item_config->service_type;
                                $item_api->Service->service_symbol = $item_config->service_symbol;
                                $item_api->Service->get_woocommerce_currency_symbol = $object_call->input_params_ajax->get_woocommerce_currency_symbol;
                                $result->list_services[$item_api->Service->ID_Local] = $item_api;
                            }
                        }else{
                            $item_api->Service->Description = $item_config->service_key;
                            $item_api->Service->ID_Local = $item_config->id;
                            $item_api->Service->service_type = $item_config->service_type;
                            $item_api->Service->service_symbol = $item_config->service_symbol;
                            $item_api->Service->get_woocommerce_currency_symbol = $object_call->input_params_ajax->get_woocommerce_currency_symbol;
                            $result->list_services[$item_api->Service->ID_Local] = $item_api;
                        }
                    }
                } else {
                    if (isset($list_api_services)){
                        foreach ($list_api_services as &$item_api) {
                            $api_rate_code = $item_api->Service->Code;
                            if (intval($config_rate_code) === intval($api_rate_code)) {
                                if(isset($item_api->TimeInTransit)){
                                    if ((strpos($item_config->service_key, $model_config->satDeli) && intval($item_api->TimeInTransit->ServiceSummary->SaturdayDelivery) == 1)
                                    || (strpos($item_config->service_key, $model_config->satDeli) === false && intval($item_api->TimeInTransit->ServiceSummary->SaturdayDelivery) == 0)) {
                                        $item_api->Service->Description = $item_config->service_key;
                                        $item_api->Service->ID_Local = $item_config->id;
                                        $item_api->Service->service_type = $item_config->service_type;
                                        $item_api->Service->service_symbol = $item_config->service_symbol;
                                        $item_api->Service->get_woocommerce_currency_symbol = $object_call->input_params_ajax->get_woocommerce_currency_symbol;
                                        $result->list_services[$item_api->Service->ID_Local] = $item_api;
                                    }
                                }else{
                                    $item_api->Service->Description = $item_config->service_key;
                                    $item_api->Service->ID_Local = $item_config->id;
                                    $item_api->Service->service_type = $item_config->service_type;
                                    $item_api->Service->service_symbol = $item_config->service_symbol;
                                    $item_api->Service->get_woocommerce_currency_symbol = $object_call->input_params_ajax->get_woocommerce_currency_symbol;
                                    $result->list_services[$item_api->Service->ID_Local] = $item_api;
                                
                                }
                            }
                        }
                    }
                }
            }
            $result->check_api_response = "{$this->status_cal_api_ok}";
        } else {
            $result->error_code = isset($responseObject->Fault->detail->Errors->ErrorDetail) ? $responseObject->Fault->detail->Errors->ErrorDetail : '';
        }
        return $result;
    }
    /*
     * Name function: ups_eu_woo_process_data_shop_service
     * Params:
     *  @responseObject: type object
     *  @object_call: type object
     *  @service_type: type string
     * Return: object
     * * */

    public function ups_eu_woo_process_data_shop_service($data, &$object_call, $service_id)
    {
        $result = new \stdClass();
        $result->check = false;
        $result->custom = new \stdClass();
        $result->custom->time_in_transit = '';
        $result->custom->CurrencyCode = '';
        $result->custom->monetary_value = '';
        if ((!empty($data))&& (isset($data))) {
            /* processing update rate and time */
            if(isset($data->TimeInTransit)){
                $TimeInTransit = $data->TimeInTransit;
                $to = '';
                $arrival_date = $TimeInTransit->ServiceSummary->EstimatedArrival->Arrival->Date ?? 'N/A';
                $arrival_time = $TimeInTransit->ServiceSummary->EstimatedArrival->Arrival->Time ?? 'N/A';
                $arrival_dates = date('d F Y', strtotime(substr($arrival_date, 0, 4) . '-' .
                        substr($arrival_date, 4, 2) . '-' . substr($arrival_date, 6, 2)));
                $arrival_dates_format = date_i18n(wc_date_format(), strtotime(substr($arrival_date, 0, 4) . '-' .
                        substr($arrival_date, 4, 2) . '-' . substr($arrival_date, 6, 2)));

                $arrival_times = substr($arrival_time, 0, 2) . ':' . substr($arrival_time, 2, 2);
                $day = $this->ups_eu_woo_convert_date(date('Y-m-d', strtotime($arrival_dates)));
                $list_get_date = $this->ups_eu_woo_get_date();
                if (empty($list_get_date[$this->ups_eu_woo_get_number_key_of_date_by_week($day)])) {
                    $date_translate = $day;
                } else {
                    $date_translate = $list_get_date[$this->ups_eu_woo_get_number_key_of_date_by_week($day)];
                }
                $to = $arrival_times . ' ' . $day . ' ' . $arrival_dates;
                if ($arrival_times === '23:30') {
                    $to = __("Delivered by End of Business Day", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) . ', ' .
                        $date_translate . ', ' . $arrival_dates_format;
                    $to = $this->convertTranslateMonth($to);
                } else {
                    $date_format_time_arrival = date_i18n(get_option('time_format'), strtotime("{$arrival_times}"));
                    $to = __("Delivered by", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) . ' ' .
                        $date_format_time_arrival . ', ' . $date_translate . ', ' . $arrival_dates_format;
                    $to = $this->convertTranslateMonth($to);
                }
            }else{
                $to = __("N/A", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
            }
            //Change currency
            //$all_plugins = apply_filters('active_plugins', get_option('active_plugins'));
            //$check_plugin_currency = array_search('woo-currency/wcu.php', $all_plugins,false); //$check_plugin_currency
            $options = get_option('wcu_options');
            if (!empty($options['options']['convert_checkout'])) {
                $to_currency = get_woocommerce_currency();
                $convert_cerrency_api = $this->ups_eu_woo_get_currency_transfer($data->TotalCharges->CurrencyCode, $to_currency, $data->TotalCharges->MonetaryValue);
                $result->custom->CurrencyCode = $convert_cerrency_api['main_currency'];
                $result->custom->monetary_value = $convert_cerrency_api['total_convert'];
            } else {
                $result->custom->CurrencyCode = $data->TotalCharges->CurrencyCode;
                $result->custom->monetary_value = $data->TotalCharges->MonetaryValue;
            }

            if (isset($data->NegotiatedRateCharges->TotalCharge->MonetaryValue)) {
                $result->custom->CurrencyCode = $data->NegotiatedRateCharges->TotalCharge->CurrencyCode;
                $result->custom->monetary_value = $data->NegotiatedRateCharges->TotalCharge->MonetaryValue;
            }
            
            if($result->custom->monetary_value <= 0){
                return;
             }
            //echo"<pre>";print_r($result->custom->monetary_value);die();
            //Apply ItemizedCharges
            // if (isset($data->ItemizedCharges)) {
            //     $ItemizedCharges = $data->ItemizedCharges;
            //     if (is_array($ItemizedCharges) && count($ItemizedCharges) > 1) {
            //         foreach ($ItemizedCharges as $ItemizedCharge) {
            //             $result->custom->monetary_value += $ItemizedCharge->MonetaryValue;
            //         }
            //     } else {
            //         $result->custom->monetary_value += $ItemizedCharges->MonetaryValue;
            //     }
            // }

            $result->custom->service_id = $service_id;
           
            $result->custom->monetary_value = call_user_func_array(
                [
                new Ups_Eu_Woo_Model_Services(), "ups_eu_woo_get_price_service"
                ],
                [
                $service_id,
                $result->custom->monetary_value,
                $object_call->input_params_ajax->get_cart_total,
                $result->custom->CurrencyCode,
                $object_call->input_params_ajax->get_woocommerce_currency,
                get_woocommerce_currency()
                ]
            );
           
            $result->custom->time_in_transit = $to;
            $result->custom->monetary_value_fomart = '';
            if (class_exists('WOOCS') AND $result->custom->monetary_value) {
                global $WOOCS;
                $result->custom->monetary_value_fomart = wc_price($WOOCS->woocs_exchange_value($result->custom->monetary_value));
            }else{
                $result->custom->monetary_value_fomart = wc_price($result->custom->monetary_value);
            }
            $result->check = "{$this->status_cal_api_ok}";
           
        }
        return $result;
    }


    /*
     * Name function: ups_eu_woo_process_data_shop_service
     * Params:
     *  @responseObject: type object
     *  @object_call: type object
     *  @service_type: type string
     * Return: object
     * * */

    public function ups_eu_woo_process_data_shop_service_package($data, &$object_call, $service_id)
    {
        $result = new \stdClass();
        $result->check = false;
        $result->custom = new \stdClass();
        $result->custom->service_id = $data->service_id;
        $result->custom->service_name = $data->service_name;
        $result->custom->time_in_transit = $data->service_type;
        $result->custom->monetary_value = $data->fallback_rate;
        $result->custom->monetary_value_fomart = wc_price($data->fallback_rate);
        $result->check = "{$this->status_cal_api_ok}";
        return $result;
    }

    /*
     * Name function: ups_eu_woo_get_currency_transfer
     * Params:
     *  @object_call: type object
     *  @service_type: type string
     * Return: object
     * * */
    public function ups_eu_woo_get_currency_transfer($from_currency, $to_currency, $monetary_value)
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $main_currency = $to_currency;
        if ($model_config->ups_eu_woo_get_by_key('MAIN_CURRENCY') === true) {
            $main_currency = $model_config->value;
            //Convert To main currency code
            $model_currency = new Ups_Eu_Woo_Currency(new Ups_Eu_Woo_Model_Config());
            $total_convert = $model_currency->ups_eu_woo_convert_currency(
                $from_currency,
                $main_currency,
                $monetary_value
            );
        } else {
            $total_convert = $monetary_value;
        }
        $array = [];
        $array['total_convert'] = $total_convert;
        $array['main_currency'] = $main_currency;
        return $array;
    }
    /*
     * Name function: ups_eu_woo_init_params_rate_time_in_transit
     * Params:
     *  @object_call: type object
     *  @service_type: type string
     * Return: object
     * * */

    public function ups_eu_woo_init_params_rate_time_in_transit(&$object_call, $service_id = 0)
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $model_services = new Ups_Eu_Woo_Model_Services();
        $model_services->ups_eu_woo_get_by_id($service_id);
        $data_params = new \stdClass();
        $data_params->{$model_config->check_call} = "{$this->status_cal_api_ok}";
        /* Rate API Data RATETIMEINTRANSIT */
        $data_params->shipping_type = "{$model_services->service_type}";
        $data_params->typerate = "createshipment";
        $data_params->request_option = "RATETIMEINTRANSIT";
        $data_params->pickup_date = $model_config->ups_eu_woo_get_cut_off_time();

        $load_params_basic = $this->ups_eu_woo_load_params_basic($object_call, $model_services->service_type);
        if ($load_params_basic->check_call === "{$this->status_cal_api_no}") {
            $data_params->{$model_config->check_call} = "{$this->status_cal_api_no}";
            return $data_params;
        }
        $data_params->shipper = $load_params_basic->data_params->shipper;
        $data_params->shipfrom = $load_params_basic->data_params->shipfrom;
        $data_params->shipto = $load_params_basic->data_params->shipto;
        $data_params->account_number = $load_params_basic->data_params->account_number;
        $data_params->package = $load_params_basic->data_params->package;
        if (strtoupper(trim($data_params->shipping_type)) === 'AP') {
            $data_params->alternate_delivery_address = $load_params_basic->data_params->alternate_delivery_address;
        }

        $data_params->service = new \stdClass();
        $data_params->service->code = "{$model_services->rate_code}";
        $data_params->service->description = "{$model_services->service_name}";

        $data_params->invoice_line_total = new \stdClass();
        $data_params->invoice_line_total->currency_code = "{$object_call->input_params_ajax->get_woocommerce_currency}";
        $data_params->invoice_line_total->monetary_value = "{$object_call->input_params_ajax->get_cart_total}";

        $params_name = "init_params_RateTimeInTransit_{$service_id}";
        if ($this->show_params_call_api === true) {
            $object_call->{$params_name} = $data_params;
        }
        return $data_params;
    }
    /*
     * Name function: ups_eu_woo_process_data_rate_time_in_transit
     * Params:
     *  @responseObject: type object
     *  @object_call: type object
     *  @service_type: type string
     * Return: object
     * * */

    public function ups_eu_woo_process_data_rate_time_in_transit($responseObject, &$object_call, $service_id)
    {
        $result = new \stdClass();
        $result->check = false;
        $result->custom = new \stdClass();
        $result->custom->time_in_transit = '';
        $result->custom->CurrencyCode = '';
        $result->custom->monetary_value = '';

        if (is_object($responseObject) && !empty($responseObject->RateResponse->Response->ResponseStatus) &&
            intval($responseObject->RateResponse->Response->ResponseStatus->Code) === 1) {
            /* processing update  rate and time */
            if(isset($result->RatedShipment->TimeInTransit)){
                $result->RatedShipment = $responseObject->RateResponse->RatedShipment;
                $TimeInTransit = $result->RatedShipment->TimeInTransit;
                $arrival_date = $TimeInTransit->ServiceSummary->EstimatedArrival->Arrival->Date;
                $arrival_time = $TimeInTransit->ServiceSummary->EstimatedArrival->Arrival->Time;
                $arrival_dates = date('d F Y', strtotime(substr($arrival_date, 0, 4) . '-' .
                        substr($arrival_date, 4, 2) . '-' . substr($arrival_date, 6, 2)));
                $arrival_dates_format = date_i18n(wc_date_format(), strtotime(substr($arrival_date, 0, 4) . '-' .
                        substr($arrival_date, 4, 2) . '-' . substr($arrival_date, 6, 2)));

                $arrival_times = substr($arrival_time, 0, 2) . ':' . substr($arrival_time, 2, 2);
                $day = $this->ups_eu_woo_convert_date(date('Y-m-d', strtotime($arrival_dates)));
                $list_get_date = $this->ups_eu_woo_get_date();
                if (empty($list_get_date[$this->ups_eu_woo_get_number_key_of_date_by_week($day)])) {
                    $date_translate = $day;
                } else {
                    $date_translate = $list_get_date[$this->ups_eu_woo_get_number_key_of_date_by_week($day)];
                }

                $to = $arrival_times . ' ' . $day . ' ' . $arrival_dates;
                if ($arrival_times === '23:30') {
                    $to = __("Delivered by End of Business Day", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) . ', ' .
                        $date_translate . ', ' . $arrival_dates_format;
                    $to = $this->convertTranslateMonth($to);
                } else {
                    $date_format_time_arrival = date_i18n(get_option('time_format'), strtotime("{$arrival_times}"));
                    $to = __("Delivered by", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) . ' ' .
                        $date_format_time_arrival . ', ' . $date_translate . ', ' . $arrival_dates_format;
                    $to = $this->convertTranslateMonth($to);
                }
            }else{
                $to = __("N/A", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
            }
            $result->custom->CurrencyCode = $result->RatedShipment->TotalCharges->CurrencyCode;

            $result->custom->monetary_value = $result->RatedShipment->TotalCharges->MonetaryValue;

            if (isset($result->RatedShipment->NegotiatedRateCharges->TotalCharge->MonetaryValue)) {
                $result->custom->CurrencyCode = $result->RatedShipment->NegotiatedRateCharges->TotalCharge->CurrencyCode;
                $result->custom->monetary_value = $result->RatedShipment->NegotiatedRateCharges->TotalCharge->MonetaryValue;
            }
           
            //Apply ItemizedCharges
            // if (isset($data->ItemizedCharges)) {
            //     $ItemizedCharges = $data->ItemizedCharges;
            //     if (count($ItemizedCharges) > 1) {
            //         foreach ($ItemizedCharges as $ItemizedCharge) {
            //             $result->custom->monetary_value += $ItemizedCharge->MonetaryValue;
            //         }
            //     } else {
            //         $result->custom->monetary_value += $ItemizedCharges->MonetaryValue;
            //     }
            // }

            $result->custom->service_id = $service_id;

            $result->custom->monetary_value = call_user_func_array(
                [
                new Ups_Eu_Woo_Model_Services(), "ups_eu_woo_get_price_service"
                ],
                [
                $service_id,
                $result->custom->monetary_value,
                $object_call->input_params_ajax->get_cart_total,
                $result->custom->CurrencyCode,
                $object_call->input_params_ajax->get_woocommerce_currency,
                get_woocommerce_currency()
                ]
            );
            $result->custom->time_in_transit = $to;
            $result->custom->monetary_value_fomart = number_format((float)$result->custom->monetary_value, 2);
            $result->check = "{$this->status_cal_api_ok}";
        }
        return $result;
    }
    /*
     * Name function: ups_eu_woo_convert_date
     * Params:
     *  @data: type string
     * Return: type string
     * * */

    private function ups_eu_woo_convert_date($date)
    {
        $datetime = date('d', strtotime($date));
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        $thoigian = mktime(0, 0, 0, $month, $datetime, $year);
        return strtolower(date("l", $thoigian));
    }
    /*
     * Name function: ups_eu_woo_process_html
     * Params:
     *  @object_call: type object
     * Return: type object
     * * */

    public function ups_eu_woo_process_html(&$object_call)
    {
        $error_check_api = ['110548','111030','111031','111035','111036','111050','111055','111056','111057','111546','111547','111548','112117','112118','112119','112120','9110054','9110055','9110056','9110057', '9110023'];
        $html_object = new \stdClass();
        $model_LogFrontend = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Log_Frontend();
        $model_service = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Services();
        $model_config = new Ups_Eu_Woo_Model_Config();

        $model_LogFrontend->update_data_content_by_woocommerce_key(
            $object_call->input_params_ajax->ups_eu_woocommerce_key,
            ["RateTimeInTransit" => !empty($object_call->RateTimeInTransit) ? base64_encode(json_encode($object_call->RateTimeInTransit)) : '']
        );
        $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
        $dataObject = new \stdClass();
        $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key($model_LogFrontend->lang_page_checkout);
        $dataObject->data = $object_call;
        $dataObject->get_woocommerce_currency = get_woocommerce_currency();
        $object_call->min_total_price_service = $this->ups_eu_woo_min_total_price_service($object_call);

        $package_setting_option = 1;
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->PACKAGE_SETTING_OPTION}") === true) {
            $package_setting_option = $model_config->value;
        }
        $package_setting_option *= 1;
        $api_error_code = "000";
        if (!empty($object_call->info_rateShopADD->error_code->PrimaryErrorCode->Code)) {
            $api_error_code = trim($object_call->info_rateShopADD->error_code->PrimaryErrorCode->Code);
        }
        if (!empty($object_call->info_rateShopADD->error_code) && is_array($object_call->info_rateShopADD->error_code)) {
            foreach ($object_call->info_rateShopADD->error_code as $tmp_error_api) {
                if (in_array($tmp_error_api->PrimaryErrorCode->Code, $error_check_api)) {
                    $api_error_code = trim($tmp_error_api->PrimaryErrorCode->Code);
                    break;
                }
            }
        }

        if ((!empty($dataObject->data->info_rateShopADD)) && ($dataObject->data->info_rateShopADD->list_services) && (count($dataObject->data->info_rateShopADD->list_services) > 0) && in_array($api_error_code, $error_check_api) && (2 == $package_setting_option)) {
            $packageAddObject = $this->get_min_price_package_rate();
            $dataObject->data->min_total_price_service->id_service = $packageAddObject->id_service;
            $object_call->min_total_price_service->min_price_total = $packageAddObject->min_price_total;
            $model_LogFrontend->update_data_content_by_woocommerce_key(
                $object_call->input_params_ajax->ups_eu_woocommerce_key,
                [$model_service->service_id => $packageAddObject->id_service]
            );
        }

        $dataObject->CUT_OFF_TIME = "";
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->CUT_OFF_TIME}") === true) {
            $dataObject->CUT_OFF_TIME = $model_config->value;
        }
        $addNumber = -1;
        if (!empty($dataObject->data->info_rateShopADD->list_services) && !empty($dataObject->data->info_rateShopADD->list_services[0]) && !empty($dataObject->data->info_rateShopADD->list_services[0]->fallback_rate)) {
            $addNumber = 1*$dataObject->data->info_rateShopADD->list_services[0]->fallback_rate;
        }
        if (empty($dataObject->data->RateTimeInTransit)){
            return;
        }
        $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
        if (($addNumber > -1) && (2 == $package_setting_option) && in_array($api_error_code, $error_check_api) && (isset($dataObject->data->info_rateShopADD->list_services[0]))) {
            $html_object->html_AP = '';
            $html_object->html_ADD = $smarty->fetch("front/component/list_add_package.tpl");
        } else {
            $html_object->html_AP = $smarty->fetch("front/component/list_ap.tpl");
            $html_object->html_ADD = $smarty->fetch("front/component/list_add.tpl");
        }
        $object_call->check_api_all = true;
        return $html_object;
    }
    /*
     * Name function: ups_eu_woo_day_of_week_by_locator_item
     * Params:
     *  @item: type object
     * Return: type object
     * * */

    private function ups_eu_woo_day_of_week_by_locator_item($item)
    {
        $tmp_array = [];
        $language_day = $this->ups_eu_woo_get_date();
        $day_of_week = $item->OperatingHours->StandardHours->DayOfWeek;
        foreach ($day_of_week as $hitem) {
            $object_item = new \stdClass();
            $day = $hitem->Day;
            $object_item->date_name = "";
            if (!empty($language_day["day_{$day}"])) {
                $object_item->date_name = $language_day["day_{$day}"];
            }
            $closed_indicator = '';
            $type = "normal";
            $list_array_open_hours = [];
            $list_array_close_hours = [];
            if (isset($hitem->ClosedIndicator)) {
                $closed_indicator = $hitem->ClosedIndicator;
            }
            $show_open_hours = '';
            if (isset($hitem->OpenHours)) {
                $open_hours = $hitem->OpenHours;
                if (is_array($open_hours)) {
                    $type = "array";
                    foreach ($open_hours as $key => $open_hours_item) {
                        if (strlen($open_hours_item) == 3) {
                            $open_hours_item = '0' . $open_hours_item;
                        }
                        $list_array_open_hours[$key] = substr($open_hours_item, 0, 2) . ':' .
                            substr($open_hours_item, 2, 2);
                    }
                } else {
                    if (strlen($open_hours) == 3) {
                        $open_hours = '0' . $open_hours;
                    }
                    $show_open_hours = substr($open_hours, 0, 2) . ':' . substr($open_hours, 2, 2);
                }
            }
            $show_close_hours = '';
            if (isset($hitem->CloseHours)) {
                $close_hours = $hitem->CloseHours;
                if (is_array($close_hours)) {
                    foreach ($close_hours as $key => $close_hours_item) {
                        if (strlen($close_hours_item) == 3) {
                            $close_hours_item = '0' . $close_hours_item;
                        }
                        $list_array_close_hours[$key] = substr($close_hours_item, 0, 2) . ':' .
                            substr($close_hours_item, 2, 2);
                    }
                } else {
                    if (strlen($close_hours) == 3) {
                        $close_hours = '0' . $close_hours;
                    }
                    $show_close_hours = substr($close_hours, 0, 2) . ':' . substr($close_hours, 2, 2);
                }
            }
            if (isset($hitem->Open24HoursIndicator)) {
                $type = "Open24HoursIndicator";
            }

            $object_item->ClosedIndicator = $closed_indicator;
            $object_item->show_open_hours = $show_open_hours;
            $object_item->show_close_hours = $show_close_hours;
            $object_item->type = $type;
            $object_item->title_open24h = __("Open 24 hours", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);

            $object_item->list_array_open_hours = $list_array_open_hours;
            $object_item->list_array_close_hours = $list_array_close_hours;

            $tmp_array[$day] = $object_item;
        }
        return $tmp_array;
    }
    /*
     * Name function: day_of_week_by_locator
     * Params:
     *  @list_locator: type array
     * Return: type array object
     * * */

    private function ups_eu_woo_day_of_week_by_locator($list_locator)
    {
        $tmp_array_locator = [];
        if (count($list_locator) > 0) {
            foreach ($list_locator as $item) {
                $LocationID = "";
                if (!empty($item->LocationID)) {
                    $LocationID = $item->LocationID;
                }
                $tmp_array_locator["{$LocationID}"] = $this->ups_eu_woo_day_of_week_by_locator_item($item);
            }
        }
        return $tmp_array_locator;
    }
    /*
     * Name function: ups_eu_woo_process_html_search_locator
     * Params:
     *  @object_call: type object
     * Return: type object
     * * */

    public function ups_eu_woo_process_html_search_locator(&$object_call)
    {
        $html_object = new \stdClass();
        $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
        $dataObject = new \stdClass();
        $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
            $UpsEuWoocommerceSmarty->lang_page_checkout
        );
        $dataObject->data = $object_call;
        if (isset($object_call->info_locator->list_locator)) {
            $dataObject->day_of_week_by_locator = $this->ups_eu_woo_day_of_week_by_locator(
                $object_call->info_locator->list_locator
            );
        }
        $this->ups_eu_woo_build_view_update_cash_on_and_sat_delivery($dataObject);
        $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
        $html_object->html_bing_map = $smarty->fetch("front/component/list_bing_map.tpl");
        $object_call->check_api_all = true;
        return $html_object;
    }
    /*
     * Name function: ups_eu_woo_build_view_update_cash_on_and_sat_delivery
     * Params:
     *  @object_call: type object
     * Return: type object
     * * */

    private function ups_eu_woo_build_view_update_cash_on_and_sat_delivery(&$dataObject)
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $ups_accept_cash_on_delivery = false;
        if ($model_config->ups_eu_woo_get_by_key($model_config->UPS_ACCEPT_CASH_ON_DELIVERY) === true) {
            $ups_accept_cash_on_delivery = $model_config->value;
        }
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->ADULT_SIGNATURE}") === true) {
            $adult_signature = $model_config->value;
        } else {
            $adult_signature = "0";
        }
        $number_of_access_point_avaiable = 5;
        if ($model_config->ups_eu_woo_get_by_key($model_config->NUMBER_OF_ACCESS_POINT_AVAIABLE) === true) {
            $number_of_access_point_avaiable = $model_config->value;
        }
        $tmp_list_locator = [];
        foreach ($dataObject->data->info_locator->list_locator as $locator) {
            if (1 == intval($ups_accept_cash_on_delivery)) {
                if (in_array($dataObject->data->input_params_ajax->billing_country, $this->list_country_cash_on_dilevery)) {
                    $ServiceOffering = $locator->ServiceOfferingList->ServiceOffering;
                    if ($this->ups_eu_woo_check_code_cash_dilevery_001_011($ServiceOffering) === false) {
                        continue;
                    }
                }
            }
            if (1 == intval($adult_signature)) {
                $ServiceOffering = $locator->ServiceOfferingList->ServiceOffering;
                if ($this->ups_eu_woo_check_code_cash_dilevery_001_013($ServiceOffering) === false) {
                    continue;
                }
            }
            // Get operating hours in day of week
            $openCloseHoursInWeek = $locator->OperatingHours->StandardHours->DayOfWeek;
            $satDeliCloseFlg = false;
            if (true === $dataObject->data->input_params_ajax->SatDeliFlg) {
                foreach ($openCloseHoursInWeek as $openCloseHoursInDay) {
                    // Check saturday delivery is close
                    if ('7' == $openCloseHoursInDay->Day && property_exists($openCloseHoursInDay, 'ClosedIndicator')) {
                        $satDeliCloseFlg = true;
                        break;
                    }
                }
            }
            if (true === $satDeliCloseFlg) {
                continue;
            }
            $tmp_list_locator[] = $locator;
            if (count($tmp_list_locator) >= $number_of_access_point_avaiable) {
                break;
            }
        }
        $dataObject->data->info_locator->list_locator = $tmp_list_locator;
    }
    /*
     * Name function: ups_eu_woo_check_code_cash_dilevery_001_011
     * Params:
     *  @object_call: type object
     * Return: type object
     * * */

    private function ups_eu_woo_check_code_cash_dilevery_001_011($list_ServiceOffering)
    {
        $tmp = [];
        foreach ($list_ServiceOffering as $item) {
            $tmp[] = "{$item->Code}";
        }
        $code_001 = "001";
        $code_011 = "011";
        if (in_array($code_001, $tmp) && in_array($code_011, $tmp)) {
            return true;
        }
        return false;
    }

    /*
     * Name function: ups_eu_woo_check_code_cash_dilevery_001_013
     * Params:
     *  @object_call: type object
     * Return: type object
     * * */

    private function ups_eu_woo_check_code_cash_dilevery_001_013($list_ServiceOffering)
    {
        $tmp = [];
        foreach ($list_ServiceOffering as $item) {
            $tmp[] = "{$item->Code}";
        }
        $code_001 = "001";
        $code_013 = "013";
        if (in_array($code_001, $tmp) && in_array($code_013, $tmp)) {
            return true;
        }
        return false;
    }
    /*
     * Name function: ups_eu_woo_get_min_price_in_list
     * Params:
     *  @list_service: type array object
     *  @object_min_service: type object
     *  @list_price: type array
     *  @object_call: type object
     * Return: void
     * * */

    private function ups_eu_woo_get_min_price_in_list($list_service, &$object_min_service, &$list_price, $object_call)
    {
        if (count($list_service) > 0) {
            foreach ($list_service as $item_service) {
                $info_service = isset($item_service->Service) ? $item_service->Service : "";
                $ID_Local = isset($info_service->ID_Local) ? $info_service->ID_Local : "";
                if (intval($ID_Local) > 0) {
                    $total_price_by_service = $this->ups_eu_woo_get_total_price_by_service_id($ID_Local, $object_call);
                    if ($total_price_by_service !== false) {
                        $total_price_by_service = floatval($total_price_by_service);
                        if ($object_min_service->min_price_total > $total_price_by_service) {
                            $object_min_service->min_price_total = $total_price_by_service;
                            $object_min_service->id_service = $ID_Local;
                            $object_min_service->service_type = $info_service->service_type;
                            $object_min_service->data = $info_service;
                        }
                    }
                }
            }
        }
    }
    /*
     * Name function: min_total_price_service
     * Params:
     *  @object_call: type object
     * Return: type object
     * * */

    private function ups_eu_woo_min_total_price_service($object_call)
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $object_min_service = new \stdClass();
        $object_min_service->min_price_total = $this->min_contants_price;
        $object_min_service->id_service = 0;
        $object_min_service->service_type = '';
        $object_min_service->data = new \stdClass();
        $list_price = [];

        /* get country code */
        $country_code = "";
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->COUNTRY_CODE}") === true) {
            $country_code = $model_config->value;
        }

        $DELIVERY_TO_ACCESS_POINT = "";
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->DELIVERY_TO_ACCESS_POINT}") === true) {
            $DELIVERY_TO_ACCESS_POINT = $model_config->value;
        }
        $DELIVERY_TO_SHIPPING_ADDRESS = "";
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->DELIVERY_TO_SHIPPING_ADDRESS}") === true) {
            $DELIVERY_TO_SHIPPING_ADDRESS = $model_config->value;
        }
        $SET_DEFAULT = "";
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->SET_DEFAULT}") === true) {
            $SET_DEFAULT = $model_config->value;
        }

        $list_services_AP = [];
        $list_services_ADD = [];
        if ((!empty($object_call->info_rateShopAP) ) && ($object_call->info_rateShopAP->check_api_response === "{$this->status_cal_api_ok}" ) && (count($object_call->info_rateShopAP->list_services) > 0)) {
            $list_services_AP = $object_call->info_rateShopAP->list_services;
        }
        if ((!empty($object_call->info_rateShopADD) ) && ($object_call->info_rateShopADD->check_api_response === "{$this->status_cal_api_ok}" ) && (count($object_call->info_rateShopADD->list_services) > 0)) {
            $list_services_ADD = $object_call->info_rateShopADD->list_services;
        }
        /* the case  type ADD, AP dont existing */
        if ((count($list_services_AP) <= 0) && (count($list_services_ADD) <= 0)) {
            return $object_min_service;
        }
        /* the case  type ADD existing */
        if (count($list_services_AP) <= 0) {
            $this->ups_eu_woo_get_min_price_in_list($list_services_ADD, $object_min_service, $list_price, $object_call);
            return $object_min_service;
        }
        /* the case  type AP existing */
        if (count($list_services_ADD) <= 0) {
            $this->ups_eu_woo_get_min_price_in_list($list_services_AP, $object_min_service, $list_price, $object_call);
            return $object_min_service;
        }
        /* the case type AP,ADD existing */
        if (intval($SET_DEFAULT) === 1) {
            $this->ups_eu_woo_get_min_price_in_list($list_services_AP, $object_min_service, $list_price, $object_call);
            return $object_min_service;
        } else {
            if (strtolower($country_code) == 'us') {
                $this->ups_eu_woo_get_min_price_in_list($list_services_ADD, $object_min_service, $list_price, $object_call);
            } else {
                //$this->ups_eu_woo_get_min_price_in_list($list_services_AP, $object_min_service, $list_price, $object_call);
                $this->ups_eu_woo_get_min_price_in_list($list_services_ADD, $object_min_service, $list_price, $object_call);
            }
            return $object_min_service;
        }
        return $object_min_service;
    }
    /*
     * Name function: ups_eu_woo_get_total_price_by_service_id
     * Params:
     *  @service_id: type int
     *  @object_call: type object
     * Return: type object or false
     * * */

    private function ups_eu_woo_get_total_price_by_service_id($service_id, $object_call)
    {
        if (isset($object_call->RateTimeInTransit) && isset($object_call->RateTimeInTransit[$service_id])) {
            $info_rate_time = $object_call->RateTimeInTransit[$service_id];
            if ($info_rate_time->check === "{$this->status_cal_api_ok}") {
                return $info_rate_time->custom->monetary_value;
            }
        }
        return false;
    }
    /*
     * Name function: ups_eu_woo_get_date
     * Params: empty
     * Return: type array
     * * */

    public function ups_eu_woo_get_date()
    {
        $arr_day = [];
        $arr_day['day_2'] = __('Monday', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        $arr_day['day_3'] = __('Tuesday', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        $arr_day['day_4'] = __('Wednesday', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        $arr_day['day_5'] = __('Thursday', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        $arr_day['day_6'] = __('Friday', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        $arr_day['day_7'] = __('Saturday', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        $arr_day['day_1'] = __('Sunday', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        return $arr_day;
    }
    /*
     * Name function: ups_eu_woo_get_number_key_of_date_by_week
     * Params:
     *  @str_date:  type string
     * Return: type string
     * * */

    public function ups_eu_woo_get_number_key_of_date_by_week($str_date)
    {
        $days = [
            'Monday' => "day_2",
            'Tuesday' => "day_3",
            'Wednesday' => "day_4",
            'Thursday' => "day_5",
            'Friday' => "day_6",
            'Saturday' => "day_7",
            'Sunday' => "day_1"
        ];
        $result = "";
        if (!empty($days[ucfirst(trim($str_date))])) {
            $result = $days[ucfirst(trim($str_date))];
        }
        return $result;
    }
    /*
     * Name function: ups_eu_woo_get_number_key_of_date_by_week
     * Params:
     *  @str_date:  type string
     * Return: type string
     * * */

    public function ups_eu_woo_init_params_open_account($data)
    {
        $model_config = new Ups_Eu_Woo_Model_Config();

        $model_license = new Ups_Eu_Woo_Model_License();
        $license_data = $model_license->ups_eu_woo_get_licence_config();
        $username = $license_data->Username;
        /* get address_line_1 */
        $address = $data->address_1;
        /* get address_line_2 */
        if ($data->address_2 != '') {
            $address = $address . ', ' . $data->address_2;
        }
        /* get address_line_3 */
        if ($data->address_3 != '') {
            $address = $address . ', ' . $data->address_3;
        }
        $data->street_address = $address;

        $language_code = get_locale();

        $country_code = "GB";
        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            $country_code = $model_config->value;
        }

        $key_code_lang = substr($language_code, 0, 2) . "_" . $country_code;

        $data->language_code = $this->ups_eu_woo_language_code_for_country($key_code_lang);

        $data->username = $username;
        $data->country_code = $country_code;

        return $data;
    }

    private function ups_eu_woo_language_code_for_country($language_code)
    {
        $object = new \stdClass();
        $object->availableCode = ['en_AT', 'de_AT', 'en_BE', 'nl_BE', 'fr_BE', 'en_CZ', 'cs_CZ', 'en_DK', 'da_DK',
            'en_FI', 'fi_FI', 'en_FR', 'fr_FR', 'en_DE', 'de_DE', 'en_GR', 'el_GR', 'en_HU', 'hu_HU', 'en_IE', 'en_IT', 'it_IT',
            'en_LU', 'fr_LU', 'en_NL', 'nl_NL', 'en_NO', 'no_NO', 'en_PL', 'pl_PL', 'en_PT', 'pt_PT', 'en_RU', 'ru_RU', 'en_SI',
            'en_ES', 'es_ES', 'en_SE', 'sv_SE', 'en_CH', 'fr_CH', 'de_CH', 'en_GB', 'en_US', 'en_RS'];

        if (in_array($language_code, $object->availableCode)) {
            return $language_code;
        } else {
            $language_code = 'en_GB';
            return $language_code;
        }
    }

    /**
     * translate month
     */
    public function convertTranslateMonth($text)
    {
        $monthArr = [
            'January' => __('January', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'February' => __('February', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'March' => __('March', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'April' => __('April', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'May' => __('May', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'June' => __('June', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'July' => __('July', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'August' => __('August', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'September' => __('September', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'October' => __('October', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'November' => __('November', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'December' => __('December', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        ];
        foreach ($monthArr as $key => $value) {
            $text = str_replace($key, $value, $text);
        }
        return $text;
    }

    public function get_package_valid($list_package)
    {
        // number of items
        $number_item = 1*\WC()->cart->get_cart_contents_count();
        $package_list = $this->get_package_by_item($list_package);
        ksort($package_list);
        $select_item = 0;
        foreach ($package_list as $key => $item) {
            if ($key > $number_item) {
                break;
            } else {
                $select_item = $key;
            }
        }
        if (0 == $select_item) {
            return $list_package[0];
        } else {
            return $package_list[$select_item];
        }
    }

    public function get_package_by_item($list_package)
    {
        $package_list = [];
        foreach ($list_package as $item) {
            $key = 1*$item->package_item;
            $package_list[$key] = $item;
        }
        return $package_list;
    }

    private function get_min_price_package_rate()
    {
        $model_fallback_rates = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Fallback_Rates();

        $object_min_service = new \stdClass();
        $object_min_service->min_price_total = 0;
        $object_min_service->id_service = 0;
        $all_package_services = $model_fallback_rates->ups_eu_woo_get_all();
        if (count($all_package_services) > 0) {
            $object_min_service->min_price_total = $all_package_services[0]->fallback_rate;
            $object_min_service->id_service = $all_package_services[0]->service_id;
            foreach ($all_package_services as $item) {
                if ($item->fallback_rate < $object_min_service->min_price_total) {
                    $object_min_service->min_price_total = $item->fallback_rate;
                    $object_min_service->id_service = $item->service_id;
                }
            }
        }
        return $object_min_service;
    }
}
