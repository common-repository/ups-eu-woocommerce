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
 * ups-eu-woo-model-entity-config.php - The core plugin class.
 *
 * This is used to define the Config Entity.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Config_Entity');

class Ups_Eu_Woo_Config_Entity extends \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Base
{
    /* List colum name in table [config] database */

    public $col_config_id = "config_id";
    public $col_scope = "scope";
    public $col_scope_id = "scope_id";
    public $col_key = "key";
    public $col_value = "value";
    /* key name config had in database */
    public $ACCEPT_ACCESSORIAL = "ACCEPT_ACCESSORIAL";
    public $ACCEPT_ACCOUNT = "ACCEPT_ACCOUNT";
    public $ACCEPT_BILLING_PREFERENCE = "ACCEPT_BILLING_PREFERENCE";
    public $ACCEPT_CASH_ON_DELIVERY = "ACCEPT_CASH_ON_DELIVERY";
    public $ACCEPT_DELIVERY_RATES = "ACCEPT_DELIVERY_RATES";
    public $ACCEPT_PACKAGE_DIMENSION = "ACCEPT_PACKAGE_DIMENSION";
    public $UPS_PACK_ALGO = "UPS_PACK_ALGO";
    public $UPS_PACK_WEG_UNIT = "UPS_PACK_WEG_UNIT";
    public $UPS_PACK_DIM_UNIT = "UPS_PACK_DIM_UNIT";
    public $UPS_PACK_MAX_WEIGHT = "UPS_PACK_MAX_WEIGHT";
    public $ACCEPT_SHIPPING_SERVICE = "ACCEPT_SHIPPING_SERVICE";
    public $ACCEPT_TERM_CONDITION = "ACCEPT_TERM_CONDITION";
    public $ACTIVE = "ACTIVE";
    public $CHOOSE_ACCOUNT_NUMBER_ADD = "CHOOSE_ACCOUNT_NUMBER_ADD";
    public $CHOOSE_ACCOUNT_NUMBER_AP = "CHOOSE_ACCOUNT_NUMBER_AP";
    public $COUNTRY_CODE = "COUNTRY_CODE";
    public $CURRENCY_DATA = "CURRENCY_DATA";
    public $CUT_OFF_TIME = "CUT_OFF_TIME";
    public $DELIVERY_TO_ACCESS_POINT = "DELIVERY_TO_ACCESS_POINT";
    public $DELIVERY_TO_SHIPPING_ADDRESS = "DELIVERY_TO_SHIPPING_ADDRESS";
    public $DISPLAY_ALL_ACCESS_POINT_IN_RANGE = "DISPLAY_ALL_ACCESS_POINT_IN_RANGE";
    public $FIXED_PRICE = "FIXED_PRICE";
    public $NAME = "NAME";
    public $NUMBER_OF_ACCESS_POINT_AVAIABLE = "NUMBER_OF_ACCESS_POINT_AVAIABLE";
    public $SET_DEFAULT = "SET_DEFAULT";
    public $AP_AS_SHIPTO = "AP_AS_SHIPTO";
    public $ADULT_SIGNATURE = "ADULT_SIGNATURE";
    public $SHOW_TERM_CONDITION = "SHOW_TERM_CONDITION";
    public $TITLE = "TITLE";
    public $UPS_ACCEPT_CASH_ON_DELIVERY = "UPS_ACCEPT_CASH_ON_DELIVERY";
    public $ACCEPT_ACCOUNT_NONE = "ACCEPT_ACCOUNT_NONE";
    public $ACCEPT_ACCOUNT_SUCCESS = "ACCEPT_ACCOUNT_SUCCESS";
    public $PACKAGE_SETTING_OPTION = "PACKAGE_SETTING_OPTION";
    public $ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS = "ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS";
    public $ups_shipping_merchant_key = "ups_shipping_merchant_key";
    public $tmp_ups_open_account_number = "tmp_ups_open_account_number";
    public $ups_flat_cal_discount = "ups_flat_cal_discount";
    /* -----------variable--------- */
    public $account_Activated = "10";
    public $account_Deactivated = "20";
    public $account_Uninstalled = "30";
    public $country_code = "country-code";
    public $agree_term_and_usage = "agree-term-and-usage";
    public $access_license_text = "access_license_text";
    public $AccessLicenseText = "AccessLicenseText";
    public $CountryCode = "CountryCode";
    public $LanguageCode = "LanguageCode";
    public $require_checks = "require_checks";
    public $accepted_term_conditions = "accepted_term_conditions";
    public $finished_configuration = "finished_configuration";
    public $title = "title";
    public $menu_title = "menu_title";
    public $capability = "capability";
    public $page_url = "page_url";
    public $function = "function";
    public $class = "class";
    public $controller = "controller";
    public $none_account = "none_account";
    public $manage_options = "manage_options";
    public $class_path = "\UpsEuWoocommerce\controllers\admin\Ups_Eu_Woo_MerchantCf";
    public $ups_plugin_name = "ups_plugin_name";
    /* -----------Ups Shipping API---------- */
    public $fullAddress = "fullAddress";
    public $selectedService = "selectedService";
    public $satDeli = "SAT_DELI";
    public $billing_address_1 = "billing_address_1";
    public $billing_address_2 = "billing_address_2";
    public $billing_country = "billing_country";
    public $billing_city = "billing_city";
    public $billing_postcode = "billing_postcode";
    public $billing_state = "billing_state";
    public $get_cart_total = "get_cart_total";
    public $get_woocommerce_currency_symbol = "get_woocommerce_currency_symbol";
    public $get_woocommerce_currency = "get_woocommerce_currency";
    public $ups_shipping_text_search = "ups_shipping_text_search";
    public $ups_shipping_select_search_country = "ups_shipping_select_search_country";
    public $MaximumListSize = "MaximumListSize";
    public $ups_eu_woocommerce_key = "ups_eu_woocommerce_key";
    public $check_call = "check_call";
    public $Locale = "Locale";
    public $nearby = "nearby";
    public $ups_shipping_service_link_security_token = 'ups_shipping_service_link_security_token';
    public $ups_shipping_service_link_check = 'ups_shipping_service_link_check';
    public $ups_shipping_pre_registered_plugin_token = 'ups_shipping_pre_registered_plugin_token';
    public $ups_shipping_registered_plugin_token = 'ups_shipping_registered_plugin_token';
    public $ups_shipping_bing_map_key = 'ups_shipping_bing_map_key';
    public $ups_shipping_my_ups_id = 'ups_shipping_my_ups_id';
    public $ups_shipping_check_manage = 'ups_shipping_check_manage';
    public $ups_shipping_transfer_info_already_done = 'ups_shipping_transfer_info_already_done';
    public $ups_shipping_plugin_version = 'ups_shipping_plugin_version';
}
