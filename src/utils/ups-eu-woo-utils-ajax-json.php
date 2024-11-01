<?php namespace UpsEuWoocommerce\utils;

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
 * ups-eu-woo-utils-ajax-json.php - The core plugin class.
 *
 * This is used to process to call api of the current plugin.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Utils_Ajax_Json');

class Ups_Eu_Woo_Utils_Ajax_Json
{

    public function __construct()
    {
    }
    /*
     * Name function: ups_eu_woo_processing
     * Params: empty
     * Return: type object data
     * * */

    public function ups_eu_woo_processing()
    {
        /* Init object */
        $objectData = new \stdClass();
        /* Init class */
        $system_entity = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Systems_Entity();
        $method = "";
        if (!empty($_REQUEST[$system_entity->method])) {
            $method = trim(strip_tags($_REQUEST[$system_entity->method]));
        }
        /* Load controller ajax json */
        $ajaxjson_package = new \UpsEuWoocommerce\libsystems\ajax_json\Ups_Eu_Woo_Package_Ajax_Json();
        $ajaxjson_shipment = new \UpsEuWoocommerce\libsystems\ajax_json\Ups_Eu_Woo_Shipments_Ajax_Json();
        $ajaxjson_info = new \UpsEuWoocommerce\libsystems\ajax_json\Ups_Eu_Woo_Info_Ajax_Json();
        $ajaxjson_sync = new \UpsEuWoocommerce\libsystems\ajax_json\Ups_Eu_Woo_SyncUps_Ajax_Json();
        $ajaxjson_checkap = new \UpsEuWoocommerce\libsystems\ajax_json\Ups_Eu_Woo_CheckAP_Ajax_Json();

        switch ($method) {
            case "validate-default-package":
                $objectData = $ajaxjson_package->ups_eu_woo_validate_default_package_ajax();
                break;
            case "validate-product-dimension":
                $objectData = $ajaxjson_package->ups_eu_woo_validate_product_dimension_ajax();
                break;
            case "create-single-shipment":
                $objectData = $ajaxjson_shipment->ups_eu_woo_create_single_shipment();
                break;
            case "create-shipment":
                $objectData = $ajaxjson_shipment->ups_eu_woo_create_shipment();
                break;
            case "cancel-shipment":
                $objectData = $ajaxjson_shipment->ups_eu_woo_cancel_shipment();
                break;
            case "estimated-shipping-fee":
                $objectData = $ajaxjson_shipment->ups_eu_woo_estimated_shipping_fee();
                break;
            case "create-batch-shipment":
                $objectData = $ajaxjson_shipment->ups_eu_woo_create_batch_shipment();
                break;
            case "exec-create-batch-shipment":
                $objectData = $ajaxjson_shipment->ups_eu_woo_exec_create_batch_shipment();
                break;
            case "info-order":
                $objectData = $ajaxjson_info->ups_eu_woo_info_order();
                break;
            case "info-shipment":
                $objectData = $ajaxjson_info->ups_eu_woo_info_shipment();
                break;
            case "sync_ups_shipping":
                $objectData = $ajaxjson_sync->ups_eu_woo_sync_ups_shipping();
                break;
            case "comebackOrder":
                $objectData = $ajaxjson_info->ups_eu_woo_comback_order();
                break;
            case "check-ap":
                $objectData = $ajaxjson_checkap->ups_eu_woo_check_ap_availability();
                break;
            default:
                break;
        }
        return $objectData;
    }
    /*
     * Name function: ups_eu_woo_processing_frontend
     * Params: empty
     * Return: type object data
     * * */

    public function ups_eu_woo_processing_frontend()
    {
        /* Init object */
        $objectData = new \stdClass();
        /* Init class */
        $system_entity = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Systems_Entity();
        $method = "";
        if (!empty($_REQUEST[$system_entity->method])) {
            $method = trim(strip_tags($_REQUEST[$system_entity->method]));
        }
        /* Assigned to object */
        $objectData->check = false;
        /* Load  controller ajax checkout */
        $ajaxjson_checkout = new \UpsEuWoocommerce\libsystems\ajax_json\Ups_Eu_Woo_CheckOut_Ajax_Json();
        switch ($method) {
            case "checkout_update":
                $objectData->check = true;
                $objectData->data = $ajaxjson_checkout->ups_eu_woo_checkout_update();
                break;
            case "checkout_load":
                $objectData->check = true;
                $objectData->data = call_user_func_array(
                    [
                    new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_EShopper_Api_Ups(),
                    "ups_eu_woo_checkout_load"
                    ],
                    []
                );
                break;
            case "search_locator":
                $objectData->check = true;
                $objectData->data = call_user_func_array(
                    [
                    new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_EShopper_Api_Ups(),
                    "ups_eu_woo_search_locator"
                    ],
                    []
                );
                break;
            case "ups_service_link":
                $raw_data = file_get_contents('php://input');
                $data_post = json_decode($raw_data);
                $response = $ajaxjson_checkout->ups_eu_woo_ups_service_link($data_post);
                if ($response->check == false) {
                    wp_die("Bad Request", 400);
                } else {
                    $objectData->check = true;
                }
                break;
            default:
                break;
        }
        return $objectData;
    }

    public function saveRequestServiceLinkData($data)
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_service_link_check) === true) {
            $model_config->value = json_encode($data);
        } else {
            $model_config->key = 'ups_shipping_service_link_check';
            $model_config->value = json_encode($data);
            $model_config->scope = "default";
        }
        $model_config->ups_eu_woo_save();
    }
}
