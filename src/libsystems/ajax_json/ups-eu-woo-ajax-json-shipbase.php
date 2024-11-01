<?php namespace UpsEuWoocommerce\libsystems\ajax_json;

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
 * ups-eu-woo-ajax-json-shipbase.php - The core plugin class.
 *
 * This is used to define some methods to handle the Shipment.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_ShipBase_Ajax_Json');

class Ups_Eu_Woo_ShipBase_Ajax_Json extends Ups_Eu_Woo_Global_Ajax_Json
{
    /*
     * Name function: __construct
     * Params:
     *  @domain: type string
     * Return: type void
     * * */

    public function __construct()
    {
        /* call parent construct */
        parent::__construct();
    }

    protected function ups_eu_woo_get_order_detail($order_id)
    {
        $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
        $conditions = ["order_id_magento IN ({$order_id})"];
        $order = $model_orders->ups_eu_woo_pagination_list_data('create_shipment', [
            $model_orders->var_conditions => $conditions
        ]);
        return $order;
    }

    protected function ups_eu_woo_format_shipto_data($ship_to, $order_selected, $check_edit, $shipping_type)
    {
    
        $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
        $shipto_format = [];
        if ($shipping_type['0'] == 'ADD' && $check_edit == 1) {
            $shipto_format[] = $ship_to[0];
            $shipto_format[] = $ship_to[0];
            $shipto_format[] = $ship_to[2];
            $shipto_format[] = $ship_to[3];
            $shipto_format[] = $ship_to[4];
            $shipto_format[] = $ship_to[5];
            $shipto_format[] = $ship_to[6];
            $shipto_format[] = $ship_to[1];
            if(!empty($ship_to[7])){
                $shipto_format[] = implode("", explode(" ", $ship_to[7]));
            }else{
                $shipto_format[] = "000";
            }
            $shipto_format[] = $ship_to[8];
            $shipto_format[] = $ship_to[9];
        } else {
            $name = $order_selected[$model_orders->woo_shipping][$model_orders->first_name] . ' ' .
                $order_selected[$model_orders->woo_shipping][$model_orders->last_name];
            $shipto_format[] = substr($name, 0, 35);
            $shipto_format[] = substr($name, 0, 35);
            $shipto_format[] = $order_selected[$model_orders->phone];
            $shipto_format[] = $order_selected[$model_orders->woo_shipping][$model_orders->var_address_1];
            $shipto_format[] = $order_selected[$model_orders->woo_shipping][$model_orders->var_address_2];
            $shipto_format[] = '';
            $shipto_format[] = $order_selected[$model_orders->woo_shipping][$model_orders->city];
            $shipto_format[] = $order_selected[$model_orders->woo_shipping][$model_orders->state];
            if(!empty( $order_selected[$model_orders->woo_shipping][$model_orders->postcode])){
                $shipto_format[] = implode(
                    "",
                    explode(" ", $order_selected[$model_orders->woo_shipping][$model_orders->postcode])
                );
            }else{
                $shipto_format[] = "000";
            }
            $shipto_format[] = $order_selected[$model_orders->woo_shipping][$model_orders->country];
            $shipto_format[] = $order_selected[$model_orders->email];
        }
        return $shipto_format;
    }

    protected function ups_eu_woo_validate_package($list_package)
    {
        $model_package = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Package_Default();
        $package_validated = [];
        $list_validate = [];
        $type = "package";
        $pattern = "/^\d*\.?\d*$/";
        if (!empty($list_package) && is_array($list_package)) {
            foreach ($list_package as $key => $value) {
                if (is_array($value)) {
                    $check_weight = $this->ups_eu_woo_check_value($value[$model_package->col_weight], $pattern, $type);
                    $check_length = $this->ups_eu_woo_check_value($value[$model_package->col_length], $pattern, $type);
                    $check_width = $this->ups_eu_woo_check_value($value[$model_package->col_width], $pattern, $type);
                    $check_height = $this->ups_eu_woo_check_value($value[$model_package->col_height], $pattern, $type);
                    $package_validated[$key] = (object) [
                            'package-weight' => $check_weight,
                            'package-length' => $check_length,
                            'package-width' => $check_width,
                            'package-height' => $check_height
                    ];
                    if ($check_weight && $check_length && $check_width && $check_height) {
                        array_push($list_validate, true);
                    } else {
                        array_push($list_validate, false);
                    }
                } else {
                    array_push($list_validate, true);
                }
            }
        }
        if (in_array(false, $list_validate)) {
            return [false, $package_validated];
        } else {
            return [true, ''];
        }
    }

