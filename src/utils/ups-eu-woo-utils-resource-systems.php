<?php namespace UpsEuWoocommerce\utils;

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
 * ups-eu-woo-utils-resource-systems.php - The core plugin class.
 *
 * This is used to handle the Ups_Eu_Woo_Utils_Resource_Systems.
 */

include_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Utils_Resource_Systems');

class Ups_Eu_Woo_Utils_Resource_Systems extends \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Base
{

    private $name_table = 'name_table';
    private $key_fields = 'fields';
    private $UpsEuWoocommerce_version = "UpsEuWoocommerce_version";

    private function ups_eu_woo_get_structure_table()
    {
        return[
            [
                $this->name_table => "config",
                $this->key_fields => [
                    "config_id int(10) UNSIGNED NOT NULL COMMENT 'Config Id' AUTO_INCREMENT",
                    "scope varchar(8) DEFAULT 'default' COMMENT 'Config Scope'",
                    "scope_id int(11) DEFAULT '0' COMMENT 'Config Scope Id'",
                    "`key` varchar(255) COMMENT 'key'",
                    "value text COMMENT 'Value'",
                    "PRIMARY KEY (config_id)"
                ]
            ],
            [
                $this->name_table => "accessorial",
                $this->key_fields => [
                    "id int(11) NOT NULL AUTO_INCREMENT",
                    "accessorial_key varchar(100) DEFAULT NULL",
                    "accessorial_name varchar(100) DEFAULT NULL",
                    "accessorial_code varchar(20) DEFAULT NULL",
                    "show_config int(1) NOT NULL DEFAULT '1'",
                    "show_shipping int(1) NOT NULL DEFAULT '1'",
                    "PRIMARY KEY  (id)"
                ]
            ],
            [
                $this->name_table => "account",
                $this->key_fields => [
                    "account_id int(10) UNSIGNED NOT NULL COMMENT 'Account ID' AUTO_INCREMENT",
                    "title varchar(10) DEFAULT NULL COMMENT 'Title'",
                    "fullname varchar(100) DEFAULT NULL COMMENT 'Fullname'",
                    "company varchar(255) DEFAULT NULL COMMENT 'Company'",
                    "email varchar(100) DEFAULT NULL COMMENT 'email'",
                    "phone_number varchar(100) DEFAULT NULL COMMENT 'phone_number'",
                    "address_type varchar(255) DEFAULT NULL COMMENT 'address_type'",
                    "address_1 varchar(255) DEFAULT NULL COMMENT 'Address_1'",
                    "address_2 varchar(255) DEFAULT NULL COMMENT 'Address_2'",
                    "address_3 varchar(255) DEFAULT NULL COMMENT 'Address_3'",
                    "postal_code varchar(50) DEFAULT NULL COMMENT 'Post code'",
                    "city varchar(255) DEFAULT NULL COMMENT 'City'",
                    "country varchar(10) DEFAULT NULL COMMENT 'Country'",
                    "state varchar(12) DEFAULT 'XX' COMMENT 'state'",
                    "account_type int(11) DEFAULT NULL COMMENT 'Account type(0,1,2)'",
                    "ups_account_name varchar(255) DEFAULT NULL COMMENT 'UPS account name'",
                    "ups_account_number varchar(255) DEFAULT NULL COMMENT 'UPS account number'",
                    "ups_invoice_number varchar(255) DEFAULT NULL COMMENT 'UPS invoice number'",
                    "ups_control_id varchar(255) DEFAULT NULL COMMENT 'UPS control id US'",
                    "ups_invoice_amount varchar(255) DEFAULT NULL COMMENT 'UPS account account'",
                    "ups_currency varchar(255) DEFAULT NULL COMMENT 'UPS Currency'",
                    "ups_invoice_date date DEFAULT NULL COMMENT 'UPS invoice date'",
                    "account_default int(11) DEFAULT NULL COMMENT 'Account default'",
                    "device_identity text DEFAULT NULL COMMENT 'device_identity'",
                    "ups_account_vatnumber char(15) DEFAULT NULL COMMENT 'ups_account_vatnumber'",
                    "ups_account_promocode char(9) DEFAULT NULL COMMENT 'ups_account_promocode'",
                    "PRIMARY KEY  (account_id)"
                ]
            ],
            [
                $this->name_table => "delivery_rates",
                $this->key_fields => [
                    "id int(10) UNSIGNED NOT NULL COMMENT 'ID' AUTO_INCREMENT",
                    "service_id int(11) DEFAULT NULL COMMENT 'Service ID'",
                    "rate_type varchar(20) DEFAULT NULL COMMENT 'Rate type'",
                    "min_order_value float DEFAULT NULL COMMENT 'Min order value'",
                    "delivery_rate float DEFAULT NULL COMMENT 'Delivery rate'",
                    "PRIMARY KEY (id)"
                ]
            ],
            [
                $this->name_table => "license",
                $this->key_fields => [
                    "id int(11) NOT NULL AUTO_INCREMENT",
                    "AccessLicenseText longtext COLLATE utf8_unicode_ci",
                    "Username varchar(127) COLLATE utf8_unicode_ci DEFAULT NULL",
                    "Password varchar(127) COLLATE utf8_unicode_ci DEFAULT NULL",
                    "AccessLicenseNumber varchar(127) COLLATE utf8_unicode_ci DEFAULT NULL",
                    "PRIMARY KEY (id)"
                ]
            ],
            [
                $this->name_table => "logs_api",
                $this->key_fields => [
                    "id int(11) NOT NULL AUTO_INCREMENT",
                    "method varchar(255) DEFAULT NULL",
                    "full_uri varchar(255) DEFAULT NULL",
                    "`request` text",
                    "`response` text",
                    "time_request timestamp NULL DEFAULT NULL",
                    "time_response timestamp NULL DEFAULT NULL",
                    "PRIMARY KEY (id)"
                ]
            ],
            [
                $this->name_table => "orders",
                $this->key_fields => [
                    "id int(10) UNSIGNED NOT NULL COMMENT 'ID' AUTO_INCREMENT",
                    "order_id_magento int(11) DEFAULT NULL COMMENT 'Order Id Magento'",
                    "shipping_service int(11) DEFAULT NULL COMMENT 'Service'",
                    "accessorial_service varchar(1023) DEFAULT NULL COMMENT 'Accessorial'",
                    "shipment_id int(11) DEFAULT NULL COMMENT 'Shipment Id'",
                    "status int(11) DEFAULT NULL COMMENT 'Order status'",
                    "ap_name varchar(255) DEFAULT NULL COMMENT 'Access Point Name'",
                    "ap_address1 varchar(128) DEFAULT NULL COMMENT 'Access Point Address 1'",
                    "ap_address2 varchar(128) DEFAULT NULL COMMENT 'Access Point Address 2'",
                    "ap_address3 varchar(255) NOT NULL",
                    "ap_state varchar(12) DEFAULT NULL COMMENT 'Access Point state'",
                    "ap_postcode varchar(12) DEFAULT NULL COMMENT 'Access Point post code'",
                    "ap_city varchar(64) DEFAULT NULL COMMENT 'Access Point city'",
                    "ap_country varchar(20) COMMENT 'Access Point country'",
                    "quote_id int(11) DEFAULT NULL COMMENT 'Quote Id'",
                    "cod int(11) DEFAULT NULL COMMENT 'COD'",
                    "location_id int(11) DEFAULT NULL COMMENT 'locationID type AP'",
                    "access_point_id varchar(20) COMMENT 'Access Point ID'",
                    "woo_tmp_order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
                    "date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
                    "date_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
                    "package_type text DEFAULT NULL COMMENT 'package type'",
                    "PRIMARY KEY (id)"
                ]
            ],
            [
                $this->name_table => "package_default",
                $this->key_fields => [
                    "package_id int(10) UNSIGNED NOT NULL COMMENT 'Package ID' AUTO_INCREMENT",
                    "package_name varchar(255) DEFAULT NULL COMMENT 'Package Name'",
                    "weight float(10,2) DEFAULT NULL COMMENT 'Weight'",
                    "unit_weight varchar(30) DEFAULT NULL COMMENT 'Unit weight'",
                    "length float(10,2) DEFAULT NULL COMMENT 'Length'",
                    "width float(10,2) DEFAULT NULL COMMENT 'Width'",
                    "height float(10,2) DEFAULT NULL COMMENT 'Height'",
                    "unit_dimension varchar(30) DEFAULT NULL COMMENT 'Unit dimension'",
                    "package_item int(11) DEFAULT NULL COMMENT 'Package Item'",
                    "PRIMARY KEY (package_id)"
                ]
            ],
            [
                $this->name_table => "retry_api",
                $this->key_fields => [
                    "id_retry int(10) UNSIGNED NOT NULL COMMENT 'ID' AUTO_INCREMENT",
                    "key_api varchar(255) DEFAULT NULL COMMENT 'Key'",
                    "method_name varchar(255) DEFAULT NULL COMMENT 'method_name'",
                    "data_api text DEFAULT NULL COMMENT 'Data request api'",
                    "count_retry int(11) DEFAULT NULL COMMENT 'Count retry'",
                    "date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
                    "date_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
                    "PRIMARY KEY (id_retry)"
                ]
            ],
            [
                $this->name_table => "services",
                $this->key_fields => [
                    "id int(11) NOT NULL AUTO_INCREMENT",
                    "country_code varchar(10) DEFAULT NULL",
                    "service_type varchar(20) DEFAULT NULL",
                    "service_key varchar(100) DEFAULT NULL",
                    "service_key_delivery varchar(100) DEFAULT NULL",
                    "service_key_val varchar(100) DEFAULT NULL",
                    "service_name varchar(100) DEFAULT NULL",
                    "rate_code varchar(20) DEFAULT NULL",
                    "tin_t_code varchar(20) DEFAULT NULL",
                    "service_selected int(1) NOT NULL DEFAULT '0'",
                    "service_symbol varchar(10) NOT NULL DEFAULT ''",
                    "PRIMARY KEY (id)"
                ]
            ],
            [
                $this->name_table => "shipments",
                $this->key_fields => [
                    "id int(10) UNSIGNED NOT NULL COMMENT 'ID' AUTO_INCREMENT",
                    "shipment_number varchar(50) DEFAULT NULL COMMENT 'Shipment number'",
                    "create_date timestamp NULL DEFAULT NULL COMMENT 'Date create'",
                    "status varchar(255) DEFAULT NULL COMMENT 'Shipment status'",
                    "cod int(11) DEFAULT NULL COMMENT 'COD'",
                    "shipping_fee float DEFAULT NULL COMMENT 'Fee'",
                    "order_value float DEFAULT NULL COMMENT 'Fee Order'",
                    "accessorial_service text COMMENT 'Accessorial'",
                    "shipping_service int(11) DEFAULT NULL COMMENT 'Service'",
                    "name text COMMENT 'Name'",
                    "address1 varchar(128) COMMENT 'Address 1'",
                    "address2 varchar(128) COMMENT 'Address 2'",
                    "address3 varchar(255) COMMENT 'Address 3'",
                    "state varchar(10) COMMENT 'State'",
                    "postcode varchar(12) COMMENT 'Postcode'",
                    "city varchar(64) COMMENT 'City'",
                    "country varchar(10) COMMENT 'Country'",
                    "phone varchar(20) COMMENT 'Phone'",
                    "email varchar(150) COMMENT 'Email'",
                    "access_point_id varchar(20) COMMENT 'Access Point ID'",
                    "order_selected int(11) COMMENT 'get shipto by order_id woocommerce'",
                    "PRIMARY KEY (id)"
                ]
            ],
            [
                $this->name_table => "tracking",
                $this->key_fields => [
                    "id int(11) NOT NULL AUTO_INCREMENT",
                    "tracking_number varchar(255) DEFAULT NULL",
                    "shipment_number varchar(255) DEFAULT NULL",
                    "status int(11) DEFAULT NULL",
                    "order_id int(11) NOT NULL",
                    "package_detail text NOT NULL",
                    "PRIMARY KEY (id)"
                ]
            ],
            [
                $this->name_table => "log_frontend",
                $this->key_fields => [
                    "`id` int(11) NOT NULL AUTO_INCREMENT",
                    "`ups_eu_woocommerce_key` varchar(32)",
                    "`content_encode_json` longtext COLLATE utf8_unicode_ci",
                    "date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
                    "PRIMARY KEY (`id`)"
                ]
            ],
            [
                $this->name_table => "fallback_rates",
                $this->key_fields => [
                    "`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID'",
                    "`service_type` varchar(20) DEFAULT NULL COMMENT 'Service Type'",
                    "`service_id` int(11) DEFAULT NULL COMMENT 'Service ID'",
                    "`fallback_rate` float DEFAULT NULL COMMENT 'Fallback Rate'",
                    "PRIMARY KEY (`id`)"
                ]
            ],
            [
                $this->name_table => "product_dimension",
                $this->key_fields => [
                    "package_id int(10) UNSIGNED NOT NULL COMMENT 'Package ID' AUTO_INCREMENT",
                    "package_name varchar(255) DEFAULT NULL COMMENT 'Package Name'",
                    "weight float(10,2) DEFAULT NULL COMMENT 'Weight'",
                    "unit_weight varchar(30) DEFAULT NULL COMMENT 'Unit Weight'",
                    "length float(10,2) DEFAULT NULL COMMENT 'Length'",
                    "width float(10,2) DEFAULT NULL COMMENT 'Width'",
                    "height float(10,2) DEFAULT NULL COMMENT 'Height'",
                    "unit_dimension varchar(30) DEFAULT NULL COMMENT 'Unit Dimension'",
                    "PRIMARY KEY (package_id)"
                ]
            ]
        ];
    }

