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
 * ups-eu-woo-model-log-frontend.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Model_Log_Frontend Model.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Model_Log_Frontend');

class Ups_Eu_Woo_Model_Log_Frontend extends entities\Ups_Eu_Woo_Log_Frontend_Entity implements Ups_Eu_Woo_Interfaces
{
    private $table_name = "";
    private $key_id = "id";
    //------------atributes fields----------------
    public $id;
    public $ups_eu_woocommerce_key;
    public $content_encode_json;
    public $date_created;

    public function __construct()
    {
        parent::__construct();
        global $wpdb;
        $this->table_name = "{$wpdb->prefix}{$this->prefix_ups}log_frontend";
        $this->key_id = $this->col_id;
    }

    public function ups_eu_woo_convert_to_array()
    {
        $tmpArray = [];
        $tmpArray[$this->col_id] = $this->id;
        $tmpArray[$this->col_ups_eu_woocommerce_key] = $this->ups_eu_woocommerce_key;
        $tmpArray[$this->col_content_encode_json] = $this->content_encode_json;
        $tmpArray[$this->col_date_created] = $this->date_created;
        return $tmpArray;
    }

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

    public function update_data_content_by_woocommerce_key($ups_eu_woocommerce_key, $array_fields_key_value)
    {
        $ups_eu_woocommerce_key = sanitize_text_field($ups_eu_woocommerce_key);
        if (strlen($ups_eu_woocommerce_key) <= 0 || count($array_fields_key_value) <= 0) {
            return false;
        }

        $this->id = $this->get_by_ups_eu_woocommerce_key($ups_eu_woocommerce_key);
        $this->ups_eu_woocommerce_key = $ups_eu_woocommerce_key;
        $object_json = new \stdClass();
        if ($this->id > 0) {
            $object_json = json_decode($this->content_encode_json);
        }
        if (!is_object($object_json)) {
            $object_json = new \stdClass();
        }
        foreach ($array_fields_key_value as $key => $value) {
            $key = trim($key);
            $key = preg_replace('/[^A-Za-z0-9\_]/', '', $key);
            if (strlen($key) > 0) {
                $object_json->{$key} = "";
                if (!empty($value)) {
                    $object_json->{$key} = $value;
                }
            }
        }
        $this->content_encode_json = json_encode($object_json);
        $this->date_created = date($this->date_format_ymd_time, current_time($this->timestamp, 0));
        if ($this->ups_eu_woo_save()) {
            return true;
        }
        return false;
    }

    public function get_by_ups_eu_woocommerce_key($ups_eu_woocommerce_key)
    {
        global $wpdb;
        $ups_eu_woocommerce_key = sanitize_text_field($ups_eu_woocommerce_key);
        $ups_eu_woocommerce_key = $wpdb->_escape($ups_eu_woocommerce_key);
        $sqlSelect = "SELECT * FROM `{$this->table_name}` WHERE" .
            " `{$this->col_ups_eu_woocommerce_key}`='{$ups_eu_woocommerce_key}'";
        try {
            $results = $wpdb->get_results($sqlSelect);
            if (count($results) > 0) {
                $objectResult = $results[0];
                $result_array = (array) $objectResult;
                $this->ups_eu_woo_base_convert_array_to_object($result_array, $this);
                return $this->id;
            }
            return 0;
        } catch (Exception $ex) {
            Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlSelect, $ex);
            return 0;
        }
    }

    public function get_list_data_by_condition($conditions = [], $limit = 'all')
    {
        return $this->ups_eu_woo_base_get_list_data_by_condition($this->table_name, $conditions, $limit);
    }

    public function ups_eu_woo_delete($id)
    {
        $id = intval($id);
        if ($id > 0) {
            return $this->ups_eu_woo_base_delete($id, $this->table_name, $this->key_id);
        }
        return false;
    }

    public function ups_eu_woo_validate()
    {
        $tmpValidate = [];
        $result = true;
        if (count($tmpValidate) > 0) {
            $result = $tmpValidate;
        }
        return $result;
    }

    public function ups_eu_woo_merge_array($data)
    {
        $this->ups_eu_woo_base_convert_array_to_object($data, $this);
    }

    public function ups_eu_woo_check_existing()
    {
        return $this->ups_eu_woo_base_check_existing($this->table_name);
    }

    public function ups_eu_woo_get_table_name()
    {
        return $this->table_name;
    }

    public function ups_eu_woo_auto_remove()
    {
        $date_after = date($this->date_format_ymd, strtotime("-5 days", strtotime(date($this->date_format_ymd, current_time($this->timestamp, 0)))));
        global $wpdb;
        $sql_remove = "DELETE FROM `{$this->table_name}` WHERE `{$this->col_date_created}`<='{$date_after}'";
        try {
            $wpdb->query($sql_remove);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}