    protected function ups_eu_woo_validate_edit_shipment($check_edit, $ship_to, $shipping_type)
    {
        $system_entity = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Systems_Entity();
        $validate_edit = true;
        $edit_validated = [];
        $error_message = [];
        $type = "edit";
        if ($check_edit == 1 && !empty($ship_to)) {
            if ($shipping_type[0] == "ADD") {
                $check_name = $this->ups_eu_woo_check_value(
                    $ship_to[0],
                    $system_entity->match_all,
                    $type,
                    __('The name is not empty', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain)
                );
                $check_address = $this->ups_eu_woo_check_value(
                    $ship_to[3],
                    $system_entity->match_all,
                    $type,
                    __('The address is required', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain)
                );
                $check_postcode = $this->ups_eu_woo_check_value(
                    $ship_to[7],
                    $system_entity->match_all,
                    $type,
                    __('The postal code is empty or invalid', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain)
                );
                $check_city = $this->ups_eu_woo_check_value(
                    $ship_to[6],
                    $system_entity->match_all,
                    $type,
                    __('The city is not empty', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain)
                );
                $check_phone = $this->ups_eu_woo_check_value(
                    $ship_to[2],
                    $system_entity->match_all,
                    $type,
                    __('The phone is not empty', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain)
                );
                $check_email = $this->ups_eu_woo_check_value(
                    $ship_to[9],
                    '/^[\S]+\@[\S]+\.[\S]{2,3}$/',
                    $type,
                    __('The email is not empty', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain)
                );
                $edit_validated = [
                    $check_name[0],
                    $check_address[0],
                    $check_postcode[0],
                    $check_city[0],
                    $check_phone[0],
                    $check_email[0]
                ];
                if (in_array(false, $edit_validated)) {
                    $validate_edit = false;
                    $error_message = [
                        $check_name[1],
                        $check_address[1],
                        $check_postcode[1],
                        $check_city[1],
                        $check_phone[1],
                        $check_email[1]
                    ];
                }
            }
        }
        return [$validate_edit, $error_message, (object) $edit_validated];
    }

    private function ups_eu_woo_check_value($data, $pattern, $type, $error_message = '')
    {
        $data = trim($data);
        switch ($type) {
            case 'package':
                $check = false;
                if (0 == $data) {
                    return true;
                }
                if (!empty($data)) {
                    if (preg_match($pattern, $data)) {
                        $check_data = 1*$data;
                        if ($check_data >= 0 && $check_data < 10000) {
                            $check = true;
                        }
                    }
                }
                return $check;
            case 'edit':
                $check = false;
                $message = '';
                if (empty($data)) {
                    $message = $error_message;
                } else {
                    if (!preg_match($pattern, $data)) {
                        $message = $error_message;
                    } else {
                        $check = true;
                        $message = '';
                    }
                }
                return [$check, $message];
            default:
                break;
        }
    }

    protected function ups_eu_woo_get_list_account()
    {
        $model_account = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Account();
        $model_option = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Options();
        $list_account = $model_account->ups_eu_woo_get_all();
        if (!empty($list_account)) {
            foreach ($list_account as $key => $value) {
                $account_name = '';
                if ($value->account_default == 1) {
                    if (!empty($value->fullname)) {
                        $account_name = $value->fullname;
                    }
                } else {
                    if (!empty($value->ups_account_name)) {
                        $account_name = $value->ups_account_name;
                    }
                }
                $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
                $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
                $dataObject = new \stdClass();
                $dataObject->address_1 = $value->address_1;
                $dataObject->address_2 = $value->address_2;
                $dataObject->address_3 = $value->address_3;
                $dataObject->city = $value->city;
                $dataObject->account_name = $account_name;
                $dataObject->country = $model_option->get_country_name($value->country);
                $dataObject->phone_number = $value->phone_number;
                $stateCountry = $value->state;
                $postCodeCountry = $value->postal_code;
                if (!empty($stateCountry) && $stateCountry != 'XX') {
                    $stateName = $model_option->get_state_name($value->country, $value->state);
                    $postCodeCountry = $stateName . ', ' . $value->postal_code;
                }
                $dataObject->postal_code = $postCodeCountry;
                $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
                $list_account[$key]->account_info = $smarty->fetch(
                    "admin/merchant_cf/orders/component/info_account.tpl"
                );
            }
        }
        return $list_account;
    }

