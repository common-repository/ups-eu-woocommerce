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
 * ups-eu-woo-config-package-dimension.php - The core plugin class.
 *
 * This is used to config Package Dimension.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Config_Package_Dimension');

class Ups_Eu_Woo_Config_Package_Dimension
{
    /**
     * Name function: package_dimension
     * Params: empty
     * Return: void
     */
    public function ups_eu_woo_config_package_dimension()
    {
        /* Load all class or models */
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $model_services = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Services();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_package = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Package_Default();
        $model_fallback_rates = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Fallback_Rates();
        $model_product_dimension = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Product_Dimension();

        /* Created object */
        $dataObject = new \stdClass();
        /* submit form */
        if ($router_url->ups_eu_woo_check_method_post() === true) {
            $post_data = $_REQUEST;
            $package_setting_option = intval($post_data['package_setting_option']);
            $package_dimension = json_decode(stripcslashes($post_data['package_dimension']));
            $btn_controller = $post_data[$router_url->btn_controller];
            // Save data default package
            if (1 == $package_setting_option) {
                $order = [
                    'package_id' => 'DESC'
                ];
                $last_package = $model_package->get_final_data_by_condition([], 1, $order);
                $lastname_package = (!empty($last_package[0]->package_name) ? $last_package[0]->package_name : '');
                $arr_last_package = explode('_', $lastname_package);
                $last_number = 1 * (!empty($arr_last_package[1]) ? $arr_last_package[1] : 0);
                $model_package->ups_eu_woo_delete_all();
                foreach ($package_dimension as $key => $item) {
                    $last_number++;
                    $item->package_name = 'Package_' . $last_number;
                    $model_package->ups_eu_woo_save_package($item);
                }
            }
            // Save data product dimension
            if (2 == $package_setting_option) {
                // Get post data
                $include_dimension_setting = $post_data['include_dimension_setting'];
                $fallback_rates = json_decode(stripcslashes($post_data['backup_rate']));
                // Save include dimension setting
                $model_config->ups_eu_woo_set_value_config_by_key(
                    "{$model_config->ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS}",
                    $include_dimension_setting
                );
                // Get to address setting
                $deliveryToShippingAddress = 0;
                if ($model_config->ups_eu_woo_get_by_key($model_config->DELIVERY_TO_SHIPPING_ADDRESS) === true) {
                    $deliveryToShippingAddress = $model_config->value;
                }
                if ($deliveryToShippingAddress == 1) {
                    $model_fallback_rates->ups_eu_woo_delete_all();
                    foreach ($fallback_rates as $item) {
                        $model_fallback_rates->ups_eu_woo_merge_array($item);
                        $model_fallback_rates->ups_eu_woo_save();
                    }
                }
                $pack_algo = isset($post_data['pack_algo']) ? $post_data['pack_algo'] : "";
                // Save algo setting
                $check_pack_algo = $model_config->get_list_data_by_condition(["`key`='{$model_config->UPS_PACK_ALGO}'"]);
                if (empty($check_pack_algo)) {
                    $InitDataSystem = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Init_Data_System();
                    /* insert table config */
                    $InitDataSystem->ups_eu_woo_int_first_insert_table_config_pac_algo();
                }

                $model_config->ups_eu_woo_set_value_config_by_key(
                    "{$model_config->UPS_PACK_ALGO}",
                    $pack_algo
                );

                if ( !empty($pack_algo) && $pack_algo != 3) {
                    $weg_unit = isset($post_data['weg_unit']) ? $post_data['weg_unit'] : "";
                    // Save pack weight unit setting
                    $model_config->ups_eu_woo_set_value_config_by_key(
                        "{$model_config->UPS_PACK_WEG_UNIT}",
                        $weg_unit
                    );
                    if ($pack_algo == 1) {
                        $dim_unit = isset($post_data['dim_unit']) ? $post_data['dim_unit'] : "";
                        // Save pack dimension unit setting
                        $model_config->ups_eu_woo_set_value_config_by_key(
                            "{$model_config->UPS_PACK_DIM_UNIT}",
                            $dim_unit
                        );
                    }
                    if ($pack_algo == 2) {
                        $max_weg = isset($post_data['max_pac_weig']) ? $post_data['max_pac_weig'] : "";
                        // Save pack max weight setting
                        $model_config->ups_eu_woo_set_value_config_by_key(
                            "{$model_config->UPS_PACK_MAX_WEIGHT}",
                            $max_weg
                        );
                    }
                } else {
                    $model_product_dimension->ups_eu_woo_delete_all();
                    foreach ($package_dimension as $item) {
                        $model_product_dimension->ups_eu_woo_save_package($item);
                    }
                }
            }
            // Save package setting option
            $model_config->ups_eu_woo_set_value_config_by_key(
                "{$model_config->PACKAGE_SETTING_OPTION}",
                $package_setting_option
            );
            // Save status package dimension in accepted
            $model_config->ups_eu_woo_set_value_config_by_key(
                "{$model_config->ACCEPT_PACKAGE_DIMENSION}",
                1
            );
            // Call manage api
            if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_check_manage) === true && intval($model_config->value) === 1) {
                call_user_func_array([
                    new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Retry_Api(),
                    "ups_eu_woo_transfer_default_package"
                ], []);
            }
            // Redirect page
            if ($btn_controller == $model_config->btn_controller_next) {
                // Save status delivery rates in accepted
                $model_config->ups_eu_woo_set_value_config_by_key(
                    "{$model_config->ACCEPT_DELIVERY_RATES}",
                    1
                );
                $router_url->ups_eu_woo_redirect($router_url->url_delivery_rate);
                return;
            } else {
                $router_url->ups_eu_woo_redirect($router_url->url_package_dimension);
                return;
            }
        }
        /* Get package setting option */
        $dataObject->configs = new \stdClass();
        $dataObject->configs->PACKAGE_SETTING_OPTION = 1;
        if ($model_config->ups_eu_woo_get_by_key($model_config->PACKAGE_SETTING_OPTION) === true) {
            $dataObject->configs->PACKAGE_SETTING_OPTION = $model_config->value;
        }
        /* Get include dimensions setting */
        $dataObject->configs->ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS = 0;
        if ($model_config->ups_eu_woo_get_by_key($model_config->ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS) === true) {
            $dataObject->configs->ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS = $model_config->value;
        }
        /* Get to address setting */
        $dataObject->configs->DELIVERY_TO_SHIPPING_ADDRESS = 0;
        if ($model_config->ups_eu_woo_get_by_key($model_config->DELIVERY_TO_SHIPPING_ADDRESS) === true) {
            $dataObject->configs->DELIVERY_TO_SHIPPING_ADDRESS = $model_config->value;
        }
        /* Get contry_code */
        $model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE);
        /* set country_code value */
        if (!empty($model_config->value)) {
            $country_code = $model_config->value;
        } else {
            $country_code = "GB";
        }
        $dataObject->list_data_service = $model_services->get_list_data_by_condition(
            [
                $model_services->col_country_code => $country_code,
                $model_services->col_service_type => 'ADD',
                $model_services->col_service_selected => '1'
            ]
        );
        $list_fallback_rate = $model_fallback_rates->ups_eu_woo_get_all();
        if (empty($list_fallback_rate)) {
            $fallback_rate_obj = new \stdClass();
            $fallback_rate_obj->service_id = '';
            $fallback_rate_obj->fallback_rate = 0;
            $list_fallback_rate[] = $fallback_rate_obj;
        }
        $list_product_dimension = $model_product_dimension->ups_eu_woo_get_all();
        if (empty($list_product_dimension)) {
            $package_obj = new \stdClass();
            $package_obj->package_name = '';
            $package_obj->length = '';
            $package_obj->width = '';
            $package_obj->height = '';
            $package_obj->unit_dimension = $country_code == "US" ? 'inch' : 'cm';
            $package_obj->weight = '';
            $package_obj->unit_weight = $country_code == "US" ? 'lbs' : 'kgs';
            $list_product_dimension[] = $package_obj;
        }
        $dataObject->list_data_fallback_rate = $list_fallback_rate;
        $dataObject->list_data_product_dimension = $list_product_dimension;
        $dataObject->btn_save = $model_config->btn_controller_save;
        $dataObject->btn_next = $model_config->btn_controller_next;

        /* set language */
        $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
            $model_package->lang_page_package_dimension
        );
        /* get list all package */
        $list_packages = $model_package->get_list_data_by_condition();
        $dataObject->old_default = 0;
        if (!empty($list_packages) && empty($list_packages[0]->package_item)) {
            $list_packages[0]->package_item = 1;
            $dataObject->packages[] = $list_packages[0];
        } else {
            $dataObject->packages = $list_packages;
        }
        if (empty($dataObject->packages)) {
            $package_obj = new \stdClass();
            $package_obj->length = '';
            $package_obj->width = '';
            $package_obj->height = '';
            $package_obj->unit_dimension = $country_code == "US" ? 'inch' : 'cm';
            $package_obj->weight = '';
            $package_obj->unit_weight = $country_code == "US" ? 'lbs' : 'kgs';
            $package_obj->package_item = 1;
            $dataObject->packages[] = $package_obj;
        }
        $dataObject->javascript_data = json_encode($dataObject->packages);
        $dataObject->get_woocommerce_currency = get_woocommerce_currency();
        /* get unit weight list */
        $options = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Options();
        $dataObject->get_unit_weight_list = $options->get_unit_weight_list();
        /* get unit dimension list */
        $options = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Options();
        $dataObject->get_unit_dimension_list = $options->get_unit_dimension_list();
        /* set number block show */
        $dataObject->number_block_show = $router_url->ups_eu_woo_get_number_block_show(
            $router_url->block_package_dimension,
            5
        );
        /* get action form  url */
        $dataObject->action_form = $router_url->url_package_dimension;
        $dataObject->url_delivery_rate = $router_url->url_delivery_rate;
        /* get all link form in system */
        $dataObject->links_form = $router_url->ups_eu_woo_get_all_link_form();
        /* get key system  of page currrent */
        $dataObject->ACCEPT_PACKAGE_DIMENSION = "";
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->ACCEPT_PACKAGE_DIMENSION}") === true) {
            $dataObject->ACCEPT_PACKAGE_DIMENSION = $model_config->value;
        }
        // Packing algorithm configs
        $dataObject->UPS_PACK_ALGO = 3;
        $dataObject->UPS_PACK_DIM_UNIT = $country_code == "US" ? 'inch' : 'cm';
        $dataObject->UPS_PACK_WEG_UNIT = $country_code == "US" ? 'lbs' : 'kgs';
        $dataObject->UPS_PACK_MAX_WEIGHT = "";

        if ($model_config->ups_eu_woo_get_by_key("{$model_config->UPS_PACK_ALGO}") === true) {
            $dataObject->UPS_PACK_ALGO = $model_config->value;
        }
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->UPS_PACK_WEG_UNIT}") === true) {
            $dataObject->UPS_PACK_WEG_UNIT = $model_config->value;
        }
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->UPS_PACK_DIM_UNIT}") === true) {
            $dataObject->UPS_PACK_DIM_UNIT = $model_config->value;
        }
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->UPS_PACK_MAX_WEIGHT}") === true) {
            $dataObject->UPS_PACK_MAX_WEIGHT = $model_config->value;
        }

        $dataObject->page = $router_url->block_package_dimension;

        $dataObject->country_code = $country_code;
        /* get all package item exist*/
        //$dataObject->all_package_item = $model_package->get_all_item_by_package([], 'all', [], 'package_item');
        return $dataObject;
    }
}
