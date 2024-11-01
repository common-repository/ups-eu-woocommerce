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
 * ups-eu-woo-lang-cod.php - The core plugin class.
 *
 * This is used to load the Cash on Delivery's languages.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Cod_Language');

class Ups_Eu_Woo_Cod_Language extends Ups_Eu_Woo_Common_Language
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
            "option" => __("COD option", $this->domain),
            "On" => __("On", $this->domain),
            "des1_installed" => __("You have the official WooCommerce COD module enabled!", $this->domain),
            "des1_installed_1" => __("The COD Shipping service of this plug-in is automatically compatible with the official Collect on Delivery (COD) module by WooCommerce.", $this->domain),
            "des1_not_install_yet" => __("You do not have the official WooCommerce COD module installed and/or enabled!", $this->domain),
            "des1_not_install_yet_2" => __("If you want the UPS Shipping module to automatically detect COD shipments, <b>please make sure that you have installed WooCommerce's Collect on Delivery (COD)</b>. If you already have WooCommerce's Collect on Delivery (COD) module installed, <b>please make sure that the module is enabled</b>. <a target='_blank' href='https://docs.woocommerce.com/document/cash-on-delivery/'>[Click here]</a> for detailed guidance.", $this->domain),
            "des5" => __("Select \"YES\" if you plan to offer COD shipments to a UPS Access Points", $this->domain),
            "des6" => __("Only show Access Points supporting COD shipments?", $this->domain),
        ];
        return array_merge($lang_common, $page_lang);
    }
}
