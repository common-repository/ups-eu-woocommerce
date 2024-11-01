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
 * ups-eu-woo-utils-upgrade-version.php - The core plugin class.
 *
 * This is used to handle the Ups_Eu_Woo_Utils_Upgrade_Version.
 */

class Ups_Eu_Woo_Utils_Upgrade_Version
{

    function ups_eu_woo_transient_update_plugins($transient)
    {
        $update_data = $this->ups_eu_woo_get_update_data();
        return $transient;
    }

    function ups_eu_woo_upgrader_process_complete()
    {
    }

    function ups_eu_woo_get_update_data()
    {
    }
}
