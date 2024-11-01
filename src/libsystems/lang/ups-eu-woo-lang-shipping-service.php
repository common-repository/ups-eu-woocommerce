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
 * ups-eu-woo-lang-shipping-service.php - The core plugin class.
 *
 * This is used to load the Shipping Service's languages.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Shipping_Service_Language');

class Ups_Eu_Woo_Shipping_Service_Language extends Ups_Eu_Woo_Common_Language
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
        /* Additions lang */
        $page_lang = [
            "section1" => __("Deliver to UPS Access Point™ (to-AP delivery)", $this->domain),
            "section1_des" => __("UPS delivers the parcel to a UPS Access Point™ that the customer selected, then customer picks up their order there", $this->domain),
            "section1_options" => __("Set as default shipping option", $this->domain),
            "ap_as_shipto" => __("Set Access Point address as Ship to address", $this->domain),
            "section1_adult_signature" => __("Do any of your orders require Adult Signatures?:", $this->domain),
            "section1_select" => __("Select the shipping services for your customers to choose", $this->domain),
            "UPS_Expedited_Des" => __("International shipping only - visible when shipping address is outside of EU", $this->domain),
            "section1_select2" => __("Access Point display setting", $this->domain),
            "section1_select2_numberAP" => __("Number of Access Points visible to customers", $this->domain),
            "section1_select2_range" => __("Display all the Access Points in range of", $this->domain),
            "section1_select2_range_des" => __("kilometer around consignee's selected address", $this->domain),
            "section1_select2_account" => __("Choose Account Number for this option", $this->domain),
            "section2" => __("Deliver to consignee address (to-address delivery)", $this->domain),
            "section2_des" => __("UPS delivers the parcel to the shipping address provided by customer.", $this->domain),
            "section2_select" => __("Select the shipping services for your customers to choose", $this->domain),
            "section2_choose" => __("Choose Account Number for this option", $this->domain),
            "section2_cutofftime" => __("Cut off time", $this->domain),
            "section2_muted_1" => __("The cut off time selected here will be used in calculating the schedule delivery date and time, which will be displayed on your website checkout.", $this->domain),
            "section2_muted_2" => __("For example, if the cut off time is selected as 5 PM and your e-shoppers views your webstore at 5.01 PM, all UPS scheduled delivery dates and time will be calculated from the following business day. When deciding this cut off time, please ensure that you have sufficient time to fulfill the order before the UPS scheduled pick up or you are able to drop off the packages at a UPS Access Point™.", $this->domain),
            "section2_muted_3" => __("If you are unsure about fulfilling customer orders on the same day, you can select \"Disable\" which will result in the e-shopper seeing a generic delivery schedule for each available UPS service. For Example; \"UPS® Standard - In most cases, delivered within 1 to 3 business days in Europe.\"", $this->domain),
            "section2_muted_1_us" => __("Order checkouts before this time will display delivery dates based on same day fulfillment. Order checkouts after this time will display delivery dates based on next day fulfillment.", $this->domain),
            "section2_muted_2_us" => __("Selecting “Disable” will result in approximate delivery dates being displayed without fulfillment considerations.", $this->domain),
            "default_account" => __("Default account", $this->domain),
            "account" => __("Account", $this->domain),
            "description" => __("Select the UPS services you want to be visible in the checkout for your e-shoppers. To learn more about UPS services, refer UPS Tariff/Terms and Conditions of Service on UPS.COM", $this->domain),
            "UPS_Expedited_Des_US" => __("International shipping only – visible when delivery address is outside the U.S.", $this->domain),
            "packing_type" => __("Packing Type", $this->domain),
        ];
        return array_merge($lang_common, $page_lang);
    }
}
