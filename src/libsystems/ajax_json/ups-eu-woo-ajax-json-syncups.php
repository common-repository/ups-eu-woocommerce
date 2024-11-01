<?php namespace UpsEuWoocommerce\libsystems\ajax_json;

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
 * ups-eu-woo-ajax-json-syncups.php - The core plugin class.
 *
 * This is used to define the method to synchronize data with Ups.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_SyncUps_Ajax_Json');

class Ups_Eu_Woo_SyncUps_Ajax_Json extends Ups_Eu_Woo_Global_Ajax_Json
{
    /*
     * Name function: __construct
     * Params:
     *  @domain: type string
     * Return: type void
     * * */

    public function __construct()
    {
        /* call parent construct */
        parent::__construct();
    }

    public function ups_eu_woo_sync_ups_shipping()
    {
        $main_currency = get_woocommerce_currency();
        $object = new \stdClass();
        $object->code = "200";
        $object->data = "";
        $object->data = call_user_func_array(
            [
            new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Auto_Remove_System(), "ups_eu_woo_call_api_plugin_manager"
            ],
            [$main_currency]
        );
        return $object;
    }
}
