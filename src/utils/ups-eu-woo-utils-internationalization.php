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
 * ups-eu-woo-utils-internationalization.php - The core plugin class.
 *
 * This is used to define the language domain.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Utils_Internationalization');

class Ups_Eu_Woo_Utils_Internationalization
{

    /**
     * The domain specified for this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $domain    The domain identifier for this plugin.
     */
    private $domain;

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function ups_eu_woo_load_plugin_textdomain()
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        /* Get contry_code */
        $model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE);

        /* set country_code value */
        if (! empty($model_config->value)) {
            $country_code = $model_config->value;
        } else {
            $country_code = "GB";
        }

        $languagesCur = get_bloginfo("language");
        $check        = true;
        if ($country_code == 'PL') {
            if ($languagesCur == 'pl-PL') {
                $link = 'pl_PL';
            } else {
                $check  = false;
                $mofile = $this->domain . '-en_GB.mo';
                $link   = 'en_GB';
                $path   = WP_PLUGIN_DIR . '/' . trim(dirname(dirname(plugin_basename(__FILE__))) . '/../languages/' . $link . "/", '/');
                load_textdomain($this->domain, $path . '/' . $mofile);
            }
        } else {
            $link = get_locale();
        }

        $checkBE = explode('-', $languagesCur);
        if (isset($checkBE[1]) && $checkBE[1] == 'BE') {
            if ($checkBE[0] == 'fr') {
                $link = 'fr_FR';
            } elseif (($checkBE[0] == 'nl')) {
                $link = 'nl_NL';
            } else {
                $link = 'en_GB';
            }
        }

        /** handling US english ALL */
        if ($check) {
            if ($country_code == 'US') {
                $mofile = $this->domain . '-en_US.mo';
                $link   = 'en_US';
                $path   = WP_PLUGIN_DIR . '/' . trim(dirname(dirname(plugin_basename(__FILE__))) . '/../languages/' . $link . "/", '/');
                load_textdomain($this->domain, $path . '/' . $mofile);
            } else {
                load_plugin_textdomain(
                    $this->domain,
                    false,
                    dirname(dirname(plugin_basename(__FILE__))) . '/../languages/' . $link . "/"
                );
            }
        }
        
        Ups_Eu_Woo_Utils_Language::$domain = $this->domain;
    }

    /**
     * Set the domain equal to that of the specified domain.
     *
     * @since    1.0.0
     * @param    string    $domain    The domain that represents the locale of this plugin.
     */
    public function ups_eu_woo_set_domain($domain)
    {
        $this->domain = $domain;
    }
}
