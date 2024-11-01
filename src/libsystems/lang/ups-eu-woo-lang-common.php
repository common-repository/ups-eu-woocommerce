<?php namespace UpsEuWoocommerce\libsystems\lang;

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
 * ups-eu-woo-lang-common.php - The core plugin class.
 *
 * This is used to load the Common's languages.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Common_Language');

class Ups_Eu_Woo_Common_Language extends \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Language_Entity implements Ups_Eu_Woo_Interfaces_Language
{

    protected $list_lang;
    protected $domain;

    public function __construct($domain)
    {
        $this->domain = $domain;
    }
    /*
     * Name function: ups_eu_woo_load_lang
     * Params: empty
     * Return: type array
     * * */

    public function ups_eu_woo_load_lang()
    {
        // Init variable for shipping service
        $service_lang = [
            '2ND_DAY_AIR' => __("UPS 2nd Day Air®", $this->domain),
            '2ND_DAY_AIR_AM' => __("UPS 2nd Day Air A.M.®", $this->domain),
            '3_DAY_SELECT' => __("UPS 3 Day Select®", $this->domain),
            'GROUND' => __("UPS® Ground", $this->domain),
            'AP_ECONOMY' => __("UPS Access Point Economy", $this->domain),
            // Next day
            'NEXT_DAY_AIR' => __("UPS Next Day Air®", $this->domain),
            'NEXT_DAY_AIR_EARLY' => __("UPS Next Day Air® Early", $this->domain),
            'NEXT_DAY_AIR_SAVER' => __("UPS Next Day Air Saver®", $this->domain),
            // Standard
            'STANDARD' => __("UPS® Standard", $this->domain),
            'STANDARD_SAT_DELI' => __("UPS® Standard - Saturday Delivery", $this->domain),
            // Express
            'EXPRESS' => __("UPS Express®", $this->domain),
            'EXPRESS_PLUS' => __("UPS Express Plus®", $this->domain),
            'EXPRESS_SAVER' => __("UPS Express Saver®", $this->domain),
            'EXPRESS_12H' => __("UPS Express 12:00", $this->domain),
            'EXPRESS_SAT_DELI' => __("UPS Express® - Saturday Delivery", $this->domain),
            // Express for GB customer
            'WW_EXPRESS_PLUS' => __("UPS Express Plus®", $this->domain),
            'WW_SAVER' => __("UPS Express Saver®", $this->domain),
            // Express worldwide for US customer
            'EXPRESS_WORLDWIDE_EXPRESS' => __("UPS Worldwide Express®", $this->domain),
            'EXPRESS_WORLDWIDE_EXPRESS_PLUS' => __("UPS Worldwide Express Plus®", $this->domain),
            'EXPRESS_WORLDWIDE_SAVER' => __("UPS Worldwide Saver®", $this->domain),
            // Expedited
            'EXPEDITED' => __("UPS Expedited®", $this->domain),
            'EXPRESS_WORLDWIDE_EXPEDITED' => __("UPS Worldwide Expedited®", $this->domain),
        ];

        /* Init lang common in all system */
        $model_config   = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        /* Get contry_code */
        $model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE);
        /* set country_code value */

        /* get list states */
        $countries_obj = new \WC_Countries();
        $list_state    = [];
        $country_code = $model_config->value;

        if (! empty($model_config->value) && $country_code == 'US') {
            $list_state   = $countries_obj->get_states($country_code);
            if ($list_state == null) {
                $list_state = [];
            }
        } else {
            if (empty($model_config->value)) {
                $country_code = "GB";
            }
        }

        $languagesCur = get_bloginfo("language");

        $arrLanguages = [
            'pl-PL' => 'pl',
            'en-GB' => 'gb',
            'en-US' => 'us',
            'de-DE' => 'de',
            'en-ES' => 'es',
            'es'    => 'es',
            'fr-FR' => 'fr',
            'it-IT' => 'it',
            'nl-NL' => 'nl',
            'nl'    => 'nl',
            'en-BE' => 'gb',
            'fr-BE' => 'fr',
            'nl-BE' => 'nl',
            'en-AT' => 'at',
            'en-BG' => 'bg',
            'en-HR' => 'hr',
            'en-CY' => 'cy',
            'en-CZ' => 'cz',
            'en-DK' => 'dk',
            'en-EE' => 'ee',
            'en-FI' => 'fi',
            'en-GR' => 'gr',
            'en-HU' => 'hu',
            'en-IE' => 'ie',
            'en-PT' => 'pt',
            'en-LV' => 'lv',
            'en-LT' => 'lt',
            'en-LU' => 'lu',
            'en-MT' => 'mt',
            'en-RO' => 'ro',
            'en-SK' => 'sk',
            'en-SI' => 'si',
            'en-SE' => 'se',
            'en-NO' => 'no',
            'en-RS' => 'rs',
            'en-CH' => 'ch',
            'en-IS' => 'is',
            'en-JE' => 'je',
            'en-TR' => 'tr',
        ];
        // url default;
        $urlSupport = 'https://www.ups.com/gb/en/business-solutions/expand-your-online-business/ecommerce-plug-ins.page';

