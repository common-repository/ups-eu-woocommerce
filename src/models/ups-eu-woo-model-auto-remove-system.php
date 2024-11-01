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
 * ups-eu-woo-model-auto-remove-system.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Model_Auto_Remove_System Model.
 */

include_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Model_Auto_Remove_System');

class Ups_Eu_Woo_Model_Auto_Remove_System
{
    /*
     * Name function: run
     * Params: empty
     * Return: void
     * * */

    private function ups_eu_woo_run()
    {
        /* auto move status of order by date time */
        $model_Orders = new Ups_Eu_Woo_Model_Orders();
        $model_Orders->ups_eu_woo_auto_move_status_order_archived();
        $model_Orders->ups_eu_woo_auto_move_status_expired();
        /* auto remove log api by date time */
        $model_LogsApi = new Ups_Eu_Woo_Model_Logs_Api();
        $model_LogsApi->ups_eu_woo_auto_remove();
        /* auto remove log frontend by date time */
        $model_LogFrontend = new Ups_Eu_Woo_Model_Log_Frontend();
        $model_LogFrontend->ups_eu_woo_auto_remove();
        /* auto remove retry api type plugin manage */
        $model_RetryApi = new Ups_Eu_Woo_Model_Retry_Api();
        $model_RetryApi->ups_eu_woo_auto_remove();
    }

    public function ups_eu_woo_call_api_plugin_manager($main_currency)
    {
        $this->ups_eu_woo_run();
        $this->ups_eu_woo_save_option_settings($main_currency);
    }
    
    public function ups_eu_woo_save_option_settings($main_currency)
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        if ($model_config->ups_eu_woo_get_by_key('MAIN_CURRENCY') === true) {
            $model_config->value = $main_currency;
        } else {
            $model_config->key = "MAIN_CURRENCY";
            $model_config->value = $main_currency;
            $model_config->scope = "default";
        }
        $model_config->ups_eu_woo_save();
    }
}
