<?php namespace UpsEuWoocommerce\libsystems\api_ups;

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
 * ups-eu-woo-call-api-ups-shipments.php - The core plugin class.
 *
 * This is used to define some methods to get the information of shipment from UPS's API.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Shipments_Api_Ups');

class Ups_Eu_Woo_Shipments_Api_Ups extends Ups_Eu_Woo_Global_Api_Ups implements Ups_Eu_Woo_Interfaces_Api_Ups
{

    public function __construct()
    {
        parent::__construct();
    }

    public function ups_eu_woo_call_api_create_shipment($data)
    {
        $this->ups_eu_woo_load_lib_api_ups();
        /* ---Log before cal api--- */
        $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
        $model_logsApi->ups_eu_woo_before_log_api("Ship");
        /* ---End before call log api */
        $license = $this->get_license();
        $response = $this->lib_api_ups->ups_eu_woo_api_create_shipment($data, $license);
        /* ---Log after call api--- */
        $this->ups_eu_woo_after_log_api($model_logsApi);
        /* ----End after call api--- */
        return $response;
    }

    public function ups_eu_woo_call_api_get_rate($data)
    {
        $this->ups_eu_woo_load_lib_api_ups();
        /* ---Log before cal api--- */
        $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
        $model_logsApi->ups_eu_woo_before_log_api("Rate");
        /* ---End before call log api */
        $license = $this->get_license();
        $response = $this->lib_api_ups->ups_eu_woo_api_get_rate($data, $license);
        /* ---Log after call api--- */
        $this->ups_eu_woo_after_log_api($model_logsApi);
        /* ----End after call api--- */
        return $response;
    }

    public function ups_eu_woo_call_api_cancel_shipment($data)
    {
        $this->ups_eu_woo_load_lib_api_ups();
        /* ---Log before cal api--- */
        $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
        $model_logsApi->ups_eu_woo_before_log_api("Void");
        /* ---End before call log api */
        $license = $this->get_license();
        $response = $this->lib_api_ups->ups_eu_woo_api_cancel_shipment($data, $license);
        /* ---Log after call api--- */
        $this->ups_eu_woo_after_log_api($model_logsApi);
        /* ----End after call api--- */
        return $response;
    }

    public function ups_eu_woo_call_api_status_shipment($data)
    {
        $this->ups_eu_woo_load_lib_api_ups();
        /* ---Log before cal api--- */
        $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
        $model_logsApi->ups_eu_woo_before_log_api("Track");
        /* ---End before call log api */
        $license = $this->get_license();
        $response = $this->lib_api_ups->ups_eu_woo_api_status_shipment($data, $license);
        /* ---Log after call api--- */
        $this->ups_eu_woo_after_log_api($model_logsApi);
        /* ----End after call api--- */
        return $response;
    }

    public function ups_eu_woo_call_api_status_shipment_acc_verify($data, $license)
    {
        $this->ups_eu_woo_load_lib_api_ups();
        /* ---Log before cal api--- */
        $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
        $model_logsApi->ups_eu_woo_before_log_api("TrackAccVerify");
        /* ---End before call log api */
        $response = $this->lib_api_ups->ups_eu_woo_api_status_shipment($data, $license);
        /* ---Log after call api--- */
        $this->ups_eu_woo_after_log_api($model_logsApi);
        /* ----End after call api--- */
        return $response;
    }
}
