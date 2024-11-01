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
 * ups-eu-woo-utils-activator.php - The core plugin class.
 *
 * This is used to active the current plugin.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Utils_Activator');

class Ups_Eu_Woo_Utils_Activator
{
    public static function ups_eu_woo_activate()
    {
        $ResourceSystems = new Ups_Eu_Woo_Utils_Resource_Systems();
        $ResourceSystems->ups_eu_woo_sys_activate();
    }

    public static function ups_eu_woo_init()
    {
        $upgradePluginFlg = false;
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $ResourceSystems = new Ups_Eu_Woo_Utils_Resource_Systems();
        $currentVersion = \UpsEuWoocommerce\Ups_Eu_Woo_Main::$version;
        if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_plugin_version) !== true) {
            $upgradePluginFlg = true;
            $ResourceSystems->ups_eu_woo_sys_upgrade_version();
        } else {
            $installedVersion = $model_config->value;
            if (version_compare($installedVersion, $currentVersion) != 0) {
                $upgradePluginFlg = true;
            }
        }
        // Upgrade plugin version
        if ($upgradePluginFlg === true) {
            // Upgrade version processing
            $model_config->ups_eu_woo_set_value_config_by_key(
                $model_config->ups_shipping_plugin_version,
                $currentVersion
            );
            // Check plugin is activate
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
            $ups_plugin_main_file_path = basename(plugin_dir_path(dirname(__FILE__, 2))) . '/ups-eu-woocommerce.php';
            if (is_plugin_active($ups_plugin_main_file_path)) {
                $ResourceSystems->ups_eu_woo_sys_activate();
            }
        }
    }
}
