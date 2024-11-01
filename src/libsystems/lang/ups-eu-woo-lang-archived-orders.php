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
 * ups-eu-woo-lang-archived-orders.php - The core plugin class.
 *
 * This is used to load the Archived Orders's languages.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Archived_Orders_Language');

class Ups_Eu_Woo_Archived_Orders_Language extends Ups_Eu_Woo_Common_Language
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
        /* Adition lang */
        $page_lang = [
        ];
        return array_merge($lang_common, $page_lang);
    }
}
