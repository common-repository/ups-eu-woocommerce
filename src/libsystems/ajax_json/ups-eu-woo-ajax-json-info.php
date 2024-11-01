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
 * ups-eu-woo-ajax-json-info.php - The core plugin class.
 *
 * This is used to define some methods to get informations of shipments.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Info_Ajax_Json');

class Ups_Eu_Woo_Info_Ajax_Json extends Ups_Eu_Woo_Global_Ajax_Json
{
    /** release */
    const Listcurrency = [
        'PL' => 'PLN',
        'FR' => 'EUR',
        'GB' => 'GBP',
        'IT' => 'EUR',
        'ES' => 'EUR',
        'DE' => 'EUR',
        'NL' => 'EUR',
        'BE' => 'EUR',
        'US' => 'USD',
        'AT' => 'EUR',
        'BG' => 'BGN', 
        'HR' => 'HRK', 
        'CY' => 'EUR', 
        'CZ' => 'CZK', 
        'DK' => 'DKK', 
        'EE' => 'EUR', 
        'FI' => 'EUR', 
        'GR' => 'EUR', 
        'HU' => 'HUF', 
        'IE' => 'EUR', 
        'LV' => 'EUR', 
        'LT' => 'EUR', 
        'LU' => 'EUR', 
        'MT' => 'EUR', 
        'PT' => 'EUR',  
        'RO' => 'RON', 
        'SK' => 'EUR', 
        'SI' => 'EUR', 
        'SE' => 'SEK',
        'NO' => 'NOK', 
        'RS' => 'RSD', 
        'CH' => 'CHF',
        'IS' => 'ISK', 
        'JE' => 'GBP', 
        'TR' => 'TRY'
    ];

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

    public function ups_eu_woo_info_order()
    {
        $jsonObject = new \stdClass();
        $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
        $language = array_merge(\UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
            $UpsEuWoocommerceSmarty->lang_page_open_orders
        ));
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();

        $dataObject = new \stdClass();
        $dataObject->router_url = $router_url;
        //get order info by order_magento_id
        if ($router_url->ups_eu_woo_check_method_post() === true) {
            $order_id_magento = "";
            if (!empty($_REQUEST[$router_url->id_order])) {
                $order_id_magento = $_REQUEST[$router_url->id_order];
            }
            $info_type = "";
            if (!empty($_REQUEST[$router_url->info_type_order])) {
                $info_type = $_REQUEST[$router_url->info_type_order];
            }
        }
        $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
        $model_option = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Options();
        // Get data from DB
        $type_get_data = 'order_detail';

        $conditions = ["order_id_magento = '{$order_id_magento}'"];
        $order = $model_orders->ups_eu_woo_pagination_list_data($info_type, [
            $model_orders->var_type_get_data => $type_get_data,
            $model_orders->var_conditions => $conditions,
            $model_orders->var_limit => 1,
        ]);

        if (!empty($order)) {
            $order = array_values($order);
            if (empty($order[0])) {
                $order = [];
            } else {
                $order = $order[0];
            }
        }

        $order->customer_name = $order->woo_shipping[$model_orders->first_name] . ' ' .
            $order->woo_shipping[$model_orders->last_name];
        
        if ($order->service_type == "AP") {
            $order->add_address_all = $this->ups_eu_woo_get_add_address_all($order);
            $order->ap_address_all = $this->ups_eu_woo_get_ap_address_all($order);
        } else {
            $order->add_address_all = $this->ups_eu_woo_get_add_address_all($order);
            $order->ap_address_all = '';
        }