        if (array_key_exists($languagesCur, $arrLanguages) || in_array($languagesCur, $arrLanguages)) {
            if (strtolower($country_code) == $arrLanguages[$languagesCur] || strtolower($country_code) == $languagesCur) {
                $urlSupport = 'https://www.ups.com/'. strtolower($country_code) .'/'. strtolower($country_code) .'/business-solutions/expand-your-online-business/ecommerce-plug-ins.page';
            } else {
                $urlSupport = 'https://www.ups.com/'. strtolower($country_code) .'/en/business-solutions/expand-your-online-business/ecommerce-plug-ins.page';
            }

            $checkBE = explode('-', $languagesCur);
            if (isset($checkBE[1]) && $checkBE[1] == 'BE') {
                $urlSupport = 'https://www.ups.com/be/'. strtolower($checkBE[0]) .'/business-solutions/expand-your-online-business/ecommerce-plug-ins.page';
            }

            if ($country_code == 'US') {
                $urlSupport = 'https://www.ups.com/plugins';
            }

        };

        $info_more_account = sprintf(__("For more information on UPS Plugins please click <a target='_blank' href='%s'>this link</a> (opens in a new browser window)", $this->domain), $urlSupport);

        $this->list_lang = [
            'Collect on Delivery (COD)' => __("Collect on Delivery (COD)", $this->domain),
            "UpsShippingModule" => __("UPS Shipping Module", $this->domain),
            "To AP" => __("To AP", $this->domain),
            "To Address" => __("To Address", $this->domain),
            "sc_block1" => __("Account", $this->domain),
            "sc_block2" => __("Shipping Services", $this->domain),
            "sc_block3" => __("Cash on Delivery (COD)", $this->domain),
            "sc_block4" => __("Accessorial Services", $this->domain),
            "sc_block5" => __("Default package setting", $this->domain),
            "sc_block6" => __("Checkout Shipping Rates", $this->domain),
            "sc_block7" => __("Complete Configuration", $this->domain),
            "btn_ok" => __("Ok", $this->domain),
            "btn_close" => __("Close", $this->domain),
            "btn_cancel" => __("Cancel", $this->domain),
            "btn_edit" => __("Edit", $this->domain),
            "btn_delete" => __("Delete", $this->domain),
            "btn_save" => __("Save", $this->domain),
            "btn_next" => __("Next", $this->domain),
            "btn_continue" => __("Continue", $this->domain),
            "btn_print" => __("Print", $this->domain),
            "Weight" => __("Weight", $this->domain),
            "Unit" => __("Unit", $this->domain),
            "Dimension" => __("Dimension", $this->domain),
            "Unit" => __("Unit", $this->domain),
            "Length" => __("Length", $this->domain),
            "Item" => __("Item", $this->domain),
            "Width" => __("Width", $this->domain),
            "Height" => __("Height", $this->domain),
            "min_001_max_999999" => __("min = 0.01 max = 9999.99", $this->domain),
            "minlength_1_maxlength_50" => __("minlength = 1 maxlength = 50", $this->domain),
            "save_success" => __("Data saved successfull", $this->domain),
            "PrintForm" => __("Print form", $this->domain),
            "validate_error" => __("Some of the data you entered is not valid. Please check again.", $this->domain),
            "Yes" => __("Yes", $this->domain),
            "No" => __("No", $this->domain),
            "The Account Number existed" => __("Account number already exists in 'Your Payment Account'", $this->domain),
            "UPS_ACSRL_ADDITIONAL_HADING" => __("Additional Handling", $this->domain),
            "UPS_ACSRL_QV_SHIP_NOTIF" => __("Quantum View Ship Notification", $this->domain),
            "UPS_ACSRL_QV_DLV_NOTIF" => __("Quantum View Delivery Notification", $this->domain),
            "UPS_ACSRL_RESIDENTIAL_ADDRESS" => __("Residential Address", $this->domain),
            "UPS_ACSRL_STATURDAY_DELIVERY" => __("Saturday Delivery", $this->domain),
            "UPS_ACSRL_CARBON_NEUTRAL" => __("Carbon Neutral", $this->domain),
            "UPS_ACSRL_DIRECT_DELIVERY_ONLY" => __("Direct Delivery Only", $this->domain),
            "UPS_ACSRL_DECLARED_VALUE" => __("Declared value", $this->domain),
            "UPS_ACSRL_SIGNATURE_REQUIRED" => __("Signature Required", $this->domain),
            "UPS_ACSRL_ADULT_SIG_REQUIRED" => __("Adult Signature Required", $this->domain),
            "UPS_ACSRL_ACCESS_POINT_COD" => __("To Access Point COD", $this->domain),
            "UPS_ACSRL_TO_HOME_COD" => __("To Home COD", $this->domain),
            "Billing Preference" => __("Billing Preference", $this->domain),
            "We could not find any records" => __("We couldn't find any records", $this->domain),
            "COD" => __("COD", $this->domain),
            "Delivery Address" => __("Delivery Address", $this->domain),
            "Order ID" => __("Order ID", $this->domain),
            "Un-Archived Orders" => __("Un-Archived Orders", $this->domain),
            "Un-Archiving Orders" => __("Un-Archiving Orders", $this->domain),
            "Warning" => __("Warning", $this->domain),
            "titleAccessUnArchiving" => __("Warning! Un-Archiving orders will move your orders to Open Orders tab. Click 'OK' to continue, 'Cancel' to go back to the screen.", $this->domain),
            "Country/Territory" => __("Country/Territory", $this->domain),
            "email" => __("Email", $this->domain),
            "phone_number" => __("Phone number", $this->domain),
            "address" => __("Address", $this->domain),
            "postal_code" => __("Postal code", $this->domain),
            "account_name" => __("Account name", $this->domain),
            "account_number" => __("Account number", $this->domain),
            "currency" => __("Currency", $this->domain),
            "open_order" => __("Open Orders", $this->domain),
            "shipments" => __("Shipments", $this->domain),
            "archived_orders" => __("Archived Orders", $this->domain),
            "order_date" => __("Order Date", $this->domain),
            "order_time" => __("Order Time", $this->domain),
            "product" => __("Product", $this->domain),
            "shipping_service" => __("Shipping Service", $this->domain),
            'Customer Address line 1' => __("Customer Address line 1", $this->domain),
            'Customer Address line 2' => __("Customer Address line 2", $this->domain),
            'Customer Address line 3' => __("Customer Address line 3", $this->domain),
            'Customer PostalCode' => __("Customer PostalCode", $this->domain),
            'Customer City' => __("Customer City", $this->domain),
            'Customer StateOrProvince' => __("Customer StateOrProvince", $this->domain),
            'Customer Country' => __("Customer Country", $this->domain),
            'Customer Email' => __("Customer Email", $this->domain),
            'AlternateDeliveryAddressIndicator' => __("AlternateDeliveryAddressIndicator", $this->domain),
            'UPSAccessPointID' => __("UPSAccessPointID", $this->domain),
            'Access Point Address line 1' => __("Access Point Address line 1", $this->domain),
            'Access Point Address line 2' => __("Access Point Address line 2", $this->domain),
            'Access Point Address line 3' => __("Access Point Address line 3", $this->domain),
            'Access Point City' => __("Access Point City", $this->domain),
            'Access Point StateOrProvince' => __("Access Point StateOrProvince", $this->domain),
            'Access Point PostalCode' => __("Access Point PostalCode", $this->domain),
            'Access Point Country' => __("Access Point Country", $this->domain),
            'Shipping service' => __("Shipping service", $this->domain),
            'infor_more_account_note' => __("NOTE: If you have an existing UPS account number, please use the exact registered pickup address (which might be different from your invoice billing address) associated with this account number. Please note that the format of the postal code or zip code should exactly match the one provided in the registered pickup address.", $this->domain),
            'pickup_address' => __("Pickup Address", $this->domain),
            'tooltip_pickup_address' => __("Use registered pickup address. If you have any difficulties understanding which address to use, please contact your local UPS sales representative or call the support phone number provided on the “About” page", $this->domain),
            'pickup_postal_code' => __("Pickup Postal Code", $this->domain),
            'tooltip_pickup_postal_code' => __("The format of the postal code should exactly match the one provided in the registered pickup address. If you have any difficulties understanding which address to use, please contact your local UPS sales representative or call the support phone number provided on the “About” page", $this->domain),
            'infor_more_account' => $info_more_account,
            'error_api_try_again' => __("There are errors connecting to the UPS API servers. Please try again.", $this->domain),
            'list_state' => $list_state,
            'State' => __("State", $this->domain),
            "countryCode" => $country_code,
            "ups_account_vatnumber_notes" => __("Business to business shipments from the US to Europe require VAT number. If you do not have a VAT number at this time, you can add to your account at a later date on UPS.com.", $this->domain),
            "Additional Handling note" => "Applicable for packages exceeding 70 pounds, 48 inches on the longest side or 30 inches on the second longest side. Also applies for any article not fully encased in corrugated cardboard packaging",
            "Residential Address note" => "Applicable for delivery to a location that is a home, including a business that is operating out of a home",
            "To Home COD note"         => "Upon selection by the consumer, UPS will collect the amount shown on C.O.D. tag or package label, then send payment to you. Applicable only for packages shipped throughout the U.S. and Puerto Rico",
            "control id"               => "Countrol ID"
        ];
        // Set lang for shipping service
        $model_service = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Services();
        $list_services_type = $model_service->ups_eu_woo_get_sorted_services($country_code);
        foreach ($list_services_type as $service_type => $list_service_key) {
            foreach ($list_service_key as $service_key) {
                $search_key = sprintf('UPS_SP_SERV_%s_%s_', $country_code, $service_type);
                $service_key_lang = str_replace($search_key, '', $service_key);
                $this->list_lang[$service_key] = isset($service_lang[$service_key_lang]) ? $service_lang[$service_key_lang] : '';
            }
        }
        return $this->list_lang;
    }
}