    private function ups_eu_woo_update_accessorial($accessorial_service, &$data, $shipping_type, $cod)
    {
        $data->accessorial = [];
        if ($accessorial_service) {
            foreach ($accessorial_service as $key => $value) {
                $data->accessorial[$key] = [];
            }
        }

        if ($cod == 1) {
            if (isset($data->alternate_delivery_address)) {
                $data->alternate_delivery_address->cod = '1';
            }
            if ($shipping_type['0'] == 'AP') {
                $data->accessorial["UPS_ACSRL_ACCESS_POINT_COD"] = [];
            } else {
                $data->accessorial["UPS_ACSRL_TO_HOME_COD"] = [];
            }
        }
    }

    private function ups_eu_woo_update_data_shipment(&$data, $shipping_type, $ship_to, $accessorial_service, $cod, $package, &$package_api)
    {
        $system_entity = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Systems_Entity();
        $model_package = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Package_Default();

        if ($shipping_type['0'] == 'AP') {
            if ($shipping_type['0'] == 'AP') {
                $address_line = str_replace('&#xD', ' ', $ship_to[3]);

                $data->alternate_delivery_address = new \stdClass();
                $data->alternate_delivery_address->name = str_replace($system_entity->amp_key, '&', $ship_to[0]);
                $data->alternate_delivery_address->attention_name = str_replace($system_entity->amp_key, '&', $ship_to[0]);
                $data->alternate_delivery_address->address_line = substr($address_line, 0, 35);
                $data->alternate_delivery_address->city = $ship_to[6];
                $data->alternate_delivery_address->state_code = $ship_to[1];

                $arr_not_xx = ['CA', 'US', 'IE'];

                if (!in_array(strtoupper($ship_to[8]), $arr_not_xx)) {
                    $data->alternate_delivery_address->state_code = "XX";
                }

                $data->alternate_delivery_address->post_code = implode("", explode(" ", $ship_to[7]));
                $data->alternate_delivery_address->country_code = $ship_to[8];
            }
        }

        $this->ups_eu_woo_update_accessorial($accessorial_service, $data, $shipping_type, $cod);

        $package_api = [];
        $descriptions = [
            'kgs' => "kilograms",
            'lbs' => "Pounds",
            'cm' => "centimeter",
            'inch' => "inch"
        ];
        foreach ($package as $value) {
            $package_info = new \stdClass();
            $package_info->package_weight = new \stdClass();
            $package_info->package_weight->code = isset($value->weight_unit) ? strtoupper($value->weight_unit) : strtoupper($value->unit_weight);
            $package_info->package_weight->description = isset($value->weight_unit) ? $descriptions[$value->weight_unit] : $descriptions[$value->unit_weight];
            $package_info->package_weight->weight = $value->weight;

            if (isset($value->length) && isset($value->width) && isset($value->height)) {
                $package_info->dimension = new \stdClass();
                $package_info->dimension->code = isset($value->dimension_unit) ? strtoupper($value->dimension_unit) : strtoupper($value->unit_dimension);
                $package_info->dimension->description = isset($value->dimension_unit) ? $descriptions[$value->dimension_unit] : $descriptions[$value->unit_dimension];
                $package_info->dimension->length = $value->length;
                $package_info->dimension->width = $value->width;
                $package_info->dimension->height = $value->height;
            }
            $package_api[] = $package_info;
        }

        $data->package = $package_api;
    }

    private function ups_eu_woo_update_after_response($list_order, $package_api, $shipment_results, $shipment_number)
    {
        $model_package = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Package_Default();
        $package_plugin_manager = [];
        foreach ($list_order as $value) {
            foreach ($package_api as $key1 => $value1) {
                if (isset($shipment_results->PackageResults->TrackingNumber)) {
                    $tracking_number = $shipment_results->PackageResults->TrackingNumber;
                } else {
                    $tracking_number = $shipment_results->PackageResults[$key1]->TrackingNumber;
                }
                $value1->dimension =  new \stdClass();
                if (strtolower($value1->dimension->code) === 'cm') {
                    $value1->dimension->{$model_package->col_unit_dimension} = 'cm';
                } else {
                    $value1->dimension->{$model_package->col_unit_dimension} = 'inch';
                }
                if (strtolower($value1->package_weight->code) == 'kgs') {
                    $value1->package_weight->{$model_package->col_unit_weight} = 'Kg';
                } else {
                    $value1->package_weight->{$model_package->col_unit_weight} = 'Pounds';
                }
                $detail_package = $value1->dimension->{$model_package->col_length} . 'x' .
                    $value1->dimension->{$model_package->col_width} . 'x' .
                    $value1->dimension->{$model_package->col_height} . ' ' .
                    $value1->dimension->{$model_package->col_unit_dimension} . ', ' .
                    $value1->package_weight->{$model_package->col_weight} .
                    $value1->package_weight->{$model_package->col_unit_weight};

                //save tracking to ups tracking.
                $model_tracking = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Tracking();
                $model_tracking->tracking_number = $tracking_number;
                $model_tracking->shipment_number = $shipment_number;
                $model_tracking->status = 1;
                $model_tracking->order_id = $value;
                $model_tracking->package_detail = $detail_package;
                $model_tracking->ups_eu_woo_save();

                $package_api[$key1]->tracking_number = $tracking_number;
                $package_plugin_manager[] = (object) $package_api[$key1];
            }
        }
        //check duplicate
        $package_plugin_manager = array_unique($package_plugin_manager, SORT_REGULAR);
        return $package_plugin_manager;
    }

