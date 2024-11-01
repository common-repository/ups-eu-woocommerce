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
 * ups-eu-woo-model-data-base.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Data_Base Model.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Data_Base');

class Ups_Eu_Woo_Data_Base extends entities\Ups_Eu_Woo_Systems_Entity
{

    protected $prefix_ups = "ups_shipping_";
    protected $msg_error = "msg_error";
    protected $date_format_ymd = "Y-m-d";
    protected $date_format_ymd_time = "Y-m-d H:i:s";

    /*
     * Name function: __constuct
     * Params: empty
     * Return: void
     * * */

    public function __construct()
    {
    }
    /*
     * Name function: ups_eu_woo_base_get_by_id
     * Params:
     *  @id: type int
     *  @table_name: type string
     *  @key_id: type string
     * Return: type boolean
     * * */

    protected function ups_eu_woo_base_get_by_id($id, $table_name, $key_id = "id")
    {
        if (empty($id) || intval($id) <= 0 || empty($table_name)) {
            return false;
        }

        $id = intval($id);
        if ($id > 0) {
            global $wpdb;
            $sqlSelect = "SELECT * FROM `{$table_name}` WHERE `{$key_id}`='{$id}'";
            try {
                $results = $wpdb->get_results($sqlSelect);
                if (count($results) > 0) {
                    $objectResult = $results[0];
                    return (array) $objectResult;
                }
                return false;
            } catch (Exception $ex) {
                Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlSelect, $ex);
                return false;
            }
        }
        return false;
    }

    /**
     * ups_eu_woo_base_get_all
     * @param $table_name : name of table want get all data
     * */
    protected function ups_eu_woo_base_get_all($table_name)
    {
        if (empty($table_name)) {
            return false;
        }

        global $wpdb;
        $sqlSelect = "SELECT * FROM `{$table_name}`";
        $results = $wpdb->get_results($sqlSelect);

        return $results;
    }

    /**
     * ups_eu_woo_base_get_first
     * @param $table_name : name of table want get all data
     * */
    protected function ups_eu_woo_base_get_first($table_name)
    {
        if (empty($table_name)) {
            return false;
        }

        global $wpdb;
        $results = [];
        $sqlSelect = "SELECT * FROM `{$table_name}` LIMIT 1";
        $rs = $wpdb->get_results($sqlSelect);

        if (count($rs) > 0) {
            $objectResult = $rs[0];
            $results = (array) $objectResult;
        }

        return $results;
    }
    /*
     * Name function: ups_eu_woo_base_get_list_data_by_condition
     * Params:
     *  @table_name: type string
     *  @conditions: type array
     *  @limit: type string
     *  @orders: type array
     *  @joins: type array
     *  @selects: type boolean
     * Return: array object or false
     * * */

    protected function ups_eu_woo_base_get_list_data_by_condition($table_name, $conditions = [], $limit = 'all', $orders = [], $joins = [], $selects = false)
    {
        global $wpdb;
        $str_where = $this->ups_eu_woo_base_set_conditions($conditions);
        $str_limit = $this->ups_eu_woo_base_set_limits($limit);
        $str_order = $this->ups_eu_woo_base_set_orders($orders);
        $str_join = $this->ups_eu_woo_base_set_joins($joins);
        $str_select = $selects !== false ? $selects : '*';

        $sqlSelect = "SELECT {$str_select} FROM `{$table_name}` {$str_join} {$str_where} {$str_order} {$str_limit}";

        try {
            $tmp_data = $wpdb->get_results($sqlSelect);
            return $tmp_data;
        } catch (Exception $ex) {
            Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlSelect, $ex);
            return false;
        }
    }
    /*
     * Name function: ups_eu_woo_base_delete
     * Params:
     *  @id: type int
     *  @table_name: type string
     *  @key_id: type string
     * Return: type boolean
     * * */

    protected function ups_eu_woo_base_delete($id, $table_name, $key_id = "id")
    {
        if (empty($id) || intval($id) <= 0 || empty($table_name)) {
            return false;
        }

        try {
            global $wpdb;
            $id = intval($id);
            $sqlDelete = "DELETE FROM `{$table_name}` WHERE `{$key_id}`='{$id}'";
            $wpdb->query($sqlDelete);
            return true;
        } catch (Exception $ex) {
            Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlDelete, $ex);
            return false;
        }
    }
    /*
     * Name function: ups_eu_woo_base_delete_all
     * Params:
     *  @table_name: type string
     *  @conditions: type array
     * Return: type boolean
     * * */

    protected function ups_eu_woo_base_delete_all($table_name, $conditions = [])
    {
        if (empty($table_name)) {
            return false;
        }
        try {
            global $wpdb;
            $str_where = self::ups_eu_woo_base_set_conditions($conditions);
            $sqlDelete = "DELETE FROM `{$table_name}` {$str_where}";
            $wpdb->query($sqlDelete);
            return true;
        } catch (Exception $ex) {
            Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlDelete, $ex);
            return false;
        }
    }

    /*
     * Name function: ups_eu_woo_base_save
     * Params:
     *  @dataArray: type array
     *  @table_name: type string
     *  @conditions: type array
     * Return: type int or false
     * * */

    protected function ups_eu_woo_base_save_package($dataArray, $table_name, $keyId = "id")
    {
        $tmpFields = [];
        $tmpValues = [];
        $tmpOnDuplicate = [];
        $checkId = 0;
        foreach ($dataArray as $key => $value) {
            if ($keyId != $key) {
                $value_format = esc_sql($value);
                $tmpOnDuplicate[] = "`{$key}`='{$value_format}'";
                $tmpValues[] = "'{$value_format}'";
            } else {
                $checkId = intval($value);
                if (empty($checkId)) {
                    $checkId = "NULL";
                }
                $tmpValues[] = "{$checkId}";
            }
            $tmpFields[] = "`{$key}`";
        }
        $strFields = implode(",", $tmpFields);

        $strValues = implode(",", $tmpValues);
        $strOnDuplicate = implode(",", $tmpOnDuplicate);
        global $wpdb;
        $sqlInsertUpdate = "INSERT INTO {$table_name} ({$strFields}) VALUES ({$strValues})" .
            " ON DUPLICATE KEY UPDATE {$strOnDuplicate}";
        try {
            $wpdb->query($sqlInsertUpdate);
            if ($checkId == 'NULL') {
                $lastIndexByTable = $wpdb->get_row("SHOW TABLE STATUS LIKE '{$table_name}'");
                return $lastIndexByTable->Auto_increment - 1;
            }
            return $checkId;
        } catch (Exception $ex) {
            Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlInsertUpdate, $ex);
            return false;
        }
    }
    /*
     * Name function: ups_eu_woo_base_save
     * Params:
     *  @dataArray: type array
     *  @table_name: type string
     *  @conditions: type array
     * Return: type int or false
     * * */

    protected function ups_eu_woo_base_save($dataArray, $table_name, $keyId = "id")
    {
        $tmpFields = [];
        $tmpValues = [];
        $tmpOnDuplicate = [];
        $checkId = 0;
        foreach ($dataArray as $key => $value) {
            if ($keyId != $key) {
                $value_format = esc_sql($value);
                $tmpOnDuplicate[] = "`{$key}`='{$value_format}'";
                $tmpValues[] = "'{$value_format}'";
            } else {
                $checkId = intval($value);
                if (empty($checkId)) {
                    $checkId = "NULL";
                }
                $tmpValues[] = "{$checkId}";
            }
            $tmpFields[] = "`{$key}`";
        }
        $strFields = implode(",", $tmpFields);

        $strValues = implode(",", $tmpValues);
        $strOnDuplicate = implode(",", $tmpOnDuplicate);
        global $wpdb;
        $sqlInsertUpdate = "INSERT INTO {$table_name} ({$strFields}) VALUES ({$strValues})" .
            " ON DUPLICATE KEY UPDATE {$strOnDuplicate}";

        try {
            $wpdb->query($sqlInsertUpdate);
            if ($checkId == 'NULL') {
                $lastIndexByTable = $wpdb->get_row("SHOW TABLE STATUS LIKE '{$table_name}'");
                return $lastIndexByTable->Auto_increment - 1;
            }
            return $checkId;
        } catch (Exception $ex) {
            Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlInsertUpdate, $ex);
            return false;
        }
    }
    /*
     * Name function: ups_eu_woo_base_update
     * Params:
     *  @dataArray: type array
     *  @table_name: type string
     *  @conditions: type array
     * Return: type boolean
     * * */

    protected function ups_eu_woo_base_update($dataArray, $table_name, $conditions = [])
    {
        $tmpOnDuplicate = [];
        foreach ($dataArray as $key => $value) {
            $tmpOnDuplicate[] = " `{$key}` ='{$value}'";
        }

        $strOnDuplicate = implode(",", $tmpOnDuplicate);

        $str_where = self::ups_eu_woo_base_set_conditions($conditions);

        $sqlUpdate = "UPDATE {$table_name} SET {$strOnDuplicate} {$str_where} ";

        global $wpdb;
        try {
            return $wpdb->query($sqlUpdate);
        } catch (Exception $ex) {
            Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlUpdate, $ex);
            return false;
        }
    }

    /**
     * ups_eu_woo_base_set_conditions
     * */
    private function ups_eu_woo_base_set_conditions($conditions, $type = 'WHERE')
    {
        $str_conditions = "";
        if (count($conditions) > 0) {
            $str_conditions = implode(" AND ", $conditions);
        }
        $str_conditions = ltrim(trim($str_conditions), 'AND');
        if ($str_conditions != '') {
            $str_conditions = ' ' . $type . ' ' . $str_conditions;
        }

        return $str_conditions;
    }

    /**
     * ups_eu_woo_base_set_orders
     * */
    private function ups_eu_woo_base_set_orders($orders)
    {
        $str_order = "";
        if (!empty($orders)) {
            foreach ($orders as $field => $order) {
                $str_order .= $field . ' ' . $order . ',';
            }
            $str_order = " ORDER BY " . $str_order;
            $str_order = rtrim($str_order, ',');
        }

        return $str_order;
    }

    /**
     * ups_eu_woo_base_set_joins
     * */
    private function ups_eu_woo_base_set_joins($joins)
    {
        $str_join = " ";
        if (!empty($joins)) {
            foreach ($joins as $join) {
                if (array_key_exists('type', $join)) {
                    $typeJoin = $join['type'];
                } else {
                    $typeJoin = 'JOIN';
                }
                $str_join .= ' ' . $typeJoin . ' ' . $join['table'] .
                    $this->ups_eu_woo_base_set_conditions($join['conditions'], 'ON') . ' ';
            }
        }
        return $str_join;
    }

    /**
     * ups_eu_woo_base_set_limits
     * */
    private function ups_eu_woo_base_set_limits($limit)
    {
        $str_limit = "";
        if (is_array($limit)) {
            $offset = intval($limit[1]) > 0 ? (intval($limit[1]) - 1) : 0;
            $offset = $offset * intval(
                $limit[0]
            );
            $str_limit = " LIMIT " . intval($limit[0]) . ' OFFSET ' . $offset;
        } else {
            if (!($limit === "all")) {
                $str_limit = " LIMIT " . intval($limit);
            }
        }
        return $str_limit;
    }
    /*
     * Name function: ups_eu_woo_base_convert_array_to_object
     * Params:
     *  @tmpArray: type array
     *  @object: type object
     * Return: void
     * * */

    protected function ups_eu_woo_base_convert_array_to_object($tmpArray, &$object)
    {
        if (is_array($tmpArray) || is_object($tmpArray)) {
            foreach ($tmpArray as $key => $value) {
                if (property_exists($object, "{$key}")) {
                    $object->$key = $value;
                }
            }
        }
        return;
    }
    /*
     * Name function: ups_eu_woo_base_check_existing
     * Params:
     *  @table_name: type string
     *  @conditions: type array
     * Return: type boolean
     * * */

    protected function ups_eu_woo_base_check_existing($table_name, $conditions = [])
    {
        if (strlen(
            $table_name
        ) > 0) {
            global $wpdb;
            $str_conditions = $this->ups_eu_woo_base_set_conditions($conditions);
            $sqlSelect = "SELECT COUNT(0) as total FROM `{$table_name}` {$str_conditions}";
            try {
                $results = $wpdb->get_results($sqlSelect);
                if (count($results) > 0) {
                    $objectResult = $results[0];
                    if (!empty($objectResult) && (!empty($objectResult->total)) && $objectResult->total > 0) {
                        return true;
                    }
                }
            } catch (Exception $ex) {
                Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlSelect, $ex);
                return false;
            }
        }
        return false;
    }
}
