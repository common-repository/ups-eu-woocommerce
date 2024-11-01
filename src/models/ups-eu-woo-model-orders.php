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
 * ups-eu-woo-model-orders.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Model_Orders Model.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Model_Orders');

class Ups_Eu_Woo_Model_Orders extends entities\Ups_Eu_Woo_Orders_Entity implements Ups_Eu_Woo_Interfaces
{

    private $table_name = "";
    private $key_id = "id";
    private $_tpl_delivery_address = "admin/merchant_cf/orders/component/delivery_address.tpl";
    //------------atributes fields----------------
    public $id;
    public $order_id_magento;
    public $shipping_service;
    public $accessorial_service;
    public $shipment_id;
    public $status;
    public $ap_name;
    public $ap_address1;
    public $ap_address2;
    public $ap_address3;
    public $ap_state;
    public $ap_postcode;
    public $ap_city;
    public $ap_country;
    public $quote_id;
    public $cod;
    public $location_id;
    public $access_point_id;
    public $woo_tmp_order_date;
    public $date_created;
    public $date_update;
    public $package_type;
    private $var_order_id_woocommerce = '';
    private $var_table_shipping_services = '';

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
     * Params: empty
     * Return: void
     * * */


    public function __construct()
    {
        parent::__construct();
        global $wpdb;
        $this->table_name = "{$wpdb->prefix}{$this->prefix_ups}orders";
        $this->key_id = $this->col_id;
        $model_services = new Ups_Eu_Woo_Model_Services();
        $this->var_order_id_woocommerce = "{$this->table_name}.{$this->col_order_id_magento}";
        $this->var_table_shipping_services = "`{$model_services->ups_eu_woo_get_table_name()}` as SV";
    }
    /*
     * Name function: ups_eu_woo_convert_to_array
     * Params: empty
     * Return: type array
     * * */

    public function ups_eu_woo_convert_to_array()
    {
        $tmpArray = [];
        $tmpArray[$this->col_id] = $this->id;
        $tmpArray[$this->col_order_id_magento] = $this->order_id_magento;
        $tmpArray[$this->col_shipping_service] = $this->shipping_service;
        $tmpArray[$this->col_accessorial_service] = $this->accessorial_service;
        $tmpArray[$this->col_shipment_id] = $this->shipment_id;
        $tmpArray[$this->col_status] = $this->status;
        $tmpArray[$this->col_ap_name] = $this->ap_name;
        $tmpArray[$this->col_ap_address1] = $this->ap_address1;
        $tmpArray[$this->col_ap_address2] = $this->ap_address2;
        $tmpArray[$this->col_ap_address3] = $this->ap_address3;
        $tmpArray[$this->col_ap_state] = $this->ap_state;
        $tmpArray[$this->col_ap_postcode] = $this->ap_postcode;
        $tmpArray[$this->col_ap_city] = $this->ap_city;
        $tmpArray[$this->col_ap_country] = $this->ap_country;
        $tmpArray[$this->col_quote_id] = $this->quote_id;
        $tmpArray[$this->col_cod] = $this->cod;
        $tmpArray[$this->col_location_id] = $this->location_id;
        $tmpArray[$this->col_woo_tmp_order_date] = $this->woo_tmp_order_date;
        $tmpArray[$this->col_access_point_id] = $this->access_point_id;
        $tmpArray[$this->col_package_type] = $this->package_type;
        return $tmpArray;
    }
    /*
     * Name function: save
     * Params: empty
     * Return: type boolean
     * * */

    public function ups_eu_woo_save()
    {
        if ($this->ups_eu_woo_validate() === true) {
            $dataArray = $this->ups_eu_woo_convert_to_array();
            $check_save_id = $this->ups_eu_woo_base_save($dataArray, $this->table_name, $this->key_id);
            if ($check_save_id > 0) {
                $this->{$this->key_id} = $check_save_id;
                return true;
            }
            return false;
        }
        return false;
    }
    /*
     * Name function: ups_eu_woo_update_all
     * Params:
     *  @dataArray: type array
     *  @conditions: type array
     * Return: type boolean
     * * */

    public function ups_eu_woo_update_all($dataArray, $conditions = [])
    {
        if ($this->ups_eu_woo_validate() === true) {
            $this->ups_eu_woo_base_update($dataArray, $this->table_name, $conditions);
            return false;
        }
        return false;
    }
    /*
     * Name function: ups_eu_woo_update_shipto
     * Params:
     *  @dataArray: type array
     *  @conditions: type array
     * Return: type boolean
     * * */

