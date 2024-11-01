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
 * ups-eu-woo-call-api-ups-global.php - The core plugin class.
 *
 * This is used to load libraries and define the license to call UPS API.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Global_Api_Ups');

class Ups_Eu_Woo_Global_Api_Ups
{

    public $token_username;
    public $token_pass_data;
    public $AccessLicenseNumber;
    /* status call api */
    public $status_cal_api_ok = "ok";
    public $status_cal_api_no = "no";
    public $lib_api_ups;
    public $lib_api_manage;
    protected $check_call = 'check_call';
    protected $ups_invoice_date = 'ups_invoice_date';
    protected $key_country_code = "country_code";
    protected $key_language_code = "language_code";
    protected $key_promo_code = "promo_code";
    public $api_manage_enable = true;

    /* method call api */
    protected $call_user_method_shopservice_package = "ups_eu_woo_process_data_shop_service_package";
    protected $call_user_method_shopservice = "ups_eu_woo_process_data_shop_service";
    protected $call_user_method_shoptint = "ups_eu_woo_process_data_shop_time_in_transit";

    public function __construct()
    {
        $this->token_pass_data = "T!@#052018";
        $this->token_username = "TuChu0103";
        $this->AccessLicenseNumber = "0D46678E86A9D038";
    }

    protected function ups_eu_woo_load_lib_api_ups()
    {
        if (empty($this->lib_api_ups)) {
            include_once \UpsEuWoocommerce\Ups_Eu_Woo_Main::ups_eu_woo_plugin_path_ups() . '/lib/upsmodule/sdk/class-api-ups-eu-woo-ups.php';
            $this->lib_api_ups = new \Ups_Eu_Woo_UPS();
        }
    }

    protected function ups_eu_woo_load_lib_api_manage()
    {
        if (empty($this->lib_api_manage)) {
            include_once \UpsEuWoocommerce\Ups_Eu_Woo_Main::ups_eu_woo_plugin_path_ups() . '/lib/upsmodule/sdk/class-api-ups-eu-woo-manage.php';
            $this->lib_api_manage = new \Ups_Eu_Woo_Manage();
        }
    }

    protected function ups_eu_woo_after_log_api($model_logsApi)
    {
        $logApi = $this->lib_api_ups->get_information_all(
            $model_logsApi->col_full_uri,
            $model_logsApi->col_request,
            $model_logsApi->col_response
        );
        $model_logsApi->ups_eu_woo_after_log_api($logApi);
        // Check log api response has error
        $responseLogApi = json_decode($logApi[$model_logsApi->col_response]);
        if (property_exists($responseLogApi, 'Fault')) {
            $this->ups_eu_woo_manage_save_error_log($logApi[$model_logsApi->col_full_uri], $logApi[$model_logsApi->col_request], $logApi[$model_logsApi->col_response]);
        }
    }

    protected function ups_eu_woo_after_log_api_manage($model_logsApi)
    {
        $logApi = $this->lib_api_manage->get_information_all(
            $model_logsApi->col_full_uri,
            $model_logsApi->col_request,
            $model_logsApi->col_response
        );
        $model_logsApi->ups_eu_woo_after_log_api($logApi);
        // Check log api response has error
        $responseLogApi = json_decode($logApi[$model_logsApi->col_response]);
        if (property_exists($responseLogApi, 'error') && !empty($responseLogApi->error)) {
            $this->ups_eu_woo_manage_save_error_log($logApi[$model_logsApi->col_full_uri], $logApi[$model_logsApi->col_request], $logApi[$model_logsApi->col_response]);
        }
    }

    protected function get_license($call_first = false)
    {
        $this->ups_eu_woo_load_lib_api_ups();
        $license_data = new \stdClass();
        if ($call_first === true) {
            $license_data->Username = $this->token_username;
            $license_data->Password = $this->token_pass_data;
            $license_data->AccessLicenseNumber = $this->AccessLicenseNumber;
        } else {
            $model_license = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_License();
            $model_license->ups_eu_woo_get_by_id(1);
            if (!empty($model_license->Username)) {
                $license_data->Username = $model_license->Username;
            } else {
                $license_data->Username = $this->token_username;
            }
            if (!empty($model_license->Password)) {
                $license_data->Password = $model_license->Password;
            } else {
                $license_data->Password = $this->token_pass_data;
            }
            if (!empty($model_license->AccessLicenseNumber)) {
                $license_data->AccessLicenseNumber = $model_license->AccessLicenseNumber;
            } else {
                $license_data->AccessLicenseNumber = $this->AccessLicenseNumber;
            }
        }
        return $license_data;
    }

    private function ups_eu_woo_manage_save_error_log($logApiUrl, $logApiRequest, $logApiResponse)
    {
        // Get data from config table
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $country_code = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            $country_code = $model_config->value;
        }
        $ups_shipping_merchant_key = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) === true) {
            $ups_shipping_merchant_key = $model_config->value;
        }
        $token = '';
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_registered_plugin_token) === true) {
            $token = $model_config->value;
        }
        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
        // Set request data for manage api
        $request = new \stdClass();
        $request->Platform = '40'; // Woocommerce platform code
        $request->CountryCode = $country_code;
        $request->MerchantUrl = $scheme . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $request->MerchantKey = $ups_shipping_merchant_key;
        $request->LogApiUrl = $logApiUrl;
        $request->LogApiRequest = $logApiRequest;
        $request->LogApiResponse = $logApiResponse;

        // Call api manage to save error log info
        $this->ups_eu_woo_load_lib_api_manage();
        $this->lib_api_manage->ups_eu_woo_api_manage_save_error_log($request, $token);

        /* Save database logs api
        $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
        $model_logsApi->ups_eu_woo_before_log_api("SaveLogApiError");
        $logApi = $this->lib_api_manage->get_information_all(
            $model_logsApi->col_full_uri, $model_logsApi->col_request, $model_logsApi->col_response
        );
        $model_logsApi->ups_eu_woo_after_log_api($logApi);
        */
    }
}
