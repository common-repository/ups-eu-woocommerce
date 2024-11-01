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
 * ups-eu-woo-ajax-json-checkout.php - The core plugin class.
 *
 * This is used to define some methods to call api of checkout pages.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_CheckOut_Ajax_Json');

class Ups_Eu_Woo_CheckOut_Ajax_Json extends Ups_Eu_Woo_Global_Ajax_Json
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

    public function ups_eu_woo_checkout_update()
    {
        /* load model serive */
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $model_service = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Services();
        /* new object */
        $jsonObject = new \stdClass();
        /* load model log frontend */
        $model_LogFrontend = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Log_Frontend();
        /* get data from method post */
        if (!empty($_REQUEST["ups_eu_woocommerce_key"])) {
            $ups_eu_woocommerce_key = $_REQUEST["ups_eu_woocommerce_key"];
        } else {
            $ups_eu_woocommerce_key = "";
        }
        /* santize data from method post */
        $ups_eu_woocommerce_key = sanitize_text_field($ups_eu_woocommerce_key);
        if (!empty($_REQUEST[$model_service->service_id])) {
            $service_id = $_REQUEST[$model_service->service_id];
        } else {
            $service_id = "";
        }
        $service_id = intval($service_id);
        /* get service by id */
        $model_service->ups_eu_woo_get_by_id($service_id);
        if (!empty($_REQUEST[$model_service->LocationID])) {
            $LocationID = $_REQUEST[$model_service->LocationID];
        } else {
            $LocationID = "";
        }
        $LocationID = intval($LocationID);
        /* update content data to table logfrontend in dadtabase */
        $model_LogFrontend->update_data_content_by_woocommerce_key(
            $ups_eu_woocommerce_key,
            [$model_service->LocationID => $LocationID]
        );
        /* call controller  checkout for update  session */
        call_user_func_array(
            [
            new \UpsEuWoocommerce\controllers\front\Ups_Eu_Woo_CheckOut,
            "update_session_ups_eu_woocommerce_key"
            ],
            [
            "{$ups_eu_woocommerce_key}"
            ]
        );
        if ($model_LogFrontend->update_data_content_by_woocommerce_key(
            $ups_eu_woocommerce_key,
            [$model_service->service_id => $service_id]
        ) == true) {
            $jsonObject->check = "ok";
        } else {
            $jsonObject->check = "error";
        }
        // check update
        \WC()->session->set('checkout_update', '1');
        $jsonObject->service_type = $model_service->service_type;
        $jsonObject->id = $model_service->id;
        return $jsonObject;
    }

    public function ups_eu_woo_ups_service_link($data)
    {
        $this->saveRequestServiceLinkData($data);
        $response_data = new \stdClass();
        $response_data->check = true;
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $ups_service_secret_key = '';
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_service_link_security_token) === true) {
            $ups_service_secret_key = $model_config->value;
        }
        $ups_service_handshake_key = '';
        $command = '';
        if (isset($data->UpsServiceLinkSecurityToken) && isset($data->Command)) {
            $ups_service_handshake_key = $data->UpsServiceLinkSecurityToken;
            $command = $data->Command;
        } else {
            $response_data->check = false;
        }
        if ($ups_service_handshake_key == $ups_service_secret_key && $command == 'PushPreRegistrationToken') {
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_pre_registered_plugin_token) === true) {
                $model_config->value = $data->PreRegisteredPluginToken;
            } else {
                $model_config->key = 'ups_shipping_pre_registered_plugin_token';
                $model_config->value = $data->PreRegisteredPluginToken;
                $model_config->scope = "default";
            }
            $model_config->ups_eu_woo_save();
            $response_data->check = true;
        } else {
            $response_data->check = false;
        }
        return $response_data;
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
