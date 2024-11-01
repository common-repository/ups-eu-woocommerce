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
 * ups-eu-woo-model-package-default.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Model_Package_Default Model.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Model_Package_Default');

class Ups_Eu_Woo_Model_Package_Default extends entities\Ups_Eu_Woo_Package_Default_Entity implements Ups_Eu_Woo_Interfaces
{
    private $table_name = "";
    private $key_id = "package_id";
    //------------atributes fields----------------
    public $package_id;
    public $package_name;
    public $weight;
    public $unit_weight;
    public $length;
    public $width;
    public $height;
    public $unit_dimension;
    public $package_item;

    /*
     * Name function: __construct
     * Params: empty
     * Return: void
     * * */

    public function __construct()
    {
        parent::__construct();
        global $wpdb;
        $this->table_name = "{$wpdb->prefix}{$this->prefix_ups}package_default";
        $this->key_id = $this->col_package_id;
    }
    /*
     * Name function: ups_eu_woo_convert_to_array
     * Params: empty
     * Return: type array
     * * */

    public function ups_eu_woo_convert_to_array()
    {
        $tmpArray = [];
        $tmpArray[$this->col_package_id] = $this->package_id;
        $tmpArray[$this->col_package_name] = $this->package_name;
        $tmpArray[$this->col_weight] = $this->weight;
        $tmpArray[$this->col_unit_weight] = $this->unit_weight;
        $tmpArray[$this->col_length] = $this->length;
        $tmpArray[$this->col_width] = $this->width;
        $tmpArray[$this->col_height] = $this->height;
        $tmpArray[$this->col_unit_dimension] = $this->unit_dimension;
        $tmpArray[$this->col_package_item] = $this->package_item;

        return $tmpArray;
    }
    /*
     * Name function: ups_eu_woo_get_all
     * Params: empty
     * Return: type array
     * * */

    public function ups_eu_woo_get_all()
    {
        return $this->ups_eu_woo_base_get_all($this->table_name);
    }
    /*
     * Name function: save
     * Params: empty
     * Return: type boolean
     * * */

    public function ups_eu_woo_check_package($dataArray)
    {
        /* check validate */
        $returnValidate = $this->ups_eu_woo_validate_package($dataArray);
        return $returnValidate;
    }
    /*
     * Name function: save
     * Params: empty
     * Return: type boolean
     * * */

    public function ups_eu_woo_save_package($dataArray)
    {
        /* check validate */
        $check_save_id = $this->ups_eu_woo_base_save_package($dataArray, $this->table_name, $this->key_id);
        if ($check_save_id > 0) {
            /* set package id after save it */
            $this->{$this->key_id} = $check_save_id;
            return true;
        }
    }
    /*
     * Name function: save
     * Params: empty
     * Return: type boolean
     * * */

