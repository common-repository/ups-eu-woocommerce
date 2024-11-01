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
 * ups-eu-woo-ajax-json-shipestimated.php - The core plugin class.
 *
 * This is used to define some methods to handle the Estimated Shipment.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_ShipEstimated_Ajax_Json');

class Ups_Eu_Woo_ShipEstimated_Ajax_Json extends Ups_Eu_Woo_ShipBase_Ajax_Json
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

    public function ups_eu_woo_config_estimated_shipping_fee()
    {
        //load neccessary model
        $upsapi_shipment = new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Shipments_Api_Ups();
        $model_package = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Package_Default();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
        $system_entity = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Systems_Entity();
        $check = true;
        $message = "";
        $result_data = [];

        $data_post = $_REQUEST;
        $package = $data_post[$model_orders->package];
        foreach ($package as $key => $package_item) {
            if (!is_array($package_item)) {
                $package[$key] = json_decode(stripcslashes($package_item));
            } else {
                $package[$key] = (object) $package_item;
            }
        }
        $validate_package = $this->ups_eu_woo_validate_package($package);
        $check_edit = $data_post[$model_orders->edit_shipment];
        $ship_to = $data_post[$model_orders->ship_to];
        
        $shipping_type = $data_post[$model_orders->shipping_type];
        $validate_edit = $this->ups_eu_woo_validate_edit_shipment($check_edit, $ship_to, $shipping_type);
        $error_message = $validate_edit[1];

        if ($validate_package[0] && $validate_edit[0]) {
            $ship_from = $data_post[$model_orders->ship_from];
            $accessorial_service = '';
            if (!empty($data_post[$model_orders->col_accessorial_service])) {
                $accessorial_service = $data_post[$model_orders->col_accessorial_service];
            }
            $order_selected = $data_post[$model_orders->order_selected];
            $list_order = $data_post[$model_orders->idorder];
            $cod = $data_post[$model_orders->col_cod];
            $order_value = (double) filter_var(
                $data_post[$model_orders->order_value],
                FILTER_SANITIZE_NUMBER_FLOAT,
                FILTER_FLAG_ALLOW_FRACTION
            );
            $pickup_date = $model_config->ups_eu_woo_get_cut_off_time();
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

            $data = new \stdClass();
            $data->shipping_type = $shipping_type[0];
            $data->typerate = "createshipment";
            $data->request_option = 'RATETIMEINTRANSIT';

            $data->pickup_date = $pickup_date;

            $data->shipper = new \stdClass();
            $data->shipper->name = $ship_from[0];
            $data->shipper->shipper_number = $ship_from[2];
            $data->shipper->address_line = [$ship_from[4], $ship_from[5], $ship_from[6]];
            $data->shipper->city = $ship_from[7];
            $data->shipper->state_code = $ship_from[10]; // "XX";
            $data->shipper->post_code = implode("", explode(" ", $ship_from[8]));
            $data->shipper->country_code = $ship_from[9];

            $data->shipto = new \stdClass();
            $data->shipto->name = $shipto_format[0];
            $data->shipto->shipper_number = "0W73E6";
            $data->shipto->address_line = [$shipto_format[3], $shipto_format[4], $shipto_format[5]];
            $data->shipto->city = $shipto_format[6];
            $data->shipto->state_code = $shipto_format[7];
            $data->shipto->post_code = $shipto_format[8];
            $data->shipto->country_code = $shipto_format[9];

            $data->shipfrom = new \stdClass();
            $data->shipfrom->name = $ship_from[0];
            $data->shipfrom->shipper_number = $ship_from[2];
            $data->shipfrom->address_line = [$ship_from[4], $ship_from[5], $ship_from[6]];
            $data->shipfrom->city = $ship_from[7];
            $data->shipfrom->state_code = $ship_from[10]; // "XX";
            $data->shipfrom->post_code = implode("", explode(" ", $ship_from[8]));
            $data->shipfrom->country_code = $ship_from[9];

            $data->service = new \stdClass();
            $data->service->code = $shipping_type[1];
            $data->service->description = $shipping_type[3];

            $data->invoice_line_total = new \stdClass();
            $data->invoice_line_total->currency_code = $order_selected[$system_entity->currency_code];
            $data->invoice_line_total->monetary_value = $order_value;

            $data->account_number = $ship_from[2];

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
            $package_api = [];
            $descriptions = [
                'kgs' => "kilograms",
                'lbs' => "Pounds",
                'cm' => "centimeter",
                'inch' => "inch"
            ];
            foreach ($package as $key => $value) {
                $package_info = new \stdClass();
                if (is_numeric($value)) {
                    //get package
                    $list_package_default = $model_package->ups_eu_woo_get_by_id($value);
                    if (!empty($list_package_default)) {
                        $package_info->package_weight = new \stdClass();
                        $package_info->package_weight->code = strtoupper($list_package_default->unit_weight);
                        $package_info->package_weight->description = $descriptions[$list_package_default->unit_weight];
                        $package_info->package_weight->weight = "{$list_package_default->weight}";

                        $package_info->dimension = new \stdClass();
                        $package_info->dimension->code = strtoupper($list_package_default->unit_dimension);
                        $package_info->dimension->description = $descriptions[$list_package_default->unit_dimension];
                        $package_info->dimension->length = "{$list_package_default->length}";
                        $package_info->dimension->width = "{$list_package_default->width}";
                        $package_info->dimension->height = "{$list_package_default->height}";
                        $package_info->dimension->package_item = "{$list_package_default->package_item}";
                    }
                } else {
                    if (is_array($value)) {
                        $value = (object) $value;
                    }
                    $package_info->package_weight = new \stdClass();
                    $package_info->package_weight->code = strtoupper($value->unit_weight);
                    $package_info->package_weight->description = $descriptions[$value->unit_weight];
                    $package_info->package_weight->weight = "{$value->weight}";
                    if (isset($value->length) && isset($value->width) && isset($value->height)) {
                        $package_info->dimension = new \stdClass();
                        $package_info->dimension->code = strtoupper($value->unit_dimension);
                        $package_info->dimension->description = $descriptions[$value->unit_dimension];
                        $package_info->dimension->length = "{$value->length}";
                        $package_info->dimension->width = "{$value->width}";
                        $package_info->dimension->height = "{$value->height}";
                        $package_info->dimension->package_item = "{$value->package_item}";
                    }
                }
                $package_api[] = $package_info;
            }

            $data->package = $package_api;

            //call api get tracking, shipment number
            $response = json_decode($upsapi_shipment->ups_eu_woo_call_api_get_rate($data));
            if (isset($response->RateResponse->Response->ResponseStatus->Code) &&
                $response->RateResponse->Response->ResponseStatus->Code == 1) {
                $response_rate = $response->RateResponse->RatedShipment;
                $result_data[$system_entity->currency_code] = $response_rate->TotalCharges->CurrencyCode;

                $result_data['monetary_value'] = $response_rate->TotalCharges->MonetaryValue;

                if (isset($response_rate->NegotiatedRateCharges->TotalCharge->MonetaryValue)) {
                    $result_data[$system_entity->currency_code] = $response_rate->NegotiatedRateCharges->TotalCharge->CurrencyCode;
                    $result_data['monetary_value'] = $response_rate->NegotiatedRateCharges->TotalCharge->MonetaryValue;
                }

                $date1 = $response_rate->TimeInTransit->ServiceSummary->EstimatedArrival->Arrival->Date;
                $time1 = $response_rate->TimeInTransit->ServiceSummary->EstimatedArrival->Arrival->Time;
                $date2 = $response_rate->TimeInTransit->ServiceSummary->EstimatedArrival->Pickup->Date;
                $time2 = $response_rate->TimeInTransit->ServiceSummary->EstimatedArrival->Pickup->Time;
                if ((int) $date1 > (int) $date2) {
                    $date = $date1;
                    $time = $time1;
                } else {
                    $date = $date2;
                    $time = $time2;
                }
                $date_time = substr($date, 0, 4) . '-' . substr($date, 4, 2) . '-' . substr($date, 6, 2) . ' ' .
                    substr($time, 0, 2) . ':' . substr($time, 2, 2) . ':' . substr($time, 4, 2);
                $result_data['time_in_transit'] = date_i18n(get_option('date_format') . ' ' .
                    get_option('time_format'), strtotime($date_time));
                $message = "";
            } else {
                $check = false;
                if (!empty($response)) {
                    $message = $response->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description;
                }
            }
        } else {
            $check = false;
            if ($validate_edit[0]) {
                $message = $this->package_error;
                $result_data = $validate_package[1];
            } elseif ($validate_package[0]) {
                $message = implode($model_orders->html_br, $this->ups_eu_woo_add_array($error_message));
                $result_data = $validate_edit[2];
            } else {
                $error_message[] = $this->package_error;
                $message = implode($model_orders->html_br, $this->ups_eu_woo_add_array($error_message));
                $result_data = [$validate_edit[2], $validate_package[1]];
            }
        }

        $dataObject = new \stdClass();
        $dataObject->code = "200";
        $dataObject->check = $check;
        $dataObject->message = $message;
        $dataObject->result = $result_data;
        $dataObject->validate = [$validate_edit[0], $validate_package[0]];
        return $dataObject;
    }
}