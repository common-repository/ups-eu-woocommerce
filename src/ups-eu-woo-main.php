<?php namespace UpsEuWoocommerce;

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
 * ups-eu-woo-main.php - The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and public-facing site hooks.
 * Also maintains the unique identifier of this plugin as well as the current version of the plugin
 */

include_once('ups-eu-woo-autoloader.php');
new Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Main');

class Ups_Eu_Woo_Main
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name = "ups-eu-woocommerce";

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    public static $version = "3.8.0";
    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct($loader)
    {
        $this->loader = $loader;
        $this->ups_eu_woo_set_locale();
        $this->ups_eu_woo_define_admin_hooks();
        $this->ups_eu_woo_define_public_hooks();
        $this->ups_eu_woo_main_menu();
    }

    private function ups_eu_woo_main_menu()
    {
        $plugin_admin = new controllers\admin\Ups_Eu_Woo_Admin_Config_Controller($this->ups_eu_woo_get_plugin_name(), $this->ups_eu_woo_get_version());
        $this->loader->ups_eu_woo_loader_add_action('admin_menu', $plugin_admin, 'ups_eu_woo_admin');
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Internationalization class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function ups_eu_woo_set_locale()
    {
        $plugin_i18n = new utils\Ups_Eu_Woo_Utils_Internationalization();
        $plugin_i18n->ups_eu_woo_set_domain($this->ups_eu_woo_get_plugin_name());
        $this->loader->ups_eu_woo_loader_add_action('plugins_loaded', $plugin_i18n, 'ups_eu_woo_load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function ups_eu_woo_define_admin_hooks()
    {
        $plugin_admin = new controllers\admin\Ups_Eu_Woo_Admin_Config_Controller($this->ups_eu_woo_get_plugin_name(), $this->ups_eu_woo_get_version());
        $this->loader->ups_eu_woo_loader_add_action('admin_enqueue_scripts', $plugin_admin, 'ups_eu_woo_enqueue_styles');
        $this->loader->ups_eu_woo_loader_add_action('admin_enqueue_scripts', $plugin_admin, 'ups_eu_woo_enqueue_scripts');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function ups_eu_woo_define_public_hooks()
    {
        $plugin_fontend = new controllers\front\Ups_Eu_Woo_Front_Controller($this->ups_eu_woo_get_plugin_name(), $this->ups_eu_woo_get_version());
        $this->loader->ups_eu_woo_loader_add_action('wp_enqueue_scripts', $plugin_fontend, 'ups_eu_woo_enqueue_styles');
        $this->loader->ups_eu_woo_loader_add_action('wp_enqueue_scripts', $plugin_fontend, 'ups_eu_woo_enqueue_scripts');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function ups_eu_woo_main_run()
    {
        $this->loader->ups_eu_woo_loader_run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function ups_eu_woo_get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Loader    Orchestrates the hooks of the plugin.
     */
    public function ups_eu_woo_get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function ups_eu_woo_get_version()
    {
        return self::$version;
    }

    public static function ups_eu_woo_plugin_url_ups()
    {
        return untrailingslashit(plugins_url('/', UPS_EU_WOO_SHIPPING_FILE));
    }

    /**
     * Get the plugin path.
     *
     * @return string
     */
    public static function ups_eu_woo_plugin_path_ups()
    {
        return untrailingslashit(plugin_dir_path(UPS_EU_WOO_SHIPPING_FILE));
    }
}
