<?php namespace UpsEuWoocommerce\controllers\admin;

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
 * ups-eu-woo-config-shipping-service.php - The core plugin class.
 *
 * This is used to config Shipping Service.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Config_Shipping_Service');

class Ups_Eu_Woo_Config_Shipping_Service
{

    /**
     * Name function: shipping_service
     * Params: empty
     * Return: void
     */
    public function ups_eu_woo_config_shipping_service()
    {
        /* Load models class */
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $model_services = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Services();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_account = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Account();
        $options = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Options();
        /* Init variable */
        $ups_services = [];
        $mess_dont_check = "";
        $configs = [];
        /* check method post */
        if ($router_url->ups_eu_woo_check_method_post() === true) {
            /* Get btn controller button is clicked */
            $btn_controller = "";
            if (!empty($_REQUEST[$router_url->btn_controller])) {
                $btn_controller = trim(sanitize_text_field(strip_tags($_REQUEST[$router_url->btn_controller])));
            }
            /* Get all data request */
            $data = $_REQUEST;
            /* set data of ups_services */
            if (!empty($data[$model_services->ups_services])) {
                $ups_services = $data[$model_services->ups_services];
            }
            /* set data config */
            if (!empty($data[$model_services->configs])) {
                $configs = $data[$model_services->configs];
            }

            /* set packing Type */
            global $wpdb;
            $table_name = $wpdb->prefix . "ups_shipping_config";
            $result = $wpdb->get_results( "SELECT value FROM $table_name WHERE `key` = 'UPS_ACCEPT_PACKAGE_TYPE'" );
           
            if(!empty($result)) {
                $wpdb->update($table_name, array('value' => $data['ups_package_type']),array('key' => 'UPS_ACCEPT_PACKAGE_TYPE'));       
            } else {
                $data = array('scope' => 'default','scope_id' => '0','key' => 'UPS_ACCEPT_PACKAGE_TYPE','value' => $data['ups_package_type']);
                $wpdb->insert( $table_name, $data);
            }

            /* check btn controller is next */
            if ($btn_controller === "{$model_config->btn_controller_next}") {
                /* check save shipping service to database */
                $check = $this->ups_eu_woo_save_shipping_service($ups_services, $configs);
                if ($check === true) {
                    /* The case save is true */
                    $model_config->ups_eu_woo_set_value_config_by_key(
                        "{$model_config->ACCEPT_CASH_ON_DELIVERY}",
                        2,
                        $model_config->btn_controller_next
                    );
                    /* transfer shipping service */
                    if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_check_manage) === true &&
                        intval($model_config->value) === 1
                    ) {
                        call_user_func_array([
                            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Retry_Api(), "ups_eu_woo_transfer_shipping_services"
                        ], []);
                    }
                    /* redirect to collect on delivery */
                    $router_url->ups_eu_woo_redirect($router_url->url_cod);
                } else {
                    /* The case is false */
                    $mess_dont_check = $check;
                }
            }

