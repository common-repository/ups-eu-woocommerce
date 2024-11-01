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
 * ups-eu-woo-model-accessorial.php - The core plugin class.
 *
 * This is used to define the Accessorial Model.
 */

include_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Model_Accessorial');

class Ups_Eu_Woo_Model_Accessorial extends entities\Ups_Eu_Woo_Accessorial_Entity implements Ups_Eu_Woo_Interfaces
{
    private $table_name = "";
    private $key_id = "";
    //------------atributes fields----------------
    public $id;
    public $accessorial_key;
    public $accessorial_name;
    public $accessorial_code;
    public $show_config;
    public $show_shipping;

    /**
     * Name function: __construct
     * Params: empty
     * Return: void
     */
    public function __construct()
    {
        parent::__construct();
        global $wpdb;
        $this->table_name = "{$wpdb->prefix}{$this->prefix_ups}accessorial";
        $this->key_id = $this->col_id;
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
        $tmpArray[$this->col_accessorial_key] = $this->accessorial_key;
        $tmpArray[$this->col_accessorial_name] = $this->accessorial_name;
        $tmpArray[$this->col_accessorial_code] = $this->accessorial_code;
        $tmpArray[$this->col_show_config] = $this->show_config;
        $tmpArray[$this->col_show_shipping] = $this->show_shipping;
        return $tmpArray;
    }
    /*
     * Name function: save
     * Param: empty
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
     *  @coditions: type array
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
     * Name function: ups_eu_woo_get_by_id
     * Params: type int
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
     *  @order: type array
     * * */

    public function get_list_data_by_condition($conditions = [], $limit = 'all', $order = [])
    {
        return $this->ups_eu_woo_base_get_list_data_by_condition($this->table_name, $conditions, $limit, $order);
    }

    /**
     * Name function: ups_eu_woo_get_list_checked
     * Params:
     * @sat_deli_flg: type boolean
     * Return: object
     * */
    public function ups_eu_woo_get_list_checked($sat_deli_flg = false)
    {
        $list = $this->ups_eu_woo_base_get_list_data_by_condition($this->table_name, [
            "$this->col_show_config = 1",
            "$this->col_show_shipping = 1"
        ]);
        if ($sat_deli_flg === true) {
            $list = $this->ups_eu_woo_base_get_list_data_by_condition($this->table_name, [
                "($this->col_show_config = 1 AND $this->col_show_shipping = 1) OR ($this->col_accessorial_key = 'UPS_ACSRL_STATURDAY_DELIVERY')"
            ]);
        }
        $result = [];
        if (!empty($list)) {
            foreach ($list as $data) {
                $result[$data->accessorial_key] = $data->accessorial_name;
            }
        }

        if (count($result) > 0) {
            return json_encode($result);
        } else {
            return '';
        }
    }
    /*
     * Name function: ups_eu_woo_get_all
     * Params: empty
     * Return: array object
     * * */

    public function ups_eu_woo_get_all()
    {
        return $this->ups_eu_woo_base_get_all($this->table_name);
    }

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
     * Return: array or true
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
     * Return: void
     * * */

    public function ups_eu_woo_merge_array($data)
    {
        $this->ups_eu_woo_base_convert_array_to_object($data, $this);
    }
    /*
     * Name function: ups_eu_woo_check_existing
     * Params: empty
     * Return: type object
     */

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
