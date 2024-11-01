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
 * License.php - The core plugin class.
 *
 * This is used to define the License Model.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Model_License');

class Ups_Eu_Woo_Model_License extends entities\Ups_Eu_Woo_License_Entity implements Ups_Eu_Woo_Interfaces
{
    private $table_name = "";
    private $key_id = "id";
    //------------atributes fields----------------
    public $id;
    public $AccessLicenseText;
    public $Username;
    public $Password;
    public $AccessLicenseNumber;

    /*
     * Name function: __construct
     * Params: empty
     * Return: void
     * * */

    public function __construct()
    {
        parent::__construct();
        global $wpdb;
        $this->table_name = "{$wpdb->prefix}{$this->prefix_ups}license";
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
        $tmpArray[$this->col_AccessLicenseText] = $this->AccessLicenseText;
        $tmpArray[$this->col_Username] = $this->Username;
        $tmpArray[$this->col_pass_data] = $this->Password;
        $tmpArray[$this->col_AccessLicenseNumber] = $this->AccessLicenseNumber;
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

    /**
     * ups_eu_woo_save_html
     * @param $dataArray : data for save
     * */
    public function ups_eu_woo_save_html($dataArray)
    {
        try {
            global $wpdb;
            $wpdb->insert(
                $this->table_name,
                $dataArray,
                ["%s"]
            );
        } catch (Exception $ex) {
            Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log("ups_eu_woo_save_html", $ex);
            return false;
        }
    }
    /*
     * Name function: ups_eu_woo_get_by_id
     * Params:
     *  @id: type int
     * Return: type object or false
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
     * Name function: ups_eu_woo_get_licence_config
     * Params: empty
     * Return: object class
     * * */

    public function ups_eu_woo_get_licence_config()
    {
        $result_array = $this->ups_eu_woo_base_get_first($this->table_name);
        $this->ups_eu_woo_base_convert_array_to_object($result_array, $this);
        return $this;
    }
    /*
     * Name function: get_list_data_by_condition
     * Params:
     *  @conditions: type array
     *  @limit: type string
     * Return: type array or false
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
     * Return: type array or false
     * * */

    public function ups_eu_woo_validate()
    {
        $tmpValidate = [];
        if (empty($this->AccessLicenseText)) {
            $tmpValidate[$this->col_AccessLicenseText][$this->msg_error] = __(
                "AccessLicenseText is empty",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
        if (empty($this->Username)) {
            $tmpValidate[$this->col_Username][$this->msg_error] = __(
                "Username is empty",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
        if (empty($this->Password)) {
            $tmpValidate[$this->col_pass_data][$this->msg_error] = __(
                "Password is empty",
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
     * Return: type object class
     * * */

    public function ups_eu_woo_merge_array($data)
    {
        $this->ups_eu_woo_base_convert_array_to_object($data, $this);
    }
    /*
     * Name function: ups_eu_woo_check_existing
     * Params: empty
     * Return: type object class
     * * */

    public function ups_eu_woo_check_existing()
    {
        return $this->ups_eu_woo_base_check_existing($this->table_name);
    }
    /*
     * Name function: ups_eu_woo_update_by_field
     * Params:
     *  @data: type array
     * Return: type boolean
     * * */

    public function ups_eu_woo_update_by_field($data)
    {
        if (count($data) > 0) {
            //`Username`='323232',`Password`='dsdsdsds',`AccessLicenseNumber`=''
            $tmp_update = [];
            foreach ($data as $key => $value) {
                $tmp_update[] = "`{$key}`='{$value}'";
            }
            $str_update = implode(" , ", $tmp_update);
            global $wpdb;
            $sqlUpdate = "UPDATE  `{$this->table_name}` SET {$str_update} WHERE {$this->col_id}=1";
            try {
                $wpdb->query($sqlUpdate);
                return true;
            } catch (Exception $ex) {
                Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlUpdate, $ex);
                return false;
            }
        }
        return false;
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
