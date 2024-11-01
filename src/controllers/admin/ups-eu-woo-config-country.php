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
 * ups-eu-woo-config-country.php - The core plugin class.
 *
 * This is used to config Country.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Config_Country');

class Ups_Eu_Woo_Config_Country
{

    /**
     * Name function: country
     * Params: empty
     * Return: void
     */
    public function ups_eu_woo_config_country()
    {
        /* Create object model */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        /* Check permission accept link */
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();

        /* Save form data */
        if ($router_url->ups_eu_woo_check_method_post() === true) {
            call_user_func_array([
                new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Manage_Api_Ups(), "ups_eu_woo_call_api_handshake"
                ], []);
            /* set data for model save */
            $model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE);
            $model_config->scope = 'default';
            $model_config->scope_id = 0;
            $model_config->key = $model_config->COUNTRY_CODE;
            $model_config->value = $_REQUEST[$model_config->country_code];
            /* merge data */
            $model_config->ups_eu_woo_merge_array($data);
            /* Validate data model */
            $validate = $model_config->ups_eu_woo_validate();
            /* Save data */
            if ($validate && $model_config->ups_eu_woo_save()) {
                /* Set Page none acount is enable */
                $InitDataSystem = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Init_Data_System();
                $InitDataSystem->ups_eu_woo_int_term_table_config();
                $router_url->ups_eu_woo_redirect($router_url->url_terms_conditions);
            }
        }

        $dataObject = new \stdClass();
        $options = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Options();
        /* get country list */
        $dataObject->country_list = $options->get_country_list();
        $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
            $model_config->lang_page_country
        );
        $dataObject->action_form = $router_url->url_country;

        return $dataObject;
    }
}
