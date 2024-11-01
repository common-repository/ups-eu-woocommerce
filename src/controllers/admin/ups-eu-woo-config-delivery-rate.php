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
 * ups-eu-woo-config-delivery-rate.php - The core plugin class.
 *
 * This is used to config Delivery Rate.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Config_Delivery_Rate');

class Ups_Eu_Woo_Config_Delivery_Rate
{
    /**
     * Name function: ups_eu_woo_config_delivery_rate
     * Params: empty
     * Return: void
     */
    public function ups_eu_woo_config_delivery_rate()
    {
        /* define necessary */
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_services = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Services();
        $model_delivery_rates = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Delivery_Rates();
        $options = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Options();
        /* get select type */
        $select_type = [];
        if (!empty($_REQUEST[$model_delivery_rates->select_type])) {
            $select_type = $_REQUEST[$model_delivery_rates->select_type];
        }
        /* get delivery with flat rate */
        $delivery_rate_flat = [];
        if (!empty($_REQUEST[$model_delivery_rates->delivery_rate_flat])) {
            $delivery_rate_flat = $_REQUEST[$model_delivery_rates->delivery_rate_flat];
        }
        
        /* get delivery with real time */
        $delivery_rate_real_time = [];
        if (!empty($_REQUEST[$model_delivery_rates->delivery_rate_real_time])) {
            $delivery_rate_real_time = $_REQUEST[$model_delivery_rates->delivery_rate_real_time];
        }

        /* get flat rate calculation options */
        $ups_flat_cal_discount = '';
        if (!empty($_REQUEST[$model_delivery_rates->ups_flat_cal_discount])) {
            $ups_flat_cal_discount = $_REQUEST[$model_delivery_rates->ups_flat_cal_discount];
        }
        
        /* define variable */
        $check_validate_all = false;
        $check_save_success = 0;
        $mess_duplicate_flat_rate = "";
        /* check method post */
        if ($router_url->ups_eu_woo_check_method_post() === true) {
           
            /* Remove all data of type not choise */
            list($delivery_rate_flat_save, $delivery_rate_real_time_save) = $this->ups_eu_woo_remove_hide_data(
                $select_type,
                $delivery_rate_flat,
                $delivery_rate_real_time
            );
            /* Get button type */
            $btn_controller = "";
            if (!empty($_REQUEST[$router_url->btn_controller])) {
                $btn_controller = trim(sanitize_text_field(strip_tags($_REQUEST[$router_url->btn_controller])));
            }
            /* Validate */
            $delivery_rate_flat_save = $model_delivery_rates->ups_eu_woo_format_validate_array_type_flat(
                $delivery_rate_flat_save
            );
            /* check duplicate flat rate */
            $mess_duplicate_flat_rate = $model_delivery_rates->ups_eu_woo_duplicate_flat_rate(
                $delivery_rate_flat_save
            );
            /* set duplicate flat rate */
            $mess_duplicate_flat_rate = "";
            if ($mess_duplicate_flat_rate === true) {
                $mess_duplicate_flat_rate = $mess_duplicate_flat_rate;
            }
            /* validate real time service */
            $delivery_rate_real_time_save = $model_delivery_rates->ups_eu_woo_format_validate_array_type_real_time(
                $delivery_rate_real_time_save
            );
            /* check validate all service */
            $check_validate_all = $model_delivery_rates->ups_eu_woo_check_validate_by_select(
                $delivery_rate_flat_save,
                $delivery_rate_real_time_save,
                $select_type
            );

            if (array_key_exists('ups_flat_cal_discount', $_REQUEST)) {
                $model_config->ups_eu_woo_set_value_config_by_key($model_config->ups_flat_cal_discount, 1, "new_or_overwrite");
            } else {
                $model_config->ups_eu_woo_set_value_config_by_key($model_config->ups_flat_cal_discount, 0, "new_or_overwrite");
            }

            if ($check_validate_all === false) {
                /* call save all to deliver rate */
                
                $model_delivery_rates->ups_eu_woo_save_all(
                    $delivery_rate_flat_save,
                    $delivery_rate_real_time_save,
                    $select_type
                );

                /* call retry api */
                if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_check_manage) === true &&
                    intval($model_config->value) === 1
                ) {
                    call_user_func_array([
                        new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Retry_Api(),
                        "ups_eu_woo_transfer_delivery_rates"
                    ], []);
                }
                /* set key config [ACCEPT_DELIVERY_RATES] */
                $model_config->ups_eu_woo_set_value_config_by_key(
                    "{$model_config->ACCEPT_DELIVERY_RATES}",
                    1,
                    $model_config->btn_controller_save
                );


                /* define variable */
                //$select_type = []
                $delivery_rate_flat = [];
                $delivery_rate_real_time = [];
                $check_validate_all = false;
                $check_save_success = 1;
                if ($btn_controller === "{$model_config->btn_controller_next}") {
                    /* set key config accept billing preference */
                    $model_config->ups_eu_woo_set_value_config_by_key(
                        $model_config->ACCEPT_BILLING_PREFERENCE,
                        2,
                        $model_config->btn_controller_next
                    );
                    /* redirect to billing preference page */
                    $router_url->ups_eu_woo_redirect($router_url->url_billing_preference);
                }
            } else {
                /* Set validate message to data show in view      */
                $delivery_rate_flat = $this->ups_eu_woo_merge_data(
                    $delivery_rate_flat,
                    $delivery_rate_flat_save
                );
                /* merge data type real time */
                $delivery_rate_real_time = $this->ups_eu_woo_merge_data(
                    $delivery_rate_real_time,
                    $delivery_rate_real_time_save
                );
            }
        }

        $dataObject = new \stdClass();
        /* get language by key */
        $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
            $model_delivery_rates->lang_page_delivery_rate
        );
        $dataObject->number_block_show = $router_url->ups_eu_woo_get_number_block_show(
            $router_url->block_delivery_rate,
            6
        );
        /* render data with smarty */
        $obj_smarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $smarty = $obj_smarty->ups_eu_woo_get_smarty();
        $country_list = WC()->countries->__get('countries');
        $smarty->assign('country_list',$country_list);
        $dataObject->object_json_javascript = json_encode([
            "element_flat_rate" => $smarty->fetch(
                "admin/merchant_cf/shipping_config/javascript/element_flat_rate.tpl"
            ),
        ]);
        /* get list service */
        $model_config->ups_eu_woo_get_by_key("COUNTRY_CODE");
        $country_code = $model_config->value;
        $dataObject->services = $model_services->get_list_data_by_condition(
            [
                $model_services->col_country_code => $country_code,
                $model_services->col_service_selected => '1'
            ]
        );
        /* set config value DELIVERY_TO_ACCESS_POINT */
        $dataObject->DELIVERY_TO_ACCESS_POINT = "";
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->DELIVERY_TO_ACCESS_POINT}") === true) {
            $dataObject->DELIVERY_TO_ACCESS_POINT = $model_config->value;
        }
        /* set config value DELIVERY_TO_SHIPPING_ADDRESS */
        $dataObject->DELIVERY_TO_SHIPPING_ADDRESS = "";
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->DELIVERY_TO_SHIPPING_ADDRESS}") === true) {
            $dataObject->DELIVERY_TO_SHIPPING_ADDRESS = $model_config->value;
        }
        /* set config value ACCEPT_DELIVERY_RATES */
        $dataObject->ACCEPT_DELIVERY_RATES = "";
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->ACCEPT_DELIVERY_RATES}") === true) {
            $dataObject->ACCEPT_DELIVERY_RATES = $model_config->value;
        }
        $dataObject->ups_flat_cal_discount = "";
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->ups_flat_cal_discount}") === true) {
            $dataObject->ups_flat_cal_discount = $model_config->value;
        }

        /* set init delivery rates */
        $model_delivery_rates->ups_eu_woo_init_delivery_rates(
            $select_type,
            $delivery_rate_flat,
            $delivery_rate_real_time,
            $check_validate_all,
            $dataObject,
            $country_code
        );
        $dataObject->check_save_success = $check_save_success;
        /* get type rate */
        $dataObject->get_type_rate = $options->get_type_rate();
        /* get country list */
        $dataObject->country_list = WC()->countries->__get('countries');
       
        /* get woocommerce currency */
        $dataObject->get_woocommerce_currency = get_woocommerce_currency();
        $dataObject->action_form = $router_url->url_delivery_rate;
        $dataObject->links_form = $router_url->ups_eu_woo_get_all_link_form();
        $dataObject->mess_duplicate_flat_rate = $mess_duplicate_flat_rate;
        $dataObject->page = $router_url->block_delivery_rate;

        return $dataObject;
    }

    /**
     * Name function: ups_eu_woo_merge_data
     * Params:
     * @arr1: type array
     * @$arr2: type array
     * Return: type array
     */
    public function ups_eu_woo_merge_data($arr1, $arr2)
    {
        foreach ($arr1 as $key => $item) {
            if (array_key_exists($key, $arr2)) {
                $arr1[$key] = $arr2[$key];
            }
        }

        return $arr1;
    }

    /**
     * Name function: ups_eu_woo_remove_hide_data
     * Params:
     * @select_type: type array
     * @delivery_rate_flat: type array
     * @delivery_rate_real_time: type array
     * Return: type array
     */
    public function ups_eu_woo_remove_hide_data($select_type, $delivery_rate_flat, $delivery_rate_real_time)
    {
        /* check all service type */
        foreach ($select_type as $service_id => $item_type) {
            $type = intval($item_type["type"]);
            switch ($type) {
                /* real time */
                case 1:
                    if (array_key_exists($service_id, $delivery_rate_real_time)) {
                        unset($delivery_rate_real_time[$service_id]);
                    }
                    break;
                /* flat rate */
                case 2:
                    if (array_key_exists($service_id, $delivery_rate_flat)) {
                        unset($delivery_rate_flat[$service_id]);
                    }
                    break;
                default:
                    break;
            }
        }

        return [$delivery_rate_flat, $delivery_rate_real_time];
    }
}