        $dataObject->order = $order;
        $dataObject->lang = $language;
        $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);

        $jsonObject->html = $smarty->fetch("admin/merchant_cf/orders/popups/content_info_order.tpl");

        $jsonObject->code = "200";
        return $jsonObject;
    }

    public function ups_eu_woo_info_shipment()
    {
        $jsonObject = new \stdClass();
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $model_config   = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
        $language = array_merge(
            \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
                $UpsEuWoocommerceSmarty->lang_page_open_orders
            ),
            \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key($UpsEuWoocommerceSmarty->lang_page_shipments)
        );

        $dataObject = new \stdClass();
        $dataObject->router_url = $router_url;
        //get order info by order_magento_id
        if ($router_url->ups_eu_woo_check_method_post() === true) {
            $order_id_magento = "";
            if (!empty($_REQUEST[$router_url->id_order])) {
                $order_id_magento = $_REQUEST[$router_url->id_order];
            }
            $info_type = "";
            if (!empty($_REQUEST[$router_url->info_type_order])) {
                $info_type = $_REQUEST[$router_url->info_type_order];
            }
            $tracking_id = "";
            if (!empty($_REQUEST[$router_url->trackId])) {
                $tracking_id = $_REQUEST[$router_url->trackId];
            }
        }

        $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
        $model_option = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Options();
        // Get data from DB
        $type_get_data = $model_orders->var_info_shipment;

        $conditions = ["order_id_magento = '{$order_id_magento}' AND ST.id = '{$tracking_id}'"];
        $order = $model_orders->ups_eu_woo_pagination_list_data($info_type, [
            $model_orders->var_type_get_data => $type_get_data,
            $model_orders->var_conditions => $conditions,
            $model_orders->var_limit => 1,
        ]);

        if (!empty($order)) {
            $order = array_values($order);
            if (empty($order[0])) {
                $order = [];
            } else {
                $order = $order[0];
            }
        }
        $order->shipment_status = $this->_get_package_status($order->tracking_number);
        // update status shipment
        $this->ups_eu_woo_update_status_shipments(
            $model_orders,
            $order->order_id_magento,
            $order->shipping_shipment_id,
            $order->shipment_status,
            $order->tracking_number
        );
        //$order->package_detail = $this->_get_package_detail($tracking_id)
        $order->accessorial_service_text = str_replace(',', '<br>', $order->accessorial_service_text);

        $order->customer_name = $order->woo_shipping[$model_orders->first_name] . ' ' .
            $order->woo_shipping[$model_orders->last_name];
        
        if ($order->service_type == "AP") {
            $order->add_address_all = $this->ups_eu_woo_get_add_address_all($order);
            $order->ap_address_all = $this->ups_eu_woo_get_ap_address_all($order);
        } else {
            $order->add_address_all = $this->ups_eu_woo_get_add_address_all($order);
            $order->ap_address_all = '';
        }

        $dataObject->order = $order;
        $dataObject->lang = $language;

        $order_value = filter_var(
            $dataObject->order->shipment_order_value,
            FILTER_SANITIZE_NUMBER_FLOAT,
            FILTER_FLAG_ALLOW_FRACTION
        );

        $dataObject->order->shipment_order_value =  wc_price($order_value);
        
        $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();

        /* Get contry_code */
        $model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE);

        /* set country_code value */
        if (! empty($model_config->value)) {
            $country_code = $model_config->value;
        } else {
            $country_code = "GB";
        }
        $dataObject->order->currency_code = self::Listcurrency[$country_code];
        $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);

        $jsonObject->html = $smarty->fetch("admin/merchant_cf/orders/popups/content_info_shipment.tpl");

        $jsonObject->code = "200";
        return $jsonObject;
    }

    private function ups_eu_woo_update_status_shipments(
        $model_orders,
        $order_id_magento,
        $shipment_id,
        $shipment_status,
        $tracking_number
    ) {

        //update status order Woocomerce
        if (strtolower($shipment_status) == 'delivered') {
            $model_orders->ups_eu_woo_update_status_woo($order_id_magento, 'completed');
        } else {
            $model_orders->ups_eu_woo_update_status_woo($order_id_magento, 'processing');
        }

        //update status in table wp_ups_shipping_shipments
        $model_shipments = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Shipments();
        $model_shipments = $model_shipments->ups_eu_woo_get_by_id($shipment_id);
        $model_shipments->status = "{$shipment_status}";
        $model_shipments->ups_eu_woo_save();

        //get tracking number of shipment.
        $shipment = [];
        $shipment_data = new \stdClass();
        $shipment_data->tracking_number = $tracking_number;
        $shipment_data->shipment_status = "{$shipment_status}";
        $shipment[0] = $shipment_data;
        call_user_func_array(
            [
            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Retry_Api(), "ups_eu_woo_update_shipments_status"
            ],
            [
            $shipment
            ]
        );
    }

    private function ups_eu_woo_get_add_address_all($order)
    {
        $model_option = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Options();
        $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();

        $dataObject = new \stdClass();
        $dataObject->name = "";
        $dataObject->address1 = $order->woo_shipping[$model_orders->var_address_1];
        $dataObject->address2 = $order->woo_shipping[$model_orders->var_address_2];
        $dataObject->address3 = "";
        $dataObject->city = $order->woo_shipping[$model_orders->city];
        $dataObject->state = $model_option->get_state_name(
            $order->woo_shipping[$model_orders->country],
            $order->woo_shipping[$model_orders->state]
        );
        $dataObject->postcode = $order->woo_shipping[$model_orders->postcode];
        $dataObject->country = $model_option->get_country_name($order->woo_shipping[$model_orders->country]);

        $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
        $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
        return $smarty->fetch("admin/merchant_cf/orders/component/customer_address.tpl");
    }

    private function ups_eu_woo_get_ap_address_all($order)
    {
        $model_option = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Options();

        $dataObject = new \stdClass();
        $dataObject->name = $order->ap_name;
        $dataObject->address1 = $order->ap_address1;
        $dataObject->address2 = $order->ap_address2;
        $dataObject->address3 = $order->ap_address3;
        $dataObject->city = $order->ap_city;
        $dataObject->state = $model_option->get_state_name($order->ap_country, $order->ap_state);
        $dataObject->postcode = $order->ap_postcode;
        $dataObject->country = $model_option->get_country_name($order->ap_country);

        $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
        $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
        return $smarty->fetch("admin/merchant_cf/orders/component/customer_address.tpl");
    }
}