    private function ups_eu_woo_get_structure_options()
    {
        return [];
    }

    private function ups_eu_woo_get_structure_table_update()
    {
        global $wpdb;
        $arrColumn = [];

        $arrColumnState = [
            $this->name_table => "account",
            $this->key_fields => [
                "ADD COLUMN IF NOT EXISTS state varchar(12) DEFAULT 'XX' COMMENT 'state'"
            ]
        ];

        $column_name = 'state';
        $name_table = 'account';
        $table_name = "{$wpdb->prefix}{$this->prefix_ups}{$name_table}";
        $row = $wpdb->get_results('SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = "'. $table_name .'" AND column_name = "'.$column_name.'"');

        if (empty($row)) {
            $arrColumn[] = $arrColumnState;
        }
        $arrColumnControl = [
            $this->name_table => "account",
            $this->key_fields => [
                "ADD COLUMN IF NOT EXISTS ups_control_id varchar(255) DEFAULT NULL COMMENT 'UPS control id US'"
            ]
        ];

        $column_name = 'ups_control_id';
        $name_table = 'account';
        $table_name = "{$wpdb->prefix}{$this->prefix_ups}{$name_table}";
        $row = $wpdb->get_results('SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = "'. $table_name .'" AND column_name = "'.$column_name.'"');

        if (empty($row)) {
            $arrColumn[] = $arrColumnControl;
        }
        $arrColumnPackageItem = [
            $this->name_table => "package_default",
            $this->key_fields => [
                "ADD COLUMN IF NOT EXISTS package_item int(11) DEFAULT NULL COMMENT 'Package Item'"
            ]
        ];

        $column_name = 'package_item';
        $name_table = 'package_default';
        $table_name = "{$wpdb->prefix}{$this->prefix_ups}{$name_table}";
        $row = $wpdb->get_results('SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = "'. $table_name .'" AND column_name = "'.$column_name.'"');

        if (empty($row)) {
            $arrColumn[] = $arrColumnPackageItem;
        }
        $arrColumnPackageType = [
            $this->name_table => "orders",
            $this->key_fields => [
                "ADD COLUMN IF NOT EXISTS package_type varchar(255) DEFAULT NULL COMMENT 'package type'"
            ]
        ];

        $column_name = 'package_type';
        $name_table = 'orders';
        $table_name = "{$wpdb->prefix}{$this->prefix_ups}{$name_table}";
        $row = $wpdb->get_results('SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = "'. $table_name .'" AND column_name = "'.$column_name.'"');

        if (empty($row)) {
            $arrColumn[] = $arrColumnPackageType;
        }
        return $arrColumn;
    }