    protected function ups_eu_woo_exec_create_shipment($data)
    {
    
        $model_order = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
        $upsapi_shipment = new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Shipments_Api_Ups();
        $system_entity = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Systems_Entity();

        $check = false;
        $message = "";

        $ship_from = $data[$model_order->ship_from];
        $ship_to = $data[$model_order->ship_to];
        $shipping_type = $data[$model_order->shipping_type];
        $accessorial_service = '';
        if (!empty($data[$model_order->col_accessorial_service])) {
            $accessorial_service = $data[$model_order->col_accessorial_service];
        }
        $package = $data[$model_order->package];
        $check_edit = $data[$model_order->edit_shipment];
        $order_selected = $data[$model_order->order_selected];
        $list_order = $data[$model_order->idorder];

        $cod = $data[$model_order->col_cod];
        $order_value = (double) filter_var(
            $data[$model_order->order_value],
            FILTER_SANITIZE_NUMBER_FLOAT,
            FILTER_FLAG_ALLOW_FRACTION
        );

        /**
         * shipto:
         * 0: ap_name,
         * 1: state,
         * 2: phone,
         * 3: ap_address1,
         * 4: ap_address2,
         * 5: ap_address3,
         * 6: ap_city,
         * 7: ap_postcode,
         * 8: ap_country,
         * 9: email
         */
        $shipto_format = $this->ups_eu_woo_format_shipto_data($ship_to, $order_selected, $check_edit, $shipping_type);
        $state = 'XX';
        if (!empty($ship_from[10])) {
            $state = $ship_from[10];
        }
        
        $company_name = '';
        if(isset($list_order[0])){
        	$order = wc_get_order( $list_order[0] );
            $company_name  = $order->get_shipping_company();
		}
        
        $model_account = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Account();
        $account_default = $model_account->ups_eu_woo_get_default_account();
        $email_address = $account_default['email'];

        $data = new \stdClass();
        $data->shipping_type = $shipping_type[0];
        $data->currency_code = $order_selected[$system_entity->currency_code];
        $data->monetary_value = $order_value;

        $data->shipper = new \stdClass();
        $data->shipper->name = $ship_from[0];
        $data->shipper->attention_name = $ship_from[1];
        $data->shipper->shipper_number = $ship_from[2];
        $data->shipper->phone_number = $ship_from[3];
        $data->shipper->address_line = [$ship_from[4], $ship_from[5], $ship_from[6]];
        $data->shipper->city = $ship_from[7];
        $data->shipper->state_code = $state;
        $data->shipper->post_code = implode("", explode(" ", $ship_from[8]));
        $data->shipper->country_code = $ship_from[9];
        $data->shipper->email = $email_address;

        $data->shipto = new \stdClass();
        $data->shipto->name = $shipto_format[0];
        $data->shipto->attention_name = (($company_name != '') ? $company_name : $shipto_format[0]);
        $data->shipto->phone_number = $shipto_format[2];
        $data->shipto->address_line = [$shipto_format[3], $shipto_format[4], $shipto_format[5]];
        $data->shipto->city = $shipto_format[6];
        $data->shipto->state_code = $shipto_format[7];
        $data->shipto->post_code = $shipto_format[8];
        $data->shipto->country_code = $shipto_format[9];
        $data->shipto->email = $shipto_format[10];

        $data->shipfrom = new \stdClass();
        $data->shipfrom->name = $ship_from[0];
        $data->shipfrom->attention_name = $ship_from[1];
        $data->shipfrom->phone_number = $ship_from[3];
        $data->shipfrom->address_line = [$ship_from[4], $ship_from[5], $ship_from[6]];
        $data->shipfrom->city = $ship_from[7];
        $data->shipfrom->state_code = $state;
        $data->shipfrom->post_code = implode("", explode(" ", $ship_from[8]));
        $data->shipfrom->country_code = $ship_from[9];

        $data->ShipmentRatingOptions = new \stdClass();
        $data->ShipmentRatingOptions->NegotiatedRatesIndicator = "";

        $data->account_number = $ship_from[2];

        $data->service = new \stdClass();
        $data->service->code = $shipping_type[1];
        $data->service->description = $shipping_type[3];

        $data->invoice_line_total = new \stdClass();
        $data->invoice_line_total->currency_code = $order_selected[$system_entity->currency_code];
        $data->invoice_line_total->monetary_value = $order_value;

        $this->ups_eu_woo_update_data_shipment($data, $shipping_type, $ship_to, $accessorial_service, $cod, $package, $package_api);
        //call api get tracking, shipment number
        $response = json_decode($upsapi_shipment->ups_eu_woo_call_api_create_shipment($data));
        $package_plugin_manager = [];

        if (isset($response->ShipmentResponse->Response->ResponseStatus->Code) &&
            $response->ShipmentResponse->Response->ResponseStatus->Code == 1) {
            $shipment_results = $response->ShipmentResponse->ShipmentResults;

            $shipping_fee = $shipment_results->ShipmentCharges->TotalCharges->MonetaryValue;

            if (isset($shipment_results->NegotiatedRateCharges->TotalCharge->MonetaryValue)) {
                $shipping_fee = $shipment_results->NegotiatedRateCharges->TotalCharge->MonetaryValue;
            }

            $shipment_number = $shipment_results->ShipmentIdentificationNumber;
            $accessorial = '';
            if ($accessorial_service) {
                $accessorial = json_encode($accessorial_service);
            }
            $package_plugin_manager = $this->ups_eu_woo_update_after_response($list_order, $package_api, $shipment_results, $shipment_number);
            //insert shipment to
            $model_shipment = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Shipments();
            $model_shipment->shipment_number = $shipment_number;
            $model_shipment->status = 'Status not available';
            $model_shipment->create_date = date('Y-m-d H:i:s', current_time('timestamp', 0));
            $model_shipment->cod = $cod;
            $model_shipment->shipping_fee = $shipping_fee;
            $model_shipment->order_value = $order_value;
            $model_shipment->accessorial_service = $accessorial;
            $model_shipment->shipping_service = $shipping_type[2];
            $model_shipment->name = $ship_to[0];
            $model_shipment->address1 = $ship_to[3];
            $model_shipment->address2 = $ship_to[4];
            $model_shipment->address3 = $ship_to[5];
            $model_shipment->state = $ship_to[1];
            $postal_code = str_replace(['amp;', '&lt;', '&gt;'], ['', '<', '>'], $ship_to[7]);
            $model_shipment->postcode = preg_replace('/[^A-Za-z0-9]/', '', $postal_code);
            $model_shipment->city = $ship_to[6];
            $model_shipment->country = $ship_to[8];
            $model_shipment->phone = preg_replace('/\D/', '', $ship_to[2]);
            $model_shipment->email = $ship_to[9];
            if (strtolower($shipping_type['0']) == 'ap') {
                $model_shipment->access_point_id = $order_selected["access_point_id"];
                $model_shipment->order_selected = $order_selected["order_id_magento"];
            }
            $model_shipment->ups_eu_woo_save();
            $shipment_id = $model_shipment->id;

            //update status order ups
            $order_id_update = implode(',', $list_order);
            $update_condition = 'order_id_magento IN (' . $order_id_update . ')';
            $model_order->ups_eu_woo_update_all([
                'shipment_id' => $shipment_id,
                'status' => 2,
                'date_update' => date('Y-m-d H:i:s', current_time('timestamp', 0))
                ], [$update_condition]);

            //update status woocommerce
            // foreach ($list_order as $items) {
            //     $model_order->ups_eu_woo_update_status_woo($items, 'on-hold');
            // }
            $check = true;
            $message = "";
            call_user_func_array(
                [
                new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Retry_Api(), "ups_eu_woo_transfer_shipments"
                ],
                [
                $model_shipment,
                $ship_from,
                $shipping_type,
                $accessorial_service,
                $list_order,
                $package_plugin_manager
                ]
            );
        } else {
            $check = false;
            if (!empty($response)) {
                $message = $response->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description;
            }
        }
        return [$check, $message];
    }
}