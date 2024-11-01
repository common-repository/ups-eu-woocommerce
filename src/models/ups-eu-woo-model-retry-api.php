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
 * ups-eu-woo-model-retry-api.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Model_Retry_Api Model.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Model_Retry_Api');

class Ups_Eu_Woo_Model_Retry_Api extends entities\Ups_Eu_Woo_Retry_Api_Entity implements Ups_Eu_Woo_Interfaces
{

    private $table_name = "";
    private $key_id = "id_retry";
    //------------atributes fields----------------
    public $id_retry;
    public $key_api;
    public $data_api;
    public $count_retry;
    public $date_created;
    public $date_update;
    public $method_name;

    /*
     * Name function: __construct
     * Params: empty
     * Return: void
     * * */

    public function __construct()
    {
        parent::__construct();
        global $wpdb;
        $this->table_name = "{$wpdb->prefix}{$this->prefix_ups}retry_api";
        $this->key_id = $this->col_id_retry;
    }
    /*
     * Name function: ups_eu_woo_convert_to_array
     * Params: empty
     * Return: type array
     * * */

    public function ups_eu_woo_convert_to_array()
    {
        $tmpArray = [];
        $tmpArray[$this->col_id_retry] = $this->id_retry;
        $tmpArray[$this->col_key_api] = $this->key_api;
        $tmpArray[$this->col_data_api] = $this->data_api;
        $tmpArray[$this->col_count_retry] = $this->count_retry;
        $tmpArray[$this->col_date_created] = $this->date_created;
        $tmpArray[$this->col_date_update] = $this->date_update;
        $tmpArray[$this->col_method_name] = $this->method_name;
        return $tmpArray;
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
                /* set id after save it */
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
     *  @id: tyype int
     * Return: type object or false
     * * */

    public function ups_eu_woo_get_by_id($id)
    {
        $id = intval($id);
        if ($id > 0) {
            /* get data by id */
            $result_array = $this->ups_eu_woo_base_get_by_id($id, $this->table_name, $this->key_id);
            /* convert result data from array to object */
            $this->ups_eu_woo_base_convert_array_to_object($result_array, $this);
            return $this;
        }
        return false;
    }
    /*
     * Name function: get_list_data_by_condition
     * Params:
     *  @conditions: type array
     *  @limit: tyype string
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
     * Name function: delete
     * Params:
     *  @id: type int
     * Return: type boolean
     * * */

    public function ups_eu_woo_delete_all()
    {
        try {
            global $wpdb;
            $table_name = $this->table_name;
            $sqlDelete = "truncate `{$table_name}`";
            $wpdb->query($sqlDelete);
            return true;
        } catch (Exception $ex) {
            Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlDelete, $ex);
            return false;
        }
    }
    /*
     * Name function: validate
     * Params: empty
     * Return: type array or false
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
     *  @data: array
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
    /*
     * Name function: ups_eu_woo_get_table_name
     * Params: empty
     * Return: type string
     * * */

    public function ups_eu_woo_load_api_manage_library()
    {
        return new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Manage_Api_Ups();
    }
    /*
     * Name function: ups_eu_woo_update_merchant_status_remove_account
     * Params:
     *  @account_number: type string
     * Return: void
     * * */

    public function ups_eu_woo_update_merchant_status_remove_account($account_number)
    {
        $upsapi_manage = $this->ups_eu_woo_load_api_manage_library();
        /* updateMerchantStatus for remove account */
        $upsapi_manage->ups_eu_woo_update_merchant_status_remove_account($account_number);
    }
    /*
     * Name function: ups_eu_woo_transfer_merchant_info_by_user
     * Params:
     *  @account_number: type string
     * Return: void
     * * */

    public function ups_eu_woo_transfer_merchant_info_by_user($account_number)
    {
        $upsapi_manage = $this->ups_eu_woo_load_api_manage_library();
        /* transferMerchantInfo by user when add account */
        $upsapi_manage->ups_eu_woo_transfer_merchant_info_by_user($account_number);
    }
    /*
     * Name function: ups_eu_woo_transfer_merchant_info
     * Params: empty
     * Return: void
     * * */

    public function ups_eu_woo_transfer_merchant_info()
    {
        $upsapi_manage = $this->ups_eu_woo_load_api_manage_library();
        /* transferMerchantInfo when finish configuration */
        $response = $upsapi_manage->ups_eu_woo_transfer_merchant_info();
        if ($response) {
            $upsapi_manage->ups_eu_woo_transfer_merchant_info(1);
            $upsapi_manage->ups_eu_woo_save_option_setting('ups_shipping_transfer_info_already_done', 1);
        }
    }
    /*
     * Name function: ups_eu_woo_transfer_accessorials
     * Params: empty
     * Return: void
     * * */

    public function ups_eu_woo_transfer_accessorials()
    {
        $upsapi_manage = $this->ups_eu_woo_load_api_manage_library();
        /* transferAccessorial after finish configuration */
        $upsapi_manage->ups_eu_woo_transfer_accessorials();
    }
    /*
     * Name function: ups_eu_woo_transfer_shipping_services
     * Params: empty
     * Return: void
     * * */

    public function ups_eu_woo_transfer_shipping_services()
    {
        $upsapi_manage = $this->ups_eu_woo_load_api_manage_library();
        /* transferAccessorial after finish configuration */
        $upsapi_manage->ups_eu_woo_transfer_shipping_services();
    }
    /*
     * Name function: ups_eu_woo_transfer_delivery_rates
     * Params: empty
     * Return: void
     * * */