    public function ups_eu_woo_update_shipto()
    {
        if ($this->ups_eu_woo_validate() === true) {
            if (empty($this->ap_name) || empty($this->ap_address1) || empty($this->ap_country)) {
                return false;
            }
            global $wpdb;
            $shipto_table = "{$wpdb->prefix}postmeta";
            $shipto_update_sql = 'UPDATE '.$shipto_table.' SET meta_value = 
                            CASE 
                                WHEN meta_key = "_shipping_first_name" AND post_id = "'.$this->order_id_magento.'" THEN "'.$this->ap_name.'"
                                WHEN meta_key = "_shipping_last_name" AND post_id = "'.$this->order_id_magento.'" THEN "'.$this->ap_name.'"
                                WHEN meta_key = "_shipping_company" AND post_id = "'.$this->order_id_magento.'" THEN ""
                                WHEN meta_key = "_shipping_address_1" AND post_id = "'.$this->order_id_magento.'" THEN "'.$this->ap_address1.'"
                                WHEN meta_key = "_shipping_city" AND post_id = "'.$this->order_id_magento.'" THEN "'.$this->ap_city.'"
                                WHEN meta_key = "_shipping_postcode" AND post_id = "'.$this->order_id_magento.'" THEN "'.$this->ap_postcode.'"
                                WHEN meta_key = "_shipping_country" AND post_id = "'.$this->order_id_magento.'" THEN "'.$this->ap_country.'"
                                ELSE meta_value
                            END;';
            try {
                return $wpdb->query($shipto_update_sql);
            } catch (Exception $ex) {
                Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($shipto_update_sql, $ex);
                return false;
            }
        }
    }
    /*
     * Name function: ups_eu_woo_get_by_id
     * Params:
     *  @id: type int
     * Return: type boolean
     * * */

    public function ups_eu_woo_get_by_id($id)
    {
        $id = intval($id);
        if ($id > 0) {
            $result_array = $this->ups_eu_woo_base_get_by_id($id, $this->table_name, $this->key_id);
            $this->ups_eu_woo_base_convert_array_to_object($result_array, $this);
            return $this;
        }
        return false;
    }
    /*
     * Name function: get_list_data_by_condition
     * Params:
     *  @conditions: type array
     *  @limit: type string
     * Return: type array object or false
     * * */

    public function get_list_data_by_condition(
        $conditions = [],
        $limit = 'all',
        $order = [],
        $joins = [],
        $selects = false
    ) {
        return $this->ups_eu_woo_base_get_list_data_by_condition($this->table_name, $conditions, $limit, $order, $joins, $selects);
    }
    /*
     * Name function: delete
     * Params:
     *  @id: int
     * Return: boolean
     * * */

    public function ups_eu_woo_delete($id)
    {
        $id = intval($id);
        if ($id > 0) {
            return $this->ups_eu_woo_base_delete($id, $this->table_name, $this->key_id);
        }
        return false;
    }
    /*
     * Name function: validate
     * Params: empty
     * Return: type array or false
     * * */

    public function ups_eu_woo_validate()
    {
        $tmpValidate = [];
        $result = true;
        if (count($tmpValidate) > 0) {
            $result = $tmpValidate;
        }
        return $result;
    }
    /*
     * Name function: ups_eu_woo_merge_array
     * Params:
     *  @data: type array
     * Return: type object
     * * */

    public function ups_eu_woo_merge_array($data)
    {
        $this->ups_eu_woo_base_convert_array_to_object($data, $this);
    }
    /*
     * Name function: ups_eu_woo_check_existing
     * Params: empty
     * Return: type boolean
     * * */

    public function ups_eu_woo_check_existing()
    {
        return $this->ups_eu_woo_base_check_existing($this->table_name);
    }
    /*
     * Name function: ups_eu_woo_pagination_condition
     * Params:
     *  @params: type array
     * Return: type array
     * * */

    public function ups_eu_woo_pagination_condition($params = [])
    {
        return [];
    }
    /*
     * Name function: ups_eu_woo_pagination_list_data
     * Params:
     *  @page: type int
     *  @params: type array
     * Return: type array object
     * * */

    public function ups_eu_woo_pagination_list_data($page, $params = [])
    {
        if ($page == $this->var_shipment || $page == $this->var_info_shipment) {
            return $this->ups_eu_woo_pagination_list_data_shipment($page, $params);
        } elseif ($page == 'create_shipment') {
            return $this->ups_eu_woo_get_data_create_shipment($page, $params);
        } else {
            return $this->ups_eu_woo_pagination_list_data_order($page, $params);
        }
    }
    /*
     * Name function: ups_eu_woo_count_data
     * Params:
     *  @page: type int
     *  @status: type int
     * Return: type int
     * * */

    public function ups_eu_woo_count_data($page, $status)
    {
        if ($page == $this->var_shipment) {
            return $this->ups_eu_woo_count_data_shipment($status);
        } else {
            return $this->ups_eu_woo_pagination_total_record($status);
        }
    }
    /*
     * Name function: ups_eu_woo_get_data_create_shipment
     * Params:
     *  @page: type int
     *  @params: type array
     * Return: type object
     * * */

