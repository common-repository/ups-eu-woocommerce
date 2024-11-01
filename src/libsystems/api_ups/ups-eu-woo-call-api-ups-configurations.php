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
 * ups-eu-woo-call-api-ups-configurations.php - The core plugin class.
 *
 * This is used to define some methods to get information from Ups API for Configuration.
 */
if ( !session_id() ) {
    session_start(['read_and_close' => true]);
}
include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Configurations_Api_Ups');

class Ups_Eu_Woo_Configurations_Api_Ups extends Ups_Eu_Woo_Global_Api_Ups implements Ups_Eu_Woo_Interfaces_Api_Ups
{

    public function __construct()
    {
        parent::__construct();
    }

    public function ups_eu_woo_registration_success($data)
    {
        $this->ups_eu_woo_load_lib_api_ups();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $data->customer_name = "{$data->fullname}";
        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            $data->{$this->key_country_code} = $model_config->value;
        } else {
            $data->{$this->key_country_code} = "PL";
        }
        $data->post_code = "{$data->postal_code}";

        if (strlen($data->{$this->ups_invoice_date}) > 0) {
            $data->{$this->ups_invoice_date} = str_replace("-", "", $data->{$this->ups_invoice_date});
        }

        $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
        try {
            $license = $this->get_license();
            /* ---Log before cal api--- */
            $model_logsApi->ups_eu_woo_before_log_api("registrationSuccess");
            /* ---End before call log api */
            $response_registration_success = $this->lib_api_ups->ups_eu_woo_api_registration_success($data, $license);
            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api($model_logsApi);
            /* ----End after call api--- */
            if ($response_registration_success["check"] === false) {
                return $response_registration_success['message'];
            } else {
                return true;
            }
        } catch (Exception $ex) {
            $this->ups_eu_woo_after_log_api($model_logsApi);
            return -1;
        }
    }

    public function ups_eu_woo_call_api_promo_discount_agreement($PromoCode = 'CA98RKNB9')
    {
        /* init params */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $data = new \stdClass();
        $data->{$this->key_promo_code} = "{$PromoCode}";
        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            $data->{$this->key_country_code} = $model_config->value;
        } else {
            $data->{$this->key_country_code} = "PL";
        }
        if (!empty(get_locale())) {
            $language_code = strtoupper(substr(get_locale(), 0, 2));
        } else {
            $language_code = 'EN';
        }
        if ($language_code !== 'PL') {
            $language_code = "EN";
        } else {
            $language_code = "PL";
        }
        $data->{$this->key_language_code} = "{$language_code}";
        /* load libraries ups */
        $this->ups_eu_woo_load_lib_api_ups();
        /* ---Log before cal api--- */
        $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
        $model_logsApi->ups_eu_woo_before_log_api("_apiPromoDiscountAgreeMent");
        /* ---End before call log api */
        $license = $this->get_license();
        $response = $this->lib_api_ups->ups_eu_woo_api_promo_discount_agreement($data, $license);
        /* ---Log after call api--- */
        $this->ups_eu_woo_after_log_api($model_logsApi);
        /* ----End after call api--- */
        $apiPromoDiscount = json_decode($response);

        if (isset($apiPromoDiscount->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description)) {
            $_SESSION['MSG_OPENACCOUNT_STATUS'] = 2;
            $_SESSION['MSG_OPENACCOUNT'] = $apiPromoDiscount->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description;
        }

        if (isset($apiPromoDiscount->PromoDiscountAgreementResponse->Response->ResponseStatus->Code) &&
            $apiPromoDiscount->PromoDiscountAgreementResponse->Response->ResponseStatus->Code == '1') {
            $this->ups_eu_woo_call_api_promo(
                $PromoCode,
                $apiPromoDiscount->PromoDiscountAgreementResponse->PromoAgreement->AcceptanceCode
            );
        }
        return;
    }

    public function ups_eu_woo_call_api_promo($PromoCode = "CA98RKNB9", $PromoDiscountRequest = "CA9_01_17_2018-12-31")
    {
        /* init params */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $data = new \stdClass();
        $data->check_acceptance_code = "{$PromoDiscountRequest}";
        $data->{$this->key_promo_code} = "{$PromoCode}";
        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            $data->{$this->key_country_code} = $model_config->value;
        } else {
            $data->{$this->key_country_code} = "PL";
        }
        if (!empty(get_locale())) {
            $language_code = strtoupper(substr(get_locale(), 0, 2));
        } else {
            $language_code = 'EN';
        }
        if ($language_code !== 'PL') {
            $language_code = "EN";
        } else {
            $language_code = "PL";
        }
        $data->{$this->key_language_code} = "{$language_code}";
        $data->account_number = "";
        if ($model_config->ups_eu_woo_get_by_key("tmp_ups_open_account_number") === true) {
            $data->account_number = $model_config->value;
        }
        /* load libraries ups */
        $this->ups_eu_woo_load_lib_api_ups();
        /* ---Log before cal api--- */
        $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
        $model_logsApi->ups_eu_woo_before_log_api("_apiPromo");
        /* ---End before call log api */
        $license = $this->get_license();
        $response = $this->lib_api_ups->ups_eu_woo_api_promo($data, $license);

        $apiPromo = json_decode($response);

        if (isset($apiPromo->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description)) {
            $_SESSION['MSG_OPENACCOUNT_STATUS'] = 2;
            $_SESSION['MSG_OPENACCOUNT'] = $apiPromo->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description;
        } else {
            $_SESSION['MSG_OPENACCOUNT_STATUS'] = 1;
            $_SESSION['MSG_OPENACCOUNT'] = "Promo Discount ". $apiPromo->PromoDiscountResponse->Response->ResponseStatus->Description;
        }
        
        /* ---Log after call api--- */
        $this->ups_eu_woo_after_log_api($model_logsApi);
        /* ----End after call api--- */
        return $response;
    }

    public function ups_eu_woo_print_label($data)
    {
        $this->ups_eu_woo_load_lib_api_ups();
        /* ---Log before cal api--- */
        $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
        $model_logsApi->ups_eu_woo_before_log_api("LBRecovery");
        /* ---End before call log api */
        $license = $this->get_license();
        $response = $this->lib_api_ups->ups_eu_woo_api_print_label($data, $license);
        /* ---Log after call api--- */
        $this->ups_eu_woo_after_log_api($model_logsApi);
        /* ----End after call api--- */
        return $response;
    }
}
