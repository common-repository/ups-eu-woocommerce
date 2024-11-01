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
 * ups-eu-woo-lang-billing-preference.php - The core plugin class.
 *
 * This is used to load the Billing Preference's languages.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Billing_Preference_Language');

class Ups_Eu_Woo_Billing_Preference_Language extends Ups_Eu_Woo_Common_Language
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
        $lang_common = parent::ups_eu_woo_load_lang();
        
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

        /* Addition lang */
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
        $urlSupport = 'https://www.ups.com/gb/en/services/technology-integration/ecommerce-plugins.page';
        $urlLoc     = 'https://wwwapps.ups.com/pickup/schedule?loc=en_GB';
        $urlHere    = 'https://www.ups.com/gb/en/help-center/contact.page';

        if (array_key_exists($languagesCur, $arrLanguages) || in_array($languagesCur, $arrLanguages)) {
            if (strtolower($country_code) == $arrLanguages[$languagesCur] || strtolower($country_code) == $languagesCur) {
                $urlSupport = 'https://www.ups.com/'. strtolower($country_code) .'/'. strtolower($country_code) .'/services/individual-shipper/preparing-to-ship.page';
                $urlLoc     = 'https://wwwapps.ups.com/pickup/schedule?loc='. strtolower($country_code) .'_'. $country_code;
                $urlHere    = 'https://www.ups.com/'. strtolower($country_code) .'/'. strtolower($country_code) .'/help-center/contact.page';
                if (strtolower($country_code) == 'us') {
                    $urlSupport = 'https://www.ups.com/'. strtolower($country_code) .'/en/services/individual-shipper/preparing-to-ship.page';
                    $urlLoc     = 'https://wwwapps.ups.com/pickup/schedule?loc='. strtolower($country_code) .'_en';
                }
            } else {
                $checkBE = explode('-', $languagesCur);
                if (isset($checkBE[1]) && $checkBE[1] == 'BE' && $country_code == 'BE') {
                    $urlSupport = 'https://www.ups.com/BE/'. strtolower($checkBE[0]) .'/services/individual-shipper/preparing-to-ship.page';
                    $urlLoc     = 'https://wwwapps.ups.com/pickup/schedule?loc='. strtolower($checkBE[0]) .'_BE';
                    $urlHere    = 'https://www.ups.com/be/'. strtolower($checkBE[0]) .'/help-center/contact.page';
                } else {
                    $urlSupport = 'https://www.ups.com/'. strtolower($country_code) .'/en/services/individual-shipper/preparing-to-ship.page';
                    $urlLoc     = 'https://wwwapps.ups.com/pickup/schedule?loc=en_'. $country_code;
                    $urlHere    = 'https://www.ups.com/'. strtolower($country_code) .'/en/help-center/contact.page';
                }
            }
        };

        if ($country_code == 'US') {
            $urlSupport = 'https://www.ups.com/us/en/services/individual-shipper/preparing-to-ship.page';
            $urlLoc     = 'https://wwwapps.ups.com/pickup/schedule?loc=en_US';
            $urlHere    = 'https://www.ups.com/us/en/shipping/services/value-added/daily-pickup.page';
        }
        
        $describe4 = sprintf(__("1. How do I get more information about my new UPS shipping account?<br>If you opened a new UPS shipping account from the plug-in, a confirmation email with more information will be sent to the email address that you entered while creating the new account.<br><br>2. How do I prepare my packages for UPS collection or drop off to a UPS Access Point™?<br>Refer to the package preparation recommendations at this link - <a target='_blank' href='%s'>%s</a><br><br>3. How do I give my packages to UPS?<br>You can drop you packages at any authorized UPS location such as a UPS Access Point™. Click below to search for a convenient access point location near you.", $this->domain), $urlSupport, $urlSupport);
        $describe7 = sprintf(__("You can also ask UPS to pickup packages from your warehouse or business address. If you need an occasional pickup, you can directly schedule a pickup from UPS.COM using this link - <a target='_blank' href='%s'>%s</a><br><br> If you have UPS packages on most business days and would prefer a regular UPS pickup, you can contact UPS by calling at the phone number provided under Billing Questions <a target='_blank' href='%s'>here</a>. Then a UPS representative will be in touch with you to discuss a daily UPS pickup.", $this->domain), $urlLoc, $urlLoc, $urlHere);
        $describe14 = sprintf(__("4. What steps do I need to take to set up a UPS Collect on Delivery (COD) service?<br>You can contact UPS by calling at the phone number provided under Billing Questions <a target='_blank' href='%s'>here</a>. Then a UPS representative will be in touch with you to discuss the COD service.", $this->domain), $urlHere);
        
        if ($country_code == 'PL' && $languagesCur != "pl-PL") {
            $describe7  = "You can also ask UPS to pickup packages from your warehouse or business address. If you need an occasional pickup, you can directly schedule a pickup from UPS.COM using this link - <a target=\"_blank\" href=\"https://wwwapps.ups.com/pickup/schedule?loc=pl_EN\">https://wwwapps.ups.com/pickup/schedule?loc=pl_EN</a><br><br>If you have UPS packages on most business days and would prefer a regular UPS pickup, you can email a completed and signed Pickup form to the following email address - konto@ups.com. Then a UPS representative will be in touch with you to discuss a daily UPS pickup.";
            $describe14 = "4. What steps do I need to take to set up a UPS Collect on Delivery (COD) service?<br>You can email a completed and signed COD form to the following email address - konto@ups.com. Then a UPS representative will be in touch with you to discuss the COD service.";
        }

        if ($country_code == 'PL' && $languagesCur == "pl-PL") {
            $describe7  = "Możesz zaplanować odbiór przez kuriera UPS. Jeśli Twoje nadania nie są regularne – skorzystaj z poniższego linku: <a target='_blank' href='". $urlSupport ."'>". $urlSupport ."</a><br><br>Jeśli planujesz wysyłki UPS częściej niż 3 razy w tygodniu, możesz uzgodnić z UPS stałe podjazdy kuriera. W tym celu wyślij na adres konto@ups.com wypełniony i podpisany dokument Stałych Odbiorów. Skontaktuje się z Tobą przedstawiciel UPS aby zakończyć proces ustalania Stałych Odbiorów.";
            $describe14 = "4. Co muszę zrobić aby uruchomić opcję Przesyłki za Pobraniem (COD)?<br>Wyslij na adres konto@ups.com wypełniony i podpisany dokument Przesyłka za Pobraniem. Skontaktuje się z Tobą przedstawiciel UPS aby zakończyć proces udostępnienia usługi  Przesyłka za Pobraniem.";
        }
        
        global $wpdb;
                $Usernamefrmdb_sql = "SELECT Username FROM ".$wpdb->prefix."ups_shipping_license";
                $userid = $wpdb->get_results($Usernamefrmdb_sql);
                $username ="";
                if(!empty($userid))
                {
                    foreach($userid as $usrid){
                     $username .= isset($usrid -> Username) ? $usrid -> Username.', ' : '';
                
                    }
                }
               
        $page_lang = [
            "describe1" => __("You can start shipping now!", $this->domain),
            "describe2" => __("Click on the \"Complete Configuration\" button to finish the configuration of the plug-in and start offering UPS shipping services on your website.<br>", $this->domain),
            "describe3" => __("If you are new to UPS, please refer to the following FAQs for additional information -", $this->domain),
            "describe4" => $describe4,
            "describe5" => __("Search Access Point™", $this->domain),
            "describe6" => __("REGULAR PICKUP AND COD REGISTRATION", $this->domain),
            "describe7" => $describe7,
            "describe7a" => __("Download COD and Pickup Registration form", $this->domain),
            "describe8" => __("SCHEDULE A PICKUP", $this->domain),
            "describe9" => __("If you do not ship on a daily base, please go to ups.com to schedule a pick-up.", $this->domain),
            "describe10" => __("MANAGE MY PAYMENT OPTIONS", $this->domain),
            "describe11" => __("If you want to change your payment methods or enroll for other billing tools, please go to ups.com.", $this->domain),
            "describe12" => __("Local tax(es) is included in the shipping fee", $this->domain),
            "describe13" => __("REGISTER FOR PREMIUM SERVICE BY UPS", $this->domain),
            "describe14" => $describe14,
            "describe15" => __("How to activate account based or negotiated rates with UPS?", $this->domain),
            "describe16" => __("To activate account based or negotiated rates with UPS you have to activate them seperately for this plugin. You can do that by following one of the following options: <br><br> 1. Please get in contact with your UPS Account Manager and request to activate the negotiated rates for following User ID : [ " .rtrim($username, ', '). " ]<br>",$this->domain),
            "describe17" => __("2. Please send to upsplugins@ecommerce.help an email requesting to activate your negotiated rates for User ID [ " .rtrim($username, ', '). " ]. We will contact UPS on your behalf.", $this-> domain),
            "checkShowButton" => $country_code
        ];
// echo "<pre>";print_r($this->domain);die();
        return array_merge($lang_common, $page_lang);
    }
}