    public function ups_eu_woo_save()
    {
        /* check validate */
        if ($this->ups_eu_woo_validate() === true) {
            /* convert data to array */
            $dataArray = $this->ups_eu_woo_convert_to_array();
            /* save data to database */
            $check_save_id = $this->ups_eu_woo_base_save($dataArray, $this->table_name, $this->key_id);
            if ($check_save_id > 0) {
                /* set package id after save it */
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
            /* get package by id */
            $result_array = $this->ups_eu_woo_base_get_by_id($id, $this->table_name, $this->key_id);
            /* convert result data to object */
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

    public function get_list_data_by_condition($conditions = [], $limit = 'all')
    {
        return $this->ups_eu_woo_base_get_list_data_by_condition($this->table_name, $conditions, $limit);
    }
    /*
     * Name function: get_final_data_by_condition
     * Params:
     *  @conditions: type array
     *  @limit: type string
     * Return: type array object or false
     * * */

    public function get_final_data_by_condition($conditions = [], $limit = '1', $order = [])
    {
        return $this->ups_eu_woo_base_get_list_data_by_condition($this->table_name, $conditions, $limit, $order);
    }

    /*
     * Name function: get_final_data_by_condition
     * Params:
     *  @conditions: type array
     *  @limit: type string
     * Return: type array object or false
     * * */

    public function get_all_item_by_package($conditions = [], $limit = '1', $order = [], $select = '*')
    {
        $arr_condition_items = $this->ups_eu_woo_base_get_list_data_by_condition($this->table_name, $conditions, $limit, $order, [], $select);

        $arr_item_exist = [];
        foreach ($arr_condition_items as $item) {
            $arr_item_exist[] = $item->package_item;
        }
        return $arr_item_exist;
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

    public function ups_eu_woo_validate_package($package_dimension)
    {
        global $wpdb;
        $tmpValidate = [];
        $result = true;
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        // only 1 package
        if (is_null($package_dimension[0])) {
            $tmp_package = [];
            $tmp_package[] = $package_dimension;
            $package_dimension = $tmp_package;
        }

        foreach ($package_dimension as $key => $value) {
            /* validate package weight is empty */
            if (empty($value['weight'])) {
                $tmpValidate[$key][$this->col_weight][$this->msg_error] = __(
                    "weight is empty",
                    \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                );
            }
            /* validate package length is empty */
            if (empty($value['length'])) {
                $tmpValidate[$key][$this->col_length][$this->msg_error] = __(
                    "length is empty",
                    \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                );
            }
            /* validate package width is empty */
            if (empty($value['width'])) {
                $tmpValidate[$key][$this->col_width][$this->msg_error] = __(
                    "width is empty",
                    \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                );
            }
            /* validate package height is empty */
            if (empty($value['height'])) {
                $tmpValidate[$key][$this->col_height][$this->msg_error] = __(
                    "height is empty",
                    \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                );
            }
            /* validate weight value */
            if (($value['weight'] < 0.01) || !$this->ups_eu_woo_is_numeric($value['weight'])) {
                $tmpValidate[$this->col_weight][$this->msg_error] = __(
                    "weight value invalid",
                    \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                );
            }
            /* validate weight value */
            $max_weight = 154.32;
            $weight_error = __("Error! Maximum allowable per package weight is 70.00 kgs or 154.32 lbs.", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);

            if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
                if ('US' == $model_config->value) {
                    $max_weight = 150;
                    $weight_error = __("Error! Maximum allowable weight per package weight is 150lbs.", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
                }
            }
            if (($value['weight'] > 70 && $this->unit_weight == 'kgs') || ($value['weight'] > $max_weight && $this->unit_weight == 'lbs')) {
                $tmpValidate['weight_error'] = $weight_error;
            }

            if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
                if (('US' == $model_config->value) && ($this->unit_dimension == 'inch') && (($value['length'] > 108) || ($value['width'] > 108) || ($value['height'] > 108))) {
                    $tmpValidate['dimension_error'] = __("Error! Maximum allowable package length is 108 inches", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
                }
            }
            /* validate length value */
            if (($value['length'] < 0.01) || ($value['length'] > 9999.99) || !$this->ups_eu_woo_is_numeric($value['length'])) {
                $tmpValidate[$key][$this->col_length][$this->msg_error] = __(
                    "length value invalid",
                    \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                );
            }
            /* validate width value */
            if (($value['width'] < 0.01) || ($value['width'] > 9999.99) || !$this->ups_eu_woo_is_numeric($value['width'])) {
                $tmpValidate[$key][$this->col_width][$this->msg_error] = __(
                    "width value invalid",
                    \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                );
            }
            /* validate height value */
            if (($value['height'] < 0.01) || ($value['height'] > 9999.99) || !$this->ups_eu_woo_is_numeric($value['height'])) {
                $tmpValidate[$key][$this->col_height][$this->msg_error] = __(
                    "height value invalid",
                    \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                );
            }
            /* validate weight value */
            $dimension = $value['length']*1 + ($value['width'] * 2) + ($value['height'] * 2);
            $max_limit = 157.48;
            $dimension_error = __("Error! Package exceeds the maximum allowable size of 400 cm or 157.48 inches (the maximum allowable size calculation = length + 2 * width + 2 * height).", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
            if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
                if ('US' == $model_config->value) {
                    $max_limit = 165;
                    $dimension_error = __("Error! Package exceeds the maximum allowable size of 165 inches (the maximum allowable size calculation = length + 2 * width + 2 * height).", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
                }
            }
            if (($dimension > 400 && $this->unit_dimension == 'cm') || ($dimension > $max_limit && $this->unit_dimension == 'inch')) {
                $tmpValidate['dimension_error'] = $dimension_error;
            }
            /* check validate package value */
            if (!empty($tmpValidate)) {
                $result = true;
                if (count($tmpValidate) > 0) {
                    $result = $tmpValidate;
                    break;
                }
            }
        }
        return $result;
    }

    /*
     * Name function: validate
     * Params: empty
     * Return: type array or false
     * * */

    public function ups_eu_woo_validate()
    {
        global $wpdb;
        $tmpValidate = [];
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        /* validate package name is empty */
        if (empty($this->package_name)) {
            $tmpValidate[$this->col_package_name][$this->msg_error] = __(
                "package name is empty",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
        /* validate package weight is empty */
        if (empty($this->weight)) {
            $tmpValidate[$this->col_weight][$this->msg_error] = __(
                "weight is empty",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
        /* validate package length is empty */
        if (empty($this->length)) {
            $tmpValidate[$this->col_length][$this->msg_error] = __(
                "length is empty",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
        /* validate package width is empty */
        if (empty($this->width)) {
            $tmpValidate[$this->col_width][$this->msg_error] = __(
                "width is empty",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
        /* validate package height is empty */
        if (empty($this->height)) {
            $tmpValidate[$this->col_height][$this->msg_error] = __(
                "height is empty",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
        /* check empty validate */
        if (!empty($tmpValidate)) {
            $result = true;
            if (count($tmpValidate) > 0) {
                $result = $tmpValidate;
            }
            return $result;
        }

        // check validate min, max lenght
        if ((strlen($this->package_name) < 1 || strlen($this->package_name) > 50)) {
            $tmpValidate[$this->col_package_name][$this->msg_error] = __(
                "package name value invalid",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
        /* validate weight value */
        if (($this->weight < 0.01) || !$this->ups_eu_woo_is_numeric($this->weight)) {
            $tmpValidate[$this->col_weight][$this->msg_error] = __(
                "weight value invalid",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
        /* validate weight value */
        $max_weight = 154.32;
        $weight_error = __("Error! Maximum allowable per package weight is 70.00 kgs or 154.32 lbs.", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);

        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            if ('US' == $model_config->value) {
                $max_weight = 150;
                $weight_error = __("Error! Maximum allowable weight per package weight is 150lbs.", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
            }
        }
        if (($this->weight > 70 && $this->unit_weight == 'kgs') || ($this->weight > $max_weight && $this->unit_weight == 'lbs')) {
            $tmpValidate['weight_error'] = $weight_error;
        }

        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            if (('US' == $model_config->value) && ($this->unit_dimension == 'inch') && (($this->length > 108) || ($this->width > 108) || ($this->height > 108))) {
                $tmpValidate['dimension_error'] = __("Error! Maximum allowable package length is 108 inches", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
            }
        }
        /* validate length value */
        if (($this->length < 0.01) || ($this->length > 9999.99) || !$this->ups_eu_woo_is_numeric($this->length)) {
            $tmpValidate[$this->col_length][$this->msg_error] = __(
                "length value invalid",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
        /* validate width value */
        if (($this->width < 0.01) || ($this->width > 9999.99) || !$this->ups_eu_woo_is_numeric($this->width)) {
            $tmpValidate[$this->col_width][$this->msg_error] = __(
                "width value invalid",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
        /* validate height value */
        if (($this->height < 0.01) || ($this->height > 9999.99) || !$this->ups_eu_woo_is_numeric($this->height)) {
            $tmpValidate[$this->col_height][$this->msg_error] = __(
                "height value invalid",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
        /* validate weight value */
        $dimension = $this->length*1 + ($this->width * 2) + ($this->height * 2);
        $max_limit = 157.48;
        $dimension_error = __("Error! Package exceeds the maximum allowable size of 400 cm or 157.48 inches (the maximum allowable size calculation = length + 2 * width + 2 * height).", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            if ('US' == $model_config->value) {
                $max_limit = 165;
                $dimension_error = __("Error! Package exceeds the maximum allowable size of 165 inches (the maximum allowable size calculation = length + 2 * width + 2 * height).", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
            }
        }
        if (($dimension > 400 && $this->unit_dimension == 'cm') || ($dimension > $max_limit && $this->unit_dimension == 'inch')) {
            $tmpValidate['dimension_error'] = $dimension_error;
        }
        /* check validate package value */
        if (!empty($tmpValidate)) {
            $result = true;
            if (count($tmpValidate) > 0) {
                $result = $tmpValidate;
            }
            return $result;
        }

        // check package name exist
        $package_name_esc_sql = esc_sql($this->package_name);
        if (!empty($this->package_id)) {
            $packages = $this->get_list_data_by_condition(
                ["BINARY upper({$this->col_package_name}) = upper('{$package_name_esc_sql}')" .
                    " AND package_id != '$this->package_id'"]
            );
        } else {
            $packages = $this->get_list_data_by_condition(
                ["BINARY upper({$this->col_package_name}) = upper('{$package_name_esc_sql}')"]
            );
        }
        /* set package error message validate */
        if (!empty($packages)) {
            $tmpValidate[$this->col_package_name][$this->msg_error] = __(
                "package name value invalid",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
            $tmpValidate["msg_common_error"] = __(
                "The name Package is exist.",
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
        $this->package_name = stripslashes($this->package_name);
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
     * Name function: ups_eu_woo_is_numeric
     * Params:
     *  @number: type string
     * Return: type boolean
     * * */

    public function ups_eu_woo_is_numeric($number)
    {
        $num = explode(".", $number);
        if (!is_numeric($number)) {
            //if (!is_numeric($number) || (isset($num[1]) && strlen($num[1]) > 2)) {
            return false;
        } else {
            return true;
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
}
