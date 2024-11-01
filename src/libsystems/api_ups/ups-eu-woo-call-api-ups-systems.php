<?php namespace UpsEuWoocommerce\libsystems\api_ups;

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
 * ups-eu-woo-call-api-ups-systems.php - The core plugin class.
 *
 * This is used to handle the actived and deactived current plugin.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Systems_Api_Ups');

class Ups_Eu_Woo_Systems_Api_Ups extends Ups_Eu_Woo_Global_Api_Ups implements Ups_Eu_Woo_Interfaces_Api_Ups
{

    public function __construct()
    {
        parent::__construct();
    }

    public function ups_eu_woo_activated_plugin()
    {
        //update merchant status = 10 in plugin manager
    }

    public function ups_eu_woo_deactivated_plugin()
    {
        //update merchant status = 20 in plugin manager
    }

    public function ups_eu_woo_uninstalled_plugin()
    {
        //update merchant status = 30 in plugin manager
    }
}
