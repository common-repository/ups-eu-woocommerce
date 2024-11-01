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
 * ups-eu-woo-model-tracking.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Model_Tracking Model.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Model_Tracking');

class Ups_Eu_Woo_Model_Tracking extends entities\Ups_Eu_Woo_Tracking_Entity implements Ups_Eu_Woo_Interfaces
{
    private $table_name = "";
    private $key_id = "id";
    //------------atributes fields----------------
    public $id;
    public $tracking_number;
    public $shipment_number;
    public $status;
    public $order_id;
    public $package_detail;

    /*
     * Name function: __construct
     * Params: empty
     * Return: void
     * * */

    public function __construct()
    {
        parent::__construct();
        global $wpdb;
        $this->table_name = "{$wpdb->prefix}{$this->prefix_ups}tracking";
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
        $tmpArray[$this->col_tracking_number] = $this->tracking_number;
        $tmpArray[$this->col_shipment_number] = $this->shipment_number;
        $tmpArray[$this->col_status] = $this->status;
        $tmpArray[$this->col_order_id] = $this->order_id;
        $tmpArray[$this->col_package_detail] = $this->package_detail;
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
     * Name function: ups_eu_woo_get_by_id
     * Params:
     *  @id: type int
     * Return: type object class or false
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
     * Return: type array object
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
     * Return: type array or false
     * * */

    public function ups_eu_woo_validate()
    {
        $tmpValidate = [];
        if (empty($this->tracking_number)) {
            $tmpValidate[$this->col_tracking_number][$this->msg_error] = __(
                "tracking_number is empty",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }

        if (empty($this->shipment_number)) {
            $tmpValidate[$this->col_shipment_number][$this->msg_error] = __(
                "shipment_number is empty",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }

        if (empty($this->status)) {
            $tmpValidate[$this->col_status][$this->msg_error] = __(
                "status is empty",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }

        if (empty($this->order_id)) {
            $tmpValidate[$this->col_order_id][$this->msg_error] = __(
                "order_id is empty",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }

        if (empty($this->package_detail)) {
            $tmpValidate[$this->col_package_detail][$this->msg_error] = __(
                "package_detail is empty",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
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
     * Name function: ups_eu_woo_get_table_name
     * Params: empty
     * Return: type string
     * * */

    public function ups_eu_woo_get_table_name()
    {
        return $this->table_name;
    }
}
