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
 * ups-eu-woo-config-terms-condition.php - The core plugin class.
 *
 * This is used to config Terms and Conditions.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Config_Terms_Condition');

class Ups_Eu_Woo_Config_Terms_Condition
{

    /**
     * Name function: terms_conditions
     * Params: empty
     * Return: void
     */
    public function ups_eu_woo_config_terms_conditions()
    {
        /* Load models class */
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_licence = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_License();
        $upsapi_config = new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Manage_Api_Ups();
        /* Created object  data */
        $dataObject = new \stdClass();
        /* Get access license text form UPS api */
        $model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE);
        /* get [Language Code] from config of wordpress */
        if (!empty(get_locale())) {
            $language_code = strtoupper(substr(get_locale(), 0, 2));
        } else {
            $language_code = 'EN';
        }
        // $access_license_text = ''
        /* Save form data */
        if ($router_url->ups_eu_woo_check_method_post() === true &&
            isset($_REQUEST[$model_config->agree_term_and_usage]) &&
            $_REQUEST[$model_config->agree_term_and_usage] == 'on') {
            /* Setup master data config */
            $access_license_text = "";
            if (!empty($_REQUEST[$model_config->access_license_text])) {
                $access_license_text = $_REQUEST[$model_config->access_license_text];
            }
            $InitDataSystem = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Init_Data_System();
            /* insert table accessorial */
            $InitDataSystem->ups_eu_woo_int_first_insert_table_accessorial();
            /* insert table config */
            $InitDataSystem->ups_eu_woo_int_first_insert_table_config();
            /* insert table service */
            $InitDataSystem->ups_eu_woo_int_first_insert_table_services();

            /* Save status SHOW_TERM_CONDITION is on */
            if ($model_config->ups_eu_woo_get_by_key($model_config->SHOW_TERM_CONDITION) === true &&
                $model_config->value !== 1) {
                $model_config->value = 1;
                $model_config->ups_eu_woo_save();
            }
            /* Save status ACCEPT_TERM_CONDITION is on */
            if ($model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_TERM_CONDITION) === true &&
                $model_config->value !== 1) {
                $model_config->value = 1;
                $model_config->ups_eu_woo_save();
            }

            /* Set Page none acount is enable */
            $model_config->ups_eu_woo_set_value_config_by_key(
                $model_config->ACCEPT_ACCOUNT,
                2,
                $model_config->btn_controller_next
            );

            /* Create account */
            $model_licence->ups_eu_woo_save_html([
                $model_config->AccessLicenseText => $access_license_text,
            ]);

            $router_url->ups_eu_woo_redirect($router_url->url_none_account);
        }

        $request_data = new \stdClass();
        $request_data->country_code = $model_config->value;
        $request_data->language_code = $language_code;
        $upsmodule_token = '';
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_pre_registered_plugin_token) === true) {
            $upsmodule_token = $model_config->value;
        }
        $request_data->upsmodule_token = $upsmodule_token;
        /* call api termcondition */
        $access_license_text = $upsapi_config->ups_eu_woo_call_api_termcondition($request_data);
        $dataObject->message_call_api_error = "";
        if (($access_license_text === false) || empty($access_license_text)) {
            /* set error message */
            $dataObject->message_call_api_error = __(
                "Connection error, try later to install and configure",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }

        $access_license_text = urldecode(html_entity_decode($access_license_text));

        $arrCheck = ['DE', 'NL', 'IT', 'BE'];

        if (in_array($request_data->country_code, $arrCheck) && function_exists('iconv')) {
            $txt = iconv(mb_detect_encoding($access_license_text, mb_detect_order(), true), "ISO-8859-1//IGNORE", $access_license_text);
            $dataObject->access_license_text = iconv(mb_detect_encoding($txt, mb_detect_order(), true), "UTF-8//IGNORE", $txt);
        } else {
            $dataObject->access_license_text = trim(preg_replace(
                "/(&#xD;)/",
                '<br>',
                $access_license_text
            ));
        }

        //$dataObject->access_license_text = $access_license_text
        $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
            $model_config->lang_page_terms_conditions
        );
        $dataObject->action_form = $router_url->url_terms_conditions;
        $dataObject->object_json_javascript = json_encode(
            ["access_license_text" => $dataObject->access_license_text]
        );
        return $dataObject;
    }
}
