<?php namespace UpsEuWoocommerce\models\entities;

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
 * ups-eu-woo-model-entity-retry-api.php - The core plugin class.
 *
 * This is used to define the RetryApi Entity.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Retry_Api_Entity');

class Ups_Eu_Woo_Retry_Api_Entity extends \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Base
{
    /* List colum name in table [retry_api] database */

    public $col_id_retry = "id_retry";
    public $col_key_api = "key_api";
    public $col_data_api = "data_api";
    public $col_count_retry = "count_retry";
    public $col_date_created = "date_created";
    public $col_date_update = "date_update";
    public $col_method_name = "method_name";

    /* Name method  main api */
    public $api_remove_account = "ups_eu_woo_update_merchant_status_remove_account";
    public $api_add_account = "ups_eu_woo_transfer_merchant_info_by_user";
    public $api_complete_config = "ups_eu_woo_transfer_merchant_info";
    public $api_accessorials = "ups_eu_woo_transfer_accessorials";
    public $api_shipping_service = "ups_eu_woo_transfer_shipping_services";
    public $api_delivery_rates = "ups_eu_woo_transfer_delivery_rates";
    public $api_default_package = "ups_eu_woo_transfer_default_package";
    public $api_created_shipment = "ups_eu_woo_transfer_shipments";
    public $api_changed_status_order = "ups_eu_woo_update_shipments_status";
    public $api_activated_plugin = "ups_eu_woo_activated_plugin";
    public $api_deactivated_plugin = "ups_eu_woo_deactivated_plugin";
    public $api_uninstalled_plugin = "ups_eu_woo_uninstalled_plugin";
}
