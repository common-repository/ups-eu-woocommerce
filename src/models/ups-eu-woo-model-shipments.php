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
 * ups-eu-woo-model-shipments.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Model_Shipments Model.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Model_Shipments');

class Ups_Eu_Woo_Model_Shipments extends entities\Ups_Eu_Woo_Shipments_Entity implements Ups_Eu_Woo_Interfaces
{
    private $table_name = "";
    private $key_id = "id";
    //------------atributes fields----------------
    public $id;
    public $shipment_number;
    public $create_date;
    public $status;
    public $cod;
    public $shipping_fee;
    public $order_value;
    public $accessorial_service;
    public $shipping_service;
    public $name;
    public $address1;
    public $address2;
    public $address3;
    public $state;
    public $postcode;
    public $city;
    public $country;
    public $phone;
    public $email;
    public $access_point_id;
    public $order_selected;

    /*
     * Name function: __construct
     * Params: empty
     * Return: void
     * * */

    public function __construct()
    {
        parent::__construct();
        global $wpdb;
        $this->table_name = "{$wpdb->prefix}{$this->prefix_ups}shipments";
        $this->key_id = $this->col_id;
    }
    /*
     * Name function: ups_eu_woo_convert_to_array
     * Params: empty
     * Return: array
     * * */

    public function ups_eu_woo_convert_to_array()
    {
        $tmpArray = [];
        $tmpArray[$this->col_id] = $this->id;
        $tmpArray[$this->col_shipment_number] = $this->shipment_number;
        $tmpArray[$this->col_create_date] = $this->create_date;
        $tmpArray[$this->col_status] = $this->status;
        $tmpArray[$this->col_cod] = $this->cod;
        $tmpArray[$this->col_shipping_fee] = $this->shipping_fee;
        $tmpArray[$this->col_order_value] = $this->order_value;
        $tmpArray[$this->col_accessorial_service] = $this->accessorial_service;
        $tmpArray[$this->col_shipping_service] = $this->shipping_service;
        $tmpArray[$this->col_name] = $this->name;
        $tmpArray[$this->col_address1] = $this->address1;
        $tmpArray[$this->col_address2] = $this->address2;
        $tmpArray[$this->col_address3] = $this->address3;
        $tmpArray[$this->col_state] = $this->state;
        $tmpArray[$this->col_postcode] = $this->postcode;
        $tmpArray[$this->col_city] = $this->city;
        $tmpArray[$this->col_country] = $this->country;
        $tmpArray[$this->col_phone] = $this->phone;
        $tmpArray[$this->col_email] = $this->email;
        $tmpArray[$this->col_access_point_id] = $this->access_point_id;
        $tmpArray[$this->col_order_selected] = $this->order_selected;

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
     * Name function: save
     * Params:
     *  @id: type int
     * Return: type object class of false
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
     * Return: type boolean
     * * */

    public function get_list_data_by_condition($conditions = [], $limit = 'all')
    {
        return $this->ups_eu_woo_base_get_list_data_by_condition($this->table_name, $conditions, $limit);
    }
    /*
     * Name function: delete
     * Params:
     *  @id: type int
     * Return: type boolean
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
     * Name function: ups_eu_woo_delete_all
     * Params:
     *  @conditions: type array
     * Return: type boolean
     * * */

    public function ups_eu_woo_delete_all($conditions = [])
    {
        if (!empty($conditions)) {
            return $this->ups_eu_woo_base_delete_all($this->table_name, $conditions);
        }
        return false;
    }
    /*
     * Name function: validate
     * Params: empty
     * Return: type array or true
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
     * Return: type object class
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
     * Name function: ups_eu_woo_pagination_total_record
     * Params:
     *  @params: type array
     * Return: type int or false
     * * */

    public function ups_eu_woo_pagination_total_record($params = [])
    {
        global $wpdb;
        $sqlSelect = "SELECT count(0) as total FROM `{$this->table_name}`";
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
     * Return: type string
     * * */

    public function ups_eu_woo_pagination_order_by($params = [])
    {
        return ["{$this->col_id}" => "desc"];
    }
    /*
     * Name function: ups_eu_woo_cancel_order_shipmment_woo
     * Params:
     *  @order_id: type int
     * Return: void
     * * */

    public function ups_eu_woo_cancel_order_shipmment_woo($order_id)
    {
        $order = new \WC_Order($order_id);
        if (!empty($order)) {
            $order->update_status('processing');
        }
    }
    /*
     * Name function: ups_eu_woo_get_table_name
     * Params: empty
     * Return: string
     * * */

    public function ups_eu_woo_get_table_name()
    {
        return $this->table_name;
    }
    /*
     * Name function: ups_eu_woo_get_list_shipment_changed_status
     * Params: empty
     * Return: type array
     * * */

    public function ups_eu_woo_get_list_shipment_changed_status()
    {
        global $wpdb;
        $last_date = date($this->date_format_ymd, strtotime("-90 days", strtotime(date($this->date_format_ymd))));
        $sqlSelect = "SELECT `id` FROM `{$this->table_name}` WHERE `create_date` <= '{$last_date}' ";
        try {
            $results = $wpdb->get_results($sqlSelect);
            if (!empty($results)) {
                foreach ($results as &$result_items) {
                    $result_items = $result_items->id;
                }
            }
            return $results;
        } catch (Exception $ex) {
            Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlSelect, $ex);
            return [];
        }
    }
}
