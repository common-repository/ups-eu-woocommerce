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
 * ups-eu-woo-model-delivery-rates.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Delivery_Rates Model.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Delivery_Rates');

class Ups_Eu_Woo_Delivery_Rates extends entities\Ups_Eu_Woo_Delivery_Rates_Entity implements Ups_Eu_Woo_Interfaces
{

    private $table_name = "";
    private $key_id = "id";
    //------------atributes fields----------------
    public $id;
    public $service_id;
    public $rate_type;
    public $min_order_value;
    public $delivery_rate;
    public $rate_country;
    public $rate_rule;

    /*
     * Name function: __construct
     * Params: empty
     * Return: void
     * * */

    public function __construct()
    {
        parent::__construct();
        global $wpdb;
        $this->table_name = "{$wpdb->prefix}{$this->prefix_ups}delivery_rates";
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
        $tmpArray[$this->col_service_id] = $this->service_id;
        $tmpArray[$this->col_rate_type] = $this->rate_type;
        $tmpArray[$this->col_min_order_value] = $this->min_order_value;
        $tmpArray[$this->col_delivery_rate] = $this->delivery_rate;
        $tmpArray[$this->col_rate_country] = $this->rate_country;
        $tmpArray[$this->col_rate_rule] = $this->rate_rule;
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
        if (empty($this->service_id)) {
            $tmpValidate[$this->col_service_id][$this->msg_error] = __(
                "service_id is empty",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
        switch ($this->rate_type) {
            case 1:
                if (!preg_match($this->var_pattern, $this->min_order_value)) {
                    $tmpValidate[$this->col_min_order_value][$this->msg_error] = __(
                        "min_order_value invalid",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    );
                } else {
                    $check_min_order_value = floatval($this->min_order_value);
                    if (($check_min_order_value < 0) || ($check_min_order_value > 9999.99)) {
                        $tmpValidate[$this->col_min_order_value][$this->msg_error] = __(
                            "min_order_value invalid",
                            \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                        );
                    }
                }
                if (!preg_match($this->var_pattern, $this->delivery_rate)) {
                    $tmpValidate[$this->col_delivery_rate][$this->msg_error] = __(
                        $this->var_delivery_rate_invalid,
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    );
                } else {
                    $check_delivery_rate = floatval(sanitize_text_field($this->delivery_rate));
                    if (($check_delivery_rate < 0) || ($check_delivery_rate > 9999.99)) {
                        $tmpValidate[$this->col_delivery_rate][$this->msg_error] = __(
                            $this->var_delivery_rate_invalid,
                            \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                        );
                    }
                }
                break;
            case 2:
                if (!preg_match($this->var_pattern, $this->delivery_rate)) {
                    $tmpValidate[$this->col_delivery_rate][$this->msg_error] = __(
                        $this->var_delivery_rate_invalid,
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    );
                } else {
                    $check_delivery_rate = floatval($this->delivery_rate);
                    if (($check_delivery_rate < 1.00) || ($check_delivery_rate > 1000.00)) {
                        $tmpValidate[$this->col_delivery_rate][$this->msg_error] = __(
                            $this->var_delivery_rate_invalid,
                            \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                        );
                    }
                }
                break;
            default:
                break;
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
     * Return: type boolean
     * * */

    public function ups_eu_woo_check_existing()
    {
        return $this->ups_eu_woo_base_check_existing($this->table_name);
    }
    /*
     * Name function: ups_eu_woo_check_validate_in_array
     * Params:
     *  @array_items: type array
     *  @key_sevice_id: type int
     * Return: type boolean
     * * */

    private function ups_eu_woo_check_validate_in_array($array_items, $key_sevice_id)
    {
        foreach ($array_items as $item) {
            if (intval($item[$this->col_service_id]) === intval($key_sevice_id) &&
                $item[$this->var_validate] !== true) {
                return true;
            }
        }
        return false;
    }
    /*
     * Name function: ups_eu_woo_check_validate_by_select
     * Params:
     *  @delivery_rate_flat: type array object
     *  @delivery_rate_real_time: type array object
     *  @select_type: type array
     * Return: type boolean
     * * */

    public function ups_eu_woo_check_validate_by_select($delivery_rate_flat, $delivery_rate_real_time, $select_type)
    {
        $check = false;
        foreach ($select_type as $key_sevice_id => $item_type) {
            $type = intval($item_type["type"]);
            switch ($type) {
                case 1:
                    if ($check === true) {
                        return true;
                    }
                    $delivery_rate_list = $delivery_rate_flat[$key_sevice_id];
                    $check = $this->ups_eu_woo_check_validate_in_array($delivery_rate_list, $key_sevice_id);
                    break;
                case 2:
                    if ($check === true) {
                        return true;
                    }
                    $delivery_rate_item = $delivery_rate_real_time[$key_sevice_id];
                    if ($delivery_rate_item[$this->var_validate] !== true) {
                        $check = true;
                    } else {
                        $check = false;
                    }
                    break;
                default:
                    break;
            }
        }
        return $check;
    }
    /*
     * Name function: ups_eu_woo_delete_by_type_and_service_id
     * Params:
     *  @rate_type: type string
     *  @service_id: type int
     *  @delivery_rate_flat: type array
     * Return: type boolean
     * * */

    private function ups_eu_woo_delete_by_type_and_service_id($rate_type, $service_id, $delivery_rate_flat = [])
    {
        global $wpdb;
        switch ($rate_type) {
            case 1:
                $sqlDelete = "DELETE FROM `{$this->table_name}` WHERE `service_id`='{$service_id}' AND rate_type=2";
                try {
                    $wpdb->query($sqlDelete);
                    $list_ids = [];
                    $tmp_destroy = array_reduce(
                        $delivery_rate_flat[$service_id],
                        function ($results, $item) use (&$list_ids) {
                            if (strlen($item[$this->col_id]) < 36 && intval($item[$this->col_id]) > 0) {
                                $list_ids[$item[$this->col_id]] = $item[$this->col_id];
                            }
                            return $results;
                        }
                    );
                    if (count($list_ids) > 0) {
                        $strl_list_id = implode(",", $list_ids);
                        $sqlDelete2 = "DELETE FROM `{$this->table_name}` WHERE `service_id`='{$service_id}' AND" .
                            " `id` not in({$strl_list_id})";
                        $wpdb->query($sqlDelete2);
                    }
                    return true;
                } catch (Exception $ex) {
                    Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlDelete, $ex);
                    return false;
                }
                break;
            case 2:
                $sqlDelete = "DELETE FROM `{$this->table_name}` WHERE `service_id`='{$service_id}' AND rate_type=1";
                try {
                    $wpdb->query($sqlDelete);
                    return true;
                } catch (Exception $ex) {
                    Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlDelete, $ex);
                    return false;
                }
                break;
            default:
                break;
        }
        $rate_type = intval($rate_type);
        $service_id = intval($service_id);
        if (($rate_type > 0) && ($service_id > 0)) {

        }
    }
    /*
     * Name function: ups_eu_woo_save_all
     * Params:
     *  @delivery_rate_flat: type array object
     *  @delivery_rate_real_time: type array object
     *  @select_type: type array
     * Return: type boolean
     * * */

    public function ups_eu_woo_save_all($delivery_rate_flat, $delivery_rate_real_time, $select_type)
    {
        foreach ($select_type as $key_sevice_id => $item_type) {
            $type = intval($item_type["type"]);
            switch ($type) {
                case 1:
                    /* start coloum added */
                    global $wpdb;
                    $exist = $wpdb->get_results("SHOW COLUMNS FROM `".$wpdb->prefix."ups_shipping_delivery_rates` LIKE 'rate_country'");
                    if(!$exist){
                        $sql_add_col1 = "ALTER TABLE ".$wpdb->prefix."ups_shipping_delivery_rates ADD rate_country varchar(10) DEFAULT NULL";
                        $sql_add_col2 = "ALTER TABLE ".$wpdb->prefix."ups_shipping_delivery_rates ADD rate_rule varchar(10) DEFAULT NULL";
                        $wpdb->query($sql_add_col1);
                        $wpdb->query($sql_add_col2);
                    }
                    /* end */
                    $delivery_rate_list = $delivery_rate_flat[$key_sevice_id];
                    $this->ups_eu_woo_delete_by_type_and_service_id(1, $key_sevice_id, $delivery_rate_flat);
                    foreach ($delivery_rate_list as $item) {
                    
                        if (intval($item[$this->col_service_id]) === intval($key_sevice_id)) {
                            $this->ups_eu_woo_merge_array($item);
                            if (strlen($this->id) === 36) {
                                $this->id = '';
                            }
                            $this->ups_eu_woo_save();
                        }
                    }
                    break;
                case 2:
                    /* start coloum added */
                    global $wpdb;
                    $exist = $wpdb->get_results("SHOW COLUMNS FROM `".$wpdb->prefix."ups_shipping_delivery_rates` LIKE 'rate_country'");
                    if(!$exist){
                        $sql_add_col1 = "ALTER TABLE ".$wpdb->prefix."ups_shipping_delivery_rates ADD rate_country varchar(10) DEFAULT NULL";
                        $sql_add_col2 = "ALTER TABLE ".$wpdb->prefix."ups_shipping_delivery_rates ADD rate_rule varchar(10) DEFAULT NULL";
                        $wpdb->query($sql_add_col1);
                        $wpdb->query($sql_add_col2);
                    }
                    /* end */
                    $delivery_rate_item = $delivery_rate_real_time[$key_sevice_id];
                    $delivery_rate_item['rate_country'] = "";
                    $delivery_rate_item['rate_rule'] = "";
                    $delivery_rate_item['min_order_value'] = "0";
                    $this->ups_eu_woo_merge_array($delivery_rate_item);
                    if (strlen($this->id) === 36) {
                        $this->id = '';
                    }
                    $this->ups_eu_woo_delete_by_type_and_service_id(2, $key_sevice_id);
                    $this->ups_eu_woo_save();
                    break;
                default:
                    break;
            }
        }
        return true;
    }
    /*
     * Name function: ups_eu_woo_check_duplicate_by_service
     * Params:
     *  @list_item_by_services: type array object
     *  @min_order_value: type float
     * Return: type boolean
     * * */

    private function ups_eu_woo_check_duplicate_by_service($list_item_by_services, $min_order_value)
    {
        return false;
        // $check_duplicate = 0;
        // foreach ($list_item_by_services as $item) {
        //     if (floatval($item[$this->col_min_order_value]) === floatval($min_order_value)) {
        //         $check_duplicate++;
        //     }
        // }
        // $check = false;
        // if ($check_duplicate >= 2) {
        //     $check = true;
        // }
        // return $check;
    }
    /*
     * Name function: ups_eu_woo_format_validate_array_type_flat
     * Params:
     *  @delivery_rate_flat: type array object
     * Return: type array object
     * * */

    public function ups_eu_woo_format_validate_array_type_flat($delivery_rate_flat)
    {
        foreach ($delivery_rate_flat as $key => &$list_item) {
            foreach ($list_item as &$item) {
                $this->ups_eu_woo_merge_array($item);
                $validate = $this->ups_eu_woo_validate();
                $item[$this->col_delivery_rate] = $this->delivery_rate;
                $item[$this->col_min_order_value] = $this->min_order_value;
                $item[$this->col_rate_country] = $this->rate_country;
                $item[$this->col_rate_rule] = $this->rate_rule;
                if ($validate === true) {
                    /* check duplicate */
                    if ($this->ups_eu_woo_check_duplicate_by_service($list_item, $this->min_order_value) === true) {
                        $tmpValidate = [];
                        $tmpValidate[$this->col_min_order_value][$this->msg_error] = __(
                            "The minimum thresholds can not be the same",
                            \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                        );
                        $tmpValidate[$this->col_min_order_value][$this->var_is_show_error] = 1;
                        $item[$this->var_validate] = $tmpValidate;
                    } else {
                        $item[$this->var_validate] = $validate;
                    }
                } else {
                    $item[$this->var_validate] = $validate;
                }
            }
        }
        return $delivery_rate_flat;
    }
    /*
     * Name function: ups_eu_woo_format_validate_array_type_real_time
     * Params:
     *  @delivery_rate_real_time: type array object
     * Return: type array object
     * * */

    public function ups_eu_woo_format_validate_array_type_real_time($delivery_rate_real_time)
    {
        foreach ($delivery_rate_real_time as &$item) {
            $this->ups_eu_woo_merge_array($item);
            $validate = $this->ups_eu_woo_validate();
            $item[$this->col_delivery_rate] = $this->delivery_rate;
            $item[$this->col_min_order_value] = $this->min_order_value;
            $item[$this->col_rate_country] = $this->rate_country;
            $item[$this->col_rate_rule] = $this->rate_rule;
            $item[$this->var_validate] = $validate;
        }
        return $delivery_rate_real_time;
    }
    /*
     * Name function: ups_eu_woo_array_reduce_delivery_rate_all
     * Params:
     *  @dataObject: type object
     *  @list_rate_type: type array object
     * Return: type array object
     *
     * * */

    private function ups_eu_woo_array_reduce_delivery_rate_all($dataObject, &$list_rate_type)
    {
        $tmp_destroy = array_reduce(
            $dataObject->delivery_rate_all,
            function ($results, $list_item) use (&$list_rate_type) {
                if (count($list_item) > 0) {
                    foreach ($list_item as $item_list_sub) {
                        if (count($item_list_sub) > 0) {
                            foreach ($item_list_sub as $item) {
                                $list_rate_type["{$item[$this->col_service_id]}"] = $item[$this->col_rate_type];
                            }
                        }
                    }
                }
                return $results;
            }
        );
        return $tmp_destroy;
    }
    /*
     * Name function: ups_eu_woo_init_delivery_rates
     * Params:
     *  @select_type: type array
     *  @delivery_rate_flat: type array object
     *  @delivery_rate_real_time: type array object
     *  @check_validate_all: type boolean
     *  @dataObject: type object
     * Return: type array object
     *
     * * */

    public function ups_eu_woo_init_delivery_rates(
        &$select_type,
        &$delivery_rate_flat,
        &$delivery_rate_real_time,
        &$check_validate_all,
        &$dataObject,
        $country_code
    ) {
        $dataObject->delivery_rate_all = $this->get_list_data_by_condition([]);
        $dataObject->isCountryCode = $country_code;
        $us_default_rate = 0;
        if (empty($dataObject->delivery_rate_all) && 'us' == strtolower($country_code)) {
            $us_default_rate = 1;
        }
        $dataObject->delivery_rate_all = array_reduce($dataObject->delivery_rate_all, function ($results, $item) {
            if (intval($item->rate_type) !== 1) {
                $rate_type = $this->var_realtime;
            } else {
                $rate_type = "flat";
            }
            $item->validate = 1;
            $results["{$rate_type}"][$item->service_id][$item->id] = (array) $item;
            return $results;
        });

        if (!empty($select_type)) {
            $dataObject->select_type = $select_type;
        } else {
            $list_rate_type = [];
            if ($dataObject->delivery_rate_all && count($dataObject->delivery_rate_all) > 0) {
                $tmp_destroy = $this->ups_eu_woo_array_reduce_delivery_rate_all($dataObject, $list_rate_type);
            }
            $dataObject->select_type = array_reduce(
                $dataObject->services,
                function ($results, $item) use ($list_rate_type, $us_default_rate) {
                    $tmp = [];
                    if (!empty($list_rate_type[$item->id])) {
                        $tmp["type"] = $list_rate_type[$item->id];
                    } else {
                        if (1 == $us_default_rate) {
                            $tmp["type"] = 2;
                        } else {
                            $tmp["type"] = 1;
                        }
                    }
                    $results[$item->id] = $tmp;
                    return $results;
                }
            );
        }
        if (!empty($delivery_rate_flat)) {
            $dataObject->delivery_rate_flat = $delivery_rate_flat;
        } else {
            $dataObject->delivery_rate_flat = [];
            if (!empty($dataObject->delivery_rate_all["flat"])) {
                $dataObject->delivery_rate_flat = $dataObject->delivery_rate_all["flat"];
            }
        }
        $tmp_destroy = array_reduce($dataObject->services, function ($results, $item) use (&$dataObject) {
            if (empty($dataObject->delivery_rate_flat[$item->id])) {
                $dataObject->delivery_rate_flat[$item->id]["empty_flat_{$item->id}"] = [
                    $this->col_id => "empty_flat_{$item->id}",
                    $this->col_service_id => $item->id,
                    $this->col_rate_type => 1,
                    $this->col_min_order_value => "0",
                    $this->col_delivery_rate => "0",
                    $this->col_rate_country = "0",
                    $this->col_rate_rule = "0",
                    $this->var_validate => 1
                ];
            }
            return $results;
        });

        if (!empty($delivery_rate_real_time)) {
            $dataObject->delivery_rate_real_time = $delivery_rate_real_time;
        } else {
            $dataObject->delivery_rate_real_time = [];
            if (!empty($dataObject->delivery_rate_all[$this->var_realtime])) {
                $dataObject->delivery_rate_real_time = $dataObject->delivery_rate_all[$this->var_realtime];
            }
            $tmp_destroy = array_reduce(
                $dataObject->delivery_rate_real_time,
                function ($results, $list_item) use (&$dataObject) {
                    foreach ($list_item as $item) {
                        $dataObject->delivery_rate_real_time["{$item[$this->col_service_id]}"] = $item;
                    }
                    return $results;
                }
            );
        }
        $tmp_destroy = array_reduce($dataObject->services, function ($results, $item) use (&$dataObject) {
            if (empty($dataObject->delivery_rate_real_time[$item->id])) {
                $dataObject->delivery_rate_real_time[$item->id] = [
                    $this->col_id => "empty_real_time{$item->id}",
                    $this->col_service_id => $item->id,
                    $this->col_rate_type => 2,
                    $this->col_min_order_value => "",
                    $this->col_delivery_rate => "100",
                    $this->col_rate_country = "",
                    $this->col_rate_rule = "",
                    $this->var_validate => 1
                ];
            }
            return $results;
        });
        $dataObject->check_validate_all = $check_validate_all;
    }
    /*
     * Name function: ups_eu_woo_duplicate_flat_rate
     * Params:
     *  @delivery_rate_flat: type array
     * Return: type boolean
     *
     * * */

    public function ups_eu_woo_duplicate_flat_rate($delivery_rate_flat)
    {
        foreach ($delivery_rate_flat as $list_service) {
            foreach ($list_service as $item) {
                if (isset($item[$this->var_validate][$this->col_min_order_value][$this->var_is_show_error]) &&
                    $item[$this->var_validate][$this->col_min_order_value][$this->var_is_show_error] === 1) {
                    return $item[$this->var_validate][$this->col_min_order_value];
                }
            }
        }
        return false;
    }
    /*
     * Name function: ups_eu_woo_get_min_max_delivery_by_service_id
     * Params:
     *  @service_id: type int
     * Return: type object or false
     *
     * * */

    public function ups_eu_woo_get_min_max_delivery_by_service_id($service_id)
    {
        global $wpdb;
        $sqlSelect = "SELECT * FROM `{$this->table_name}` WHERE" .
            " service_id='{$service_id}' ORDER BY min_order_value ASC";
        try {
            $results = $wpdb->get_results($sqlSelect);
            return $results;
        } catch (Exception $ex) {
            Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlSelect, $ex);
            return false;
        }
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
