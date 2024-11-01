<?php namespace UpsEuWoocommerce\controllers\admin;

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
 * ups-eu-woo-shipment-open-order.php - The core plugin class.
 *
 * This is used to config open order page and handle to export order, shipment.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Shipment_Open_Order');

class Ups_Eu_Woo_Shipment_Open_Order
{

    /**
     * ups_eu_woo_open_orders
     * */
    private $key_open_order = 'open_order';

    /**
     * Name function: ups_eu_woo_open_orders
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_open_orders()
    {
        /* Load models class */
        $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
        $model_account = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Account();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $ups_pagination = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Ups_Pagination();
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $model_services = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Services();

        /* submit form */
        if ($router_url->ups_eu_woo_check_method_post() === true) {
            $btn_controller = "";
            if (!empty($_REQUEST[$router_url->btn_controller])) {
                $btn_controller = trim(sanitize_text_field(strip_tags($_REQUEST[$router_url->btn_controller])));
            }
            if ($btn_controller == 'set_archive_order') {
                $order_ids = explode(',', $_REQUEST[$model_orders->order_ids]);
                if (!empty($order_ids) && $order_ids[0] != '') {
                    $model_orders->ups_eu_woo_set_to_archive_order($order_ids);
                }
            }
        }
        $dataObject = new \stdClass();
        $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key($model_orders->lang_page_open_orders);
        $dataObject->router_url = $router_url;

        $dataObject->pagination = $ups_pagination->ups_eu_woo_build_lists($this->key_open_order);

        $dataObject->action_form = $router_url->url_open_orders;

        /* set account default for create shipment when config in shipping service */
        $account_default = $model_account->ups_eu_woo_get_default_account();
        $account_default_id = 1;
        if (!empty($account_default)) {
            $account_default_id = $account_default[$model_account->col_account_id];
        }
        $account_config_default = [];
        $model_config->ups_eu_woo_get_by_key($model_config->CHOOSE_ACCOUNT_NUMBER_AP);
        if (!empty($model_config->value)) {
            $account = $model_account->ups_eu_woo_get_by_id($model_config->value);
            if (!empty($account->account_id)) {
                $account_config_default[strtolower($model_services->value_service_type_ap)] = $account->account_id;
            } else {
                $account_config_default[strtolower($model_services->value_service_type_ap)] = $account_default_id;
            }
        } else {
            $account_config_default[strtolower($model_services->value_service_type_ap)] = $account_default_id;
        }
        $model_config->ups_eu_woo_get_by_key($model_config->CHOOSE_ACCOUNT_NUMBER_ADD);
        if (!empty($model_config->value)) {
            $account = $model_account->ups_eu_woo_get_by_id($model_config->value);
            if (!empty($account->account_id)) {
                $account_config_default[strtolower($model_services->value_service_type_add)] = $account->account_id;
            } else {
                $account_config_default[strtolower($model_services->value_service_type_add)] = $account_default_id;
            }
        } else {
            $account_config_default[strtolower($model_services->value_service_type_ap)] = $account_default_id;
        }

        /* get list states */
        $country = new \WC_Countries();
        $dataObject->list_country = json_encode($country->get_countries());
        $state_data = $country->load_country_states();
        $dataObject->list_state = json_encode($country->states);

        $dataObject->account_default = $account_config_default;

        $dataObject->title = $this->key_open_order;

