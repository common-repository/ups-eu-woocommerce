<?php namespace UpsEuWoocommerce\controllers\admin;

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
 * ups-eu-woo-config-account.php - The core plugin class.
 *
 * This is used to config Account.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Config_Account');

class Ups_Eu_Woo_Config_Account
{
    /**
     * Name function: ups_eu_woo_api_promo_discount_agreement
     * Params:
     * @model_account: type object class
     * @api_ups_api: type object class
     * Return: void
     */
    private function ups_eu_woo_api_promo_discount_agreement($model_account, $upsapi_config)
    {
        /* check account type is 3 then call api */
        if (intval($model_account->account_type) === 3 && strlen($model_account->ups_account_promocode) > 0) {
            $upsapi_config->ups_eu_woo_call_api_promo_discount_agreement($model_account->ups_account_promocode);
        }
    }

    /**
     * Name function: none_account
     * Params: empty
     * Return: void
     */
    public function ups_eu_woo_config_none_account()
    {
        /* Load models class */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_account = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Account();
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        /* Init variable */
        $validate = [];
        $mess_error_call_api = "";
        /* Post data */
        if ($router_url->ups_eu_woo_check_method_post() === true) {
            /* Get data form post */
            $data = $_POST;
            if ($data['country'] == 'US') {
                $data['ups_account_promocode'] = 'CP313WO77';
            }
            /* Set data to model */
            $model_account = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Account();
            $model_account->ups_eu_woo_merge_array($data);
            /* Set data by UPS account type */
            if (isset($data[$model_account->col_account_type])) {
                switch ($data[$model_account->col_account_type]) {
                    /* Not have account */
                    case 0:
                        /* Call api */
                        break;
                    /* Set data for accout with invoice */
                    case 1:
                        $model_account->ups_eu_woo_merge_array($data[$model_account->key_have_with_invoice]);
                        break;
                    /* Set data for accout without invoice */
                    case 2:
                        $model_account->ups_eu_woo_merge_array($data[$model_account->key_have_without_invoice]);
                        break;
                    /* Set data for accout with username and password */
                    case 4:
                        $model_account->ups_eu_woo_merge_array($data[$model_account->key_have_with_accpass]);
                        break;
                    default:
                        break;
                }
            }

            /* check validate account */
            $validate = $model_account->ups_eu_woo_validate();

            /* Set account type is primary */
            $model_account->account_default = 1;

            /* Save data */
            if ($validate === true) {
                if ($model_config->ups_eu_woo_get_by_key($model_account->key_accept_account) === true) {
                    /* load api library */
                    $upsapi_config = new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Configurations_Api_Ups();
                    $manageapi_config = new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Manage_Api_Ups();
                    /* call registration api */
                    $api_registration_check_message = $manageapi_config->ups_eu_woo_registration((array) $model_account);
                    if ($api_registration_check_message === true) {
                        $this->ups_eu_woo_get_registered_token_and_bing_map_key();
                        /* check case account type is 3, then update account number from open account */
                        if (intval($model_account->account_type) === 3) {
                            $model_config2 = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
                            /* get ups open account number */
                            $tmp_ups_open_account_number = "";
                            if ($model_config2->ups_eu_woo_get_by_key($model_config2->tmp_ups_open_account_number) === true) {
                                $tmp_ups_open_account_number = $model_config2->value;
                            }
                            /* set ups account number to model account */
                            $model_account->ups_account_number = $tmp_ups_open_account_number;
                        }
                        if ($model_account->ups_eu_woo_get_default_account() === false && $model_account->ups_eu_woo_save($data) === true) {
                            $model_config->value = 1;
                            $model_config->ups_eu_woo_save();
                            /* after save database then call api ups_eu_woo_call_api_promo_discount_agreement */
                            $this->ups_eu_woo_api_promo_discount_agreement($model_account, $upsapi_config);
                            $router_url->ups_eu_woo_redirect($router_url->url_account);
                        }
                    } else {
                        $mess_error_call_api = "[ " . $api_registration_check_message . " ]";
                    }
                } else {
                    $router_url->ups_eu_woo_redirect($router_url->url_none_account);
                }
            }
        }

        /* Create object data */
        $dataObject = new \stdClass();
        /* Set for multilanguage */
        $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
            $model_account->lang_page_none_account
        );
        /* Set data for form */
        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            $model_account->country = $model_config->value;
        } else {
            $model_account->country = "PL";
        }
        /* set ups invoice date */
        if (! empty($model_account->ups_invoice_date)) {
            $model_account->ups_invoice_date = $model_account->ups_invoice_date;
        } else {
            $model_account->ups_invoice_date = date("m/d/Y");
        }
        if (strpos($model_account->ups_invoice_date, "-") > 0) {
            /* format ups invoice date */
            $model_account->ups_invoice_date = preg_replace(
                "/([0-9]{4})-([0-9]{2})-([0-9]{2})/",
                "$2/$3/$1",
                $model_account->ups_invoice_date
            );
        }
        /* get account default */
        $load_account_default = $model_account->ups_eu_woo_get_default_account();
        if ($load_account_default) {
            /* get account default by id */
            $model_account->ups_eu_woo_get_by_id($load_account_default[$model_account->col_account_id]);
        }
        /* set account type */
        if (!empty($model_account->account_type)) {
            $model_account->account_type = $model_account->account_type;
        } else {
            $model_account->account_type = 4;
        }
        /* set account ups currency */
        if (!empty($model_account->ups_currency)) {
            $model_account->ups_currency = $model_account->ups_currency;
        } else {
            $model_account->ups_currency = 'EUR';
        }
        $dataObject->form = $model_account;
        /* Set error data for form */
        $dataObject->validate = $validate;
        if (!empty($mess_error_call_api)) {
            $all_ph = [
                    'be' => '+32 78 48 49 16',
                    'fr' => '+33 805 11 96 92',
                    'de' => '+49 32 221097485',
                    'it' => '+39 800 725 920',
                    'nl' => '+31 85 107 0232',
                    'pl' => '+48 22 103 24 55',
                    'es' => '+34 518 90 05 99',
                    'gb' => '+44 808 258 0323',
                    'AT' => '+49 32 221097485',
                    'BG' => '+49 32 221097485',
                    'HR' => '+49 32 221097485',
                    'CY' => '+49 32 221097485',
                    'CZ' => '+49 32 221097485',
                    'DK' => '+49 32 221097485',
                    'EE' => '+49 32 221097485',
                    'FI' => '+49 32 221097485',
                    'GR' => '+49 32 221097485',
                    'HU' => '+49 32 221097485',
                    'IE' => '+49 32 221097485',
                    'LV' => '+49 32 221097485',
                    'LT' => '+49 32 221097485',
                    'LU' => '+49 32 221097485',
                    'MT' => '+49 32 221097485',
                    'RO' => '+49 32 221097485',
                    'SK' => '+49 32 221097485',
                    'SI' => '+49 32 221097485',
                    'SE' => '+49 32 221097485',
                    'NO' => '+49 32 221097485',
                    'RS' => '+49 32 221097485',
                    'CH' => '+49 32 221097485',
                    'IS' => '+49 32 221097485',
                    'JE' => '+49 32 221097485', 
                    'TR' => '+49 32 221097485'
                ];
            $sprt_ph = "";
            if ( isset($data['country']) && isset($all_ph[strtolower($data['country'])]) ) {
                $sprt_ph = $all_ph[strtolower($data['country'])];
            }
            $mess_error_call_api = "The following issue was detected. ".$mess_error_call_api."Please reach out to your Account Manager to understand and resolve the issue. For further instructions reach out to ".$sprt_ph.".";
        }
        $dataObject->mess_error_call_api = $mess_error_call_api;
        /* Set action url for form */
        $dataObject->action_form = $router_url->url_none_account;
        $dataObject->page = 'none_account';

        /* Get list currency from database */
        $options = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Options();
        /* get currency list */
        $dataObject->currency_list = $options->ups_eu_woo_get_currency_list();
        $dataObject->country_list_define = $options->country_list_define();

        return $dataObject;
    }

    /**
     * Name function: ups_eu_woo_get_registered_token_and_bing_map_key
     * Params: empty
     * Return: void
     */
    public function ups_eu_woo_get_registered_token_and_bing_map_key()
    {
        /* Load models class */
        $model_license = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_License();
        $license_data = $model_license->ups_eu_woo_get_licence_config();
        call_user_func_array([
            new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Manage_Api_Ups(),
            "ups_eu_woo_call_api_registered_plugin_token"
            ], [$license_data]);
        call_user_func_array([
            new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Manage_Api_Ups(),
            "ups_eu_woo_call_api_get_bing_map_credential"
            ], []);
    }

    /**
     * Name function: ups_eu_woo_transfer_merchant_info_by_user
     * Params:
     * @model_account:type object class
     * Return: type void
     */
    private function ups_eu_woo_transfer_merchant_info_by_user($model_account)
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_check_manage) === true &&
            intval($model_config->value) === 1
        ) {
            /* check ups account number not empty then call api */
            if (strlen($model_account->ups_account_number) > 0) {
                /* transfer merchant user info */
                call_user_func_array([
                    new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Retry_Api(),
                    "ups_eu_woo_transfer_merchant_info_by_user"], [
                    $model_account->ups_account_number
                    ]);
            }
        }
    }

    /**
     * Name function: account
     * Params: empty
     * Return: void
     */
    public function ups_eu_woo_config_account()
    {
        /* Permission access link */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $model_account = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Account();
        $mess_error_call_api = "";

        $validate = [];
        /* check method post */
        if ($router_url->ups_eu_woo_check_method_post() === true) {
            $btn_controller = "";
            if (!empty($_REQUEST[$router_url->btn_controller])) {
                $btn_controller = trim(sanitize_text_field(strip_tags($_REQUEST[$router_url->btn_controller])));
            }

            switch ($btn_controller) {
                case "pwd_reset":
                    $username = isset($_REQUEST['reset_name']) ? sanitize_text_field($_REQUEST['reset_name']) : "";
                    $password = isset($_REQUEST['reset_pass']) ? sanitize_text_field($_REQUEST['reset_pass']) : "";
                    if (empty($username)) {
                        $validate['reset_name'] = array("msg_error"=>"Username required");
                    }
                    if (empty($password)) {
                        $validate['reset_pass'] = array("msg_error"=>"Password required");
                    }
                    if (!empty($username) && !empty($password)) {
                        global $wpdb;
                        $pass_up_sql = "UPDATE `".$wpdb->prefix."ups_shipping_license` SET `Username` = '".$username."', `Password` = '".$password."' WHERE `id` = 1";
                        if ($wpdb->query($pass_up_sql)) {
                            $reset_acc_status = 3;
                            $reset_acc_msg = "Username and password updated successfully.";
                        } else {
                            $reset_acc_status = 4;
                            $reset_acc_msg = "Username and password update failed.";
                        }
                    }
                    break;
                /* click button next */
                case "{$model_config->btn_controller_next}":
                    /* get value config ACCEPT_ACCOUNT */
                    $model_config->ups_eu_woo_set_value_config_by_key($model_account->key_accept_account, 3);
                    /* get value config ACCEPT_SHIPPING_SERVICE */
                    $model_config->ups_eu_woo_set_value_config_by_key(
                        $model_config->ACCEPT_SHIPPING_SERVICE,
                        2,
                        $model_config->btn_controller_next
                    );

                    $router_url->ups_eu_woo_redirect($router_url->url_shipping_service);
                    break;
                /* click button verify */
                case "{$model_config->btn_controller_verify}":
                    $data = $_REQUEST;
                    $model_account = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Account();
                    $model_account->ups_eu_woo_merge_array($data);
                    /* merge data account */
                    $this->ups_eu_woo_merge_data_account($model_account, $data);
                    $validate = $model_account->ups_eu_woo_validate(null, false);
                    if ($validate === true) {
                        /* save */
                        $upsapi_config = new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Configurations_Api_Ups();
                        $registration_success_check = $upsapi_config->ups_eu_woo_registration_success($model_account);
                        if ($registration_success_check === true) {
                            /* check account's exist */
                            if ($model_account->check_account_number_existing(
                                $model_account->ups_account_number
                            ) === false) {
                                $model_account->ups_eu_woo_save();
                                $this->ups_eu_woo_transfer_merchant_info_by_user($model_account);
                            }
                            /* set value config of account */
                            $model_config->ups_eu_woo_set_value_config_by_key($model_account->key_accept_account, 3);
                            $router_url->ups_eu_woo_redirect("{$router_url->url_account}&mess_success=ok");
                        } else {
                            $mess_error_call_api = $registration_success_check;
//                            $router_url->ups_eu_woo_redirect($router_url->url_account)
                        }
                    }
                    break;
                /* click remove account */
                case "{$model_config->btn_controller_remove}":
                    $id_remove = "";
                    if (! empty($_REQUEST[$model_account->key_id_remove])) {
                        $id_remove = trim(sanitize_text_field(strip_tags($_REQUEST[$model_account->key_id_remove])));
                    }
                    /* get account by id */
                    $model_account->ups_eu_woo_get_by_id($id_remove);
                    $ups_account_number = $model_account->ups_account_number;
                    /* delete account */
                    $model_account->ups_eu_woo_delete($id_remove);
                    if (strlen($ups_account_number) > 0) {
                        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_check_manage) === true &&
                            intval($model_config->value) === 1
                        ) {
                            /* update merchant status when remove account */
                            call_user_func_array([
                                new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Retry_Api(),
                                "ups_eu_woo_update_merchant_status_remove_account"
                                ], [$ups_account_number]);
                        }
                    }
                    break;
                default:
                    break;
            }
        }

        $dataObject = new \stdClass();
        /* get language translate */
        $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
            $model_account->lang_page_account
        );
        $dataObject->number_block_show = $router_url->ups_eu_woo_get_number_block_show(
            $router_url->block_account,
            1
        );
        $dataObject->validate = $validate;
        $dataObject->mess_error_call_api = $mess_error_call_api;
        /* get country by key */
        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            $model_account->country = $model_config->value;
        } else {
            $model_account->country = "PL";
        }
        if (! empty($model_account->ups_invoice_date)) {
            $model_account->ups_invoice_date = $model_account->ups_invoice_date;
        } else {
            $model_account->ups_invoice_date = date("m/d/Y");
        }
        if (strpos($model_account->ups_invoice_date, "-") > 0) {
            /* format ups invoice date */
            $model_account->ups_invoice_date = preg_replace(
                "/([0-9]{4})-([0-9]{2})-([0-9]{2})/",
                "$2/$3/$1",
                $model_account->ups_invoice_date
            );
        }
        /* set ups currency */
        if (!empty($model_account->ups_currency)) {
            $model_account->ups_currency = $model_account->ups_currency;
        } else {
            $model_account->ups_currency = "EUR";
        }
        $dataObject->form = $model_account;
        $options = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Options();
        $dataObject->currency_list = $options->ups_eu_woo_get_currency_list();
        $dataObject->country_list_define = $options->country_list_define();
        /* get account default */
        $dataObject->default_account = $model_account->ups_eu_woo_get_default_account();

        $dataObject->list_accouts    = $model_account->get_list_data_by_condition([]);


        if ($model_account->country == 'US') {
            $dataObject->default_account["state"] = $options->get_state_name($model_account->country, $dataObject->default_account["state"]);
            $list_accouts = [];
            foreach ($dataObject->list_accouts as $key => $item) {
                $item->state = $options->get_state_name($model_account->country, $item->state);
                $list_accouts[] = $item;
            }
            $dataObject->list_accouts = $list_accouts;
        }

        $dataObject->mess_success = "";
        if (! empty($_REQUEST[$model_account->key_mess_success])) {
            $dataObject->mess_success = trim(sanitize_text_field(strip_tags($_REQUEST[$model_account->key_mess_success])));
        }
        /* accept link */
        $dataObject->action_form = $router_url->url_account;
        $dataObject->links_form = $router_url->ups_eu_woo_get_all_link_form();
        $dataObject->page = 'success_account';

        $dataObject->reset_acc_status = isset($reset_acc_status) ? $reset_acc_status : "";
        $dataObject->reset_acc_msg = isset($reset_acc_msg) ? $reset_acc_msg : "";

        return $dataObject;
    }

    /**
     * Name function: ups_eu_woo_merge_data_account
     * Params:
     * @model_account: type  object class
     * @data: type array
     * Return: type void
     */
    private function ups_eu_woo_merge_data_account(&$model_account, $data)
    {
        if (isset($data[$model_account->col_account_type])) {
            switch ($data[$model_account->col_account_type]) {
                /* Set data for account with an invoice */
                case 1:
                    $model_account->ups_eu_woo_merge_array($data[$model_account->key_have_with_invoice]);
                    break;
                /* Set data for account without invoice */
                case 2:
                    $model_account->ups_eu_woo_merge_array($data[$model_account->key_have_without_invoice]);
                    break;
                default:
                    break;
            }
        }
    }
}
