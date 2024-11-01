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
 * ups-eu-woo-lang-delivery-rate.php - The core plugin class.
 *
 * This is used to load the Delivery Rate's languages.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Delivery_Rate_Language');

class Ups_Eu_Woo_Delivery_Rate_Language extends Ups_Eu_Woo_Common_Language
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
        /* Addition lang */
        $page_lang = [
            "type_ship_AP" => __("Ship to UPS Access Point™", $this->domain),
            "subtext_1" => __("The e-shopper will see the % of real time UPS rates. These rates are calculated using the default package weight and dimensions that you configured in the previous screen (Package Dimensions).<br><br>Please Note :<br>1. UPS real time shipping rates are exclusive of VAT. If you want to display the rates including VAT, please add the VAT % to the shipping rate. E.g. If VAT is 23%, and you want to display rates including VAT, you should insert 123% above.<br>2. The e-shopper may select COD as a payment option within the Woocommerce checkout after the shipping rates are calculated. In this scenario, UPS COD surcharges which will be billed, are not added to the displayed shipping rates automatically. This is due to the order in which Woocommerce displays shipping and payment options.", $this->domain),
            "subtext_1_us" => __("1. Real time shipping rates – the merchant’s delivery rates are displayed to the e-shopper based on the default package dimensions configured in the previous screen.  The delivery rates include base transportation and fuel charges, so merchants may adjust the “% of UPS shipping rates” field to cover their common ad hoc charges.<br /><span class='left-10'>Ad hoc charges can be found in the Daily Rate and Service Guide posted here:<br /></span><span class='left-10'><a href='https://www.ups.com/us/en/shipping/daily-rates.page' target='_blank'>https://www.ups.com/us/en/shipping/daily-rates.page</a></span><br />2. Flat rates – merchants set delivery rates that display to the e-shopper based on their order value.  Orders less than or equal to the specified “order value threshold” will show the delivery rate entered for that threshold.  Any order value above the highest threshold will default to a delivery rate of $0.<br /><span class='left-10'>Example: an “order value threshold” of $50 with a delivery rate of $15 will show a delivery rate of $15 for orders less than or equal to $50 and a delivery rate of $0 for orders over $50.</span>", $this->domain),
            "subtext_2" => __("Please Note : Because COD is a payment option in shopping cart that is selected by e-shopper after selecting UPS service in the website check out, the UPS plug-in cannot automatically add back UPS COD charges in the total shipping fee even if you show UPS shipping rates in the check-out.", $this->domain),
            "type_ship_Add" => __("Ship to Address", $this->domain),
            "type_flat_rate" => __("Flat Rates Calculation", $this->domain),
            "type_flat_rate_txt" => __("Calculate after discount applied", $this->domain),
            "minimum_order_value" => __("Weight/Order Value threshold", $this->domain),
            "country" => __("Country", $this->domain),
            "rule" => __("Rule", $this->domain),
            "delivery_rates" => __("Delivery rates", $this->domain),
            "delivery_date_is" => __("Delivery rates is", $this->domain),
            "of_UPS_shipping_rates" => __("% of UPS shipping rates", $this->domain),
            "save_error" => __("Save error", $this->domain),
            "placeholder_min_order_value" => __("min = 0.01 max = 9999.99", $this->domain),
            "placeholder_delivery_rate" => __("minlength = 0.01 maxlength = 9999.99", $this->domain),
            "placeholder_percentage" => __("min = 1.00max = 100.00", $this->domain),
        ];
        return array_merge($lang_common, $page_lang);
    }
}