    protected function ups_eu_woo_get_data_create_shipment($page, $params = [])
    {

        $entity_language = new entities\Ups_Eu_Woo_Language_Entity();
        $language = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key($entity_language->lang_common);
        $type_get_data = '';
        if (array_key_exists($this->var_type_get_data, $params)) {
            $type_get_data = $params[$this->var_type_get_data];
        }
        if (array_key_exists($this->var_limit, $params)) {
            $limit = $params[$this->var_limit];
        } else {
            $limit = 'all';
        }
        $order = [];
        if (array_key_exists($this->var_order, $params)) {
            $order = $params[$this->var_order];
        }
        $conditions = [];
        if (array_key_exists($this->var_conditions, $params)) {
            $conditions = $params[$this->var_conditions];
        }
        $joins = [
            [
                $this->var_table => $this->var_table_shipping_services,
                $this->var_conditions => [
                    'SV.id = `' . $this->table_name . '`.' . $this->col_shipping_service
                ],
                $this->var_type => $this->var_left_join
            ]
        ];

        // Get order by type
        $status = $this->ups_eu_woo_config_get_status_order($page);

        $conditions[] = "`{$this->table_name}`.status = {$status}";
        // Set param sort data get form database
        $order = $this->ups_eu_woo_build_order_by_order($order);
        // Get data from database
        $data = $this->get_list_data_by_condition($conditions, $limit, $order, $joins);

        // Prepare data
        $results = [];
        $order_value = 0;
        foreach ($data as $item) {
            /* Get data form woocommerce */
            $this->ups_eu_woo_mo_get_order_detail($item, $type_get_data);

            /* Prepare data from database */

            $item->order_time = date_i18n(get_option($this->var_time_format), strtotime($item->woo_tmp_order_date));
            $item->order_date = date_i18n(get_option($this->var_date_format), strtotime($item->woo_tmp_order_date));
            $item->delivery_address = $this->ups_eu_woo_get_delivery_address($item, $page, $item->woo_shipping);

            $item->ap_address_text = '';
            $item->add_address_text = '';
            $shipto_address = $this->ups_eu_woo_get_shipto_address($item);
            if (!empty($shipto_address)) {
                $item->ap_address_text = $shipto_address['ap_address_text'];
                $item->add_address_text = $shipto_address['add_address_text'];
            }
            $order_value = $order_value + (double) filter_var(
                $item->total_price,
                FILTER_SANITIZE_NUMBER_FLOAT,
                FILTER_FLAG_ALLOW_FRACTION
            );

            $item->accessorial_service = $item->accessorial_translate;

            $results[$item->order_id_magento] = $item;
        }
        $results['order_value'] = number_format($order_value, 2);

        return $results;
    }
    /*
     * Name function: ups_eu_woo_pagination_list_data_order
     * Params:
     *  @page: type int
     *  @params: type array
     * Return: type array object
     * * */

    protected function ups_eu_woo_pagination_list_data_order($page, $params = [])
    {
        $type_get_data = '';
        if (array_key_exists($this->var_type_get_data, $params)) {
            $type_get_data = $params[$this->var_type_get_data];
        }
        if (array_key_exists($this->var_limit, $params)) {
            $limit = $params[$this->var_limit];
        } else {
            $limit = 'all';
        }
        $order = [];
        if (array_key_exists($this->var_order, $params)) {
            $order = $params[$this->var_order];
        }
        $conditions = [];
        if (array_key_exists($this->var_conditions, $params)) {
            $conditions = $params[$this->var_conditions];
        }
        $joins = [
            [
                $this->var_table => $this->var_table_shipping_services,
                $this->var_conditions => [
                    'SV.id = `' . $this->table_name . '`.' . $this->col_shipping_service
                ],
                $this->var_type => $this->var_left_join
            ]
        ];

        // Get order by type
        $status = $this->ups_eu_woo_config_get_status_order($page);

        $conditions[] = "`{$this->table_name}`.status = {$status}";
        // Set param sort data get form database
        $order = $this->ups_eu_woo_build_order_by_order($order);
        // Get data from database
        $data = $this->get_list_data_by_condition($conditions, $limit, $order, $joins);

        // Prepare data
        $results = [];
        foreach ($data as $item) {
            /* Get data form woocommerce */
            $this->ups_eu_woo_mo_get_order_detail($item, $type_get_data);

            /* Prepare data from database */

            $item->order_time = date_i18n(get_option($this->var_time_format), strtotime($item->woo_tmp_order_date));
            $item->order_date = date_i18n(get_option($this->var_date_format), strtotime($item->woo_tmp_order_date));
            $item->delivery_address = $this->ups_eu_woo_order_list_delivery_address($item);

            if (strlen($item->accessorial_service) > 0) {
                $item->accessorial_service = json_decode($item->accessorial_service);
                $item->accessorial_service = (array) $item->accessorial_service;
            }

            $results[$item->order_id_magento] = $item;
        }

        return $results;
    }
    /*
     * Name function: ups_eu_woo_pagination_list_data_shipment
     * Params:
     *  @page: type int
     *  @params: type array
     * Return: type array object
     * * */

    protected function ups_eu_woo_pagination_list_data_shipment($page, $params = [])
    {
        $type_get_data = '';
        if (array_key_exists($this->var_type_get_data, $params)) {
            $type_get_data = $params[$this->var_type_get_data];
        }
        if (array_key_exists($this->var_limit, $params)) {
            $limit = $params[$this->var_limit];
        } else {
            $limit = 50;
        }
        $order = [];
        if (array_key_exists($this->var_order, $params)) {
            $order = $params[$this->var_order];
        }
        $conditions = [];
        if (array_key_exists($this->var_conditions, $params)) {
            $conditions = $params[$this->var_conditions];
        }

        $selects = "*,ST.id as shipping_tracking_id, SS.status as shipment_status,
        SS.id as shipping_shipment_id,
        SS.cod as shipment_cod,
        SS.create_date as shipment_create_date,
        SS.shipment_number as shipment_shipment_number,
        SS.shipping_fee as shipment_shipping_fee,
        SS.order_value as shipment_order_value,
        SS.name as shipment_customer_name,
        SS.email as shipment_email,
        SS.phone as shipment_phone
        ";
        $model_config   = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();

        // Set param sort data get form database
        $order = $this->ups_eu_woo_build_order_by_shipment($order);
        // Get order by type
        $status = $this->ups_eu_woo_config_get_status_order($page);
        // Get data from database
        $data = $this->ups_eu_woo_get_data_shipment($status, $conditions, $limit, $order, $selects, $page);

        /* Get contry_code */
        $model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE);

