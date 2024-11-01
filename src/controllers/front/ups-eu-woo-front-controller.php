<?php

namespace UpsEuWoocommerce\controllers\front;

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
 * ups-eu-woo-front-controller.php - The core plugin class.
 *
 * The public-facing functionality of the plugin.
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Front_Controller');

class Ups_Eu_Woo_Front_Controller
{
    private $plugin_name;
    private $version;

    /* constructor */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    /* load style info */
    public function ups_eu_woo_enqueue_styles()
    {
    }
    /* load script info */
    public function ups_eu_woo_enqueue_scripts()
    {
    }
    /* render shopper shipping service */
    public function e_shopper_shipping_services()
    {
        $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
        return $smarty->fetch("front/e_shopper_shipping_services.tpl");
    }
}
