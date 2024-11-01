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
 * ups-eu-woo-config-accessorial-service.php - The core plugin class.
 *
 * This is used to config Accessorial Service.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Config_Accessorial_Service');

class Ups_Eu_Woo_Config_Accessorial_Service
{

    /**
     * Name function: ups_eu_woo_accessorial_services
     * Params: empty
     * Return: void
     */
    public function ups_eu_woo_config_accessorial_services()
    {

        /* load class models */
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_accessorial = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Accessorial();
        $dataObject = new \stdClass();
        /* Get status install COD Plugin */
        $WC_Gateway_COD = new \WC_Gateway_COD();
        $dataObject->cod_is_available = $WC_Gateway_COD->is_available();
        $dataObject->list_option_check_disable = [
            $model_accessorial->UPS_ACSRL_ACCESS_POINT_COD,
            $model_accessorial->UPS_ACSRL_TO_HOME_COD
        ];
        /* Check method post */
        if ($router_url->ups_eu_woo_check_method_post() === true) {
            $btn_controller = '';
            if (!empty($_REQUEST[$router_url->btn_controller])) {
                $btn_controller = trim(sanitize_text_field(strip_tags($_REQUEST[$router_url->btn_controller])));
            }
            
            /* Check action next */
            if ($btn_controller === $router_url->btn_controller_next) {
                $this->save_accessorial_services($_REQUEST, $dataObject->cod_is_available, $dataObject);
                $model_config->ups_eu_woo_set_value_config_by_key(
                    $model_config->ACCEPT_PACKAGE_DIMENSION,
                    2,
                    $router_url->btn_controller_next
                );
                $router_url->ups_eu_woo_redirect($router_url->url_package_dimension);
            }
            /* Check action save */
            if ($btn_controller === $router_url->btn_controller_save) {
                /* Get data from method post */
                $this->save_accessorial_services($_REQUEST, $dataObject->cod_is_available, $dataObject);
                /* Save status finish page */
                if ($model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_ACCESSORIAL) === true) {
                    $model_config->value = 1;
                    $model_config->ups_eu_woo_save();
                }
                /* set value to conifg  by key  accept page dimension */
                $model_config->ups_eu_woo_set_value_config_by_key(
                    $model_config->ACCEPT_PACKAGE_DIMENSION,
                    2,
                    $router_url->btn_controller_next
                );
                $router_url->ups_eu_woo_redirect($router_url->url_package_dimension);
            }
        }
        /* Get  languae */
        $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
            $model_accessorial->lang_page_accessorial_services
        );
        /* Get status tab show */
        $dataObject->number_block_show = $router_url->ups_eu_woo_get_number_block_show(
            $model_accessorial->key_accessorial_services,
            4
        );
        /* Get option from database */
        $dataObject->list_option_accessorials = $model_accessorial->get_list_data_by_condition(
            ['show_config = 1'],
            $router_url->btn_controller_all,
            [$model_accessorial->col_id => $model_accessorial->ASC]
        );
        $dataObject->action_form = $router_url->url_accessorial_services;
        $dataObject->links_form = $router_url->ups_eu_woo_get_all_link_form();
        $dataObject->ACCEPT_ACCESSORIAL = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_ACCESSORIAL) === true) {
            $dataObject->ACCEPT_ACCESSORIAL = $model_config->value;
        }
        $dataObject->page = $model_accessorial->key_accessorial_services;

        return $dataObject;
    }

    /**
     * Name function: save_accessorial_services
     * Params:
     * @data: type array
     * @cod_is_available: type boolean
     * @dataObject: type object
     * Return: void
     */
    private function save_accessorial_services($data, $cod_is_available, $dataObject)
    {
        /* Created object model */
        $model_accessorial = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Accessorial();
        
        $ups_accessorial_services = [];
        if (!empty($data[$model_accessorial->key_accessorial_services])) {
            $ups_accessorial_services = $data[$model_accessorial->key_accessorial_services];
        }

        $list_check = $list_un_check = $list_checked = $list_un_checked = '';

        if (!empty($ups_accessorial_services)) {
            foreach ($ups_accessorial_services as $item => $val) {
                /* String list of option will check */
                $list_check .= '"' . $item . '",';
                /* Option was disabled will not change statuus */
                if (!$cod_is_available && in_array($item, $dataObject->list_option_check_disable)) {
                    continue;
                }
                /* String list of option will uncheck */
                $list_un_check .= '"' . $item . '",';
            }

            /* Condition for list option checked */
            $list_checked = $model_accessorial->col_accessorial_key . ' IN (' . rtrim($list_check, ',') . ')';
            /* Condition for list option unchecked */
            $list_un_checked = $model_accessorial->col_accessorial_key . ' NOT IN (' . rtrim($list_un_check, ',') . ')';
        }

        /* Save data : checked option */
        $model_accessorial->ups_eu_woo_update_all([$model_accessorial->col_show_shipping => 1], [$list_checked]);
        /* Save data : unchecked option without option was disabled */
        $model_accessorial->ups_eu_woo_update_all([$model_accessorial->col_show_shipping => 0], [$list_un_checked, "show_config = 1"]);
    }
}