        /* set country_code value */
        if (! empty($model_config->value)) {
            $country_code = $model_config->value;
        } else {
            $country_code = "GB";
        }

        // Prepare data
        $results = [];
        foreach ($data as $item) {
            /* Get data form woocommerce */
            $this->ups_eu_woo_mo_get_order_detail($item, $type_get_data);

            /* Prepare data from database */
            $item->order_time = date_i18n(get_option($this->var_time_format), strtotime($item->shipment_create_date));
            $item->order_date = date_i18n(get_option($this->var_date_format), strtotime($item->shipment_create_date));
            $item->delivery_address = $this->ups_eu_woo_shipment_list_delivery_address($item);
            $item->currency_code    = self::Listcurrency[$country_code];
            if (strlen($item->accessorial_service) > 0) {
                $item->accessorial_service = json_decode($item->accessorial_service);
                $item->accessorial_service = (array) $item->accessorial_service;
            }

            $key = $item->order_id_magento . '-' . $item->shipping_tracking_id;
            $results[$key] = $item;
        }

        return $results;
    }
    /*
     * Name function: ups_eu_woo_count_data_shipment
     * Params:
     *  @status: type int
     * Return: type int
     * * */

    public function ups_eu_woo_count_data_shipment($status)
    {
        $selects = "count(*) as total";
        // Get data from database
        $results = $this->ups_eu_woo_get_data_shipment($status, [], 'all', [], $selects);
        if (count($results) > 0) {
            $objectResult = $results[0];
            $data = 0;
            if (!empty($objectResult->total)) {
                $data = $objectResult->total;
            }
            return $data;
        }

        return 0;
    }
    /*
     * Name function: ups_eu_woo_get_data_shipment
     * Params:
     *  @status: type int
     *  @conditions: type array
     *  @limit: type string
     *  @order: type object
     *  @selects: type object
     *  @type_get_data: type string
     * Return: type array
     * * */

    public function ups_eu_woo_get_data_shipment($status, $conditions, $limit, $order, $selects, $type_get_data = '')
    {
        $condition_join_shipping_service = '`' . $this->table_name . '`.' . $this->col_shipping_service;
        $model_tracking = new Ups_Eu_Woo_Model_Tracking();
        $model_shipments = new Ups_Eu_Woo_Model_Shipments();

        if ($type_get_data == $this->var_info_shipment) {
            $condition_join_shipping_service = 'SS.' . $this->col_shipping_service;
        }

        $joins = [
            [
                $this->var_table => '`' . $model_shipments->ups_eu_woo_get_table_name() . '` as SS',
                $this->var_conditions => [
                    'SS.id = `' . $this->table_name . '`.shipment_id'
                ],
                $this->var_type => $this->var_left_join
            ],
            [
                $this->var_table => $this->var_table_shipping_services,
                $this->var_conditions => [
                    'SV.id = ' . $condition_join_shipping_service
                ],
                $this->var_type => $this->var_left_join
            ],
            [
                $this->var_table => '`' . $model_tracking->ups_eu_woo_get_table_name() . '` as ST',
                $this->var_conditions => [
                    'ST.order_id = `' . $this->table_name . '`.order_id_magento'
                ],
                $this->var_type => $this->var_left_join
            ],
        ];

        $conditions[] = "`{$this->table_name}`.status = {$status}";
        // Get data from database
        $data = $this->get_list_data_by_condition($conditions, $limit, $order, $joins, $selects);
        return $data;
    }
    /*
     * Name function: ups_eu_woo_config_get_status_order
     * Params:
     *  @page: type int
     * Return: type int
     * * */

    private function ups_eu_woo_config_get_status_order($page)
    {
        // Get order by type
        switch ($page) {
            case $this->var_info_shipment:
                $status = 2;
                break;
            case $this->var_shipment:
                $status = 2;
                break;
            case 'archived_order':
                $status = 3;
                break;
            default:
                $status = 1;
                break;
        }

        return $status;
    }
    /*
     * Name function: ups_eu_woo_build_order_by_order
     * Params:
     *  @page: type int
     * Return: type int
     * * */

    public function ups_eu_woo_get_status_order($page)
    {
        return $this->ups_eu_woo_config_get_status_order($page);
    }
    /*
     * Name function: ups_eu_woo_build_order_by_shipment
     * Params:
     *  @order: type array
     * Return: type array
     * * */

    private function ups_eu_woo_build_order_by_shipment($order)
    {
        if (!empty($order)) {
            if (array_key_exists($this->var_id_shipment, $order)) {
                $order = [
                    'SS.shipment_number' => $order[$this->var_id_shipment],
                    $this->var_order_id_woocommerce => $order[$this->var_id_shipment]
                ];
            }

            if (array_key_exists($this->var_order_id, $order)) {
                $order = [
                    $this->var_order_id_woocommerce => $order[$this->var_order_id]
                ];
            }

            if (array_key_exists($this->var_service_name, $order)) {
                $order = [
                    'SV.service_name' => $order[$this->var_service_name],
                    $this->var_order_id_woocommerce => $order[$this->var_service_name]
                ];
            }

            if (array_key_exists($this->var_order_date, $order)) {
                $order = [
                    'SS.create_date' => $order[$this->var_order_date],
                    $this->var_order_id_woocommerce => $order[$this->var_order_date]
                ];
            }

            if (array_key_exists($this->var_order_time, $order)) {
                $order = [
                    "DATE_FORMAT(SS.create_date,'%H:%i:%s')" => $order[$this->var_order_time],
                    $this->var_order_id_woocommerce => $order[$this->var_order_time]
                ];
            }

            if (array_key_exists($this->var_delivery_address, $order)) {
                $order = [
                    'SS.name' => $order[$this->var_delivery_address],
                    'SS.address1' => $order[$this->var_delivery_address],
                    'SS.address2' => $order[$this->var_delivery_address],
                    'SS.address3' => $order[$this->var_delivery_address],
                    'SS.city' => $order[$this->var_delivery_address],
                    $this->var_order_id_woocommerce => $order[$this->var_delivery_address]
                ];
            }

            if (array_key_exists($this->var_shipping_fee, $order)) {
                $order = [
                    "SS.shipping_fee" => $order[$this->var_shipping_fee],
                    $this->var_order_id_woocommerce => $order[$this->var_shipping_fee]
                ];
            }
        }
        $order['`' . $this->table_name . '`.id'] = 'desc';
        return $order;
    }
    /*
     * Name function: ups_eu_woo_build_order_by_order
     * Params:
     *  @order: type array
     * Return: type array
     * * */

    private function ups_eu_woo_build_order_by_order($order)
    {
        if (!empty($order)) {
            if (array_key_exists($this->var_order_id, $order)) {
                $order = [
                    $this->var_order_id_woocommerce => $order[$this->var_order_id]
                ];
            }

            if (array_key_exists($this->var_service_name, $order)) {
                $order = [
                    'SV.service_name' => $order[$this->var_service_name],
                    $this->var_order_id_woocommerce => $order[$this->var_service_name]
                ];
            }

            if (array_key_exists($this->var_order_date, $order)) {
                $order = [
                    '`' . $this->table_name . '`.woo_tmp_order_date' => $order[$this->var_order_date],
                    $this->var_order_id_woocommerce => $order[$this->var_order_date]
                ];
            }

            if (array_key_exists($this->var_order_time, $order)) {
                $order = [
                    "DATE_FORMAT(`{$this->table_name}`.woo_tmp_order_date,'%H:%i:%s')" =>
                    $order[$this->var_order_time],
                    $this->var_order_id_woocommerce => $order[$this->var_order_time]
                ];
            }

            if (array_key_exists($this->var_delivery_address, $order)) {
                $order = [
                    '`' . $this->table_name . '`.ap_name' => $order[$this->var_delivery_address],
                    '`' . $this->table_name . '`.ap_address1' => $order[$this->var_delivery_address],
                    '`' . $this->table_name . '`.ap_address2' => $order[$this->var_delivery_address],
                    '`' . $this->table_name . '`.ap_address3' => $order[$this->var_delivery_address],
                    '`' . $this->table_name . '`.ap_city' => $order[$this->var_delivery_address],
                    $this->var_order_id_woocommerce => $order[$this->var_delivery_address]
                ];
            }
        }
        $order['`' . $this->table_name . '`.id'] = 'desc';

        return $order;
    }
    /*
     * Name function: ups_eu_woo_mo_get_order_detail
     * Params:
     *  @item: type array
     *  @type_get: type string
     * Return: type void
     * * */

    private function ups_eu_woo_mo_get_order_detail(&$item, $type_get = '')
    {
        $order = wc_get_order($item->order_id_magento);
        if ($order) {
            // Get language
            $entity_language = new entities\Ups_Eu_Woo_Language_Entity();
            $language = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key($entity_language->lang_page_shipping_service);
            $common_translate = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key($entity_language->lang_common);
            $order_data = $order->get_data();
            $order_items = $order->get_items();
            //$shipping_service_type = strtolower($item->service_type) == 'ap' ? 'To AP' : 'To Address';
            if ($item->service_type !== null) {
                $shipping_service_type = strtolower($item->service_type) == 'ap' ? 'To AP' : 'To Address';
            } else{
                $shipping_service_type = 'To Address';
            }
            if (array_key_exists($item->service_key, $language)) {
                $shipping_service_name = $language[$item->service_key];
            } else {
                $shipping_service_name = $item->service_name;
            }

            $item->woo_shipping = $order_data['shipping'];
            $shipping_method = $order->get_shipping_method();
            $item->default_shipping= "";
            if($shipping_method){
                $item->default_shipping = $shipping_method;
            }
            $ups_shipping_method = @array_shift($order->get_shipping_methods());
            $item->shipping_method_id = isset($ups_shipping_method['method_id']);

            switch ($type_get) {
                case 'export_csv':
                    $item->woo_order_status = $this->ups_eu_woo_convert_status($order->get_status());
                    $item->shipping_service_name = $shipping_service_name;
                    $item->woo_billing = $order_data[$this->var_billing];

                    $woo_product_text_list = '';
                    $woo_total_product = 0;
                    $woo_total_product_price = 0;
                    foreach ($order_items as $items_key => $items_value) {
                        $woo_product_price = intval($items_value['subtotal']);
                        $woo_total_product_price += intval($items_value['qty']) * $woo_product_price;

                        $woo_total_product += intval($items_value['qty']);
                        $woo_product_text_list .= $items_value['qty'] . ' x ' . $items_value['name'] . ', ';
                    }
                    $item->woo_product_text_list = rtrim($woo_product_text_list, ', ');
                    $item->woo_total_product = $woo_total_product;
                    $item->woo_total_product_price = $woo_total_product_price;
                    break;
                case 'order_detail':
                    $item->woo_order_status = $this->ups_eu_woo_convert_status($order->get_status());
                    $item->woo_billing = $order_data[$this->var_billing];

                    foreach ($order_items as $items_key => $items_value) {
                        $item->product[] = [
                            'qty' => $items_value['qty'],
                            'name' => $items_value['name']
                        ];
                    }
                    break;
                default:
                    foreach ($order_items as $items_key => $items_value) {
                        $item->product[] = [
                            'qty' => $items_value['qty'],
                            'name' => $items_value['name']
                        ];
                    }
                    $item->email = $order_data[$this->var_billing]['email'];
                    $item->phone = $order_data[$this->var_billing]['phone'];
                    break;
            }


            $item->currency_code = $order->get_currency();
            $item->total_price = $order->get_total();

            //add special key to shipping service show in front-end.
            $arrTrade = [
                'UPS 2nd Day Air',
                'UPS 2nd Day Air A.M'
            ];

            if ($item->service_symbol == '&trade;' && ! in_array($item->service_name, $arrTrade)) {
                $shipping_service_name = 'UPS Access Point&trade; Economy';
            } else {
                $arr1 = [
                    'UPS Ground'   => 'UPS&reg; Ground',
                    'UPS Standard' => 'UPS&reg; Standard',
                    'UPS Next Day Air Early' => 'UPS Next Day Air&reg; Early'
                ];
                $shipping_service_name = $item->service_name . $item->service_symbol;
                if (isset($arr1[$item->service_name])) {
                    $shipping_service_name = $arr1[$item->service_name];
                }
            }

            $item->shipping_service_text = $shipping_service_type . " (" . $shipping_service_name . ")";

            // get cod text, cod_amount, cod_currency, total_paid, accessorial_service_text
            $cod_text = $language['No'];
            $cod_amount = '';
            $cod_currency = '';
            $total_paid = filter_var(
                $item->total_price,
                FILTER_SANITIZE_NUMBER_FLOAT,
                FILTER_FLAG_ALLOW_FRACTION
            );

            if ($item->cod == 1) {
                $cod_text = $language['Yes'];
                $cod_amount = $total_paid;
                $cod_currency = $item->currency_code;
            }

            $accessorialValue = '';
            $accessorial_cod = '';
            $accessorial_array = [];
            $accessorialShipment = [];
            if (!empty($item->accessorial_service)) {
                $accessorial_service = (array) json_decode($item->accessorial_service);
                foreach ($accessorial_service as $key => $value) {
                    $accessorial_array[$key] = $common_translate[$key];
                }
            }
            $item->accessorial_translate = $accessorial_array;
            if (!empty($accessorial_array)) {
                $accessorialShipment = array_values($accessorial_array);
            }
            if ($item->cod == 1) {
                if (strtolower($item->service_type) == 'ap') {
                    $accessorialShipment[] = $common_translate['UPS_ACSRL_ACCESS_POINT_COD'];
                    $accessorial_cod = $common_translate['UPS_ACSRL_ACCESS_POINT_COD'];
                } else {
                    $accessorialShipment[] = $common_translate['UPS_ACSRL_TO_HOME_COD'];
                    $accessorial_cod = $common_translate['UPS_ACSRL_TO_HOME_COD'];
                }
            }
            $accessorialValue = implode(', ', $accessorialShipment);

            $item->cod_text = $cod_text;
            $item->cod_currency = $cod_currency;
            $item->cod_amount = $cod_amount;
            $item->total_paid = $total_paid;
            $item->total_paid_currency = wc_price($item->total_paid);
            $item->accessorial_service_text = $accessorialValue;

            //add front-end create shipment
            $item->accessorial_cod = $accessorial_cod;
        }
    }
    /*
     * Name function: ups_eu_woo_convert_status
     * Params:
     *  @status: type int
     * Return: type string
     * * */

    private function ups_eu_woo_convert_status($status)
    {
        $status = strtolower($status);
        $status_text = '';
        switch ($status) {
            case $this->var_cancelled:
                $status_text = 'Canceled';
                break;

            default:
                $status_text = ucfirst($status);
                break;
        }

        return $status_text;
    }
    /*
     * Name function: ups_eu_woo_shipment_list_delivery_address
     * Params:
     *  @item: type array
     * Return: type array
     * * */

    private function ups_eu_woo_shipment_list_delivery_address($item)
    {
        $dataObject = new \stdClass();
        $dataObject->name = "";
        $dataObject->address1 = $item->address1;
        $dataObject->address2 = $item->address2;
        $dataObject->address3 = $item->address3;
        $dataObject->city = $item->city;
        $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
        $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
        return $smarty->fetch($this->_tpl_delivery_address);
    }
    /*
     * Name function: ups_eu_woo_order_list_delivery_address
     * Params:
     *  @item: type array
     * Return: type array
     * * */

    private function ups_eu_woo_order_list_delivery_address($item)
    {
        $shipping_address = $item->woo_shipping;
        $dataObject = new \stdClass();
        if (strtolower(isset($item->service_type)) == 'ap') {
            $dataObject->name = $item->ap_name;
            $dataObject->address1 = $item->ap_address1;
            $dataObject->address2 = $item->ap_address2;
            $dataObject->address3 = $item->ap_address3;
            $dataObject->city = $item->ap_city;
        } else {
            $dataObject->name = "";
            $dataObject->address1 = $shipping_address[$this->var_address_1];
            $dataObject->address2 = $shipping_address[$this->var_address_2];
            $dataObject->address3 = "";
            $dataObject->city = $shipping_address['city'];
        }
        $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
        $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
        return $smarty->fetch($this->_tpl_delivery_address);
    }
    /*
     * Name function: ups_eu_woo_get_delivery_address
     * Params:
     *  @item: type array
     *  @page: type int
     *  @shipping_address: type array
     * Return: type array
     * * */

    private function ups_eu_woo_get_delivery_address($item, $page, $shipping_address)
    {
        $delivery_address = '';

        switch ($page) {
            case $this->var_shipment:
                $name = 'name';
                $address1 = 'address1';
                $address2 = 'address2';
                $address3 = 'address3';
                $city = 'city';
                break;

            default:
                $name = 'ap_name';
                $address1 = 'ap_address1';
                $address2 = 'ap_address2';
                $address3 = 'ap_address3';
                $city = 'ap_city';
                break;
        }
        $dataObject = new \stdClass();
        if (strtolower($item->service_type) == 'ap') {
            $dataObject->name = $item->{$name};
            $dataObject->address1 = $item->{$address1};
            $dataObject->address2 = $item->{$address2};
            $dataObject->address3 = $item->{$address3};
            $dataObject->city = $item->{$city};
        } else {
            $dataObject->name = "";
            $dataObject->address1 = $shipping_address[$this->var_address_1];
            $dataObject->address2 = $shipping_address[$this->var_address_2];
            $dataObject->address3 = "";
            $dataObject->city = $shipping_address['city'];
        }
        $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
        $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
        return $smarty->fetch($this->_tpl_delivery_address);
    }
    /*
     * Name function: ups_eu_woo_get_shipto_address
     * Params:
     *  @item: type array
     * Return: type array
     * * */

    private function ups_eu_woo_get_shipto_address($item)
    {
        $model_option = new Ups_Eu_Woo_Model_Options();
        $shipping_address = $item->woo_shipping;
        $shipto_address = [];
        $ap_address_text = '';
        $add_address_text = '';
        $state_name = '';

        if (strtolower($item->service_type) == 'ap') {
            $state_name = $model_option->get_state_name($item->ap_country, $item->ap_state);
            $state_post_city = $this->ups_eu_woo_add_array([$state_name, $item->ap_city, $item->ap_postcode]);
            $state_post_city = implode(', ', $state_post_city);
            $ap_name = '';
            if ($item->ap_name != '') {
                $ap_name = "<b>{$item->ap_name}</b>";
            }
            $ap_address_format = $this->ups_eu_woo_add_array([
                $ap_name,
                $item->ap_address1,
                $item->ap_address2,
                $item->ap_address3,
                $state_post_city,
                $model_option->get_country_name($item->ap_country),
                $item->email,
                $item->phone
            ]);
            $ap_address_text = implode('<br>', $ap_address_format);
        } else {
            $state_name = $model_option->get_state_name($shipping_address['country'], $shipping_address['state']);
            $state_post_city = $this->ups_eu_woo_add_array([$state_name, $shipping_address['city'], $shipping_address['postcode']]);

            $state_post_city = implode(', ', $state_post_city);
            $customer_name = '';
            if ($shipping_address['first_name'] != '' && $shipping_address['last_name'] != '') {
                $customer_name = "<b>{$shipping_address['first_name']} {$shipping_address['last_name']}</b>";
            }

            $customer_address = $this->ups_eu_woo_add_array([
                $customer_name,
                $shipping_address[$this->var_address_1],
                $shipping_address[$this->var_address_2],
                $state_post_city,
                $model_option->get_country_name($shipping_address['country']),
                $item->email,
                $item->phone
            ]);
            $add_address_text = implode('<br>', $customer_address);
        }
        $shipto_address['ap_address_text'] = $ap_address_text;
        $shipto_address['add_address_text'] = $add_address_text;
        return $shipto_address;
    }
    /*
     * Name function: addArray
     * Params:
     *  @array: type array
     * Return: type array
     * * */

    private function ups_eu_woo_add_array($array)
    {
        $array_return = [];
        foreach ($array as $key => $value) {
            if (!empty($value)) {
                $array_return[] = $value;
            }
        }
        return $array_return;
    }
    /*
     * Name function: ups_eu_woo_sort_field_order
     * Params:
     *  @order_by: type string
     *  @order_type: type string
     *  @conditions: type array
     * Return: type array
     * * */

    private function ups_eu_woo_sort_field_order($order_by, $order_type, $conditions)
    {
        switch ($order_by) {
            case 'date':
                $query = new \WC_Order_Query([
                    'orderby' => $order_by,
                    $this->var_order => $order_type,
                    'return' => 'ids',
                ]);
                $order_ids = $query->get_orders();
                break;

            case $this->var_order_time:
                # code...
                break;

            default:
                # code...
                break;
        }

        if (!empty($order_ids)) {
            $conditions[] = $this->var_order_id_woocommerce . ' IN (' . implode(',', $order_ids) . ')';
        }

        $order = [$this->var_order_id_woocommerce => $order_type];

        return [$order, $conditions];
    }
    /*
     * Name function: ups_eu_woo_pagination_total_record
     * Params:
     *  @status: type int
     *  @params: type array
     * Return: type int or false
     * * */

    public function ups_eu_woo_pagination_total_record($status, $params = [])
    {
        global $wpdb;
        $sqlSelect = "SELECT count(0) as total FROM `{$this->table_name}` where status = {$status}";
        try {
            $results = $wpdb->get_results($sqlSelect);
            if (count($results) > 0) {
                $objectResult = $results[0];
                $data = 0;
                if (!empty($objectResult->total)) {
                    $data = $objectResult->total;
                }
                return $data;
            }
            return 0;
        } catch (Exception $ex) {
            Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlSelect, $ex);
            return false;
        }
    }
    /*
     * Name function: ups_eu_woo_pagination_order_by
     * Params:
     *  @params: type array
     * Return: type array
     * * */

    public function ups_eu_woo_pagination_order_by($params = [])
    {
        return ["id" => "desc"];
    }
    /*
     * Name function: ups_eu_woo_set_to_archive_order
     * Params:
     *  @order_ids: type array
     * Return: type void
     * * */

    public function ups_eu_woo_set_to_archive_order($order_ids)
    {
        // foreach ($order_ids as $order_id) {
        //     $this->ups_eu_woo_update_status_woo($order_id, $this->var_cancelled);
        // }
        return $this->ups_eu_woo_update_all(['status' => 3], ['order_id_magento IN (' . implode(',', $order_ids) . ')']);
    }

    public function ups_eu_woo_set_to_comback_archive_order($order_ids)
    {
        // foreach ($order_ids as $order_id) {
        //     $this->ups_eu_woo_update_status_woo($order_id, 'on-hold');
        // }
        return $this->ups_eu_woo_update_all(['status' => 1], ['order_id_magento IN (' . implode(',', $order_ids) . ')']);
    }
    /*
     * Name function: ups_eu_woo_get_table_name
     * Params: empty
     * Return: type string
     * * */

    public function ups_eu_woo_get_table_name()
    {
        return $this->table_name;
    }
    /*
     * Name function: ups_eu_woo_update_status_woo
     * Params:
     *  @order_id: type int
     *  @status: type int
     * Return: type void
     * * */

    public function ups_eu_woo_update_status_woo($order_id, $status)
    {
        switch ($status) {
            case 'pending':
                $status = 'pending';
                break;
            case 'on-hold':
                $status = 'on-hold';
                break;
            case 'completed':
                $status = 'completed';
                break;
            case $this->var_cancelled:
                $status = $this->var_cancelled;
                break;
            default:
                $status = 'processing';
                break;
        }

        $order = new \WC_Order($order_id);
        if (!empty($order)) {
            $order->update_status($status);
        }
    }
    /*
     * Name function: ups_eu_woo_auto_move_status_order_archived
     * Params: empty
     * Return: type void
     * * */

    public function ups_eu_woo_auto_move_status_order_archived()
    {
        $sub_date = date($this->date_format_ymd, strtotime("-90 days", strtotime(date($this->date_format_ymd))));

        $query_str = " WHERE (`{$this->col_status}`=1 AND `{$this->col_date_created}`<='{$sub_date}')";
        $sql_update_status = "UPDATE `{$this->table_name}` SET `{$this->col_status}` = 3,
            `{$this->col_date_update}` = now() {$query_str}";

        /* Save to database */
        global $wpdb;
        try {
            $wpdb->query($sql_update_status);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function ups_eu_woo_auto_move_status_expired()
    {
        $model_shipments = new Ups_Eu_Woo_Model_Shipments();
        $str_list_shippemnt_id = "";
        $list_id_shpment = $model_shipments->ups_eu_woo_get_list_shipment_changed_status();
        if (count($list_id_shpment) > 0) {
            $str_list_shippemnt_id = "'" . implode("','", $model_shipments->ups_eu_woo_get_list_shipment_changed_status()) . "'";
        }
        $sub_date = date($this->date_format_ymd, strtotime("-90 days", strtotime(date($this->date_format_ymd))));

        $tmp_conditions = [];
        /* check  case from shipment */
        if (strlen($str_list_shippemnt_id) > 0) {
            $tmp_conditions[] = "(`{$this->col_shipment_id}` IN ({$str_list_shippemnt_id}))";
        }
        /* Check case open order status is 3 to 4 by date update */
        $tmp_conditions[] = "(`{$this->col_status}`=3 AND `{$this->col_date_update}`<='{$sub_date}')";
        $str_where = " WHERE " . implode(" OR ", $tmp_conditions);

        $sql_update_status = "UPDATE `{$this->table_name}` SET `{$this->col_status}` = 4 {$str_where}";
        /* Save to database */
        global $wpdb;
        try {
            $wpdb->query($sql_update_status);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}
