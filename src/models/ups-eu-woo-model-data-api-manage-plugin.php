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
 * ups-eu-woo-model-data-api-manage-plugin.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Data_Api_Manage_Plugin Model.
 */

include_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Data_Api_Manage_Plugin');

class Ups_Eu_Woo_Data_Api_Manage_Plugin extends Ups_Eu_Woo_Data_Base
{
    /* List variables */

    public $api_manager_key = "key";
    public $api_manager_token = "token";
    public $api_manager_merchant_key = "merchant_key";
    public $package_setting_option = 'package_setting_option';
    public $item_level_rating_include_dimensions = "item_level_rating_include_dimensions";
    /* PackageDefault */
    public $api_manager_service_key_delivery = "service_key_delivery";
    public $value_platform = "40";
    public $col_platform = "platform";
    public $var_account_list = "account_list";
    public $var_deliveryService = "deliveryService";
    public $var_service = "service";
    public $var_package = "package";
    public $var_package_default_list = "package_default_list";
    public $var_product_dimension_list = "product_dimension_list";
    public $var_fallback_rates_list = "fallback_rates_list";
    public $var_accessorials = "accessorials";
    public $var_shipment = "shipment";
    public $var_shipmentId = "shipmentId";
    public $var_shipmentStatus = "shipmentStatus";

    /*
     * Name function: ups_eu_woo_load_account
     * Params: empty
     * Return: object
     * * */

