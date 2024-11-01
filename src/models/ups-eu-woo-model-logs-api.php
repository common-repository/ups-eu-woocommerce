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
 * ups-eu-woo-model-logs-api.php - The core plugin class.
 *
 * This is used to define the LogsApi Model.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Model_Logs_Api');

class Ups_Eu_Woo_Model_Logs_Api extends entities\Ups_Eu_Woo_Logs_Api_Entity implements Ups_Eu_Woo_Interfaces
{

    private $table_name = "";
    private $key_id = "id";
    //------------atributes fields----------------
    public $id;
    public $method;
    public $full_uri;
    public $request;
    public $response;
    public $time_request;
    public $time_response;
    private $plugin_manager_url = "fa-upsecpluginstools-proto.azurewebsites.net";

    public function __construct()
    {
        parent::__construct();
        global $wpdb;
        $this->table_name = "{$wpdb->prefix}{$this->prefix_ups}logs_api";
        $this->key_id = $this->col_id;
    }

    public function ups_eu_woo_convert_to_array()
    {
        $tmpArray = [];
        $tmpArray[$this->col_id] = $this->id;
        $tmpArray[$this->col_method] = $this->method;
        $tmpArray[$this->col_full_uri] = $this->full_uri;
        $tmpArray[$this->col_request] = $this->request;
        $tmpArray[$this->col_response] = $this->response;
        $tmpArray[$this->col_time_request] = $this->time_request;
        $tmpArray[$this->col_time_response] = $this->time_response;
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

    public function get_list_data_by_condition($conditions = [], $limit = 'all', $orders = [])
    {
        if (empty($orders)) {
            $orders = [$this->col_id => "desc"];
        }
        return $this->ups_eu_woo_base_get_list_data_by_condition($this->table_name, $conditions, $limit, $orders);
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

    /**
     *  params:
     * +  $name_method:type tring
     */
    public function ups_eu_woo_before_log_api($name_method)
    {
        $this->time_request = date("{$this->date_format_ymd_time}", current_time($this->timestamp, 0));
        $this->method = $name_method;
        $this->ups_eu_woo_save();
    }

    /**
     *  params:
     * +  $url:type tring
     * +  $request: type object
     * +  $response:$type object
     */
    public function ups_eu_woo_after_log_api($data_all)
    {
        $url = "";
        if (!empty($data_all["{$this->col_full_uri}"])) {
            $url = $data_all["{$this->col_full_uri}"];
        }
        $request = "";
        if (!empty($data_all["{$this->col_request}"])) {
            $request = $data_all["{$this->col_request}"];
        }
        $response = "";
        if (!empty($data_all["{$this->col_response}"])) {
            $response = $data_all["{$this->col_response}"];
        }
        $this->full_uri = $url;
        if (is_object($request) || is_array($request)) {
            $this->request = json_encode($request);
        } else {
            $this->request = $request;
        }
        if (is_object($response) || is_array($response)) {
            $this->response = json_encode($response);
        } else {
            $this->response = $response;
        }
        $this->time_response = date("{$this->date_format_ymd_time}", current_time($this->timestamp, 0));
        $this->ups_eu_woo_save();
    }
    /*
     * Name function: ups_eu_woo_auto_remove
     * Params: empty
     * Return: void
     * * */

    public function ups_eu_woo_auto_remove()
    {
        $date_after = date($this->date_format_ymd, strtotime("-5 days", strtotime(date($this->date_format_ymd, current_time($this->timestamp, 0)))));
        global $wpdb;
        $sql_remove = "DELETE FROM `{$this->table_name}` WHERE `{$this->col_time_response}`<='{$date_after}'";
        try {
            $wpdb->query($sql_remove);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    /*
     * Name function: ups_eu_woo_pagination_list_data
     * Params:
     *  @page: type int
     *  @params: type array
     * Return: type array object
     * * */

    public function ups_eu_woo_pagination_list_data($params = [])
    {
        $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
        $data_print_dump = "data_print_dump";
        $list = $this->get_list_data_by_condition(["`{$this->col_full_uri}` NOT LIKE '%{$this->plugin_manager_url}%'"], $params["limit"], $params["order"]);
        $tmp_list = [];
        foreach ($list as &$item) {
            if (strlen($item->request) > 0) {
                $item->request = json_decode($item->request);
                if (is_object($item->request)) {
                    $smarty->assign($data_print_dump, $item->request);
                    $item->str_request = $smarty->fetch("admin/merchant_cf/common/var_dump.tpl");
                } else {
                    $item->str_request = "";
                }
            }
            if (strlen($item->response) > 0) {
                $item->response = json_decode($item->response);
                if (is_object($item->response)) {
                    $smarty->assign($data_print_dump, $item->response);
                    $item->str_response = $smarty->fetch("admin/merchant_cf/common/var_dump.tpl");
                } else {
                    $item->str_response = "";
                }
            }
            $item->{$this->col_time_request} = date_i18n(get_option($this->var_date_format), strtotime($item->{$this->col_time_request})) . " " . date_i18n(get_option($this->var_time_format), strtotime($item->{$this->col_time_request}));
            $item->{$this->col_time_response} = date_i18n(get_option($this->var_date_format), strtotime($item->{$this->col_time_response})) . " " . date_i18n(get_option($this->var_time_format), strtotime($item->{$this->col_time_response}));
            $tmp_list[$item->id] = $item;
        }
        return $tmp_list;
    }
    /*
     * Name function: ups_eu_woo_count_data
     * Params:
     *  @page: type int
     *  @status: type int
     * Return: type int
     * * */

    public function ups_eu_woo_count_data()
    {
        return count($this->get_list_data_by_condition(["`{$this->col_full_uri}` NOT LIKE '%{$this->plugin_manager_url}%'"]));
    }
}
