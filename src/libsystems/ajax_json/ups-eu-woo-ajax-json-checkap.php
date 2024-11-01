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
 * ups-eu-woo-ajax-json-package.php - The core plugin class.
 *
 * This is used to define some methods to get informations of Package.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Package_Ajax_Json');

class Ups_Eu_Woo_CheckAP_Ajax_Json extends Ups_Eu_Woo_Global_Ajax_Json
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

    public function ups_eu_woo_check_ap_availability()
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_account = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Account();
        $account_default = $model_account->ups_eu_woo_get_default_account();
        $upsapi_shipment = new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Shipments_Api_Ups();

        $descriptions = [
            'kg' => "kilograms",
            'lb' => "Pounds",
            'cm' => "centimeter",
            'in' => "inch"
        ];
        $currencies = [
            'BE' => ['Euro','EUR'],
            'NL' => ['Euro','EUR'],
            'FR' => ['Euro','EUR'],
            'ES' => ['Euro','EUR'],
            'PL' => ['Zloty','PLN'],
            'IT' => ['Euro','EUR'],
            'DE' => ['Euro','EUR'],
            'GB' => ['Pound Sterling','GBP'],
            'US' => ['US Dollar','USD'],
            'AT' => ['Euro','EUR'],
            'BG' => ['Bulgarian lev', 'BGN'],
            'HR' => ['Croatian Kuna', 'HRK'],
            'CY' => ['Euro','EUR'],
            'CZ' => ['Czech Koruna', 'CZK'],
            'DK' => ['Danish Krone', 'DKK'],
            'EE' => ['Euro','EUR'],
            'FI' => ['Euro','EUR'],
            'GR' => ['Euro','EUR'],
            'HU' => ['Forint', 'HUF'],
            'IE' => ['Euro','EUR'],
            'LV' => ['Euro','EUR'],
            'LT' => ['Euro','EUR'],
            'LU' => ['Euro','EUR'],
            'MT' => ['Euro','EUR'],
            'PT' => ['Euro','EUR'],
            'RO' => ['New Leu', 'RON'],
            'SK' => ['Euro','EUR'],
            'SI' => ['Euro','EUR'],
            'SE' => ['Swedish Krona', 'SEK'],
            'NO' => ['Norwegian Krone','NOK'],
            'RS' => ['Serbian Dinar','RSD'],
            'CH' => ['Swiss Franc', 'CHF'],
            'IS' => ['Iceland Krona ','ISK'],
            'JE' => ['Pound Sterling ','GBP'],
            'TR' => ['New Turkish Lira', 'TRY']
        ];

        $data = new \stdClass();
            
        $data->shipper = new \stdClass();
        $data->shipper->name = "";
        $data->shipper->shipper_number = $account_default['ups_account_number'];
        $data->shipper->address_line = [$account_default['address_1'], $account_default['address_2'], $account_default['address_3']];
        $data->shipper->city = $account_default['city'];
        $data->shipper->state_code = $account_default['state']; // "XX";
        $data->shipper->post_code = implode("", explode(" ", $account_default['postal_code']));
        $data->shipper->country_code = $account_default['country'];

        $data->shipto = new \stdClass();
        $data->shipto->name = "";
        $data->shipto->address_line = [$account_default['address_1'], $account_default['address_2'], $account_default['address_3']];
        $data->shipto->city = $account_default['city'];
        $data->shipto->state_code = $account_default['state'];
        $data->shipto->post_code = implode("", explode(" ", $account_default['postal_code']));
        $data->shipto->country_code = $account_default['country'];

        $data->shipfrom = new \stdClass();
        $data->shipfrom->name = "";
        $data->shipfrom->shipper_number = $account_default['ups_account_number'];
        $data->shipfrom->address_line = [$account_default['address_1'], $account_default['address_2'], $account_default['address_3']];
        $data->shipfrom->city = $account_default['city'];
        $data->shipfrom->state_code = $account_default['state']; // "XX";
        $data->shipfrom->post_code = implode("", explode(" ", $account_default['postal_code']));
        $data->shipfrom->country_code = $account_default['country'];

        $data->ShipmentRequest = new \stdClass();
        $data->ShipmentRequest->Shipment = new \stdClass();
        $data->ShipmentRequest->Shipment->ShipmentIndicationType = new \stdClass();
        $data->ShipmentRequest->Shipment->ShipmentIndicationType->Code = "02";

        $data->alternate_delivery_address = new \stdClass();
        $data->alternate_delivery_address->name = "";
        $data->alternate_delivery_address->attention_name = "";
        $data->alternate_delivery_address->address_line = $account_default['address_1'];
        $data->alternate_delivery_address->city = $account_default['city'];
        $data->alternate_delivery_address->state_code = $account_default['state'];
        $data->alternate_delivery_address->post_code = implode("", explode(" ", $account_default['postal_code']));
        $data->alternate_delivery_address->country_code = $account_default['country'];

        $data->PaymentDetails = new \stdClass();
        $data->PaymentDetails->ShipmentCharge = [];
        $shipment_charge_item = new \stdClass();
        $shipment_charge_item->Type = "01";
        $shipment_charge_item->BillShipper = new \stdClass();
        $shipment_charge_item->BillShipper->AccountNumber = $account_default['ups_account_number'];
        $data->PaymentDetails->ShipmentCharge[] = $shipment_charge_item;
        $data->ShipmentRatingOptions = new \stdClass();
        $data->ShipmentRatingOptions->NegotiatedRatesIndicator = "";
        $data->request_option = 'SHOPTIMEINTRANSIT';
        $data->account_number = $account_default['ups_account_number'];
        $data->shipping_type = 'AP';
        $data->pickup_date = date('Ymd', strtotime("+1 day"));
            
        $data->invoice_line_total = new \stdClass();
        $data->invoice_line_total->currency_code = isset($currencies[$account_default['country']][1]) ? $currencies[$account_default['country']][1] : "";
        $data->invoice_line_total->monetary_value = "10";
                
        $package_api = [];

        // $woo_def_weight_unit = get_option('woocommerce_weight_unit');
        // $woo_def_dimension_unit = get_option('woocommerce_dimension_unit');
        $woo_def_weight_unit = "kg";
        $woo_def_dimension_unit = "cm";
        
        $package_info = new \stdClass();
        $package_info->package_weight = new \stdClass();
        $package_info->package_weight->code = (strtoupper($woo_def_weight_unit) == "KG") ? "KGS" : "LBS";
        $package_info->package_weight->description = isset($descriptions[$woo_def_weight_unit]) ? $descriptions[$woo_def_weight_unit] : "";
        $package_info->package_weight->weight = "1";

        $package_info->dimension = new \stdClass();
        $package_info->dimension->code = strtoupper($woo_def_dimension_unit);
        $package_info->dimension->description = isset($descriptions[$woo_def_dimension_unit]) ? $descriptions[$woo_def_dimension_unit] : "";
        $package_info->dimension->length = "1";
        $package_info->dimension->width = "1";
        $package_info->dimension->height = "1";
        // $package_info->dimension->package_item = "{$package['include']}";
        
        $package_api[] = $package_info;
        
        $data->package = $package_api;

        $rate_res = json_decode($upsapi_shipment->ups_eu_woo_call_api_get_rate($data));

        if (isset($rate_res->RateResponse->Response->ResponseStatus->Code) && (string)$rate_res->RateResponse->Response->ResponseStatus->Code == "1") {
            $res_json = ["status" => "success"];
        } elseif (isset($rate_res->Fault->faultstring)) {
            $res_json = ["status" => (string)$rate_res->Fault->faultstring];
        } else {
            $res_json = ["status" => "Unknown error. Can't able to enable AP service."];
        }
        echo json_encode($res_json);
        exit();
    }
}