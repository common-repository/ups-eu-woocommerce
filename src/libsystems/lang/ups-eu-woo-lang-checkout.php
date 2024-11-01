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
 * ups-eu-woo-lang-checkout.php - The core plugin class.
 *
 * This is used to load the Checkout's languages.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Checkout_Language');

class Ups_Eu_Woo_Checkout_Language extends Ups_Eu_Woo_Common_Language
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
        /* load lang common */
        $lang_common = parent::ups_eu_woo_load_lang();
        /* Init lang by page checkout */
        $page_lang = [
            "option1" => __("Deliver to an UPS Access Point™", $this->domain),
            "option1_des" => __("Your package will be delivered to an UPS Access Point™", $this->domain),
            "option2" => __("Deliver to Your Address", $this->domain),
            "option2_des" => __("Your package will be delivered to your address", $this->domain),
            "search_access_point" => __("Search for the Access Point™", $this->domain),
            "search_access_point_des" => __("Please select an UPS Access Point™ to process", $this->domain),
            "Near" => __("Near", $this->domain),
            "use_my_delivery_address" => __("Use my delivery address", $this->domain),
            "Search" => __("Search", $this->domain),
            "placehoder_text_search" => __("Address line, City, State, Postcode", $this->domain),
            "results_search" => __("Results", $this->domain),
            "operating_hours" => __("Operating Hours", $this->domain),
            "Select" => __("Select", $this->domain),
            "Open" => __("Open", $this->domain),
            "Closed" => __("Closed", $this->domain),
            "mes_error_selected" => __("Please select an Access Point to process", $this->domain),
            "mes_adddress_is_required" => __("The address is required", $this->domain),
            "location_search_before" => __("Select your access point using location search before proceeding", $this->domain),
        ];
        return array_merge($lang_common, $page_lang);
    }
}
