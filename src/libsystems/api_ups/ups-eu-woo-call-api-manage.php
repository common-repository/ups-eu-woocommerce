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
 * ups-eu-woo-call-api-manage.php - The core plugin class.
 *
 * This is used to define some methods to get information from UPS's Plugin Manager.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Manage_Api_Ups');

class Ups_Eu_Woo_Manage_Api_Ups extends Ups_Eu_Woo_Global_Api_Ups implements Ups_Eu_Woo_Interfaces_Api_Ups
{

    public function __construct()
    {
        parent::__construct();
    }

    private function ups_eu_woo_generate_ups_service_link_security_token($length)
    {
        //characters
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        //characters_length
        $characters_length = strlen($characters);
        //random_string
        $random_string = '';
        //check $i
        for ($i = 0; $i < $length; $i++) {
            //random_string
            $random_string .= $characters[rand(0, $characters_length - 1)];
        }
        return $random_string;
    }

    public function ups_eu_woo_save_option_setting($key, $value)
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        if ($model_config->ups_eu_woo_get_by_key($model_config->{$key}) === true) {
            $model_config->value = $value;
        } else {
            $model_config->key = "{$key}";
            $model_config->value = $value;
            $model_config->scope = "default";
        }
        $model_config->ups_eu_woo_save();
    }

    private function ups_eu_woo_get_new_registered_plugin_token()
    {
        $model_license = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_License();
        $license_data = $model_license->ups_eu_woo_get_licence_config();
        $this->ups_eu_woo_call_api_registered_plugin_token($license_data);
    }
    /* -------------------------API-PLUGIN MANAGERS---------------------- */

    public function ups_eu_woo_call_api_handshake()
    {
        /* Trigger on events plugin uininstalled, activated, deactivated */
        if ($this->api_manage_enable === true) {
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            $this->ups_eu_woo_load_lib_api_manage();
            try {
                global $wp;
                global $woocommerce;
                $woocommerce_version = $woocommerce->version;
                $webstore_link = home_url($wp->request);
                $object = new \stdClass();
                $object->MerchantKey = "";
                if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) === true) {
                    $object->MerchantKey = $model_config->value;
                }
                $ups_service_token = $this->ups_eu_woo_generate_ups_service_link_security_token(30);
                $this->ups_eu_woo_save_option_setting('ups_shipping_service_link_security_token', $ups_service_token);
                $object->WebstoreUrl = $webstore_link;
                $object->WebstoreUpsServiceLinkSecurityToken = $ups_service_token;
                $object->WebstorePlatform = "Woocommerce";
                $object->WebstorePlatformVersion = $woocommerce_version;
                $object->UpsReadyPluginName = "UPS Shipping and UPS Access Point™ : Official Plugin";
                $object->UpsReadyPluginVersion = \UpsEuWoocommerce\Ups_Eu_Woo_Main::$version;
                $object->VerboseResponseSecurityKey = "";
                $object->WebstoreUpsServiceLinkUrl = $webstore_link . "/?frontend-ajax-json=ups&method=ups_service_link";
                /* Call API */
                $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
                $model_logsApi->ups_eu_woo_before_log_api("HandShake");
                /* ---End before call log api */
                $response = $this->lib_api_manage->ups_eu_woo_api_handshake($object);
                /* ---Log after call api--- */
                $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            } catch (Exception $ex) {
                $response = false;
            }
            return $response;
        }
        return false;
    }

    public function ups_eu_woo_call_api_registered_plugin_token($license)
    {
        /* Trigger on events plugin uininstalled, activated, deactivated */
        if ($this->api_manage_enable === true) {
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            $this->ups_eu_woo_load_lib_api_manage();
            $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
            try {
                global $wp;
                global $woocommerce;
                $woocommerce_version = $woocommerce->version;
                if (!empty($wp->request)) {
                    $ups_eu_woo_home_url = home_url($wp->request);
                } else {
                    $ups_eu_woo_home_url = home_url();
                }
                $webstore_link = $ups_eu_woo_home_url;
                $object = new \stdClass();
                $object->MerchantKey = "";
                if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) === true) {
                    $object->MerchantKey = $model_config->value;
                }
                $ups_service_token = '';
                if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_service_link_security_token) === true) {
                    $ups_service_token = $model_config->value;
                }
                $object->WebstoreUrl = $webstore_link;
                $object->WebstoreUpsServiceLinkSecurityToken = $ups_service_token;
                $object->WebstorePlatform = "Woocommerce";
                $object->WebstorePlatformVersion = $woocommerce_version;
                $object->UpsReadyPluginName = "UPS Shipping and UPS Access Point™ : Official Plugin";
                $object->UpsReadyPluginVersion = \UpsEuWoocommerce\Ups_Eu_Woo_Main::$version;
                /* Call API */
                $model_logsApi->ups_eu_woo_before_log_api("RegisteredPluginToken");
                /* ---End before call log api */
                $response = $this->lib_api_manage->ups_eu_woo_api_registered_plugin_token($object, $license);
                $this->ups_eu_woo_save_option_setting('ups_shipping_registered_plugin_token', $response);
                /* ---Log after call api--- */
                $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            } catch (Exception $ex) {
                $this->ups_eu_woo_after_log_api_manage($model_logsApi);
                $response = false;
            }
            return $response;
        }
        return false;
    }

    public function ups_eu_woo_call_api_get_bing_map_credential($count = 1)
    {
        /* Trigger on events plugin uininstalled, activated, deactivated */
        if ($this->api_manage_enable === true) {
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            $this->ups_eu_woo_load_lib_api_manage();
            $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
            try {
                $registered_plugin_token = '';
                if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_registered_plugin_token) === true) {
                    $registered_plugin_token = $model_config->value;
                }
                /* Call API */
                $model_logsApi->ups_eu_woo_before_log_api("UpsBingMapsKey");
                /* ---End before call log api */
                $response = $this->lib_api_manage->ups_eu_woo_api_get_ups_bing_maps_key($registered_plugin_token);
                if (!empty($response->data)) {
                    $this->ups_eu_woo_save_option_setting('ups_shipping_bing_map_key', $response->data);
                } else {
                    if (isset($response->error->errorCode) && intval($response->error->errorCode) === 401) {
                        $this->ups_eu_woo_get_new_registered_plugin_token();
                        $count += 1;
                        if ($count <= 5) {
                            $response = $this->ups_eu_woo_call_api_get_bing_map_credential($count);
                        }
                    } else {
                        $this->ups_eu_woo_save_option_setting('ups_shipping_bing_map_key', "");
                    }
                }
                /* ---Log after call api--- */
                $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            } catch (Exception $ex) {
                $this->ups_eu_woo_after_log_api_manage($model_logsApi);
                $response = false;
            }
            return $response;
        }
        return false;
    }

    public function ups_eu_woo_call_api_termcondition($data)
    {
        /* Trigger on events plugin uininstalled, activated, deactivated */
        if ($this->api_manage_enable === true) {
            $this->ups_eu_woo_load_lib_api_manage();
            $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
            try {
                /* Call API */
                $model_logsApi->ups_eu_woo_before_log_api("License");
                /* ---End before call log api */
                $response = $this->lib_api_manage->ups_eu_woo_api_termcondition($data);
                /* ---Log after call api--- */
                $this->ups_eu_woo_after_log_api_manage($model_logsApi);
                return $response;
            } catch (Exception $ex) {
                /* ---Log after call api--- */
                $this->ups_eu_woo_after_log_api_manage($model_logsApi);
                /* ----End after call api--- */
                return false;
            }
        }
        return false;
    }

    private function ups_eu_woo_call_api_get_ups_id($count = 0)
    {
        $this->ups_eu_woo_load_lib_api_manage();
        $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $upsmodule_token = '';
        $result = '';
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_pre_registered_plugin_token) === true) {
            $upsmodule_token = $model_config->value;
        }
        try {
            /* ---Log before cal api--- */
            $model_logsApi->ups_eu_woo_before_log_api("GetUpsID");
            /* ---End before call log api */
            $response = $this->lib_api_manage->ups_eu_woo_api_get_ups_id($upsmodule_token);
            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            /* ----End after call api--- */
            if (isset($response->error->errorCode) && $response->error->errorCode == "401" && $count < 5) {
                $count = $count + 1;
                $this->ups_eu_woo_call_api_handshake();
                $result = $this->ups_eu_woo_call_api_get_ups_id($count);
            } else {
                if (!empty($response->data)) {
                    $result = $response->data;
                }
            }
            return $result;
        } catch (Exception $ex) {
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            return $result;
        }
    }

    public function ups_eu_woo_access2($data)
    {
        $this->ups_eu_woo_load_lib_api_manage();
        $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
        try {
            /* ---Log before cal api--- */
            $model_logsApi->ups_eu_woo_before_log_api("Access2");
            /* ---End before call log api */
            $response = $this->lib_api_manage->ups_eu_woo_api_access_2($data);
            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            /* ----End after call api--- */
            return $response;
        } catch (Exception $ex) {
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            return false;
        }
    }
    public function ups_eu_woo_access2_rest($data)
    {
        $this->ups_eu_woo_load_lib_api_manage();
        $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
        try {
            /* ---Log before cal api--- */
            $model_logsApi->ups_eu_woo_before_log_api("Access2Rest");
            /* ---End before call log api */
            $response = $this->lib_api_manage->ups_eu_woo_api_access_2_rest($data);
            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            /* ----End after call api--- */
            return $response;
        } catch (Exception $ex) {
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            return false;
        }
    }

    public function ups_eu_woo_registration($model_account)
    {
        global $woocommerce;
        $this->ups_eu_woo_load_lib_api_manage();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_license = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_License();
        $data = (object) $model_account;
        $data->myUpsID = ($data->account_type == 4) ? $data->ups_account_u_name : $this->ups_eu_woo_call_api_get_ups_id();
        $upsmodule_token = '';
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_pre_registered_plugin_token) === true) {
            $upsmodule_token = $model_config->value;
        }
        $data->upsmodule_token = $upsmodule_token;
        $data->customer_name = "{$data->fullname}";
        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            $data->{$this->key_country_code} = $model_config->value;
        } else {
            $data->{$this->key_country_code} = "PL";
        }
        $data->post_code = "{$data->postal_code}";

        if (strlen($data->ups_invoice_date) > 0) {
            $data->ups_invoice_date = str_replace("-", "", $data->ups_invoice_date);
        }
        if ($data->account_type == 4) {
            $data->province_code = $data->state;
            $data->language_code = strtoupper(substr(get_locale(), 0, 2));
            $data->fax = '';

            $data->soft_install = "Woocommerce";
            $data->soft_product_name = "Woocommerce Plugin";
            $data->soft_provider = "Woocommerce";

            if (!empty($woocommerce->version)) {
                $data->version = $woocommerce->version;
            } else {
                $data->version = "3.6";
            }

            $model_license->ups_eu_woo_get_by_id(1);
            $data->access_license_text = $model_license->AccessLicenseText;

            $access_license_res = $this->ups_eu_woo_access2_rest($data);
            $access_license_res = !empty($access_license_res) ? json_decode($access_license_res) : "";
            if (!empty($access_license_res)) {
                if (isset($access_license_res->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description)) {
                    return (string)$access_license_res->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description;
                } elseif (isset($access_license_res->AccessLicenseResponse->AccessLicenseNumber)) {
                    $data->ups_account_access = (string)$access_license_res->AccessLicenseResponse->AccessLicenseNumber;
                } else {
                    return "Can't able to get license key. Unknown response found.";
                }
            } else {
                return "Can't able to get license key.";
            }
        }
        $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
        try {
            
            /* ---Log before cal api--- */
            $model_logsApi->ups_eu_woo_before_log_api("Registration");
            /* ---End before call log api */
            $response_registration = $this->lib_api_manage->ups_eu_woo_api_registration($data);
            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            /* ----End after call api--- */
            if ($response_registration["check"] === false) {
                return $response_registration['message'];
            } else {
                $check = $model_license->ups_eu_woo_update_by_field([
                    "Username" => trim(strip_tags($response_registration["username"])),
                    "Password" => trim($response_registration["password"])
                ]);
                if ($data->account_type == 4) {
                    $check = $model_license->ups_eu_woo_update_by_field([
                        "AccessLicenseNumber" => $data->ups_account_access
                    ]);
                    if ($check === true) {
                        return true;
                    } else {
                        return "Error while saving Access Key.";
                    }
                } else {
                    return $this->ups_eu_woo_update_check_open_account($check, $data, $woocommerce, $model_license);
                }
            }
        } catch (Exception $ex) {
            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            /* ----End after call api--- */
            return "errorr_call_api";
        }
    }

    private function ups_eu_woo_update_check_open_account($check, $data, $woocommerce, $model_license)
    {
        if ($check === true) {
            if (intval($data->account_type) === 3) {
                $check_open_account_mess = $this->ups_eu_woo_open_account($data);
                if ($check_open_account_mess !== true) {
                    return $check_open_account_mess;
                }
            }
            $data->province_code = $data->state;
            $data->language_code = strtoupper(substr(get_locale(), 0, 2));
            $data->fax = '';

            $data->soft_install = "Woocommerce";
            $data->soft_product_name = "Woocommerce Plugin";
            $data->soft_provider = "Woocommerce";

            if (!empty($woocommerce->version)) {
                $data->version = $woocommerce->version;
            } else {
                $data->version = "3.6";
            }

            $model_license->ups_eu_woo_get_by_id(1);
            $data->access_license_text = $model_license->AccessLicenseText;
            $response_access2 = $this->ups_eu_woo_access2($data);
            $json_access2 = json_decode($response_access2);
            if (isset($json_access2->AccessLicenseResponse->AccessLicenseNumber)) {
                $check = $model_license->ups_eu_woo_update_by_field([
                    "AccessLicenseNumber" => $json_access2->AccessLicenseResponse->AccessLicenseNumber
                ]);
                if ($check === true) {
                    return true;
                }
            }
        }
        return false;
    }

    public function ups_eu_woo_open_account($data)
    {
        $this->ups_eu_woo_load_lib_api_manage();
        /* ---Log before cal api--- */
        $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
        $model_logsApi->ups_eu_woo_before_log_api("openAccount");
        /* ---End before call log api */
        $upsmodule_token = $data->upsmodule_token;
        $model_openaccount = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Ups_Shipping_API();
        $data = $model_openaccount->ups_eu_woo_init_params_open_account($data);
        $data->upsmodule_token = $upsmodule_token;
        $response = $this->lib_api_manage->ups_eu_woo_api_open_account($data);

        /* ---Log after call api--- */
        $this->ups_eu_woo_after_log_api_manage($model_logsApi);
        /* ----End after call api--- */
        $response = json_decode($response);

        //checkError
        if (isset($response->Fault->detail->Errors->ErrorDetail)) {
            $checkError = $response->Fault->detail->Errors->ErrorDetail;
        }

        //check isset and empty checkError Severity
        $message_please = __(". Please update the city and postal code values with one of these selections and click Get Started”", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        if (isset($checkError->Severity) && !empty($checkError->Severity)) {
            $error_message = $checkError->PrimaryErrorCode->Description;
            //check isset($error_message
            if (isset($error_message)) {
                return $error_message;
            } else {
                $error_message = __("Your request to create a UPS Shipping Account was not successful. Please check the ‘City’ and ‘Postal code’ values that you entered. Here are some suggestions on the City and Postal code that", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
                $data = $this->request->post;
                if (isset($response->OpenAccountResponse->PickupAddressCandidate)) {
                    $getPostalCountry = $response->OpenAccountResponse->PickupAddressCandidate;
                    foreach ($getPostalCountry as $item) {
                        $error_message .= '"' . $item->City . ', ' . $item->PostalCode . '";';
                    }
                    $error_message = rtrim($error_message, ";");
                    $error_message .= '. ';
                }
                $error_message .=$message_please;
                return $error_message;
            }
        } else {
            /* check this case  repsonse code 9580101 */
            $check_string_response_9580101 = $this->ups_eu_woo_check_response_9580101($response, $message_please);
            if (strlen($check_string_response_9580101) > 0) {
                return $check_string_response_9580101;
            }
            /* ok succcess api */
            $this->ups_eu_woo_update_open_account_number($response);
            return true;
        }
    }

    private function ups_eu_woo_check_response_9580101($response, $message_please)
    {
        if ($response->OpenAccountResponse->Response->Alert->Code == "9580101") {
            $error_message1 = __("Your request to create a UPS Shipping Account was not successful. Please check the ‘City’ and ‘Postal code’ values that you entered. Here are some suggestions on the City and Postal code that are a valid combination - ", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
            $tmp_city_postal_code = [];
            if (isset($response->OpenAccountResponse->PickupAddressCandidate)) {
                $getPostalCountry = $response->OpenAccountResponse->PickupAddressCandidate;
                if (is_array($getPostalCountry)) {
                    foreach ($getPostalCountry as $item) {
                        $tmp_city_postal_code[] = '“' . $item->City . ', ' . $item->PostalCode . '”';
                    }
                } else {
                    $item = $getPostalCountry;
                    $tmp_city_postal_code[] = '“' . $item->City . ', ' . $item->PostalCode . '”';
                }
            }
            $str_city_postal_code = "";
            if (count($tmp_city_postal_code) > 0) {
                $str_city_postal_code = implode(";", $tmp_city_postal_code);
            }
            return $error_message1 . "{$str_city_postal_code}" . $message_please;
        }
        return "";
    }

    private function ups_eu_woo_update_open_account_number($response)
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        if ($model_config->ups_eu_woo_get_by_key($model_config->tmp_ups_open_account_number) !== true) {
            $model_config->key = $model_config->tmp_ups_open_account_number;
            $model_config->value = $response->OpenAccountResponse->ShipperNumber;
            $model_config->scope = "default";
            $model_config->ups_eu_woo_save();
        }
    }

    public function ups_eu_woo_update_merchant_status($account_number = "", $status = "", $count = 1)
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $upsmodule_token = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_registered_plugin_token) === true) {
            $upsmodule_token = $model_config->value;
        }
        /* Trigger on events plugin uininstalled, activated, deactivated */
        if (!empty($upsmodule_token) && $this->api_manage_enable === true) {
            $this->ups_eu_woo_load_lib_api_manage();
            $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
            $object = new \stdClass();
            $object->status = $status;
            $object->merchant_key = "";
            if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) === true) {
                $object->merchant_key = $model_config->value;
            }
            if (!empty($account_number)) {
                $object->account_number = $account_number;
            }
            $object->upsmodule_token = $upsmodule_token;
            /* Call API */
            $model_logsApi->ups_eu_woo_before_log_api("_updateMerchantStatus");
            try {
                $response = $this->lib_api_manage->ups_eu_woo_api_update_merchant_status($object);
            } catch (Exception $ex) {
                $response = false;
            }
            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            /* save to table retry api */
            if (isset($response->error->errorCode) && intval($response->error->errorCode) === 401 && $count <= 3) {
                $count = $count + 1;
                $this->ups_eu_woo_get_new_registered_plugin_token();
                $response = $this->ups_eu_woo_update_merchant_status($account_number, $status, $count);
            }
            if (isset($response->errors) && $count <= 4) {
                $count = $count + 1;
                $response = $this->ups_eu_woo_update_merchant_status($account_number, $status, $count);
            }
            return $response;
        }
        return false;
    }

    public function ups_eu_woo_update_merchant_status_remove_account($account_number)
    {
        /* Remove account */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $ACCEPT_BILLING_PREFERENCE = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_BILLING_PREFERENCE) === true) {
            $ACCEPT_BILLING_PREFERENCE = $model_config->value;
        }
        if ((intval($ACCEPT_BILLING_PREFERENCE) === 1) && ($this->api_manage_enable === true)) {
            try {
                $response = $this->ups_eu_woo_update_merchant_status($account_number, $model_config->account_Deactivated);
            } catch (Exception $ex) {
                $response = false;
            }
            return $response;
        }

        return false;
    }

    private function ups_eu_woo_get_account_number($account_number)
    {
        $str_account_number = "";
        if (is_object($account_number)) {
            if (!empty($account_number->account_number)) {
                $str_account_number = $account_number->account_number;
            }
        } else {
            $str_account_number = strval($account_number);
        }
        return $str_account_number;
    }

    public function ups_eu_woo_transfer_merchant_info_by_user($account_number, $count = 1)
    {
        /* Add new account account */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $ACCEPT_BILLING_PREFERENCE = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_BILLING_PREFERENCE) === true) {
            $ACCEPT_BILLING_PREFERENCE = $model_config->value;
        }
        if ((intval($ACCEPT_BILLING_PREFERENCE) === 1) && ($this->api_manage_enable === true)) {
            $this->ups_eu_woo_load_lib_api_manage();
            /* ---Log before cal api--- */
            $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
            $model_logsApi->ups_eu_woo_before_log_api("_transferMerchantInfoByUser");
            /* ---End before call log api */
            $model_data_plugin = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Api_Manage_Plugin();
            $data = $model_data_plugin->ups_eu_woo_load_account_infor_by_user($account_number);
            global $wp;
            $website = explode('://', home_url($wp->request));
            if (isset($website[1])) {
                $data->website = $website[1];
            } else {
                $data->website = $website[0];
            }
            $data->version = \UpsEuWoocommerce\Ups_Eu_Woo_Main::$version;
            $data->joining_date = date("m/d/Y");
            if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_registered_plugin_token) === true) {
                $data->upsmodule_token = $model_config->value;
            }
            try {
                $response = $this->lib_api_manage->ups_eu_woo_api_transfer_merchant_info_by_user($data);
            } catch (Exception $ex) {
                $response = false;
            }
            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            /* ----End after call api--- */
            if (isset($response->error->errorCode) && intval($response->error->errorCode) === 401 && $count <= 3) {
                $count = $count + 1;
                $this->ups_eu_woo_get_new_registered_plugin_token();
                $response = $this->ups_eu_woo_transfer_merchant_info_by_user($account_number, $count);
            }
            if (isset($response->errors) && $count <= 4) {
                $count = $count + 1;
                $response = $this->ups_eu_woo_transfer_merchant_info_by_user($account_number, $count);
            }
            return $response;
        }
        return false;
    }

    public function ups_eu_woo_transfer_merchant_info($option = 0, $count = 1)
    {
        /*
         * On button [Complete Configuration] is  done then call api,
         */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $ACCEPT_BILLING_PREFERENCE = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_BILLING_PREFERENCE) === true) {
            $ACCEPT_BILLING_PREFERENCE = $model_config->value;
        }
        if ((intval($ACCEPT_BILLING_PREFERENCE) === 1) && ($this->api_manage_enable === true)) {
            $this->ups_eu_woo_load_lib_api_manage();
            /* ---Log before cal api--- */
            $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
            $model_logsApi->ups_eu_woo_before_log_api("_transferMerchantInfo");
            /* ---End before call log api */
            $model_data_plugin = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Api_Manage_Plugin();
            $data = $model_data_plugin->ups_eu_woo_load_complete_configuration($option);
            if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_registered_plugin_token) === true) {
                $data->upsmodule_token = $model_config->value;
            }
            global $wp;
            if (isset($wp)){
                $website = explode('://', home_url($wp->request));
            }
            if (isset($website[1])) {
                $data->website = $website[1];
            } else {
                $data->website = $website[0];
            }
            $data->version = \UpsEuWoocommerce\Ups_Eu_Woo_Main::$version;
            $data->joining_date = date("m/d/Y");
            try {
                $response = $this->lib_api_manage->ups_eu_woo_api_transfer_merchant_info($data);
            } catch (Exception $ex) {
                $response = false;
            }
            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            /* ----End after call api--- */
            if (isset($response->error->errorCode) && intval($response->error->errorCode) === 401 && $count <= 3) {
                $count = $count + 1;
                $this->ups_eu_woo_get_new_registered_plugin_token();
                $response = $this->ups_eu_woo_transfer_merchant_info($option, $count);
            }
            if (isset($response->errors) && $count <= 4) {
                $count = $count + 1;
                $response = $this->ups_eu_woo_transfer_merchant_info($option, $count);
            }
            return $response;
        }
        return false;
    }

    public function ups_eu_woo_transfer_accessorials($count = 1)
    {
        /* Disable method */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $check_manage = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_check_manage) === true) {
            $check_manage = $model_config->value;
        }
        if ((intval($check_manage) === 1) && ($this->api_manage_enable === true)) {
            $this->ups_eu_woo_load_lib_api_manage();
            /* ---Log before cal api--- */
            $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
            $model_logsApi->ups_eu_woo_before_log_api("_transferAccessorials");
            /* ---End before call log api */
            $model_data_plugin = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Api_Manage_Plugin();
            $data = $model_data_plugin->ups_eu_woo_load_accessorial();
            if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_registered_plugin_token) === true) {
                $data->upsmodule_token = $model_config->value;
            }
            try {
                $response = $this->lib_api_manage->ups_eu_woo_api_transfer_accessorials($data);
            } catch (Exception $ex) {
                $response = false;
            }
            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            /* ----End after call api--- */
            if (isset($response->error->errorCode) && intval($response->error->errorCode) === 401 && $count <= 3) {
                $count = $count + 1;
                $this->ups_eu_woo_get_new_registered_plugin_token();
                $response = $this->ups_eu_woo_transfer_accessorials($count);
            }
            if (isset($response->errors) && $count <= 4) {
                $count = $count + 1;
                $response = $this->ups_eu_woo_transfer_accessorials($count);
            }
            return $response;
        }
        return false;
    }

    public function ups_eu_woo_transfer_shipping_services($count = 1)
    {
        /*
         * Apply page shipping service
         * after save data done then call api
         */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $check_manage = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_check_manage) === true) {
            $check_manage = $model_config->value;
        }
        if ((intval($check_manage) === 1) && ($this->api_manage_enable === true)) {
            $this->ups_eu_woo_load_lib_api_manage();
            /* ---Log before cal api--- */
            $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
            $model_logsApi->ups_eu_woo_before_log_api("_transferShippingServices");
            /* ---End before call log api */
            $model_data_plugin = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Api_Manage_Plugin();
            $data = $model_data_plugin->ups_eu_woo_load_shipping_service();
            if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_registered_plugin_token) === true) {
                $data->upsmodule_token = $model_config->value;
            }
            try {
                $response = $this->lib_api_manage->ups_eu_woo_api_transfer_shipping_services($data);
            } catch (Exception $ex) {
                $response = false;
            }
            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            /* ----End after call api--- */
            if (isset($response->error->errorCode) && intval($response->error->errorCode) === 401 && $count <= 3) {
                $count = $count + 1;
                $this->ups_eu_woo_get_new_registered_plugin_token();
                $response = $this->ups_eu_woo_transfer_shipping_services($count);
            }
            if (isset($response->errors) && $count <= 4) {
                $count = $count + 1;
                $response = $this->ups_eu_woo_transfer_shipping_services($count);
            }
            return $response;
        }
        return false;
    }

    public function ups_eu_woo_transfer_delivery_rates($count = 1)
    {
        /* Apply on page Delivery rate
         * after save done then call api
         */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $check_manage = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_check_manage) === true) {
            $check_manage = $model_config->value;
        }
        if ((intval($check_manage) === 1) && ($this->api_manage_enable === true)) {
            $this->ups_eu_woo_load_lib_api_manage();
            /* ---Log before cal api--- */
            $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
            $model_logsApi->ups_eu_woo_before_log_api("_transferDeliveryRates");
            /* ---End before call log api */
            $model_data_plugin = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Api_Manage_Plugin();
            $data = $model_data_plugin->ups_eu_woo_load_delivery_rate();
            if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_registered_plugin_token) === true) {
                $data->upsmodule_token = $model_config->value;
            }
            try {
                $response = $this->lib_api_manage->ups_eu_woo_api_transfer_delivery_rates($data);
            } catch (Exception $ex) {
                $response = false;
            }
            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            /* ----End after call api--- */
            if (isset($response->error->errorCode) && intval($response->error->errorCode) === 401 && $count <= 3) {
                $count = $count + 1;
                $this->ups_eu_woo_get_new_registered_plugin_token();
                $response = $this->ups_eu_woo_transfer_delivery_rates($count);
            }
            if (isset($response->errors) && $count <= 4) {
                $count = $count + 1;
                $response = $this->ups_eu_woo_transfer_delivery_rates($count);
            }
        }
        return false;
    }

    public function ups_eu_woo_transfer_default_package($count = 1)
    {
        /*
         * Apply on page default package
         * then save database done then call api
         */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_RetryApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Retry_Api();
        $check_manage = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_check_manage) === true) {
            $check_manage = $model_config->value;
        }
        if ((intval($check_manage) === 1) && ($this->api_manage_enable === true)) {
            $this->ups_eu_woo_load_lib_api_manage();
            /* ---Log before cal api--- */
            $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
            $model_logsApi->ups_eu_woo_before_log_api("_transferDefaultPackage");
            /* ---End before call log api */
            $model_data_plugin = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Api_Manage_Plugin();
            $data = $model_data_plugin->ups_eu_woo_load_package_dimension();
            if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_registered_plugin_token) === true) {
                $data->upsmodule_token = $model_config->value;
            }
            try {
                $response = $this->lib_api_manage->ups_eu_woo_api_transfer_default_package($data);
            } catch (Exception $ex) {
                $response = false;
            }

            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            /* ----End after call api--- */
            if (isset($response->error->errorCode) && intval($response->error->errorCode) === 401 && $count <= 3) {
                $count = $count + 1;
                $this->ups_eu_woo_get_new_registered_plugin_token();
                $response = $this->ups_eu_woo_transfer_default_package($count);
            }
            if (isset($response->errors) && $count <= 4) {
                $count = $count + 1;
                $response = $this->ups_eu_woo_transfer_default_package($count);
            }
            return $response;
        }
        return false;
    }

    public function ups_eu_woo_transfer_shipments($data_retry, $count = 1)
    {
        /*
         * Apply on popup  show created shippment,
         * then save database done then call api
         */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $check_manage = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_check_manage) === true) {
            $check_manage = $model_config->value;
        }
        if ((intval($check_manage) === 1) && ($this->api_manage_enable === true)) {
            $this->ups_eu_woo_load_lib_api_manage();
            /* ---Log before cal api--- */
            $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
            $model_logsApi->ups_eu_woo_before_log_api("_transferShipments");
            /* ---End before call log api */
            $model_data_plugin = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Api_Manage_Plugin();
            $data = $model_data_plugin->ups_eu_woo_load_shippment($data_retry);
            if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_registered_plugin_token) === true) {
                $data->upsmodule_token = $model_config->value;
            }
            try {
                $response = $this->lib_api_manage->ups_eu_woo_api_transfer_shipments($data);
            } catch (Exception $ex) {
                $response = false;
            }

            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            /* ----End after call api--- */
            if (isset($response->error->errorCode) && intval($response->error->errorCode) === 401 && $count <= 3) {
                $count = $count + 1;
                $this->ups_eu_woo_get_new_registered_plugin_token();
                $response = $this->ups_eu_woo_transfer_shipments($data_retry, $count);
            }
            if (isset($response->errors) && $count <= 4) {
                $count = $count + 1;
                $response = $this->ups_eu_woo_transfer_shipments($data_retry, $count);
            }
            return $response;
        }
        return false;
    }

    public function ups_eu_woo_update_shipments_status($data_retry, $count = 1)
    {
        /* Apply page view detail shippent
         * , after changed status then call api
         */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_RetryApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Retry_Api();
        $check_manage = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_check_manage) === true) {
            $check_manage = $model_config->value;
        }
        if ((intval($check_manage) === 1) && ($this->api_manage_enable === true)) {
            $this->ups_eu_woo_load_lib_api_manage();
            /* ---Log before cal api--- */
            $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
            $model_logsApi->ups_eu_woo_before_log_api("_updateShipmentsStatus");
            /* ---End before call log api */
            $model_data_plugin = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Api_Manage_Plugin();
            $data = $model_data_plugin->ups_eu_woo_load_shippment_status($data_retry);
            if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_registered_plugin_token) === true) {
                $data->upsmodule_token = $model_config->value;
            }
            try {
                $response = $this->lib_api_manage->ups_eu_woo_api_update_shipment_status($data);
            } catch (Exception $ex) {
                $response = false;
            }

            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);
            /* ----End after call api--- */
            if (isset($response->error->errorCode) && intval($response->error->errorCode) === 401 && $count <= 3) {
                $count = $count + 1;
                $this->ups_eu_woo_get_new_registered_plugin_token();
                $response = $this->ups_eu_woo_update_shipments_status($data_retry, $count);
            }
            if (isset($response->errors) && $count <= 4) {
                $count = $count + 1;
                $response = $this->ups_eu_woo_update_shipments_status($data_retry, $count);
            }
            return $response;
        }
        return false;
    }

    public function ups_eu_woo_upgrade_plugin_version()
    {
        try {
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            $accept_billing_preference = false;
            if ($model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_BILLING_PREFERENCE) === true) {
                $accept_billing_preference = (bool) $model_config->value;
            }
            if ($accept_billing_preference) {
                if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_check_manage) !== true) {
                    //get new registeredplugintoken
                    $this->ups_eu_woo_get_new_registered_plugin_token();
                    //get new bing map key
                    $this->ups_eu_woo_call_api_get_bing_map_credential();
                    //clear data in retry of old version
                    call_user_func_array([
                        new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Retry_Api(),
                        'ups_eu_woo_delete_all'
                    ], []);
                    //save transfer merchant info
                    $transfer_default_account = $this->ups_eu_woo_transfer_merchant_info();
                    if ($transfer_default_account) {
                        $this->ups_eu_woo_transfer_merchant_info(1);
                        $this->ups_eu_woo_save_option_setting($model_config->ups_shipping_transfer_info_already_done, 1);
                    }
                    //save check_manage
                    $this->ups_eu_woo_save_option_setting($model_config->ups_shipping_check_manage, 1);
                } else {
                    $this->ups_eu_woo_transfer_merchant_info();
                }
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    public function ups_eu_woo_upgrade_version($count = 1)
    {
        try {
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            $accept_billing_preference = false;
            if ($model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_BILLING_PREFERENCE) === true) {
                $accept_billing_preference = (bool) $model_config->value;
            }
            if ($accept_billing_preference) {
                $this->ups_eu_woo_load_lib_api_manage();

                $object = new \stdClass();
                $object->merchant_key    = "";
                $object->upsmodule_token = "";

                /* Call API */
                $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
                $model_logsApi->ups_eu_woo_before_log_api("_upgrade_plugin");

                if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) === true) {
                    $object->merchant_key = $model_config->value;
                }

                if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_registered_plugin_token) === true) {
                    $object->upsmodule_token = $model_config->value;
                }

                $response = $this->lib_api_manage->ups_eu_woo_api_upgrade_plugin_version($object);
                /* ---Log after call api--- */
                $this->ups_eu_woo_after_log_api_manage($model_logsApi);
                /* ----End after call api--- */
                if (isset($response->error->errorCode) && intval($response->error->errorCode) === 401 && $count <= 3) {
                    $count = $count + 1;
                    $this->ups_eu_woo_get_new_registered_plugin_token();
                    $this->ups_eu_woo_upgrade_version($count);
                }
                if (isset($response->errors) && $count <= 4) {
                    $count = $count + 1;
                    $this->ups_eu_woo_upgrade_version($count);
                }
            }

        } catch (Exception $ex) {
            return false;
        }
    }

    public function ups_eu_woo_currency_plugin()
    {
        try {
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            $this->ups_eu_woo_load_lib_api_manage();
            global $woocommerce;

            $object = new \stdClass();

            $object->merchant_key    = "";
            $object->upsmodule_token = "";

            /* Call API */
            $model_logsApi = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
            $model_logsApi->ups_eu_woo_before_log_api("_currency_plugin");

            if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_merchant_key) === true) {
                $object->merchant_key = $model_config->value;
            }

            if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_registered_plugin_token) === true) {
                $object->upsmodule_token = $model_config->value;
            }

            try {
                $response = $this->lib_api_manage->ups_eu_woo_api_currency_plugin($object);
            } catch (Exception $ex) {
                $response = false;
            }

            /* ---Log after call api--- */
            $this->ups_eu_woo_after_log_api_manage($model_logsApi);

            if (isset($response->error->errorCode) && intval($response->error->errorCode) === 401) {
                $this->ups_eu_woo_get_new_registered_plugin_token();
                $response = $this->ups_eu_woo_currency_plugin();
            }
            return $response->data;
        } catch (Exception $ex) {
            return false;
        }
    }
}
