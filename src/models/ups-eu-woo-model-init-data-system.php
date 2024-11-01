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
 * ups-eu-woo-model-init-data-system.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Init_Data_System Model.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Init_Data_System');

class Ups_Eu_Woo_Init_Data_System
{
    /*
     * Name function: ups_eu_woo_int_term_table_config
     * Params: empty
     * Return: void
     * * */

    public function ups_eu_woo_int_term_table_config()
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        /* List row table config for insert */
        $array_insert = [
            "('default','0','{$model_config->ACCEPT_TERM_CONDITION}','2')",
            "('default','0','{$model_config->SHOW_TERM_CONDITION}','0')"
        ];
        // Insert database
        $this->ups_eu_woo_insert_table_config($array_insert);
    }
    /*
     * Name function: ups_eu_woo_int_first_insert_table_config
     * Params: empty
     * Return: void
     * * */

    public function ups_eu_woo_int_first_insert_table_config()
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $table_name = $model_config->ups_eu_woo_get_table_name();
        global $wpdb;
        $sqlSelect = "SELECT COUNT(0) as total FROM `{$table_name}`";
        try {
            $results = $wpdb->get_results($sqlSelect);
        } catch (Exception $ex) {
            Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($sqlSelect, $ex);
        }
        $total = 0;
        if (count($results) > 0) {
            $objectResult = $results[0];
            if (!empty($objectResult) && (!empty($objectResult->total))) {
                $total = $objectResult->total;
            }
        }
        /* List row table config for insert */
        $array_insert = [
            "('default','0','{$model_config->ACCEPT_ACCOUNT}','0')",
            "('default','0','{$model_config->ACCEPT_SHIPPING_SERVICE}','0')",
            "('default','0','{$model_config->ACCEPT_CASH_ON_DELIVERY}','0')",
            "('default','0','{$model_config->ACCEPT_ACCESSORIAL}','0')",
            "('default','0','{$model_config->ACCEPT_PACKAGE_DIMENSION}','0')",
            "('default','0','{$model_config->ACCEPT_DELIVERY_RATES}','0')",
            "('default','0','{$model_config->ACCEPT_BILLING_PREFERENCE}','0')",
            "('default','0','{$model_config->SET_DEFAULT}','')",
            "('default','0','{$model_config->AP_AS_SHIPTO}','')",
            "('default','0','{$model_config->ADULT_SIGNATURE}','')",
            "('default','0','{$model_config->DELIVERY_TO_ACCESS_POINT}','0')",
            "('default','0','{$model_config->NUMBER_OF_ACCESS_POINT_AVAIABLE}','0')",
            "('default','0','{$model_config->DISPLAY_ALL_ACCESS_POINT_IN_RANGE}','0')",
            "('default','0','{$model_config->CHOOSE_ACCOUNT_NUMBER_AP}','0')",
            "('default','0','{$model_config->DELIVERY_TO_SHIPPING_ADDRESS}','0')",
            "('default','0','{$model_config->CHOOSE_ACCOUNT_NUMBER_ADD}','0')",
            "('default','0','{$model_config->CUT_OFF_TIME}','0')",
            "('default','0','{$model_config->ACTIVE}','0')",
            "('default','0','{$model_config->NAME}','0')",
            "('default','0','{$model_config->TITLE}','0')",
            "('default','0','{$model_config->FIXED_PRICE}','0')",
            "('default','0','{$model_config->UPS_ACCEPT_CASH_ON_DELIVERY}','0')",
            "('default','0','{$model_config->ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS}','0')",
            "('default','0','{$model_config->PACKAGE_SETTING_OPTION}','1')",
            "('default','0','{$model_config->UPS_ACCEPT_PACKAGE_TYPE}','02')"
        ];
        $this->ups_eu_woo_insert_table_config($array_insert);
    }

    /*
     * Name function: ups_eu_woo_int_first_insert_table_config_pac_algo
     * Params: empty
     * Return: void
     * * */

    public function ups_eu_woo_int_first_insert_table_config_pac_algo()
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $array_insert = [
            "('default','0','{$model_config->UPS_PACK_ALGO}','')",
            "('default','0','{$model_config->UPS_PACK_WEG_UNIT}','')",
            "('default','0','{$model_config->UPS_PACK_DIM_UNIT}','')",
            "('default','0','{$model_config->UPS_PACK_MAX_WEIGHT}','')"
        ];
        $this->ups_eu_woo_insert_table_config($array_insert);
    }

    /*
     * Name function: ups_eu_woo_add_package_dimensions_config
     * Params: empty
     * Return: void
     * * */

    public function ups_eu_woo_add_package_dimensions_config()
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();

        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            $configs = [
                [
                    $model_config->col_key => $model_config->ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS,
                    $model_config->col_value => '0'
                ],
                [
                    $model_config->col_key => $model_config->PACKAGE_SETTING_OPTION,
                    $model_config->col_value => '1'
                ]
            ];
            $array_insert = [];
            foreach ($configs as $config) {
                $isExistConfigKey = $model_config->ups_eu_woo_check_existing(["{$model_config->col_key} = '{$config[$model_config->col_key]}'"]);
                if ($isExistConfigKey) {
                    continue;
                }
                $line = "('default','0','{$config[$model_config->col_key]}','{$config[$model_config->col_value]}')";
                $array_insert[] = $line;

            }
            $this->ups_eu_woo_insert_table_config($array_insert);
        }
    }
    /*
     * Name function: ups_eu_woo_insert_table_config
     * Params:
     *  $array_insert array data insert
     * Return: void
     * * */

    private function ups_eu_woo_insert_table_config($array_insert)
    {
        global $wpdb;
        $model_config = new Ups_Eu_Woo_Model_Config();
        $table_name = $model_config->ups_eu_woo_get_table_name();
        $str_values = implode(',', $array_insert);
        /* List colums table config for inserrt */
        $colum_inserts = [
            "`{$model_config->col_scope}`",
            "`{$model_config->col_scope_id}`",
            "`{$model_config->col_key}`",
            "`{$model_config->col_value}`"
        ];
        $str_colums = implode(" , ", $colum_inserts);
        /* Build command insert sql */
        $inserts_sql = "INSERT INTO `{$table_name}` ({$str_colums}) VALUES {$str_values}";
        try {
            /* Save to database */
            $wpdb->query("{$inserts_sql}");
        } catch (Exception $ex) {
            /* Log exception of sql */
            Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($inserts_sql, $ex);
        }
    }
    /*
     * Name function: ups_eu_woo_int_first_insert_table_accessorial
     * Params: empty
     * Return: void
     * * */

    public function ups_eu_woo_int_first_insert_table_accessorial()
    {
        $model_accessorial = new Ups_Eu_Woo_Model_Accessorial();
        if ($model_accessorial->ups_eu_woo_check_existing() === false) {
            $table_name = $model_accessorial->ups_eu_woo_get_table_name();
            /* list row table accessorial for insert */
            $array_insert = [
                "('1','UPS_ACSRL_ADDITIONAL_HADING','Additional Handling','100','1','0')",
                "('2','UPS_ACSRL_QV_SHIP_NOTIF','Quantum View Ship Notification','6','1','0')",
                "('3','UPS_ACSRL_QV_DLV_NOTIF','Quantum View Delivery Notification','372','1','0')",
                "('4','UPS_ACSRL_RESIDENTIAL_ADDRESS','Residential Address','270','0','0')",
                "('5','UPS_ACSRL_STATURDAY_DELIVERY','Saturday Delivery','300','0','0')",
                "('6','UPS_ACSRL_CARBON_NEUTRAL','Carbon Neutral','441','1','0')",
                "('7','UPS_ACSRL_DIRECT_DELIVERY_ONLY','Direct Delivery Only','541','0','0')",
                "('8','UPS_ACSRL_DECLARED_VALUE','Declared value','5','0','0')",
                "('9','UPS_ACSRL_SIGNATURE_REQUIRED','Signature Required','2','1','0')",
                "('10','UPS_ACSRL_ADULT_SIG_REQUIRED','Adult Signature Required','3','1','0')",
                "('11','UPS_ACSRL_ACCESS_POINT_COD','To Access Point COD','4','0','0')",
                "('12','UPS_ACSRL_TO_HOME_COD','To Home COD','500','0','0')"
            ];
            $str_values = implode(',', $array_insert);
            $colum_inserts = [
                "`{$model_accessorial->col_id}`",
                "`{$model_accessorial->col_accessorial_key}`",
                "`{$model_accessorial->col_accessorial_name}`",
                "`{$model_accessorial->col_accessorial_code}`",
                "`{$model_accessorial->col_show_config}`",
                "`{$model_accessorial->col_show_shipping}`"
            ];
            $str_colums = implode(" , ", $colum_inserts);
            /* Build command insert sql */
            $inserts_sql = "INSERT INTO `{$table_name}` ({$str_colums}) VALUES {$str_values}";
            try {
                /* Save to database */
                global $wpdb;
                $wpdb->query("{$inserts_sql}");
            } catch (Exception $ex) {
                /* Log exception of sql */
                Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($inserts_sql, $ex);
            }
        }
    }
    /*
     * Name function: ups_eu_woo_int_first_insert_table_services
     * Params: empty
     * Return: void
     * * */

    public function ups_eu_woo_int_first_insert_table_services()
    {
        $model_config = new Ups_Eu_Woo_Model_Config();
        $country_code = '';
        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE)) {
            $country_code = $model_config->value;
        }
        $model_services = new Ups_Eu_Woo_Model_Services();
        if ($model_services->ups_eu_woo_check_existing() === false) {
            $array_insert = [];
            //$service_type_list = $model_services->ups_eu_woo_get_sorted_services($country_code);
            $country_list = $model_services->ups_eu_woo_get_sorted_services();
            $service_key_list_data = $this->ups_eu_woo_get_service_key_list_data();
            foreach ($country_list as $country_code => $service_type_list) {
                foreach ($service_type_list as $service_type => $service_key_list) {
                    foreach ($service_key_list as $service_key) {
                        $search_key = sprintf('UPS_SP_SERV_%s_%s_', $country_code, $service_type);
                        $service_key_check = str_replace($search_key, '', $service_key);
                        if (isset($service_key_list_data[$service_key_check])) {
                            $service = $service_key_list_data[$service_key_check];
                            $service_key_delivery = str_replace('UPS_SP_SERV', 'UPS_DELI', $service_key);
                            $service_key_val = $service_key_delivery . '_VAL';
                            $line = "('" . $country_code . "','" . $service_type . "','" . $service_key . "','" . $service_key_delivery . "'," .
                                "'" . $service_key_val . "','" . $service['service_name'] . "','" . $service['rate_code'] . "', NULL, '0', '" . $service['service_symbol'] . "')";
                            $array_insert[] = $line;
                        }
                    }
                }
            }
            // Insert table service
            $this->ups_eu_woo_insert_table_services($array_insert);
        }
    }

    /*
     * Name function: ups_eu_woo_add_sat_deli_shipping_service
     * Params: empty
     * Return: void
     * * */

    public function ups_eu_woo_add_sat_deli_shipping_service()
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();

        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            $array_insert = [];
            $model_services = new Ups_Eu_Woo_Model_Services();
            // Add saturday delivery shipping service
            $country_code_list = ['PL', 'GB', 'DE', 'ES', 'IT', 'FR', 'NL', 'BE', 'US', 'AT', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'GR', 'HU', 'IE', 'LV', 'LT', 'LU', 'MT', 'PT',  'RO', 'SK', 'SI', 'SE', 'NO', 'RS', 'CH', 'IS', 'JE', 'TR'];
            $service_type_list = ['AP', 'ADD'];
            $add_service_key_list = [
                [
                    'service_key' => 'UPS_SP_SERV_%s_%s_STANDARD_SAT_DELI',
                    'service_name' => 'UPS Standard - Saturday Delivery',
                    'rate_code' => '11'
                ],
                [
                    'service_key' => 'UPS_SP_SERV_%s_%s_EXPRESS_SAT_DELI',
                    'service_name' => 'UPS Express - Saturday Delivery',
                    'rate_code' => '07'
                ]
            ];
            // Set data insert to table service
            foreach ($add_service_key_list as $add_service_key) {
                foreach ($country_code_list as $country_code) {
                    foreach ($service_type_list as $service_type) {
                        if ($country_code == 'US' && strpos($add_service_key['service_key'], 'EXPRESS_SAT_DELI')) {
                            continue;
                        }
                        $service_key = sprintf($add_service_key['service_key'], $country_code, $service_type);
                        $service_key_delivery = $service_key;
                        $service_key_val = $service_key . '_VAL';
                        $isExistServiceKey = $model_services->ups_eu_woo_check_existing(["service_key = '$service_key'"]);

                        if ($isExistServiceKey === true) {
                            continue;
                        }
                        $line = "('" . $country_code . "','" . $service_type . "','" . $service_key . "','" . $service_key_delivery . "'," .
                            "'" . $service_key_val . "','" . $add_service_key['service_name'] . "','" . $add_service_key['rate_code'] . "', NULL, '0', '&reg;')";
                        $array_insert[] = $line;
                    }
                }
            }
            if(!empty($array_insert)){
                // Insert table service
                $this->ups_eu_woo_insert_table_services($array_insert);
            } 
        }
    }

    /*
     * Name function: ups_eu_woo_insert_table_services
     * Params:
     *  $array_insert array data insert
     * Return: void
     * * */

    private function ups_eu_woo_insert_table_services($array_insert)
    {
        $model_services = new Ups_Eu_Woo_Model_Services();
        $table_name = $model_services->ups_eu_woo_get_table_name();
        $str_values = implode(',', array_values($array_insert));
        /* List colums table services for inserrt */
        $colum_inserts = [
            "`{$model_services->col_country_code}`",
            "`{$model_services->col_service_type}`",
            "`{$model_services->col_service_key}`",
            "`{$model_services->col_service_key_delivery}`",
            "`{$model_services->col_service_key_val}`",
            "`{$model_services->col_service_name}`",
            "`{$model_services->col_rate_code}`",
            "`{$model_services->col_tin_t_code}`",
            "`{$model_services->col_service_selected}`",
            "`{$model_services->col_service_symbol}`"
        ];
        $str_colums = implode(" , ", $colum_inserts);
        /* Build command insert sql */
        $inserts_sql = "INSERT INTO `{$table_name}` ({$str_colums}) VALUES {$str_values}";
        try {
            /* Save to database */
            global $wpdb;
            $wpdb->query("{$inserts_sql}");
        } catch (Exception $ex) {
            /* Log exception of sql */
            Ups_Eu_Woo_Model_Log_File::ups_eu_woo_log($inserts_sql, $ex);
        }
    }

    /*
     * Name function: ups_eu_woo_get_service_key_list_data
     * Params: empty
     * Return: void
     * * */

    private function ups_eu_woo_get_service_key_list_data()
    {
        return [
            '2ND_DAY_AIR' => [
                'service_name' => 'UPS 2nd Day Air',
                'rate_code' => '02',
                'service_symbol' => '&reg;'
            ],
            '2ND_DAY_AIR_AM' => [
                'service_name' => 'UPS 2nd Day Air A.M',
                'rate_code' => '59',
                'service_symbol' => '&reg;'
            ],
            '3_DAY_SELECT' => [
                'service_name' => 'UPS 3 Day Select',
                'rate_code' => '12',
                'service_symbol' => '&reg;'
            ],
            'GROUND' => [
                'service_name' => 'UPS Ground',
                'rate_code' => '03',
                'service_symbol' => '&reg;'
            ],
            'NEXT_DAY_AIR' => [
                'service_name' => 'UPS Next Day Air',
                'rate_code' => '01',
                'service_symbol' => '&reg;'
            ],
            'NEXT_DAY_AIR_EARLY' => [
                'service_name' => 'UPS Next Day Air Early',
                'rate_code' => '14',
                'service_symbol' => '&reg;'
            ],
            'NEXT_DAY_AIR_SAVER' => [
                'service_name' => 'UPS Next Day Air Saver',
                'rate_code' => '13',
                'service_symbol' => '&reg;'
            ],
            'STANDARD' => [
                'service_name' => 'UPS Standard',
                'rate_code' => '11',
                'service_symbol' => '&reg;'
            ],
            'STANDARD_SAT_DELI' => [
                'service_name' => 'UPS Standard - Saturday Delivery',
                'rate_code' => '11',
                'service_symbol' => '&reg;'
            ],
            'AP_ECONOMY' => [
                'service_name' => 'UPS Access Point Economy',
                'rate_code' => '70',
                'service_symbol' => '&trade;'
            ],
            'EXPEDITED' => [
                'service_name' => 'UPS Expedited',
                'rate_code' => '08',
                'service_symbol' => '&reg;'
            ],
            'EXPRESS_WORLDWIDE_EXPEDITED' => [
                'service_name' => 'UPS Worldwide Expedited',
                'rate_code' => '08',
                'service_symbol' => '&reg;'
            ],
            'EXPRESS' => [
                'service_name' => 'UPS Express',
                'rate_code' => '07',
                'service_symbol' => '&reg;'
            ],
            'EXPRESS_WORLDWIDE_EXPRESS' => [
                'service_name' => 'UPS Worldwide Express',
                'rate_code' => '07',
                'service_symbol' => '&reg;'
            ],
            'EXPRESS_PLUS' => [
                'service_name' => 'UPS Express Plus',
                'rate_code' => '54',
                'service_symbol' => '&reg;'
            ],
            'WW_EXPRESS_PLUS' => [
                'service_name' => 'UPS Express Plus',
                'rate_code' => '54',
                'service_symbol' => '&reg;'
            ],
            'EXPRESS_WORLDWIDE_EXPRESS_PLUS' => [
                'service_name' => 'UPS Worldwide Express Plus',
                'rate_code' => '54',
                'service_symbol' => '&reg;'
            ],
            'EXPRESS_SAVER' => [
                'service_name' => 'UPS Express Saver',
                'rate_code' => '65',
                'service_symbol' => '&reg;'
            ],
            'WW_SAVER' => [
                'service_name' => 'UPS Express Saver',
                'rate_code' => '65',
                'service_symbol' => '&reg;'
            ],
            'EXPRESS_WORLDWIDE_SAVER' => [
                'service_name' => 'UPS Worldwide Saver',
                'rate_code' => '65',
                'service_symbol' => '&reg;'
            ],
            'EXPRESS_12H' => [
                'service_name' => 'UPS Express 12:00',
                'rate_code' => '74',
                'service_symbol' => '&reg;'
            ],
            'EXPRESS_SAT_DELI' => [
                'service_name' => 'UPS Express - Saturday Delivery',
                'rate_code' => '07',
                'service_symbol' => '&reg;'
            ]
        ];
    }
}