    private function ups_eu_woo_insert_one_table($itemStructrueTable)
    {
        global $wpdb;
        $table_name = "{$wpdb->prefix}{$this->prefix_ups}{$itemStructrueTable[$this->name_table]}";
        $fields = implode(" ,", $itemStructrueTable[$this->key_fields]);
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} ({$fields}) {$charset_collate};";

        try {
            if($wpdb->query($sql) !== false){
                return true;
            }else{
                return false;
            }
            
        } catch (Exception $ex) {
            \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log("{$sql}", $ex);
            return false;
        }
    }

    private function ups_eu_woo_update_one_table($itemStructrueTable)
    {
        global $wpdb;
        $table_name = "{$wpdb->prefix}{$this->prefix_ups}{$itemStructrueTable[$this->name_table]}";
        $fields = implode(", ", $itemStructrueTable[$this->key_fields]);
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "ALTER TABLE {$table_name} {$fields};";
       
        try {
            if($wpdb->query($sql) !== false){
                return true;
            }else{
                return false;
            }
        } catch (Exception $ex) {
            \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log("{$sql}", $ex);
            return false;
        }
    }

    private function ups_eu_woo_add_data_table()
    {
        $list_table         = $this->ups_eu_woo_get_structure_table();
        $list_table_update  = $this->ups_eu_woo_get_structure_table_update();

        foreach ($list_table as $itemStructrueTable) {
            $this->ups_eu_woo_insert_one_table($itemStructrueTable);
        }
       
        foreach ($list_table_update as $itemStructrueTable) {
            $this->ups_eu_woo_update_one_table($itemStructrueTable);
        }

        return;
    }

    private function ups_eu_woo_add_options()
    {
        delete_option($this->UpsEuWoocommerce_version);
        add_option($this->UpsEuWoocommerce_version, \UpsEuWoocommerce\Ups_Eu_Woo_Main::$version);
    }

    private function ups_eu_woo_remove_data_table()
    {
        global $wpdb;
        $list_table = $this->ups_eu_woo_get_structure_table();
        foreach ($list_table as $itemStructrueTable) {
            $table_name = "{$wpdb->prefix}{$this->prefix_ups}{$itemStructrueTable[$this->name_table]}";
            $sql = "DROP TABLE IF EXISTS $table_name";
            try {
                $wpdb->query($sql);
            } catch (Exception $ex) {
                \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log("{$sql}", $ex);
            }
        }
        return;
    }

    private function ups_eu_woo_remove_options()
    {
        $get_version_data = get_option($this->UpsEuWoocommerce_version);
        if ($get_version_data === \UpsEuWoocommerce\Ups_Eu_Woo_Main::$version) {
            delete_option($this->UpsEuWoocommerce_version);
        }
    }

    private function ups_eu_woo_verify_merchant()
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) !== true) {
            $model_config->key = $model_config->ups_shipping_merchant_key;
            $model_config->value = $model_config->ups_eu_woo_created_key_merchant();
            $model_config->scope = "default";
            $model_config->ups_eu_woo_save();
        }
    }

    private function ups_eu_woo_verify_rating()
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        if ($model_config->ups_eu_woo_get_by_key($model_config->ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS) !== true) {
            $model_config->key = $model_config->ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS;
            $model_config->value = '';
            $model_config->scope = "default";
            $model_config->ups_eu_woo_save();
        }
    }

    private function ups_eu_woo_verify_setting_package()
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        if ($model_config->ups_eu_woo_get_by_key($model_config->PACKAGE_SETTING_OPTION) !== true) {
            $model_config->key = $model_config->PACKAGE_SETTING_OPTION;
            $model_config->value = 1;
            $model_config->scope = "default";
            $model_config->ups_eu_woo_save();
        }
    }

    public function ups_eu_woo_sys_upgrade_version()
    {
        // Save new version to config table
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_config->key = $model_config->ups_shipping_plugin_version;
        $model_config->value = \UpsEuWoocommerce\Ups_Eu_Woo_Main::$version;
        $model_config->scope = "default";
        $model_config->ups_eu_woo_save();
    }

    public function ups_eu_woo_sys_activate()
    {
        // Create database schema, master data
        $this->ups_eu_woo_add_data_table();
        $this->ups_eu_woo_verify_merchant();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) == true) {
            $initDataSystem = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Init_Data_System();
            $initDataSystem->ups_eu_woo_add_sat_deli_shipping_service();
            $this->ups_eu_woo_verify_setting_package();
            $this->ups_eu_woo_verify_rating();
        }
        /* Add role and cap */
        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();
        $roles_capabilities->ups_eu_woo_activated_plugin();
        /* ended add role and cap */
        $this->ups_eu_woo_add_options();
        // Call PM api update version
        call_user_func_array([
            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Retry_Api(), "ups_eu_woo_upgrade_version"
        ], []);
        // Call PM api update merchant status
        call_user_func_array([
            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Retry_Api(), "ups_eu_woo_activated_plugin"
        ], []);
        // Check and handle action when upgrade plugin version
        call_user_func_array([
            new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Manage_Api_Ups()
            , "ups_eu_woo_upgrade_plugin_version"
        ], []);
    }

    public function ups_eu_woo_sys_deactivate()
    {
        /* remove role */
        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();
        $roles_capabilities->ups_eu_woo_deactivated_plugin();
        /* ended remove */
        $this->ups_eu_woo_remove_options();
        call_user_func_array([
            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Retry_Api(), "ups_eu_woo_deactivated_plugin"
            ], []);
    }

    public function ups_eu_woo_sys_uninstalled()
    {
        $account_number = "";
        call_user_func_array(
            [
            new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Manage_Api_Ups(),
            "ups_eu_woo_update_merchant_status"
            ],
            [$account_number, 30]
        );
        $this->ups_eu_woo_remove_data_table();
    }
}
