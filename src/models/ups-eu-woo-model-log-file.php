<?php namespace UpsEuWoocommerce\models;

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
 * ups-eu-woo-model-log-file.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Model_Log_File Model.
 */

class Ups_Eu_Woo_Model_Log_File
{
    private static $file_log = ABSPATH . 'tmp/ups-eu-woocommerce_log_dev.txt';

    /*
     * Name function: log
     * Params:
     *  @string_sql: type string
     *  @ex: type exceptions of mysql
     * Return: void
     * * */

    public static function ups_eu_woo_log($string_sql, $ex)
    {
        $date_current = date("Y-m-d h:i:sa");
        try {
            file_put_contents(
                self::$file_log,
                "\n{$date_current}:::::{$string_sql}:::" . $ex->getMessage(),
                FILE_APPEND
            );
            return;
        } catch (Exception $ex) {
            return;
        }
    }
}
