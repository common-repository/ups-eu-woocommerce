<?php
/**
 * ups-eu-woocommerce Uninstall
 *
 * Uninstalling ups-eu-woocommerce deletes user roles, pages, tables, and options.
 *
 * @author      ups-eu-woocommerce
 * @category    Core
 * @package     ups-eu-woocommerce/Uninstaller
 * @version     2.3.0
 */
namespace UpsEuWoocommerce;

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}
\UpsEuWoocommerce\uninstall_remove_data();

function uninstall_remove_data()
{
    global $wpdb;
    $version_in_database = get_option("UpsEuWoocommerce_version");
    if (empty($version_in_database)) {
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ups_shipping_config");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ups_shipping_accessorial");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ups_shipping_account");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ups_shipping_delivery_rates");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ups_shipping_license");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ups_shipping_logs_api");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ups_shipping_orders");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ups_shipping_package_default");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ups_shipping_retry_api");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ups_shipping_services");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ups_shipping_shipments");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ups_shipping_tracking");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ups_shipping_log_frontend");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ups_shipping_fallback_rates");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ups_shipping_product_dimension");
    }
}
