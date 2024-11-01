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
 * ups-eu-woo-model-config.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Model_Config Model.
 */

include_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Model_Config');

class Ups_Eu_Woo_Model_Config extends entities\Ups_Eu_Woo_Config_Entity implements Ups_Eu_Woo_Interfaces
{
    private $table_name = "";
    private $key_id = "config_id";
    /* ------------atributes fields---------------- */
    public $config_id;
    public $scope;
    public $scope_id;
    public $key;
    public $value;

    /*
     * Name function: __constuct
     * Params: empty
     * Return: void
     * * */

    public function __construct()
    {
        parent::__construct();
        global $wpdb;
        $this->table_name = "{$wpdb->prefix}{$this->prefix_ups}config";
        $this->key_id = $this->col_config_id;
    }
    /*
     * Name function: ups_eu_woo_convert_to_array
     * Params: empty
     * Return: array
     * * */

    public function ups_eu_woo_convert_to_array()
    {
        $tmpArray = [];
        $tmpArray[$this->col_config_id] = $this->config_id;
        $tmpArray[$this->col_scope] = $this->scope;
        $tmpArray[$this->col_scope_id] = $this->scope_id;
        $tmpArray[$this->col_key] = $this->key;
        $tmpArray[$this->col_value] = $this->value;
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
            if (isset($dataArray['ups_account_password'])) {
                unset($dataArray['ups_account_password']);
            }
            if (isset($dataArray['col_ups_account_password'])) {
                unset($dataArray['col_ups_account_password']);
            }
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
     * Name function: get_list_date_by_condition
     * Params:
     *  @conditions: type array
     *  @limit: type string
     * Return: get array object
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
     * Name function: validate
     * Params: empty
     * Return: type array or true
     * * */

    public function ups_eu_woo_validate()
    {
        $tmpValidate = [];
        if (empty($this->key)) {
            $tmpValidate[$this->col_key][$this->msg_error] = __(
                "key is empty",
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
     * Return: void
     * * */

    public function ups_eu_woo_merge_array($data)
    {
        $this->ups_eu_woo_base_convert_array_to_object($data, $this);
    }
    /*
     * Name function: ups_eu_woo_check_existing
     * Params: empty
     * Return: object
     * * */

    public function ups_eu_woo_check_existing()
    {
        return $this->ups_eu_woo_base_check_existing($this->table_name);
    }
    /*
     * Name function: ups_eu_woo_get_by_key
     * Params:
     *  @key: type string
     * Return: type boolean
     * * */

    public function ups_eu_woo_get_by_key($key)
    {
        $key = trim(strip_tags($key));
        if (strlen($key) > 0) {
            global $wpdb;
            $sqlSelect = "SELECT * FROM `{$this->table_name}` WHERE `key`='{$key}'";
            try {
                /* get result data in database */
                $results = $wpdb->get_results($sqlSelect);
            } catch (Exception $ex) {
                Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlSelect, $ex);
            }
            $result_array = [];
            /* check result data is not empty */
            if (count($results) > 0) {
                $objectResult = $results[0];
                $result_array = (array)$objectResult;
            }
            /* convert result data from array to object */
            $this->ups_eu_woo_base_convert_array_to_object($result_array, $this);
            if (trim($this->key ?? '') === trim($key ?? '')) {
                return true;
            }
            return false;
        }
        return false;
    }
    /*
     * Name function: ups_eu_woo_get_value_by_key
     * Params:
     *  @key: type string
     * Return: type boolean
     * * */

    public function ups_eu_woo_get_value_by_key($key)
    {
        $key = trim(strip_tags($key));
        if (strlen($key) > 0) {
            global $wpdb;
            $sqlSelect = "SELECT * FROM `{$this->table_name}` WHERE `key`='{$key}'";
            try {
                $results = $wpdb->get_results($sqlSelect);
            } catch (Exception $ex) {
                Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlSelect, $ex);
            }
            $result_array = [];
            if (count($results) > 0) {
                return $results[0]->value;
            }
        }
        return false;
    }
    /*
     * Name function: ups_eu_woo_set_value_config_by_key
     * Params:
     *  @key: type string
     *  @value: type string
     *  @type: type tring
     * Return: void
     * * */

    public function ups_eu_woo_set_value_config_by_key($key, $value, $type = "normal")
    {
        switch ($type) {
            case "normal":
                if ($this->ups_eu_woo_get_by_key("{$key}") === true) {
                    $this->value = $value;
                    return $this->ups_eu_woo_save();
                }
                return false;
            case "save":
                if ($this->ups_eu_woo_get_by_key("{$key}") === true && intval($this->value) === 2) {
                    $this->value = 1;
                    return $this->ups_eu_woo_save();
                }
                return false;
            case "next":
                if ($this->ups_eu_woo_get_by_key("{$key}") === true && intval($this->value) === 0) {
                    $this->value = 2;
                    return $this->ups_eu_woo_save();
                }
                return false;
            case "new_or_overwrite":
                if ($this->ups_eu_woo_get_by_key("{$key}") === true) {
                    $this->value = $value;
                    return $this->ups_eu_woo_save();
                }else{
                    $this->key = $key;
                    $this->value = $value;
                    return $this->ups_eu_woo_save();
                }            
            default:
                break;
        }
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
     * Name function: ups_eu_woo_get_cut_off_time
     * Params: empty
     * Return: type string
     * * */

    public function ups_eu_woo_get_cut_off_time()
    {
        /* get Cut Off Time */
        $this->ups_eu_woo_get_by_key($this->CUT_OFF_TIME);

        $pickup_date = '';
        /* format pickup date */
        if (!empty($this->value)) {
            $cut_off_time = $this->value;
            if ((int) date('H', current_time('timestamp', 0)) < (int)$cut_off_time) {
                $pickup_date = date("Ymd");
            } else {
                $pickup_date = date('Ymd', strtotime("+1 day"));
            }
        }
        return $pickup_date;
    }
    /*
     * Name function: ups_eu_woo_created_key_merchant
     * Params: empty
     * Return: type string
     * * */

    public function ups_eu_woo_created_key_merchant()
    {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $sub = '-';
        /* group 1 with 8 character */
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        /* group 2 with 4 character */
        $randomString .= $sub;
        for ($i = 0; $i < 4; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        /* group 3 with 4 character */
        $randomString .= $sub;
        for ($i = 0; $i < 4; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        /* group 4 with 4 character */
        $randomString .= $sub;
        for ($i = 0; $i < 4; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        /* group 5 with 12 character */
        $randomString .= $sub;
        for ($i = 0; $i < 12; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