            if ($btn_controller === "{$model_config->btn_controller_save}" &&
                count($configs) > 0) {
                /* set config */
                $check = $this->ups_eu_woo_save_shipping_service($ups_services, $configs);
                if ($check === true) {
                    /* transfer shipping service */
                    if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_check_manage) === true &&
                        intval($model_config->value) === 1
                    ) {
                        call_user_func_array([
                            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Retry_Api(), "ups_eu_woo_transfer_shipping_services"
                        ], []);
                    }
                    /* redirect to shipping service */
                    $router_url->ups_eu_woo_redirect($router_url->url_shipping_service);
                } else {
                    $mess_dont_check = $check;
                }
            }
        }
        /* Created object */
        $dataObject = new \stdClass();
        /* get language by key */
        $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
            $model_services->lang_page_shipping_service
        );
        /* get number block show */
        $dataObject->number_block_show = $router_url->ups_eu_woo_get_number_block_show(
            $router_url->block_shipping_service,
            2
        );
        /* Assigned message dont check */
        $dataObject->mess_dont_check = $mess_dont_check;
        /* Get contry_code */
        $model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE);
        /* set country_code value */
        if (!empty($model_config->value)) {
            $country_code = $model_config->value;
        } else {
            $country_code = "GB";
        }
        /* Init params */
        $model_services->ups_eu_woo_init_params(
            $model_config,
            $country_code,
            $dataObject,
            $configs,
            $ups_services
        );
        /* get packing Type */
        global $wpdb;
        $table_name = $wpdb->prefix . "ups_shipping_config";
        $result = $wpdb->get_results( "SELECT value FROM $table_name WHERE `key` = 'UPS_ACCEPT_PACKAGE_TYPE'" );
        $value = isset($result[0]->value) ? $result[0]->value : "BOX";
        $dataObject->ups_package_type = $value;
        /* get list data account */
        $dataObject->list_data_account = $model_account->get_list_data_by_condition();
        /* Assigned config */
        $dataObject->configs->list_data_range = [5, 10, 15, 20, 30, 50];
        $dataObject->configs->list_time_day = $options->list_time_day();
        /* set action form url */
        $dataObject->action_form = $router_url->url_shipping_service;
        $dataObject->links_form = $router_url->ups_eu_woo_get_all_link_form();

        $dataObject->page = $router_url->block_shipping_service;
        return $dataObject;
    }

    /**
     * Name function: ups_eu_woo_save_shipping_service
     * Params:
     * @ups_services: type array
     * @configs: type array
     * Return: type array
     */
    private function ups_eu_woo_save_shipping_service($ups_services, $configs)
    {
        /* Init models  for implement */
        $model_services = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Services();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_delivery_rates = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Delivery_Rates();

        $DELIVERY_TO_ACCESS_POINT = "";
        $rate_data = $model_delivery_rates->get_list_data_by_condition();
        $list_service_ids = array_map(function ($item) {
            return (int)$item->service_id;
        }, $rate_data);

        $country_code = '';
        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            $country_code = strtolower($model_config->value);
        }
        $rate_type_value = 1;
        $min_order_value = 0;
        $delivery_rate = 0;
        $rate_type = 1;
        if ('us' == $country_code) {
            $rate_type = 2;
            $rate_type_value = 2;
            $min_order_value = null;
            $delivery_rate = 100;
        }
        $delivery_value = [];
        //$item_type["type"];
        $item_type = [];
        /* santize data from form post */
        if (!empty($configs[$model_config->DELIVERY_TO_ACCESS_POINT])) {
            $DELIVERY_TO_ACCESS_POINT = sanitize_text_field($configs[$model_config->DELIVERY_TO_ACCESS_POINT]);
        }
        /* set value DELIVERY_TO_ACCESS_POINT on/off */
        if ($DELIVERY_TO_ACCESS_POINT === "on") {
            $DELIVERY_TO_ACCESS_POINT = 1;
        } else {
            $DELIVERY_TO_ACCESS_POINT = 0;
        }
        /* set value DELIVERY_TO_SHIPPING_ADDRESS */
        $DELIVERY_TO_SHIPPING_ADDRESS = "";
        if (!empty($configs[$model_config->DELIVERY_TO_SHIPPING_ADDRESS])) {
            $DELIVERY_TO_SHIPPING_ADDRESS = sanitize_text_field($configs[$model_config->DELIVERY_TO_SHIPPING_ADDRESS]);
        }
        /* set value DELIVERY_TO_SHIPPING_ADDRESS on/off */
        if ($DELIVERY_TO_SHIPPING_ADDRESS === "on") {
            $DELIVERY_TO_SHIPPING_ADDRESS = 1;
        } else {
            $DELIVERY_TO_SHIPPING_ADDRESS = 0;
        }
        /* check validate shipping service before save */
        $check_validate = $model_services->ups_eu_woo_check_validate_before_save(
            $DELIVERY_TO_ACCESS_POINT,
            $DELIVERY_TO_SHIPPING_ADDRESS,
            $ups_services
        );
        /* Check validate data */
        if ($check_validate === true) {
            $list_service_remove = [];
            foreach ($ups_services as $item) {
                $id = intval($item[$model_services->col_id]);
                if ($id > 0) {
                    /* get service data by id */
                    $model_services->ups_eu_woo_get_by_id($item[$model_services->col_id]);
                    /* set service selected value */
                    if (!empty($item[$model_services->col_service_selected])) {
                        $model_services->service_selected = 1;
                        if (!in_array($id, $list_service_ids)) {
                            $delivery_value['id'] = $id;
                            $delivery_value['service_id'] = $id;
                            $delivery_value['rate_type'] = $rate_type_value;
                            $delivery_value['min_order_value'] = $min_order_value;
                            $delivery_value['delivery_rate'] = $delivery_rate;
                            $model_delivery_rates->ups_eu_woo_merge_array($delivery_value);
                            $model_delivery_rates->ups_eu_woo_save();
                        }
                    } else {
                        $model_services->service_selected = 0;
                    }
                    /* save service info to database */
                    $model_services->ups_eu_woo_save();

                    /* Get all id will remove in delivery rate */
                    if ($model_services->service_selected == 0) {
                        $list_service_remove[] = $item[$model_services->col_id];
                    }
                }
            }
            /* Remove all data in delivery rate if shipping service is uncheck */
            if (!empty($list_service_remove)) {
                $str_service_id = implode(',', $list_service_remove);
                /* delete all service */
                $model_delivery_rates->ups_eu_woo_delete_all(["service_id IN ({$str_service_id})"]);
            }
            /* set value NUMBER_OF_ACCESS_POINT_AVAIABLE */
            $NUMBER_OF_ACCESS_POINT_AVAIABLE = "";
            if (!empty($configs[$model_config->NUMBER_OF_ACCESS_POINT_AVAIABLE])) {
                $NUMBER_OF_ACCESS_POINT_AVAIABLE = intval(sanitize_text_field($configs[$model_config->NUMBER_OF_ACCESS_POINT_AVAIABLE]));
            }

            /* set value config by key */
            $model_config->ups_eu_woo_set_value_config_by_key(
                "{$model_config->NUMBER_OF_ACCESS_POINT_AVAIABLE}",
                $NUMBER_OF_ACCESS_POINT_AVAIABLE
            );
            /* set value DISPLAY_ALL_ACCESS_POINT_IN_RANGE */
            $DISPLAY_ALL_ACCESS_POINT_IN_RANGE = "";
            if (!empty($configs[$model_config->DISPLAY_ALL_ACCESS_POINT_IN_RANGE])) {
                $DISPLAY_ALL_ACCESS_POINT_IN_RANGE = intval(sanitize_text_field($configs[$model_config->DISPLAY_ALL_ACCESS_POINT_IN_RANGE]));
            }
            /* set config value of DISPLAY_ALL_ACCESS_POINT_IN_RANGE */
            $model_config->ups_eu_woo_set_value_config_by_key(
                "{$model_config->DISPLAY_ALL_ACCESS_POINT_IN_RANGE}",
                $DISPLAY_ALL_ACCESS_POINT_IN_RANGE
            );
            /* set value of CHOOSE_ACCOUNT_NUMBER_AP */
            $CHOOSE_ACCOUNT_NUMBER_AP = "";
            if (!empty($configs[$model_config->CHOOSE_ACCOUNT_NUMBER_AP])) {
                $CHOOSE_ACCOUNT_NUMBER_AP = sanitize_text_field($configs[$model_config->CHOOSE_ACCOUNT_NUMBER_AP]);
            }
            /* set value config by key CHOOSE_ACCOUNT_NUMBER_AP */
            $model_config->ups_eu_woo_set_value_config_by_key(
                "{$model_config->CHOOSE_ACCOUNT_NUMBER_AP}",
                $CHOOSE_ACCOUNT_NUMBER_AP
            );
            /* set value of CHOOSE_ACCOUNT_NUMBER_ADD */
            $CHOOSE_ACCOUNT_NUMBER_ADD = "";
            if (!empty($configs[$model_config->CHOOSE_ACCOUNT_NUMBER_ADD])) {
                $CHOOSE_ACCOUNT_NUMBER_ADD = sanitize_text_field($configs[$model_config->CHOOSE_ACCOUNT_NUMBER_ADD]);
            }
            /* set value config by key CHOOSE_ACCOUNT_NUMBER_ADD */
            $model_config->ups_eu_woo_set_value_config_by_key(
                "{$model_config->CHOOSE_ACCOUNT_NUMBER_ADD}",
                $CHOOSE_ACCOUNT_NUMBER_ADD
            );
            /* set value config by key DELIVERY_TO_ACCESS_POINT */
            $model_config->ups_eu_woo_set_value_config_by_key(
                "{$model_config->DELIVERY_TO_ACCESS_POINT}",
                $DELIVERY_TO_ACCESS_POINT
            );
            /* set value config by key DELIVERY_TO_SHIPPING_ADDRESS */
            $model_config->ups_eu_woo_set_value_config_by_key(
                "{$model_config->DELIVERY_TO_SHIPPING_ADDRESS}",
                $DELIVERY_TO_SHIPPING_ADDRESS
            );
            /* set value of SET_DEFAULT */
            $SET_DEFAULT = "";
            if (!empty($configs[$model_config->SET_DEFAULT])) {
                $SET_DEFAULT = sanitize_text_field($configs[$model_config->SET_DEFAULT]);
            }
            if (!empty($SET_DEFAULT)) {
                $SET_DEFAULT = 1;
            } else {
                $SET_DEFAULT = 0;
            }

            /* set value config by key SET_DEFAULT */
            $model_config->ups_eu_woo_set_value_config_by_key("{$model_config->SET_DEFAULT}", $SET_DEFAULT);

            /* set value of AP_AS_SHIPTO */
            $AP_AS_SHIPTO = "";
            if (!empty($configs[$model_config->AP_AS_SHIPTO])) {
                $AP_AS_SHIPTO = sanitize_text_field($configs[$model_config->AP_AS_SHIPTO]);
            }
            if (!empty($AP_AS_SHIPTO)) {
                $AP_AS_SHIPTO = 1;
            } else {
                $AP_AS_SHIPTO = 0;
            }

            /* set value config by key AP_AS_SHIPTO */
            $model_config->ups_eu_woo_set_value_config_by_key("{$model_config->AP_AS_SHIPTO}", $AP_AS_SHIPTO, "new_or_overwrite");

            /* set value of ADULT_SIGNATURE */
            $ADULT_SIGNATURE = "";
            if (!empty($configs[$model_config->ADULT_SIGNATURE])) {
                $ADULT_SIGNATURE = sanitize_text_field($configs[$model_config->ADULT_SIGNATURE]);
            }
            if (!empty($ADULT_SIGNATURE)) {
                $ADULT_SIGNATURE = 1;
            } else {
                $ADULT_SIGNATURE = 0;
            }

            /* set value config by key ADULT_SIGNATURE */
            $model_config->ups_eu_woo_set_value_config_by_key("{$model_config->ADULT_SIGNATURE}", $ADULT_SIGNATURE);
            /* set cut of time value */
            $CUT_OFF_TIME = "";
            if (!empty($configs[$model_config->CUT_OFF_TIME])) {
                $CUT_OFF_TIME = sanitize_text_field($configs[$model_config->CUT_OFF_TIME]);
            }
            /* set value config by key CUT_OFF_TIME */
            $model_config->ups_eu_woo_set_value_config_by_key("{$model_config->CUT_OFF_TIME}", $CUT_OFF_TIME);
            /* set value config by key ACCEPT_SHIPPING_SERVICE */
            $model_config->ups_eu_woo_set_value_config_by_key(
                "{$model_config->ACCEPT_SHIPPING_SERVICE}",
                1,
                $model_config->btn_controller_save
            );
            return true;
        } else {
            /* set value message return when don't check */
            $mess_dont_check = __(
                "Please select at least one shipping service.",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
            return $mess_dont_check;
        }
    }
}
