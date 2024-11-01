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
 * ups-eu-woo-ajax-json-shipments.php - The core plugin class.
 *
 * This is used to define some methods to handle the Shipment.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Shipments_Ajax_Json');

class Ups_Eu_Woo_Shipments_Ajax_Json extends Ups_Eu_Woo_Global_Ajax_Json
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

    public function ups_eu_woo_create_single_shipment()
    {
        $ajaxjson_create = new Ups_Eu_Woo_ShipCreate_Ajax_Json();
        return $ajaxjson_create->ups_eu_woo_config_create_single_shipment();
    }

    public function ups_eu_woo_create_shipment()
    {
        $ajaxjson_create = new Ups_Eu_Woo_ShipCreate_Ajax_Json();
        return $ajaxjson_create->ups_eu_woo_config_create_shipment();
    }

    public function ups_eu_woo_create_f_single_shipment()
    {
        $ajaxjson_create = new Ups_Eu_Woo_ShipCreate_Ajax_Json();
        return $ajaxjson_create->ups_eu_woo_config_create_f_single_shipment();
    }

    public function ups_eu_woo_estimated_shipping_fee()
    {
        $ajaxjson_estimated = new Ups_Eu_Woo_ShipEstimated_Ajax_Json();
        return $ajaxjson_estimated->ups_eu_woo_config_estimated_shipping_fee();
    }

    public function ups_eu_woo_cancel_shipment()
    {
        $ajaxjson_cancel = new Ups_Eu_Woo_ShipCancel_Ajax_Json();
        return $ajaxjson_cancel->ups_eu_woo_config_cancel_shipment();
    }

    public function ups_eu_woo_create_batch_shipment()
    {
        $ajaxjson_batch = new Ups_Eu_Woo_ShipBatch_Ajax_Json();
        return $ajaxjson_batch->ups_eu_woo_config_create_batch_shipment();
    }

    public function ups_eu_woo_exec_create_batch_shipment()
    {
        $ajaxjson_batch = new Ups_Eu_Woo_ShipBatch_Ajax_Json();
        return $ajaxjson_batch->ups_eu_woo_config_exec_create_batch_shipment();
    }
}
