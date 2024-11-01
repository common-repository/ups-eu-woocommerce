<?php namespace UpsEuWoocommerce\utils;

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
 * ups-eu-woo-utils-language.php - The core plugin class.
 *
 * This is used to load to each page's languages.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Utils_Language');

class Ups_Eu_Woo_Utils_Language
{

    public static $domain;

    public static function ups_eu_woo_get_lang_by_key($key_page)
    {
        /* load entity language */
        $entity_language = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Language_Entity();
        /*  switch by key page so load page */
        switch ($key_page) {
            /* this case common */
            case $entity_language->lang_common:
                /* load class lang command */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_Common_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            /* this case page country */
            case $entity_language->lang_page_country:
                /* load class lang country */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_Country_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            /* this case page terms conditions */
            case $entity_language->lang_page_terms_conditions:
                /* load class lang terms conditions */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_Terms_Conditions_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            /* this case page none account */
            case $entity_language->lang_page_none_account:
                /* load class lang none account */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_None_Account_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            /* this case page account */
            case $entity_language->lang_page_account:
                /* load class lang account */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_Account_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            /* this case page shipping seriice */
            case $entity_language->lang_page_shipping_service:
                /* load class lang shipping service */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_Shipping_Service_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            /* this case page cod */
            case $entity_language->lang_page_cod:
                /* load class lang cod */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_Cod_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            /* this case page accessorial serice */
            case $entity_language->lang_page_accessorial_services:
                /* load class lang accessorial service */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_Accessorial_Services_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            /* this case page package dimension */
            case $entity_language->lang_page_package_dimension:
                /* load class lang package dimension */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_Package_Dimension_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            /* this case page delivery rate */
            case $entity_language->lang_page_delivery_rate:
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_Delivery_Rate_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            /* this case page billing prefercence */
            case $entity_language->lang_page_billing_preference:
                /* load class lang billing prefercence */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_Billing_Preference_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            /* this case page orders */
            case $entity_language->lang_page_orders:
                /* load class lang orders */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_Orders_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            /* this case page open orders */
            case $entity_language->lang_page_open_orders:
                /* load class lang open orders */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_Open_Orders_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            /* this case page shippments */
            case $entity_language->lang_page_shipments:
                /* load class lang shipmments */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_Shipments_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            /* this case page archived orders */
            case $entity_language->lang_page_archived_orders:
                /* load class lang archived orders */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_Archived_Orders_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            /* this case page check out */
            case $entity_language->lang_page_checkout:
                /* load class lang check out */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_Checkout_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            case $entity_language->lang_page_about_logs_api:
                /* load class lang about log api */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_About_Logs_Api_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
            /* this case page default apply  key_page dont existing */
            default:
                /* load class lang commond */
                $lang_class = new \UpsEuWoocommerce\libsystems\lang\Ups_Eu_Woo_Common_Language(self::$domain);
                return $lang_class->ups_eu_woo_load_lang();
        }
    }
}
