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
 * ups-eu-woo-config-cash-on-delivery.php - The core plugin class.
 *
 * This is used to config Cash On Delivery.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Config_Cash_On_Delivery');

class Ups_Eu_Woo_Config_Cash_On_Delivery
{

    /**
     * Name function: cod
     * Params: empty
     * Return: void
     */
    public function ups_eu_woo_config_cod()
    {

        /* Permission access link */
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();

        /* check method post */
        if ($router_url->ups_eu_woo_check_method_post() === true) {
            $data_post = $_REQUEST;
            /* set value config by key */
            if (array_key_exists('ups_accept_cod', $data_post)) {
                $model_config->ups_eu_woo_set_value_config_by_key($model_config->UPS_ACCEPT_CASH_ON_DELIVERY, 1);
            } else {
                $model_config->ups_eu_woo_set_value_config_by_key($model_config->UPS_ACCEPT_CASH_ON_DELIVERY, 0);
            }
            
            /* get value config by key */
            if ($model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_CASH_ON_DELIVERY) === true &&
                intval($model_config->value) === 2) {
                $router_url->ups_eu_woo_redirect($router_url->url_cod);
            }

            /* set value config ACCEPT_ACCESSORIAL */
            // $model_config->ups_eu_woo_set_value_config_by_key("ACCEPT_ACCESSORIAL", 2, "next")
            // $router_url->ups_eu_woo_redirect($router_url->url_accessorial_services)

            /* set value config ACCEPT_PACKAGE_DIMENSION */
            $model_config->ups_eu_woo_set_value_config_by_key(
                $model_config->ACCEPT_PACKAGE_DIMENSION,
                2,
                $router_url->btn_controller_next
            );
            /* redirect to package dimension page */
            $router_url->ups_eu_woo_redirect($router_url->url_package_dimension);
        }
        /* set value config ACCEPT_CASH_ON_DELIVERY */
        $model_config->ups_eu_woo_set_value_config_by_key(
            $model_config->ACCEPT_CASH_ON_DELIVERY,
            1,
            "save"
        );
        $dataObject = new \stdClass();
        /* get language by key */
        $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
            $model_config->lang_page_cod
        );
        $dataObject->number_block_show = $router_url->ups_eu_woo_get_number_block_show(
            $router_url->block_cod,
            3
        );
        /* check COD is available */
        $WC_Gateway_COD = new \WC_Gateway_COD();
        $dataObject->cod_is_available = $WC_Gateway_COD->is_available();

        $check_ups_accept_cod = $model_config->ups_eu_woo_get_value_by_key(
            $model_config->UPS_ACCEPT_CASH_ON_DELIVERY
        );
        
        /* set ups COD config */
        $dataObject->ups_accept_cod = $check_ups_accept_cod !== false &&
            intval($check_ups_accept_cod) === 1;

        $dataObject->action_form = $router_url->url_cod;
        $dataObject->links_form = $router_url->ups_eu_woo_get_all_link_form();

        $dataObject->page = 'cod';
        // $dataObject->title = $dataObject->lang['Collect on Delivery (COD)']
        return $dataObject;
    }
}