    public function ups_eu_woo_transfer_delivery_rates()
    {
        $upsapi_manage = $this->ups_eu_woo_load_api_manage_library();
        /* transferDeliveryrates after finish configuration */
        $upsapi_manage->ups_eu_woo_transfer_delivery_rates();
    }
    /*
     * Name function: ups_eu_woo_transfer_default_package
     * Params: empty
     * Return: void
     * * */

    public function ups_eu_woo_transfer_default_package()
    {
        $upsapi_manage = $this->ups_eu_woo_load_api_manage_library();
        /* transferDefaultPackage after finish configuration */
        $upsapi_manage->ups_eu_woo_transfer_default_package();
    }
    /*
     * Name function: ups_eu_woo_transfer_shipments
     * Params:
     *  @model_shipment: type object
     * Return: void
     * * */

    public function ups_eu_woo_transfer_shipments(
        $model_shipment = false,
        $ship_from = false,
        $shipping_type = false,
        $accessorial = false,
        $list_order = false,
        $package = false
    ) {
        $data = new \stdClass();
        $data->model_shipment = $model_shipment;
        $data->ship_from = $ship_from;
        $data->shipping_type = $shipping_type;
        $data->accessorial = $accessorial;
        $data->list_order = $list_order;
        $data->package = $package;
        $upsapi_manage = $this->ups_eu_woo_load_api_manage_library();
        /* transferShipment when create shipment */
        $upsapi_manage->ups_eu_woo_transfer_shipments($data);
    }
    /*
     * Name function: ups_eu_woo_update_shipments_status
     * Params:
     *  @model_shipment: type object
     *  @ship_from: type object
     *  @$shipping_type: type string
     *  @accessorial: type object
     *  @list_order: type array object
     *  @package: object
     * Return: void
     * * */

    public function ups_eu_woo_update_shipments_status($shipments)
    {
        $data = new \stdClass();
        $data->shipments = $shipments;
        $upsapi_manage = $this->ups_eu_woo_load_api_manage_library();
        /* updateShipmentsStatus when view detail shipment and cancel shipment */
        $upsapi_manage->ups_eu_woo_update_shipments_status($data);
    }
    /*
     * Name function: get_by_method_name_and_key
     * Params:
     *  @key_api: type text
     *  @method_name: type text
     * Return: boolean
     * * */

    public function get_by_method_name_and_key($key_api = "", $method_name = "")
    {
        $key_api = sanitize_text_field($key_api);
        $method_name = sanitize_text_field($method_name);
        if (strlen($method_name) > 0) {
            global $wpdb;
            $sqlSelect = ""
                . "SELECT * FROM `{$this->table_name}` "
                . " WHERE  TRUE"
                . "    AND `{$this->col_key_api}`='{$key_api}' "
                . "    AND `{$this->col_method_name}`='{$method_name}'";
            try {
                /* get data from database */
                $results = $wpdb->get_results($sqlSelect);
            } catch (Exception $ex) {
                \Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log("{$sqlSelect}", $ex);
            }

            $result_array = [];
            if (count($results) > 0) {
                $objectResult = $results[0];
                $result_array = (array) $objectResult;
            }
            /* convert data from array to object */
            $this->ups_eu_woo_base_convert_array_to_object($result_array, $this);
            if ((trim($this->key_api) === trim($key_api)) && (trim($this->method_name) === trim($method_name))) {
                return true;
            }
            return false;
        }
        return
            false;
    }
    /*
     * Name function: ups_eu_woo_auto_remove
     * Params: empty
     * Return: boolean
     * * */

    public function ups_eu_woo_auto_remove()
    {
        global $wpdb;
        $sql_remove = ""
            . "DELETE n1 FROM `{$this->table_name}` n1, `{$this->table_name}` n2 "
            . " WHERE TRUE"
            . "     AND n1.`{$this->col_id_retry}` < n2.`{$this->col_id_retry}` "
            . "     AND n1.`{$this->col_method_name}`= n2.`{$this->col_method_name}`"
            . "     AND n1.`{$this->col_key_api}`= n2.`{$this->col_key_api}`";
        try {
            $wpdb->query($sql_remove);

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function ups_eu_woo_get_list_method_call_api()
    {
        return $this->get_list_data_by_condition([
                "`{$this->col_count_retry}`<=5",
        ]);
    }

    public function ups_eu_woo_activated_plugin()
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_account = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Account();
        if ($model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_BILLING_PREFERENCE) === true) {
            $list_account = $model_account->ups_eu_woo_get_all();
            if (!empty($list_account)) {
                foreach ($list_account as $value) {
                    $upsapi_manage = $this->ups_eu_woo_load_api_manage_library();
                    $account_number = $value->ups_account_number;
                    /* updateMerchantStatus when activated plugin */
                    $upsapi_manage->ups_eu_woo_update_merchant_status($account_number, 10);
                }
            }
        }
    }

    public function ups_eu_woo_deactivated_plugin()
    {
        $upsapi_manage = $this->ups_eu_woo_load_api_manage_library();
        $account = "";
        /* updateMerchantStatus when deactivated plugin */
        $upsapi_manage->ups_eu_woo_update_merchant_status($account, 20);
    }

    public function ups_eu_woo_upgrade_version()
    {
        $upsapi_manage = $this->ups_eu_woo_load_api_manage_library();
        /* updateMerchantStatus when activated plugin */
        $upsapi_manage->ups_eu_woo_upgrade_version();
    }
}