    public function ups_eu_woo_load_account()
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $model_account = new Ups_Eu_Woo_Model_Account();
        $model_package_default = new Ups_Eu_Woo_Model_Package_Default();
        $data = new \stdClass();
        $data->{$this->col_platform} = $this->value_platform;
        $data->{$this->var_account_list} = $this->ups_eu_woo_get_account_list($model_account->get_list_data_by_condition());
        $data->{$this->var_accessorials} = [];
        $package = $model_package_default->get_list_data_by_condition(
            ["`{$model_package_default->col_package_id}`='1'"]
        );
        if (count($package) > 0) {
            $data->{$this->var_package} = $package[0];
        }
        $data->{$this->api_manager_merchant_key} = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) === true) {
            $data->{$this->api_manager_merchant_key} = $model_config->value;
        }
        return $data;
    }
    /*
     * Name function: load_account_info_by_user
     * Params:
     *  @account_number: type string
     * Return: object
     */

    public function ups_eu_woo_load_account_infor_by_user($account_number)
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $model_account = new Ups_Eu_Woo_Model_Account();
        $model_package_default = new Ups_Eu_Woo_Model_Package_Default();
        $data = new \stdClass();
        $data->{$this->col_platform} = $this->value_platform;
        $data->{$this->var_account_list} = $this->ups_eu_woo_get_account_list(
            $model_account->get_list_data_by_condition(
                ["`{$model_account->col_ups_account_number}`='{$account_number}'"]
            )
        );
        $data->{$this->var_accessorials} = [];
        $package = $model_package_default->get_list_data_by_condition(
            ["`{$model_package_default->col_package_id}`='1'"]
        );
        if (count($package) > 0) {
            $data->{$this->var_package} = $package[0];
        }
        $data->status = $model_config->account_Activated;
        $data->{$this->api_manager_merchant_key} = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) === true) {
            $data->{$this->api_manager_merchant_key} = $model_config->value;
        }
        return $data;
    }
    /*
     * Name function: ups_eu_woo_load_shipping_service
     * Params: empty
     * Return: object
     */

    public function ups_eu_woo_load_shipping_service()
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $data = new \stdClass();
        $data->{$this->api_manager_merchant_key} = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) === true) {
            $data->{$this->api_manager_merchant_key} = $model_config->value;
        }
        $data->delivery_service = $this->ups_eu_woo_get_shipping_service();
        return $data;
    }
    /*
     * Name function: ups_eu_woo_load_delivery_rate
     * Params: empty
     * Return: object
     */

    public function ups_eu_woo_load_delivery_rate()
    {
        global $wpdb;
        $model_config = new Ups_Eu_Woo_Model_Config();
        $model_delivery_rates = new Ups_Eu_Woo_Delivery_Rates();
        $data = new \stdClass();
        $data->{$this->api_manager_merchant_key} = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) === true) {
            $data->{$this->api_manager_merchant_key} = $model_config->value;
        }
        $where = [];
        if ($model_config->ups_eu_woo_get_by_key($model_config->DELIVERY_TO_ACCESS_POINT) === true && intval($model_config->value) == 0) {
            $where[] = "ss.`service_type` <> 'AP'";
        }
        if ($model_config->ups_eu_woo_get_by_key($model_config->DELIVERY_TO_SHIPPING_ADDRESS) === true && intval($model_config->value) == 0) {
            $where[] = "ss.`service_type` <> 'ADD'";
        }

        $joins = [];
        $joins[] = [
            'table' => "`". $wpdb->prefix ."ups_shipping_services` as ss",
            'conditions' => [
                'ss.`id` = `'. $wpdb->prefix .'ups_shipping_delivery_rates`.service_id'
            ],
            'type' => "LEFT JOIN"
        ];

        $data->delivery_service = $this->ups_eu_woo_get_service_by_list_delivery(
            $model_delivery_rates->get_list_data_by_condition($where, 'all', $joins)
        );
        return $data;
    }
    /*
     * Name function: ups_eu_woo_load_accessorial
     * Params: empty
     * Return: object
     */

    public function ups_eu_woo_load_accessorial()
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $data = new \stdClass();
        $data->{$this->api_manager_merchant_key} = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) === true) {
            $data->{$this->api_manager_merchant_key} = $model_config->value;
        }
        return $data;
    }
    /*
     * Name function: ups_eu_woo_load_package_dimension
     * Params: empty
     * Return: object
     */

    public function ups_eu_woo_load_package_dimension()
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $data = new \stdClass();
        $data->{$this->api_manager_merchant_key} = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) === true) {
            $data->{$this->api_manager_merchant_key} = $model_config->value;
        }
        $data->{$this->var_package} = $this->ups_eu_woo_get_package_dimension();
        return $data;
    }
    /*
     * Name function: ups_eu_woo_load_shippment
     * Params:
     *  @data:  type object class
     * Return: object
     */

    public function ups_eu_woo_load_shippment($data_retry)
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $model_service = new Ups_Eu_Woo_Model_Services();
        // Get service info
        $service_id = $data_retry->shipping_type[2];
        $service = $model_service->ups_eu_woo_get_by_id($service_id);
        $data = new \stdClass();
        $data->account_number = $data_retry->ship_from[2];
        $data->shipment_id = $data_retry->model_shipment->shipment_number;
        $data->order_date = $data_retry->model_shipment->create_date;
        $data->fee = $data_retry->model_shipment->shipping_fee;
        $data->revenue = $data_retry->model_shipment->shipping_fee;
        $address_2 = '';
        if (!empty($data_retry->model_shipment->address2)) {
            $address_2 = ' ' . $data_retry->model_shipment->address2;
        }
        $address_3 = '';
        if (!empty($data_retry->model_shipment->address3)) {
            $address_3 = ' ' . $data_retry->model_shipment->address3;
        }
        $data->address = $data_retry->model_shipment->address1 . $address_2 . $address_3;
        $data->postal_code  = $data_retry->model_shipment->postcode;
        $data->city = $data_retry->model_shipment->city;
        $data->country = $data_retry->model_shipment->country;
        $data->service_type  = $data_retry->shipping_type[0];
        $data->service_code = $data_retry->shipping_type[1];
        $data->service_key = $service->service_key;
        $data->service_name = $data_retry->shipping_type[3];
        $data->is_cash_on_delivery = false;
        if ($data_retry->model_shipment->cod == 1) {
            $data->is_cash_on_delivery = true;
        }
        $data->status = $data_retry->model_shipment->status;

        //accessorials
        $data->accessorials = $data_retry->accessorial;

        //package
        $data->packages = $data_retry->package;

        //product
        $list_products = [];
        if (!empty($data_retry->list_order)) {
            foreach ($data_retry->list_order as $items) {
                $order = wc_get_order($items);
                $order_items = $order->get_items();
                if (!empty($order_items)) {
                    foreach ($order_items as $item) {
                        $list_products[] = $item['qty'] . ' x ' . $item['name'];
                    }
                }
            }
        }
        $data->products = $list_products;

        $data->{$this->api_manager_merchant_key} = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) === true) {
            $data->{$this->api_manager_merchant_key} = $model_config->value;
        }
        return $data;
    }
    /*
     * Name function: ups_eu_woo_load_shippment_status
     * Params:
     *  @shipments: type array
     * Return: type object
     * */

    public function ups_eu_woo_load_shippment_status($data_retry)
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $data = new \stdClass();
        $data->{$this->var_shipment} = $data_retry->shipments;
        $data->{$this->api_manager_merchant_key} = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) === true) {
            $data->{$this->api_manager_merchant_key} = $model_config->value;
        }
        return $data;
    }
    /*
     * Name function: ups_eu_woo_load_tracking
     * Params: empty
     * Return: type object
     * */

    public function ups_eu_woo_load_tracking()
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $data = [];
        $data->{$this->api_manager_merchant_key} = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) === true) {
            $data->{$this->api_manager_merchant_key} = $model_config->value;
        }
        return $data;
    }
    /*
     * Name function: ups_eu_woo_load_complete_configuration
     * Params: empty
     * Return: type object
     * */

    public function ups_eu_woo_load_complete_configuration($option)
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $model_account = new Ups_Eu_Woo_Model_Account();
        $model_package_default = new Ups_Eu_Woo_Model_Package_Default();
        $model_delivery_rates = new Ups_Eu_Woo_Delivery_Rates();
        $model_services = new Ups_Eu_Woo_Model_Services();
        $data = new \stdClass();
        $data->{$this->col_platform} = $this->value_platform;
        $account_list = null;
        if ($option == 0) {
            $account_list = $model_account->get_list_data_by_condition(["`account_id`=1"]);
        } else {
            $account_list = $model_account->get_list_data_by_condition(["`account_id` != 1"]);
        }
        $data->{$this->var_account_list} = $this->ups_eu_woo_get_account_list($account_list);
        $data->{$this->var_accessorials} = [];
        $data->delivery_service = $this->ups_eu_woo_get_service_by_list_delivery(
            $model_delivery_rates->get_list_data_by_condition()
        );
        $data->{$this->var_package} = $this->ups_eu_woo_get_package_dimension();
        $data->{$this->var_service} = $this->ups_eu_woo_get_shipping_service();
        $data->{$this->api_manager_merchant_key} = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) === true) {
            $data->{$this->api_manager_merchant_key} = $model_config->value;
        }
        return $data;
    }
    /*
     * Name function: ups_eu_woo_get_service_by_list_delivery
     * Params:
     * @list_delivery_rates: type array
     * Return: type object
     * */

    private function ups_eu_woo_get_service_by_list_delivery($list_delivery_rates)
    {
        $model_services = new Ups_Eu_Woo_Model_Services();
        $model_delivery_rates = new Ups_Eu_Woo_Delivery_Rates();
        $data = [];
        foreach ($list_delivery_rates as $item) {
            if (is_object($item)) {
                $tmp_object = new \stdClass();
                if (intval($item->{$model_delivery_rates->col_service_id}) > 0) {
                    $model_services->ups_eu_woo_get_by_id($item->{$model_delivery_rates->col_service_id});
                    $tmp_object->{$this->api_manager_service_key_delivery} = $model_services->service_key;
                    if (intval($item->{$model_delivery_rates->col_rate_type}) === 1) {
                        $tmp_object->{$model_delivery_rates->col_rate_type} = "{$model_delivery_rates->str_flat_rate}";
                    } else {
                        $tmp_object->{$model_delivery_rates->col_rate_type} = "{$model_delivery_rates->str_real_time}";
                    }
                    $tmp_object->{$model_services->col_service_type} = $model_services->service_type;
                    $tmp_object->{$model_services->col_rate_code} = $model_services->rate_code;
                    $tmp_object->{$model_services->col_service_name} = $model_services->service_name;
                    $tmp_object->{$model_delivery_rates->col_min_order_value} =
                        $item->{$model_delivery_rates->col_min_order_value};
                    $tmp_object->{$model_delivery_rates->col_delivery_rate} =
                        $item->{$model_delivery_rates->col_delivery_rate};
                    $tmp_object->{$model_delivery_rates->col_service_id} =
                        $item->{$model_delivery_rates->col_service_id};
                    $data[] = $tmp_object;
                }
            }
        }
        return $data;
    }
    /*
     * Name function: ups_eu_woo_get_account_list
     * Params:
     * @account_list: type array
     * Return: type array object
     * */

    private function ups_eu_woo_get_account_list($account_list)
    {
        $model_account = new Ups_Eu_Woo_Model_Account();
        foreach ($account_list as &$item) {
            if (is_object($item)) {
                $item->currency_code = get_woocommerce_currency();
                $item->post_code = $item->{$model_account->col_postal_code};
            }
        }
        return $account_list;
    }
    /*
     * Name function: ups_eu_woo_get_shipping_service
     * Params:
     *  @list_services: type array
     * Return: type array object
     * */

    private function ups_eu_woo_get_shipping_service()
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $model_services = new Ups_Eu_Woo_Model_Services();
        $model_delivery_rates = new Ups_Eu_Woo_Delivery_Rates();
        $DELIVERY_TO_ACCESS_POINT = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->DELIVERY_TO_ACCESS_POINT) === true) {
            $DELIVERY_TO_ACCESS_POINT = $model_config->value;
        }
        $DELIVERY_TO_SHIPPING_ADDRESS = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->DELIVERY_TO_SHIPPING_ADDRESS) === true) {
            $DELIVERY_TO_SHIPPING_ADDRESS = $model_config->value;
        }
        if (empty($DELIVERY_TO_ACCESS_POINT) && empty($DELIVERY_TO_SHIPPING_ADDRESS)) {
            return [];
        }
        $country_code = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            $country_code = $model_config->value;
        }
        $list_services = $model_services->get_list_data_by_condition(
            [
                $model_services->col_country_code => $country_code,
                $model_services->col_service_selected => 1
            ]
        );
        if (empty($DELIVERY_TO_SHIPPING_ADDRESS)) {
            foreach ($list_services as $item) {
                if (is_object($item) && (trim($item->{$model_services->col_service_type}) ===
                    trim($model_services->value_service_type_ap))) {
                    $tmp_object = new \stdClass();
                    $tmp_object->{$model_services->col_service_key} = $item->{$model_services->col_service_key};
                    $tmp_object->{$model_services->col_service_key_delivery} =
                        $item->{$model_services->col_service_type};
                    $tmp_object->{$model_services->col_service_key_val} = $item->{$model_services->col_rate_code};
                    $tmp_object->{$model_services->col_service_name} = $item->{$model_services->col_service_name};
                    $tmp_object->{$model_services->col_rate_code} = $item->{$model_services->col_service_name};
                    $tmp_object->{$model_delivery_rates->col_service_id} = $item->{$model_services->col_id};
                    $tmp_object->{$model_services->col_service_type} = $item->{$model_services->col_service_type};
                    $data[] = $tmp_object;
                }
            }
            return $data;
        }
        if (empty($DELIVERY_TO_ACCESS_POINT)) {
            foreach ($list_services as $item) {
                if (is_object($item) && (trim($item->{$model_services->col_service_type}) ===
                    trim($model_services->value_service_type_add))) {
                    $tmp_object = new \stdClass();
                    $tmp_object->{$model_services->col_service_key} = $item->{$model_services->col_service_key};
                    $tmp_object->{$model_services->col_service_key_delivery} =
                        $item->{$model_services->col_service_type};
                    $tmp_object->{$model_services->col_service_key_val} = $item->{$model_services->col_rate_code};
                    $tmp_object->{$model_services->col_service_name} = $item->{$model_services->col_service_name};
                    $tmp_object->{$model_services->col_rate_code} = $item->{$model_services->col_service_name};
                    $tmp_object->{$model_delivery_rates->col_service_id} = $item->{$model_services->col_id};
                    $tmp_object->{$model_services->col_service_type} = $item->{$model_services->col_service_type};
                    $data[] = $tmp_object;
                }
            }
            return $data;
        }
        foreach ($list_services as $item) {
            if (is_object($item)) {
                $tmp_object = new \stdClass();
                $tmp_object->{$model_services->col_service_key} = $item->{$model_services->col_service_key};
                $tmp_object->{$model_services->col_service_key_delivery} = $item->{$model_services->col_service_type};
                $tmp_object->{$model_services->col_service_key_val} = $item->{$model_services->col_rate_code};
                $tmp_object->{$model_services->col_service_name} = $item->{$model_services->col_service_name};
                $tmp_object->{$model_services->col_rate_code} = $item->{$model_services->col_service_name};
                $tmp_object->{$model_delivery_rates->col_service_id} = $item->{$model_services->col_id};
                $tmp_object->{$model_services->col_service_type} = $item->{$model_services->col_service_type};
                $data[] = $tmp_object;
            }
        }
        return $data;
    }

    /*
     * Name function: ups_eu_woo_get_package_dimension
     * Params: empty
     * Return: object
     */
    public function ups_eu_woo_get_package_dimension()
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $data = new \stdClass();
        $data->{$this->package_setting_option} = '';
        if ($model_config->ups_eu_woo_get_by_key($model_config->PACKAGE_SETTING_OPTION) === true) {
            $data->{$this->package_setting_option} = $model_config->value;
        }
        // Get data package default
        if ($data->{$this->package_setting_option} == 1) {
            $model_package_default = new Ups_Eu_Woo_Model_Package_Default();
            $data->{$this->var_package_default_list} = $model_package_default->ups_eu_woo_get_all();
            return $data;
            // get data fallback rate
        } elseif ($data->{$this->package_setting_option} == 2) {
            $data->{$this->item_level_rating_include_dimensions} = '';
            if ($model_config->ups_eu_woo_get_by_key($model_config->ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS) === true) {
                $data->{$this->item_level_rating_include_dimensions} = boolval($model_config->value);
            }
            $model_product_dimension = new Ups_Eu_Woo_Model_Product_Dimension();
            $model_fallback_rates = new Ups_Eu_Woo_Fallback_Rates();
            $model_services = new Ups_Eu_Woo_Model_Services();
            // Get list product dimension
            $data->{$this->var_product_dimension_list} = $model_product_dimension->ups_eu_woo_get_all();
            $data->{$this->var_fallback_rates_list} = [];
            $fallback_rates_list = $model_fallback_rates->ups_eu_woo_get_all();
            // Get service key by Id
            foreach ($fallback_rates_list as $fallback_rate) {
                $fallbackRate = new \stdClass();
                $fallbackRate->service_key = $model_services->ups_eu_woo_get_by_id($fallback_rate->service_id)->service_key;
                $fallbackRate->fallback_rate = $fallback_rate->fallback_rate;
                $data->{$this->var_fallback_rates_list}[] = $fallbackRate;
            }
        }
        return $data;
    }
}
