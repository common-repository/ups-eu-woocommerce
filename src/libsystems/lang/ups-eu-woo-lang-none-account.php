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
 * ups-eu-woo-lang-none-account.php - The core plugin class.
 *
 * This is used to load the NoneAccount's languages.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_None_Account_Language');

class Ups_Eu_Woo_None_Account_Language extends Ups_Eu_Woo_Common_Language
{

    protected $list_lang;

    /*
     * Name function: __construct
     * Params:
     *  @domain: type string
     * Return: type void
     * * */

    public function __construct($domain)
    {
        parent::__construct($domain);
    }
    /*
     * Name function: ups_eu_woo_load_lang
     * Params: empty
     * Return: type array
     * * */

    public function ups_eu_woo_load_lang()
    {
        /* Get load lang common */
        $lang_common  = parent::ups_eu_woo_load_lang();

        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        /* Get contry_code */
        $model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE);
        /* set country_code value */
        if (! empty($model_config->value)) {
            $country_code = $model_config->value;
        } else {
            $country_code = "GB";
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
        $urlSupport = 'https://www.ups.com/gb/en/services/help-center/packaging-and-supplies/special-care-shipments/global-dangerous-goods.page';
        
        if (array_key_exists($languagesCur, $arrLanguages) || in_array($languagesCur, $arrLanguages)) {
            if (strtolower($country_code) == $arrLanguages[$languagesCur] || strtolower($country_code) == $languagesCur) {
                $urlSupport = 'https://www.ups.com/'. strtolower($country_code) .'/'. strtolower($country_code) .'/help-center/packaging-and-supplies/special-care-shipments/global-dangerous-goods.page';
            } else {
                $urlSupport = 'https://www.ups.com/'. strtolower($country_code) .'/en/help-center/packaging-and-supplies/special-care-shipments/global-dangerous-goods.page';
            }
            if ($country_code == 'US') {
                $urlSupport = 'https://www.ups.com/us/en/help-center/packaging-and-supplies/special-care-shipments/global-dangerous-goods.page';
            }
        };
        

        /* Addition lang */
        $page_lang = [
            "form_title1" => __("Please choose one of the account linking options below and fill the necessary form fields to get started.", $this->domain),
            "title" => __("Title", $this->domain),
            "full_name" => __("Full name", $this->domain),
            "mr" => __("Mr", $this->domain),
            "miss" => __("Miss", $this->domain),
            "mrs" => __("Mrs", $this->domain),
            "ms" => __("Ms", $this->domain),
            "company" => __("Company", $this->domain),
            "address_type" => __("Address type", $this->domain),
            "address_type_placeholder" => __("Example: Warehouse, Branch #1", $this->domain),
            "address_placeholder1" => __("Street Address", $this->domain),
            "address_placeholder2" => __("Apartment, Suite, Unit, Building, Floor, etc.", $this->domain),
            "address_placeholder3" => __("Department, c/o, etc.", $this->domain),
            "city" => __("City", $this->domain),
            "have_ups_acc_with_invoice" => __("I have a UPS Account Number WITH an invoice occurred in the last 45 days", $this->domain),
            "have_ups_acc_with_invoice_title" => __("The invoice should be 1 of the last 3 issued by UPS in last 45 days", $this->domain),
            "invoice_number" => __("Invoice number", $this->domain),
            "invoice_amount" => __("Invoice amount", $this->domain),
            "invoice_date" => __("Invoice date", $this->domain),
            "have_ups_acc_without_invoice" => __("I have a UPS Account Number WITHOUT an invoice occurred in the last 45 days", $this->domain),
            "have_ups_acc_with_accpass" => __("I already have a UPS account with Username, Password and Account number", $this->domain),
            "account_password" => __("Password", $this->domain),
            "account_username" => __("Username", $this->domain),
            "account_access" => __("Access Key", $this->domain),
            "tooltip_account_access" => __("UPS Access Licence Number associated with your account.", $this->domain),
            "tooltip_account_username" => __("UPS login username", $this->domain),
            "tooltip_account_password" => __("UPS login password", $this->domain),
            "not_have_ups_acc" => __("I do not have a UPS Account Number and would like to get one from the plug-in", $this->domain),
            "ups_account_vatnumber" => __("VAT number", $this->domain),
            "ups_account_promocode" => __("Promo Code", $this->domain),
            "get_started" => __("Get started", $this->domain),
            "tooltip_address_type" => __("Reference name that will be associate with an account. For example warehouse 1, warehouse 2,  Store 1, Store 2 etc. You can freely chose the name as per your requirement.", $this->domain),
            "tooltip_postal_code" => __("The postal code or zip code associated with your UPS account. It can be found on the top on each page of your UPS invoice under 'Purchaser'", $this->domain),
            "tooltip_account_name" => __("UPS Account Name", $this->domain),
            "tooltip_account_number" => __("UPS Account Number", $this->domain),
            "tooltip_invoice_number" => __("A unique 12 digit number assigned by UPS to an invoice. It can be found on the top left side on each page of your UPS invoice", $this->domain),
            "tooltip_invoice_amount" => __("Total Amount Due for the given invoice. It can be found on the 'Summary of Charges' table on the first page on the invoice", $this->domain),
            "tooltip_invoice_date" => __("Date of issuing the invoice. It can be found on the top left side on each page of your UPS invoice", $this->domain),
            "des_footer_access_key" => __("Please note: Visit the UPS Developer Kit page by following this link for getting your Access Key. You can find a detailed step-by-step guide on how to get your access key in this link."),
            "des_footer_access_link" => __("https://www.ups.com/dpui/upsdeveloperkit"),
            "des_footer1" => __("Please Note : Shippers are prohibited from shipping dangerous goods or hazardous materials using the account opened in this application.", $this->domain),
            "des_footer2" => __("Your account will support deliveries to authorized UPS Access Point locations after 24 hours.", $this->domain),
            "des_footer3" => __("You can find more information on dangerous goods and how UPS can support you shipping them on this link", $this->domain),
            "des_footer4_link" => $urlSupport,
        ];

        /** handling key US */
        if ($country_code == 'US') {
            $page_lang['not_have_ups_acc'] = __("I don’t have a UPS account number and would like to get one with discounted rates from the plug-in", $this->domain);
        }

        return array_merge($lang_common, $page_lang);
    }
}
