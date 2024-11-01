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
 * ups-eu-woo-model-fallback-rates.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Fallback_Rates Model.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Fallback_Rates');

class Ups_Eu_Woo_Fallback_Rates extends entities\Ups_Eu_Woo_Fallback_Rates_Entity implements Ups_Eu_Woo_Interfaces
{

    private $table_name = "";
    private $key_id = "id";
    //------------atributes fields----------------
    public $id;
    public $service_type;
    public $service_id;
    public $fallback_rate;

    /*
     * Name function: __construct
     * Params: empty
     * Return: void
     * * */
    public function __construct()
    {
        parent::__construct();
        global $wpdb;
        $this->table_name = "{$wpdb->prefix}{$this->prefix_ups}fallback_rates";
        $this->key_id = $this->col_id;
    }

    /*
     * Name function: ups_eu_woo_convert_to_array
     * Params: empty
     * Return: array object
     * * */
    public function ups_eu_woo_convert_to_array()
    {
        $tmpArray = [];
        $tmpArray[$this->col_id] = $this->id;
        $tmpArray[$this->col_service_type] = "ADD";
        $tmpArray[$this->col_service_id] = $this->service_id;
        $tmpArray[$this->col_fallback_rate] = $this->fallback_rate;
        return $tmpArray;
    }

    /*
     * Name function: save
     * Params: empty
     * Return: type boolean
     * * */
    public function ups_eu_woo_save()
    {
        $result = false;
        /* check validate */
        if ($this->ups_eu_woo_validate() === true) {
            /* convert data to array */
            $dataArray = $this->ups_eu_woo_convert_to_array();
            /* save data to database */
            $check_save_id = $this->ups_eu_woo_base_save($dataArray, $this->table_name, $this->key_id);
            if ($check_save_id > 0) {
                $result = true;
            }
        }
        return $result;
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
     * Name function: ups_eu_woo_get_all
     * Params:
     *  @id: type int
     * Return: type array
     * * */
    public function ups_eu_woo_get_all()
    {
        return (array)$this->ups_eu_woo_base_get_all($this->table_name);
    }

    /*
     * Name function: get_list_data_by_condition
     * Params:
     *  @conditions: type array
     *  @limit: type string
     * Return: type array object
     * * */
    public function get_list_data_by_condition($conditions = [], $limit = 'all', $joins = [])
    {
        return $this->ups_eu_woo_base_get_list_data_by_condition($this->table_name, $conditions, $limit, [], $joins);
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
        return $this->ups_eu_woo_base_delete_all($this->table_name, $conditions);
    }

    /*
     * Name function: validate
     * Params: empty
     * Return: type array or false
     * * */
    public function ups_eu_woo_validate()
    {
        $check = true;
        if (trim($this->fallback_rate) == '') {
            $check = false;
        } else {
            if (!preg_match($this->var_pattern, $this->fallback_rate)) {
                $check = false;
            } else {
                $check_fallback_rate = floatval($this->fallback_rate);
                if (($check_fallback_rate < 0) || ($check_fallback_rate > 9999.99)) {
                    $check = false;
                }
            }
        }
        return $check;
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
     * Name function: ups_eu_woo_get_table_name
     * Params: empty
     * Return: type string
     *
     * * */
    public function ups_eu_woo_get_table_name()
    {
        return $this->table_name;
    }
}
