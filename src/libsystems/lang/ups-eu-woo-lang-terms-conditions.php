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
 * ups-eu-woo-lang-terms-conditions.php - The core plugin class.
 *
 * This is used to load the Terms and Conditions's languages.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Terms_Conditions_Language');

class Ups_Eu_Woo_Terms_Conditions_Language extends Ups_Eu_Woo_Common_Language
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

        $agree_term_condition = __("I agree to the UPS Technology Agreement and confirm that I've been given enough time to read it and understand that it contains important terms about my use of UPS Technologies, like limiting UPS's liability and my agreement on how disputes between UPS and me will be handled.", $this->domain);
        if ($country_code == 'PL' && $languagesCur != "pl-PL") {
            $agree_term_condition = "I confirm that I have been given enough time to read and understand the UPS Technology Agreement (“UTA”) above and the Data Service Terms <a href='https://www.ups.com/assets/resources/media/ups-license-and-data-service-terms.pdf' target='_blank'>[Click here to view terms]</a> (“Data Terms”) for UPS Shipping and UPS Access Point™ : Official Plug-In (“Module”). I hereby agree the UTA contains important terms about my use of UPS Technology (as defined therein) and the Data Terms contain important terms about my use of and exchange of information with UPS through the Module, in each case including terms such as limiting UPS’s liability and my agreement on how disputes between UPS and me will be handled.";
        }
        if ($languagesCur == "pl-PL" && $country_code != 'PL') {
            $agree_term_condition = "Akceptuję Umowę dotyczącą technologii UPS i potwierdzam, że dano mi wystarczająco dużo czasu na jej przeczytanie i zrozumienie, iż zawiera ona ważne postanowienia dotyczące mojego korzystania z Technologii UPS, takie jak ograniczenia odpowiedzialności UPS i moją zgodę na sposób rozwiązywania sporów między firmą UPS a mną.";
        }
        /* Get load lang common */
        $page_lang = [
            "UPSTermsAndConditions" => __("UPS Terms and Conditions", $this->domain),
            "agree_term_condition" => $agree_term_condition,
        ];
        return array_merge($lang_common, $page_lang);
    }
}