        return $dataObject;
    }

    /**
     * Name function: export_csv
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_config_export_csv()
    {
        /* Load models */
        $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
        $model_services = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Services();

        /* get params */
        $str_list_order_id = "";
        if (array_key_exists($model_orders->textbox_export_order_ids, $_REQUEST)) {
            $str_list_order_id = $_REQUEST[$model_orders->textbox_export_order_ids];
        }
        if ($str_list_order_id != 'all') {
            $orderIds = explode(',', $str_list_order_id);
        }

        if ($str_list_order_id == 'all' || (!empty($orderIds) && $orderIds[0] != '')) {
            /* Load language */
            $language = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key($model_orders->lang_page_open_orders);
            $exportCSV = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Export_CSV();
            $options = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Options();

            /* Get param sort */
            $sort = [];
            if (array_key_exists($model_orders->sort_by, $_REQUEST)) {
                $sort = [
                    $_REQUEST[$model_orders->sort_by] => $_REQUEST[$model_orders->sort_type]
                ];
            }
            $conditions = [];
            if ($str_list_order_id != 'all') {
                $conditions[] = "{$model_orders->col_order_id_magento} IN ({$str_list_order_id})";
            }
            /* Get data from DB */
            $listOpenOrders = $model_orders->ups_eu_woo_pagination_list_data($this->key_open_order, [
                $model_orders->var_type_get_data => 'export_csv',
                $model_orders->var_conditions => $conditions,
                $model_orders->var_order => $sort
            ]);
            /* set data export */
            $dataExport = [[
                $model_orders->Order_ID,
                $model_orders->Order_Date,
                $model_orders->Order_Time,
                $model_orders->COD,
                $model_orders->COD_Amount,
                $model_orders->COD_Currency,
                $model_orders->Currency_State,
                $model_orders->Total_Paid,
                $model_orders->Total_Products,
                $model_orders->Shipping_Service,
                $model_orders->Accessorials_Service,
                $model_orders->Product_Name,
                $model_orders->Merchant_UPSaccount_Number,
                $model_orders->Customer_Last_Name,
                $model_orders->Customer_First_Name,
                $model_orders->Customer_Address_line_1,
                $model_orders->Customer_Address_line_2,
                $model_orders->Customer_Address_line_3,
                $model_orders->Customer_PostalCode,
                $model_orders->Customer_Phone,
                $model_orders->Customer_City,
                $model_orders->Customer_StateOrProvince,
                $model_orders->Customer_Country,
                $model_orders->Customer_Email,
                $model_orders->AlternateDeliveryAddressIndicator,
                $model_orders->UPSAccessPointID,
                $model_orders->Access_Point_Address_line_1,
                $model_orders->Access_Point_Address_line_2,
                $model_orders->Access_Point_Address_line_3,
                $model_orders->Access_Point_City,
                $model_orders->Access_Point_StateOrProvince,
                $model_orders->Access_Point_PostalCode,
                $model_orders->Access_Point_Country
            ]];
            /* get price format in woocommerce */
            $special_char_replace = '&amp;#xD';
            $deci = wc_get_price_decimals();
            $thou_sep = wc_get_price_thousand_separator();
            $deci_sep = wc_get_price_decimal_separator();

            foreach ($listOpenOrders as $key => $openOrder) {
                if ($openOrder->service_type == $model_services->value_service_type_ap) {
                    $alternate_delivery_address_indicator = 1;
                } else {
                    $alternate_delivery_address_indicator = 0;
                }
                /* set access point's data */
                $UPSAcessPointID = '';
                if ($openOrder->service_type == $model_services->value_service_type_ap) {
                    $UPSAcessPointID = $openOrder->access_point_id;
                }

                $Key_Access_Point_Address_line_1 = '';
                if ($openOrder->service_type == $model_services->value_service_type_ap) {
                    $Key_Access_Point_Address_line_1 = $openOrder->ap_name;
                }

                $Key_Access_Point_Address_line_2 = '';
                if ($openOrder->service_type == $model_services->value_service_type_ap) {
                    $Key_Access_Point_Address_line_2 = str_replace($special_char_replace, '', $openOrder->ap_address1);
                }

                $Key_Access_Point_Address_line_3 = '';
                if ($openOrder->service_type == $model_services->value_service_type_ap) {
                    $Key_Access_Point_Address_line_3 = str_replace($special_char_replace, '', $openOrder->ap_address2);
                }

                $Key_Access_Point_City = '';
                if ($openOrder->service_type == $model_services->value_service_type_ap) {
                    $Key_Access_Point_City = $openOrder->ap_city;
                }

                $Key_Access_Point_StateOrProvince = '';
                if ($openOrder->service_type == $model_services->value_service_type_ap) {
                    $Key_Access_Point_StateOrProvince = $options->get_state_name($openOrder->ap_country, $openOrder->ap_state);
                }

                $Key_Access_Point_PostalCode = '';
                if ($openOrder->service_type == $model_services->value_service_type_ap) {
                    $Key_Access_Point_PostalCode = $openOrder->ap_postcode;
                }

                $Key_Access_Point_Country = '';
                if ($openOrder->service_type == $model_services->value_service_type_ap) {
                    $Key_Access_Point_Country = $options->get_country_name($openOrder->ap_country);
                }

                $dataExport[] = [
                    $model_orders->var_order_id => $openOrder->order_id_magento,
                    $model_orders->var_order_date => $openOrder->order_date,
                    $model_orders->var_order_time => $openOrder->order_time,
                    $model_orders->col_cod => $openOrder->cod_text,
                    $model_orders->cod_amount => number_format(floatval($openOrder->cod_amount), $deci, $deci_sep, $thou_sep),
                    $model_orders->cod_currency => $openOrder->cod_currency,
                    $model_orders->currency_state => $openOrder->woo_order_status,
                    $model_orders->total_paid => number_format($openOrder->total_paid, $deci, $deci_sep, $thou_sep),
                    /* format total price of product */
                    $model_orders->total_product => number_format(
                        $openOrder->woo_total_product_price,
                        $deci,
                        $deci_sep,
                        $thou_sep
                    ),
                    $model_orders->col_shipping_service => $openOrder->shipping_service_name,
                    $model_orders->col_accessorial_service => $openOrder->accessorial_service_text,
                    $model_orders->list_product => $openOrder->woo_product_text_list,
                    $model_orders->merchant_ups_account_number => '',
                    /* set customer info */
                    $model_orders->customer_last_name => $openOrder->woo_billing[$model_orders->last_name],
                    $model_orders->customer_first_name => $openOrder->woo_billing[$model_orders->first_name],
                    $model_orders->customer_address_1 => str_replace(
                        $special_char_replace,
                        '',
                        $openOrder->woo_billing[$model_orders->var_address_1]
                    ),
                    $model_orders->customer_address_2 => str_replace(
                        $special_char_replace,
                        '',
                        $openOrder->woo_billing[$model_orders->var_address_2]
                    ),
                    $model_orders->customer_address_3 => '',
                    $model_orders->customer_postal_code => $openOrder->woo_billing[$model_orders->postcode],
                    $model_orders->customer_phone => $openOrder->woo_billing[$model_orders->phone],
                    $model_orders->customer_city => $openOrder->woo_billing[$model_orders->city],
                    /* get state name by country code and state code */
                    $model_orders->customer_state_or_province => $options->get_state_name(
                        $openOrder->woo_billing[$model_orders->country],
                        $openOrder->woo_billing[$model_orders->state]
                    ),
                    /* get country name by country code */
                    $model_orders->customer_country => $options->get_country_name(
                        $openOrder->woo_billing[$model_orders->country]
                    ),
                    $model_orders->customer_email => $openOrder->woo_billing[$model_orders->email],

                    $model_orders->alternaet_delivery_address_indicator => $alternate_delivery_address_indicator,
                    /* set access point's data */
                    $model_orders->UPSAcessPointID => $UPSAcessPointID,
                    $model_orders->Key_Access_Point_Address_line_1 => $Key_Access_Point_Address_line_1,
                    $model_orders->Key_Access_Point_Address_line_2 => $Key_Access_Point_Address_line_2,
                    $model_orders->Key_Access_Point_Address_line_3 => $Key_Access_Point_Address_line_3,
                    $model_orders->Key_Access_Point_City => $Key_Access_Point_City,
                    $model_orders->Key_Access_Point_StateOrProvince => $Key_Access_Point_StateOrProvince,
                    $model_orders->Key_Access_Point_PostalCode => $Key_Access_Point_PostalCode,
                    $model_orders->Key_Access_Point_Country => $Key_Access_Point_Country
                ];
            }

            $filename = "orders_data_" . date("dmy") . ".csv";
            $exportCSV->ups_eu_woo_utils_export_csv_file($dataExport, $filename);
        }
    }

    /**
     * Name function: ups_eu_woo_config_export_shipment_csv
     * Params:
     * @str_list_tracking_id: type string
     * Return: type void
     */
    public function ups_eu_woo_config_export_shipment_csv($str_list_tracking_id)
    {
        $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
        $exportCSV = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Export_CSV();
        $options = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Options();
        $model_services = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Services();

        /* Get data from DB */
        $conditions = [];
        $conditions[] = "ST.id IN ({$str_list_tracking_id})";
        $params = [
            $model_orders->var_type_get_data => 'export_csv',
            $model_orders->var_conditions => $conditions,
            //'order' => $sort
        ];

        $listShipments = $model_orders->ups_eu_woo_pagination_list_data('shipment', $params);
        /* export data info */
        $dataExport = [[
            $model_orders->Shipment_ID,
            $model_orders->Date,
            $model_orders->Time,
            $model_orders->Tracking_number,
            $model_orders->deliveryStatus,
            $model_orders->COD,
            $model_orders->CODAmount,
            $model_orders->CODCurrency,
            $model_orders->Estimated_shipping_fee,
            $model_orders->Shipping_Service,
            $model_orders->Accessorials,
            $model_orders->Order_ID,
            $model_orders->Order_Date,
            $model_orders->Order_value,
            $model_orders->Shipping_fee,
            $model_orders->Package_details,
            $model_orders->Product_details,
            $model_orders->Customer_name,
            $model_orders->Customer_Address_line_1,
            $model_orders->Customer_Address_line_2,
            $model_orders->Customer_Address_line_3,
            $model_orders->Customer_PostalCode,
            $model_orders->Customer_Phone_no,
            $model_orders->Customer_City,
            $model_orders->Customer_StateOrProvince,
            $model_orders->Customer_Country,
            $model_orders->Customer_Email,
            $model_orders->AlternateDeliveryAddressIndicator,
            $model_orders->UPSAccessPointID,
            $model_orders->Access_Point_Address_line_1,
            $model_orders->Access_Point_Address_line_2,
            $model_orders->Access_Point_Address_line_3,
            $model_orders->Access_Point_City,
            $model_orders->Access_Point_StateOrProvince,
            $model_orders->Access_Point_PostalCode,
            $model_orders->Access_Point_Country
        ]];
        /* get price format in woocommerce */
        $special_char_replace = '&amp;#xD';
        $deci = wc_get_price_decimals();
        $thou_sep = wc_get_price_thousand_separator();
        $deci_sep = wc_get_price_decimal_separator();

        foreach ($listShipments as $key => $shipment) {
            /* get shipping fee */
            $shipping_fee = $this->get_shipping_total_woo($shipment->order_id_magento);
            $model_services->ups_eu_woo_get_by_id($shipment->shipping_service);
            $rowExport = [
                $model_orders->Shipment_ID => $shipment->shipment_shipment_number,
                $model_orders->date => date('Y/m/d', strtotime($shipment->shipment_create_date)),
                $model_orders->var_order_time => date('H:i:s', strtotime($shipment->shipment_create_date)),
                $model_orders->tracking_number => $shipment->tracking_number,
                $model_orders->delivery_status => $shipment->shipment_status,
                $model_orders->col_cod => $shipment->cod_text,
                $model_orders->cod_amount => number_format(floatval($shipment->cod_amount), $deci, $deci_sep, $thou_sep),
                $model_orders->cod_currency => $shipment->cod_currency,
                /* format estimated shipping fee */
                $model_orders->estimated_shipping_fee => number_format(
                    $shipment->shipment_shipping_fee,
                    $deci,
                    $deci_sep,
                    $thou_sep
                ),
                $model_orders->col_shipping_service => $model_services->service_name,
                $model_orders->accessorials => $shipment->accessorial_service_text,
                $model_orders->var_order_id => $shipment->order_id,
                $model_orders->var_order_date => date('Y/m/d', strtotime($shipment->order_date)),
                $model_orders->order_value => number_format($shipment->order_value, $deci, $deci_sep, $thou_sep),
                $model_orders->var_shipping_fee => number_format($shipping_fee, $deci, $deci_sep, $thou_sep),
                $model_orders->Key_Package_details => $shipment->package_detail,
                $model_orders->Key_Product_details => $shipment->woo_product_text_list,
                /* set customer info */
                $model_orders->Key_Customer_name => $shipment->woo_billing[$model_orders->first_name] . ' ' .
                $shipment->woo_billing[$model_orders->last_name],
                $model_orders->Key_Customer_Address_line_1 => str_replace(
                    $special_char_replace,
                    '',
                    $shipment->woo_billing[$model_orders->var_address_1]
                ),
                $model_orders->Key_Customer_Address_line_2 => str_replace(
                    $special_char_replace,
                    '',
                    $shipment->woo_billing[$model_orders->var_address_2]
                ),
                $model_orders->Key_Customer_Address_line_3 => '',
                $model_orders->Key_Customer_PostalCode => $shipment->woo_billing[$model_orders->postcode],
                $model_orders->Key_Customer_Phone_no => $shipment->woo_billing[$model_orders->phone],
                $model_orders->Key_Customer_City => $shipment->woo_billing[$model_orders->city],
                $model_orders->Key_Customer_StateOrProvince => $options->get_state_name(
                    $shipment->woo_billing[$model_orders->country],
                    $shipment->woo_billing[$model_orders->state]
                ),
                $model_orders->Key_Customer_Country => $options->get_country_name(
                    $shipment->woo_billing[$model_orders->country]
                ),
                $model_orders->Key_Customer_Email => $shipment->woo_billing[$model_orders->email],
                /* set access point's data */
                $model_orders->AlternateDeliveryAddressIndicator => 1,
                $model_orders->UPSAccessPointID => $shipment->access_point_id,
                $model_orders->Key_Access_Point_Address_line_1 => $shipment->name,
                $model_orders->Key_Access_Point_Address_line_2 => str_replace(
                    $special_char_replace,
                    '',
                    $shipment->address1
                ),
                $model_orders->Key_Access_Point_Address_line_3 => str_replace(
                    $special_char_replace,
                    '',
                    $shipment->address2
                ),
                $model_orders->Key_Access_Point_City => $shipment->city,
                $model_orders->Key_Access_Point_StateOrProvince => $options->get_state_name(
                    $shipment->country,
                    $shipment->state
                ),
                $model_orders->Key_Access_Point_PostalCode => $shipment->postcode,
                $model_orders->Key_Access_Point_Country => $options->get_country_name($shipment->country),
            ];
            /* reset customer info when delivery to address */
            if (strtolower($shipment->service_type) == 'add') {
                $rowExport[$model_orders->Key_Customer_name] = $shipment->name;
                $rowExport[$model_orders->Key_Customer_Address_line_1] = str_replace(
                    $special_char_replace,
                    '',
                    $shipment->address1
                );
                $rowExport[$model_orders->Key_Customer_Address_line_2] = str_replace(
                    $special_char_replace,
                    '',
                    $shipment->address2
                );
                $rowExport[$model_orders->Key_Customer_Address_line_3] = str_replace(
                    $special_char_replace,
                    '',
                    $shipment->address3
                );
                $rowExport[$model_orders->Key_Customer_PostalCode] = $shipment->postcode;
                $rowExport[$model_orders->Key_Customer_Phone_no] = $shipment->phone;
                $rowExport[$model_orders->Key_Customer_City] = $shipment->city;
                $rowExport[$model_orders->Key_Customer_StateOrProvince] = $options->get_state_name(
                    $shipment->country,
                    $shipment->state
                );
                $rowExport[$model_orders->Key_Customer_Country] = $options->get_country_name($shipment->country);
                $rowExport[$model_orders->Key_Customer_Email] = $shipment->email;
                /* reset access point's data when delivery to address */
                $rowExport[$model_orders->AlternateDeliveryAddressIndicator] = 0;
                $rowExport[$model_orders->UPSAccessPointID] = '';
                $rowExport[$model_orders->Key_Access_Point_Address_line_1] = '';
                $rowExport[$model_orders->Key_Access_Point_Address_line_2] = '';
                $rowExport[$model_orders->Key_Access_Point_Address_line_3] = '';
                $rowExport[$model_orders->Key_Access_Point_City] = '';
                $rowExport[$model_orders->Key_Access_Point_StateOrProvince] = '';
                $rowExport[$model_orders->Key_Access_Point_PostalCode] = '';
                $rowExport[$model_orders->Key_Access_Point_Country] = '';
            }

            $dataExport[] = $rowExport;
        }

        $filename = "shipments_data_" . date("dmy") . ".csv";
        $exportCSV->ups_eu_woo_utils_export_csv_file($dataExport, $filename);
    }

    /**
     * Name function: get_shipping_total_woo
     * Params:
     * @order_woo_id: type int
     * Return: type void
     */
    public function get_shipping_total_woo($order_woo_id)
    {
        $shipping_total = 0;
        $order = wc_get_order($order_woo_id);
        if ($order) {
            $shipping_total = $order->get_shipping_total();
        }
        return $shipping_total;
    }
}
