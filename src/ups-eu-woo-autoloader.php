<?php namespace UpsEuWoocommerce;

/**
 * _USER_TECHNICAL_AGREEMENT
 *
 * @category    ups-shipping-for-woocommerce
 * @package     UPS Shipping and UPS Access Point™ : Official Plugin For WooCommerce
 * @author      United Parcel Service of America, Inc. <noreply@ups.com>
 * @copyright   (c) 2019, United Parcel Service of America, Inc., all rights reserved
 * @link        https://www.ups.com/us/en/help-center/technology-support/ready-program/e-commerce.page
 *
 * _LICENSE_TAG
 *
 * ups-eu-woo-autoloader.php - The core plugin class.
 *
 * This is used to autoload necessary file in the current version of the plugin
 */

class Ups_Eu_Woo_Main_Autoloader
{
    //main
    protected $ups_eu_woo_main = 'ups-eu-woo-main.php';

    //config router
    protected $config_router = 'config/ups-eu-woo-router-config.php';

    //config admin
    protected $controller_admin_config = 'controllers/admin/ups-eu-woo-admin-config-controller.php';
    protected $controller_admin_accessorial_services = 'controllers/admin/ups-eu-woo-config-accessorial-service.php';
    protected $controller_admin_account = 'controllers/admin/ups-eu-woo-config-account.php';
    protected $controller_admin_billing_preference = 'controllers/admin/ups-eu-woo-config-billing-preference.php';
    protected $controller_admin_cash_on_delivery = 'controllers/admin/ups-eu-woo-config-cash-on-delivery.php';
    protected $controller_admin_country = 'controllers/admin/ups-eu-woo-config-country.php';
    protected $controller_admin_delivery_rate = 'controllers/admin/ups-eu-woo-config-delivery-rate.php';
    protected $controller_admin_merchant = 'controllers/admin/ups-eu-woo-config-merchant.php';
    protected $controller_admin_package_dimension = 'controllers/admin/ups-eu-woo-config-package-dimension.php';
    protected $controller_admin_shipping_services = 'controllers/admin/ups-eu-woo-config-shipping-service.php';
    protected $controller_admin_term_condition = 'controllers/admin/ups-eu-woo-config-terms-condition.php';
    protected $controller_admin_open_orders = 'controllers/admin/ups-eu-woo-shipment-open-order.php';

    //config front
    protected $controller_front = 'controllers/front/ups-eu-woo-front-controller.php';
    protected $controller_check_out = 'controllers/front/ups-eu-woo-check-out.php';

    //libsystem
    protected $pagination = 'libsystems/ups-eu-woo-pagination.php';

    //libsystems ajax json
    protected $ajax_json_checkout = 'libsystems/ajax_json/ups-eu-woo-ajax-json-checkout.php';
    protected $ajax_json_global = 'libsystems/ajax_json/ups-eu-woo-ajax-json-global.php';
    protected $ajax_json_info = 'libsystems/ajax_json/ups-eu-woo-ajax-json-info.php';
    protected $ajax_json_interfaces = 'libsystems/ajax_json/ups-eu-woo-ajax-json-interfaces.php';
    protected $ajax_json_package = 'libsystems/ajax_json/ups-eu-woo-ajax-json-package.php';
    protected $ajax_json_shipbase = 'libsystems/ajax_json/ups-eu-woo-ajax-json-shipbase.php';
    protected $ajax_json_shipbatch = 'libsystems/ajax_json/ups-eu-woo-ajax-json-shipbatch.php';
    protected $ajax_json_shipcancel = 'libsystems/ajax_json/ups-eu-woo-ajax-json-shipcancel.php';
    protected $ajax_json_shipcreate = 'libsystems/ajax_json/ups-eu-woo-ajax-json-shipcreate.php';
    protected $ajax_json_shipestimated = 'libsystems/ajax_json/ups-eu-woo-ajax-json-shipestimated.php';
    protected $ajax_json_shipments = 'libsystems/ajax_json/ups-eu-woo-ajax-json-shipments.php';
    protected $ajax_json_syncups = 'libsystems/ajax_json/ups-eu-woo-ajax-json-syncups.php';
    protected $ajax_json_checkap = 'libsystems/ajax_json/ups-eu-woo-ajax-json-checkap.php';

    //libsystems api ups
    protected $api_manage = 'libsystems/api_ups/ups-eu-woo-call-api-manage.php';
    protected $api_ups_configuration = 'libsystems/api_ups/ups-eu-woo-call-api-ups-configurations.php';
    protected $api_ups_eshopper = 'libsystems/api_ups/ups-eu-woo-call-api-ups-eshopper.php';
    protected $api_ups_global = 'libsystems/api_ups/ups-eu-woo-call-api-ups-global.php';
    protected $api_ups_interfaces = 'libsystems/api_ups/ups-eu-woo-call-api-ups-interfaces.php';
    protected $api_ups_shipments = 'libsystems/api_ups/ups-eu-woo-call-api-ups-shipments.php';
    protected $api_ups_systems = 'libsystems/api_ups/ups-eu-woo-call-api-ups-systems.php';

    //libsystems lang
    protected $lang_about_log_api = 'libsystems/lang/ups-eu-woo-lang-about-logs-api.php';
    protected $lang_accessorial_services = 'libsystems/lang/ups-eu-woo-lang-accessorial-services.php';
    protected $lang_account = 'libsystems/lang/ups-eu-woo-lang-account.php';
    protected $lang_archived_orders = 'libsystems/lang/ups-eu-woo-lang-archived-orders.php';
    protected $lang_billing_preference = 'libsystems/lang/ups-eu-woo-lang-billing-preference.php';
    protected $lang_checkout = 'libsystems/lang/ups-eu-woo-lang-checkout.php';
    protected $lang_cod = 'libsystems/lang/ups-eu-woo-lang-cod.php';
    protected $lang_common = 'libsystems/lang/ups-eu-woo-lang-common.php';
    protected $lang_country = 'libsystems/lang/ups-eu-woo-lang-country.php';
    protected $lang_delivery_rate = 'libsystems/lang/ups-eu-woo-lang-delivery-rate.php';
    protected $lang_interfaces = 'libsystems/lang/ups-eu-woo-lang-interfaces.php';
    protected $lang_none_account = 'libsystems/lang/ups-eu-woo-lang-none-account.php';
    protected $lang_open_orders = 'libsystems/lang/ups-eu-woo-lang-open-orders.php';
    protected $lang_orders = 'libsystems/lang/ups-eu-woo-lang-orders.php';
    protected $lang_package_dimension = 'libsystems/lang/ups-eu-woo-lang-package-dimension.php';
    protected $lang_shipments = 'libsystems/lang/ups-eu-woo-lang-shipments.php';
    protected $lang_shipping_services = 'libsystems/lang/ups-eu-woo-lang-shipping-service.php';
    protected $lang_term_condition = 'libsystems/lang/ups-eu-woo-lang-terms-conditions.php';

    //models
    protected $models_accessorial = 'models/ups-eu-woo-model-accessorial.php';
    protected $models_account = 'models/ups-eu-woo-model-account.php';
    protected $models_auto_remove_system = 'models/ups-eu-woo-model-auto-remove-system.php';
    protected $models_config = 'models/ups-eu-woo-model-config.php';
    protected $models_currency = 'models/ups-eu-woo-model-currency.php';
    protected $models_data_api_manage = 'models/ups-eu-woo-model-data-api-manage-plugin.php';
    protected $models_data_base = 'models/ups-eu-woo-model-data-base.php';
    protected $models_delivery_rate = 'models/ups-eu-woo-model-delivery-rates.php';
    protected $models_init_data_system = 'models/ups-eu-woo-model-init-data-system.php';
    protected $models_interfaces = 'models/ups-eu-woo-model-interfaces.php';
    protected $models_license = 'models/ups-eu-woo-model-license.php';
    protected $models_log_file = 'models/ups-eu-woo-model-log-file.php';
    protected $models_log_frontend = 'models/ups-eu-woo-model-log-frontend.php';
    protected $models_log_api = 'models/ups-eu-woo-model-logs-api.php';
    protected $models_options = 'models/ups-eu-woo-model-options.php';
    protected $models_orders = 'models/ups-eu-woo-model-orders.php';
    protected $models_package_default = 'models/ups-eu-woo-model-package-default.php';
    protected $models_retry_api = 'models/ups-eu-woo-model-retry-api.php';
    protected $models_services = 'models/ups-eu-woo-model-services.php';
    protected $models_shipments = 'models/ups-eu-woo-model-shipments.php';
    protected $models_tracking = 'models/ups-eu-woo-model-tracking.php';
    protected $models_ups_shipping_api = 'models/ups-eu-woo-model-ups-shipping-api.php';
    protected $models_fallback_rate = 'models/ups-eu-woo-model-fallback-rates.php';
    protected $models_product_dimension = 'models/ups-eu-woo-model-product-dimension.php';

    //models bases
    protected $models_bases_router_url = 'models/bases/ups-eu-woo-model-base-router-url.php';

    //models entities
    protected $models_entity_accessorial = 'models/entities/ups-eu-woo-model-entity-accessorial.php';
    protected $models_entity_account = 'models/entities/ups-eu-woo-model-entity-account.php';
    protected $models_entity_api_request = 'models/entities/ups-eu-woo-model-entity-api-request.php';
    protected $models_entity_config = 'models/entities/ups-eu-woo-model-entity-config.php';
    protected $models_entity_delivery_rate = 'models/entities/ups-eu-woo-model-entity-delivery-rates.php';
    protected $models_entity_languages = 'models/entities/ups-eu-woo-model-entity-language.php';
    protected $models_entity_license = 'models/entities/ups-eu-woo-model-entity-license.php';
    protected $models_entity_log_frontend = 'models/entities/ups-eu-woo-model-entity-log-frontend.php';
    protected $models_entity_logs_api = 'models/entities/ups-eu-woo-model-entity-logs-api.php';
    protected $models_entity_orders = 'models/entities/ups-eu-woo-model-entity-orders.php';
    protected $models_entity_package_default = 'models/entities/ups-eu-woo-model-entity-package-default.php';
    protected $models_entity_retry_api = 'models/entities/ups-eu-woo-model-entity-retry-api.php';
    protected $models_entity_roles_capabilities = 'models/entities/ups-eu-woo-model-entity-roles-capabilities.php';
    protected $models_entity_services = 'models/entities/ups-eu-woo-model-entity-services.php';
    protected $models_entity_shipments = 'models/entities/ups-eu-woo-model-entity-shipments.php';
    protected $models_entity_systems = 'models/entities/ups-eu-woo-model-entity-systems.php';
    protected $models_entity_tracking = 'models/entities/ups-eu-woo-model-entity-tracking.php';
    protected $models_entity_fallback_rate = 'models/entities/ups-eu-woo-model-entity-fallback-rates.php';
    protected $models_entity_product_dimension = 'models/entities/ups-eu-woo-model-entity-product-dimension.php';

    //setting shipping
    protected $ups_eu_shipping = 'setting_shipping/ups-eu-woo-ups-eu-shipping.php';

    //utils
    protected $utils_activator = 'utils/ups-eu-woo-utils-activator.php';
    protected $utils_ajax_json = 'utils/ups-eu-woo-utils-ajax-json.php';
    protected $utils_deactivator = 'utils/ups-eu-woo-utils-deactivator.php';
    protected $utils_export_csv = 'utils/ups-eu-woo-utils-export-csv.php';
    protected $utils_internationalization = 'utils/ups-eu-woo-utils-internationalization.php';
    protected $utils_languages = 'utils/ups-eu-woo-utils-language.php';
    protected $utils_loader = 'utils/ups-eu-woo-utils-loader.php';
    protected $utils_resource_system = 'utils/ups-eu-woo-utils-resource-systems.php';
    protected $utils_smarty = 'utils/ups-eu-woo-utils-smarty.php';
    protected $utils_upgrade_version = 'utils/ups-eu-woo-utils-upgrade-version.php';
    protected $utils_ups_pagination = 'utils/ups-eu-woo-utils-ups-pagination.php';

    public function __construct($class_name)
    {
        $loader = $this->ups_eu_woo_get_list_library($class_name);
        $all_plugins = apply_filters('active_plugins', get_option('active_plugins'));

        if (!empty($loader) && is_array($loader)) {
            if (stripos(implode($all_plugins), '/woocommerce.php')) {
                foreach ($loader as $items) {
                    try {
                        include_once("{$items}");
                    } catch (\Exception $error) {
                        //log error to file.
                    }
                }
            }
        }
    }

    private function ups_eu_woo_get_list_library($class_name)
    {
        $woocommerce_plugin = $this->ups_eu_woo_get_woocomerce_plugin_path();
        if (!empty($woocommerce_plugin)) {
            $woocommerce_plugin_main_file = $woocommerce_plugin->main;
            $woocommerce_plugin_path = $woocommerce_plugin->path;
        }

        $list_library_loader = [
            //list library of UpsEuWoocommerce
            'UpsEuWoocommerce' => [
                $this->ups_eu_woo_main,
                $this->utils_activator,
                $this->utils_deactivator,
                $this->utils_internationalization,
                $this->utils_loader,
                $this->controller_check_out,
                $this->models_bases_router_url,
                $this->ups_eu_shipping,
                $this->api_manage
            ],
            //list library of Ups_Eu_Woo_Main
            'Ups_Eu_Woo_Main' => [
                $this->controller_admin_config,
                $this->utils_internationalization,
                $this->controller_front,
            ],
            //list library of Ups_Eu_Woo_RouterConfig
            'Ups_Eu_Woo_RouterConfig' => [
                $this->models_bases_router_url,
                $this->models_config,
                $this->models_entity_roles_capabilities,
                $this->utils_languages,
            ],
            //list library of Ups_Eu_Woo_Admin_Config_Controller
            'Ups_Eu_Woo_Admin_Config_Controller' => [
                $this->models_config,
                $this->models_bases_router_url,
                $this->config_router,
                $this->models_entity_roles_capabilities,
                $this->ups_eu_woo_main,
                $this->utils_languages,
                $this->utils_smarty,
                $this->controller_admin_merchant
            ],
            //list library of Ups_Eu_Woo_Config_Accessorial_Service
            'Ups_Eu_Woo_Config_Accessorial_Service' => [
                $this->models_bases_router_url,
                $this->models_config,
                $this->models_accessorial,
                $this->utils_languages,
                $woocommerce_plugin_main_file,
                $woocommerce_plugin_path . 'includes/gateways/cod/class-wc-gateway-cod.php'
            ],
            //list library of Ups_Eu_Woo_Config_Account
            'Ups_Eu_Woo_Config_Account' => [
                $this->api_manage,
                $this->models_license,
                $this->models_config,
                $this->models_account,
                $this->models_bases_router_url,
                $this->api_ups_configuration,
                $this->utils_languages,
                $this->models_options,
                $this->models_retry_api
            ],
            //list library of Ups_Eu_Woo_Config_Billing_Preference
            'Ups_Eu_Woo_Config_Billing_Preference' => [
                $this->models_bases_router_url,
                $this->models_config,
                $this->models_retry_api,
                $this->utils_languages,
                $this->api_ups_configuration,
                $this->models_entity_languages,
                $this->models_entity_shipments,
                $this->api_manage
            ],
            //list library of Ups_Eu_Woo_Config_Cash_On_Delivery
            'Ups_Eu_Woo_Config_Cash_On_Delivery' => [
                $this->models_bases_router_url,
                $this->models_config,
                $this->utils_languages,
                $woocommerce_plugin_main_file,
                $woocommerce_plugin_path . 'includes/gateways/cod/class-wc-gateway-cod.php'
            ],
            //list library of Ups_Eu_Woo_Config_Country
            'Ups_Eu_Woo_Config_Country' => [
                $this->api_manage,
                $this->models_bases_router_url,
                $this->models_config,
                $this->models_init_data_system,
                $this->models_options,
                $this->utils_languages
            ],
            //list library of Ups_Eu_Woo_Config_Delivery_Rate
            'Ups_Eu_Woo_Config_Delivery_Rate' => [
                $this->models_bases_router_url,
                $this->models_config,
                $this->models_services,
                $this->models_delivery_rate,
                $this->models_options,
                $this->models_retry_api,
                $this->utils_languages,
                $this->utils_smarty
            ],
            //list library of Ups_Eu_Woo_MerchantCf
            'Ups_Eu_Woo_MerchantCf' => [
                $this->models_bases_router_url,
                $this->models_config,
                $this->utils_ajax_json,
                $this->utils_smarty,
                $this->utils_languages,
                $this->models_entity_roles_capabilities,
                $this->controller_admin_country,
                $this->controller_admin_term_condition,
                $this->controller_admin_account,
                $this->controller_admin_shipping_services,
                $this->controller_admin_cash_on_delivery,
                $this->controller_admin_accessorial_services,
                $this->controller_admin_package_dimension,
                $this->controller_admin_delivery_rate,
                $this->controller_admin_billing_preference,
                $this->controller_admin_open_orders,
                $this->utils_ups_pagination,
                $this->models_log_api,
                $this->ups_eu_woo_main
            ],
            //list library of Ups_Eu_Woo_Config_Package_Dimension
            'Ups_Eu_Woo_Config_Package_Dimension' => [
                $this->models_bases_router_url,
                $this->models_config,
                $this->models_package_default,
                $this->models_fallback_rate,
                $this->models_product_dimension,
                $this->models_retry_api,
                $this->models_options,
                $this->utils_languages
            ],
            //list library of Ups_Eu_Woo_Config_Shipping_Service
            'Ups_Eu_Woo_Config_Shipping_Service' => [
                $this->models_bases_router_url,
                $this->models_config,
                $this->models_services,
                $this->models_account,
                $this->models_options,
                $this->models_retry_api,
                $this->utils_languages,
                $this->models_delivery_rate
            ],
            //list library of Ups_Eu_Woo_Config_Terms_Condition
            'Ups_Eu_Woo_Config_Terms_Condition' => [
                $this->models_bases_router_url,
                $this->models_config,
                $this->models_license,
                $this->models_init_data_system,
                $this->api_manage,
                $this->utils_languages
            ],
            //list library of Ups_Eu_Woo_Shipment_Open_Order
            'Ups_Eu_Woo_Shipment_Open_Order' => [
                $this->models_bases_router_url,
                $this->models_retry_api,
                $this->api_manage,
                $this->models_config,
                $this->models_orders,
                $this->models_account,
                $this->models_services,
                $this->models_options,
                $this->utils_ups_pagination,
                $this->utils_languages,
                $this->utils_export_csv,
                $woocommerce_plugin_main_file,
                $woocommerce_plugin_path . 'includes/class-wc-countries.php'
            ],
            //list library of Ups_Eu_Woo_CheckOut
            'Ups_Eu_Woo_CheckOut' => [
                $this->models_bases_router_url,
                $this->models_config,
                $this->models_options,
                $this->ups_eu_shipping,
                $this->utils_smarty,
                $this->utils_languages,
                $woocommerce_plugin_main_file
            ],
            //list library of Ups_Eu_Woo_Front_Controller
            'Ups_Eu_Woo_Front_Controller' => [
                $this->utils_smarty
            ],
            //list library of Ups_Eu_Woo_CheckOut_Ajax_Json
            'Ups_Eu_Woo_CheckOut_Ajax_Json' => [
                $this->models_bases_router_url,
                $this->models_config,
                $this->ajax_json_global,
                $this->models_services,
                $this->models_log_frontend,
                $this->controller_check_out
            ],
            //list library of Ups_Eu_Woo_Global_Ajax_Json
            'Ups_Eu_Woo_Global_Ajax_Json' => [
                $this->ajax_json_interfaces,
                $this->utils_languages,
                $this->api_ups_shipments
            ],
            //list library of Ups_Eu_Woo_Info_Ajax_Json
            'Ups_Eu_Woo_Info_Ajax_Json' => [
                $this->ajax_json_global,
                $this->utils_smarty,
                $this->utils_languages,
                $this->models_bases_router_url,
                $this->models_orders,
                $this->models_options,
                $this->models_shipments,
                $this->models_retry_api
            ],
            //list library of Ups_Eu_Woo_Package_Ajax_Json
            'Ups_Eu_Woo_Package_Ajax_Json' => [
                $this->ajax_json_global,
                $this->models_package_default,
                $this->models_product_dimension,
                $this->models_fallback_rate,
                $this->models_retry_api
            ],
            //list library of Ups_Eu_Woo_ShipBase_Ajax_Json
            'Ups_Eu_Woo_ShipBase_Ajax_Json' => [
                $this->ajax_json_global,
                $this->models_orders,
                $this->models_package_default,
                $this->models_entity_systems,
                $this->utils_languages,
                $this->models_account,
                $this->models_options,
                $this->utils_smarty,
                $this->models_tracking,
                $this->api_ups_shipments,
                $this->models_shipments,
                $this->models_retry_api
            ],
            //list library of Ups_Eu_Woo_ShipBatch_Ajax_Json
            'Ups_Eu_Woo_ShipBatch_Ajax_Json' => [
                $this->ajax_json_shipbase,
                $this->models_bases_router_url,
                $this->utils_smarty,
                $this->models_account,
                $this->models_package_default,
                $this->utils_languages,
                $this->models_orders
            ],
            //list library of Ups_Eu_Woo_ShipCancel_Ajax_Json
            'Ups_Eu_Woo_ShipCancel_Ajax_Json' => [
                $this->models_bases_router_url,
                $this->ajax_json_shipbase,
                $this->models_tracking,
                $this->models_shipments,
                $this->models_orders,
                $this->models_retry_api,
                $this->api_ups_shipments
            ],
            //list library of Ups_Eu_Woo_ShipCreate_Ajax_Json
            'Ups_Eu_Woo_ShipCreate_Ajax_Json' => [
                $this->ajax_json_shipbase,
                $this->models_bases_router_url,
                $this->utils_smarty,
                $this->models_services,
                $this->models_accessorial,
                $this->models_package_default,
                $this->models_options,
                $this->models_config,
                $this->utils_languages,
                $this->models_orders,
                $woocommerce_plugin_main_file,
                $woocommerce_plugin_path . 'includes/class-wc-countries.php'
            ],
            //list library of Ups_Eu_Woo_ShipEstimated_Ajax_Json
            'Ups_Eu_Woo_ShipEstimated_Ajax_Json' => [
                $this->ajax_json_shipbase,
                $this->models_package_default,
                $this->models_config,
                $this->models_orders,
                $this->api_ups_shipments,
                $this->models_entity_systems
            ],
            //list library of Ups_Eu_Woo_Shipments_Ajax_Json
            'Ups_Eu_Woo_Shipments_Ajax_Json' => [
                $this->ajax_json_global,
                $this->ajax_json_shipcreate,
                $this->ajax_json_shipestimated,
                $this->ajax_json_shipbatch,
                $this->ajax_json_shipcancel
            ],
            //list library of Ups_Eu_Woo_ShipUpdate_Ajax_Json
            'Ups_Eu_Woo_ShipUpdate_Ajax_Json' => [
                $this->ajax_json_global
            ],
            //list library of Ups_Eu_Woo_SyncUps_Ajax_Json
            'Ups_Eu_Woo_SyncUps_Ajax_Json' => [
                $this->ajax_json_global,
                $this->models_auto_remove_system
            ],
            //list library of Ups_Eu_Woo_Manage_Api_Ups
            'Ups_Eu_Woo_Manage_Api_Ups' => [
                $this->ups_eu_woo_main,
                $this->api_ups_interfaces,
                $this->api_ups_global,
                $this->models_config,
                $this->models_retry_api,
                $this->models_log_api,
                $this->models_data_api_manage
            ],
            //list library of Ups_Eu_Woo_Configurations_Api_Ups
            'Ups_Eu_Woo_Configurations_Api_Ups' => [
                $this->api_ups_interfaces,
                $this->api_ups_global,
                $this->models_log_api,
                $this->models_account,
                $this->models_config,
                $this->models_license,
                $this->models_ups_shipping_api,
                $this->utils_languages
            ],
            //list library of Ups_Eu_Woo_EShopper_Api_Ups
            'Ups_Eu_Woo_EShopper_Api_Ups' => [
                $this->models_entity_api_request,
                $this->api_ups_interfaces,
                $this->api_ups_global,
                $this->models_ups_shipping_api,
                $this->models_log_api
            ],
            //list library of Ups_Eu_Woo_Global_Api_Ups
            'Ups_Eu_Woo_Global_Api_Ups' => [
                $this->ups_eu_woo_main,
                $this->models_license
            ],
            //list library of Ups_Eu_Woo_Shipments_Api_Ups
            'Ups_Eu_Woo_Shipments_Api_Ups' => [
                $this->api_ups_interfaces,
                $this->api_ups_global,
                $this->models_log_api
            ],
            //list library of Ups_Eu_Woo_Systems_Api_Ups
            'Ups_Eu_Woo_Systems_Api_Ups' => [
                $this->api_ups_interfaces,
                $this->api_ups_global,
                $this->models_config,
                $this->models_retry_api,
                $this->ups_eu_woo_main
            ],
            //list library of Ups_Eu_Woo_About_Logs_Api_Language
            'Ups_Eu_Woo_About_Logs_Api_Language' => [
                $this->lang_common,
                $this->models_log_api
            ],
            //list library of Ups_Eu_Woo_Accessorial_Services_Language
            'Ups_Eu_Woo_Accessorial_Services_Language' => [
                $this->lang_common
            ],
            //list library of Ups_Eu_Woo_Account_Language
            'Ups_Eu_Woo_Account_Language' => [
                $this->lang_common
            ],
            //list library of Ups_Eu_Woo_Archived_Orders_Language
            'Ups_Eu_Woo_Archived_Orders_Language' => [
                $this->lang_common
            ],
            //list library of Ups_Eu_Woo_Billing_Preference_Language
            'Ups_Eu_Woo_Billing_Preference_Language' => [
                $this->lang_common
            ],
            //list library of Ups_Eu_Woo_Checkout_Language
            'Ups_Eu_Woo_Checkout_Language' => [
                $this->lang_common
            ],
            //list library of Ups_Eu_Woo_Cod_Language
            'Ups_Eu_Woo_Cod_Language' => [
                $this->lang_common
            ],
            //list library of Ups_Eu_Woo_Common_Language
            'Ups_Eu_Woo_Common_Language' => [
                $this->lang_interfaces,
                $this->models_entity_languages
            ],
            //list library of Ups_Eu_Woo_Country_Language
            'Ups_Eu_Woo_Country_Language' => [
                $this->lang_common
            ],
            //list library of Ups_Eu_Woo_Delivery_Rate_Language
            'Ups_Eu_Woo_Delivery_Rate_Language' => [
                $this->lang_common
            ],
            //list library of Ups_Eu_Woo_None_Account_Language
            'Ups_Eu_Woo_None_Account_Language' => [
                $this->lang_common
            ],
            //list library of Ups_Eu_Woo_Open_Orders_Language
            'Ups_Eu_Woo_Open_Orders_Language' => [
                $this->lang_common
            ],
            //list library of Ups_Eu_Woo_Orders_Language
            'Ups_Eu_Woo_Orders_Language' => [
                $this->lang_common
            ],
            //list library of Ups_Eu_Woo_Package_Dimension_Language
            'Ups_Eu_Woo_Package_Dimension_Language' => [
                $this->lang_common
            ],
            //list library of Ups_Eu_Woo_Shipments_Language
            'Ups_Eu_Woo_Shipments_Language' => [
                $this->lang_common
            ],
            //list library of Ups_Eu_Woo_Shipping_Service_Language
            'Ups_Eu_Woo_Shipping_Service_Language' => [
                $this->lang_common
            ],
            //list library of Ups_Eu_Woo_Terms_Conditions_Language
            'Ups_Eu_Woo_Terms_Conditions_Language' => [
                $this->lang_common
            ],
            //list library of Ups_Eu_Woo_Router_Url
            'Ups_Eu_Woo_Router_Url' => [
                $this->models_entity_systems,
                $this->models_config
            ],
            //list library of Ups_Eu_Woo_Accessorial_Entity
            'Ups_Eu_Woo_Accessorial_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_Account_Entity
            'Ups_Eu_Woo_Account_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_Api_Request_Entity
            'Ups_Eu_Woo_Api_Request_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_Config_Entity
            'Ups_Eu_Woo_Config_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_Delivery_Rates_Entity
            'Ups_Eu_Woo_Delivery_Rates_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_Fallback_Rates_Entity
            'Ups_Eu_Woo_Fallback_Rates_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_Product_Dimension_Entity
            'Ups_Eu_Woo_Product_Dimension_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_License_Entity
            'Ups_Eu_Woo_License_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_Log_Frontend_Entity
            'Ups_Eu_Woo_Log_Frontend_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_Logs_Api_Entity
            'Ups_Eu_Woo_Logs_Api_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_Orders_Entity
            'Ups_Eu_Woo_Orders_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_Package_Default_Entity
            'Ups_Eu_Woo_Package_Default_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_Retry_Api_Entity
            'Ups_Eu_Woo_Retry_Api_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_Roles_Capabilities_Entity
            'Ups_Eu_Woo_Roles_Capabilities_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_Services_Entity
            'Ups_Eu_Woo_Services_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_Shipments_Entity
            'Ups_Eu_Woo_Shipments_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_Systems_Entity
            'Ups_Eu_Woo_Systems_Entity' => [
                $this->models_entity_languages
            ],
            //list library of Ups_Eu_Woo_Tracking_Entity
            'Ups_Eu_Woo_Tracking_Entity' => [
                $this->models_data_base
            ],
            //list library of Ups_Eu_Woo_Model_Accessorial
            'Ups_Eu_Woo_Model_Accessorial' => [
                $this->models_interfaces,
                $this->models_entity_accessorial
            ],
            //list library of Ups_Eu_Woo_Model_Account
            'Ups_Eu_Woo_Model_Account' => [
                $this->models_interfaces,
                $this->models_entity_account,
                $this->utils_languages
            ],
            //list library of Ups_Eu_Woo_Model_Auto_Remove_System
            'Ups_Eu_Woo_Model_Auto_Remove_System' => [
                $this->models_orders,
                $this->models_log_api,
                $this->models_log_frontend,
                $this->models_retry_api,
                $this->api_manage,
                $this->api_ups_systems,
                $this->models_account,
                $this->models_license
            ],
            //list library of Ups_Eu_Woo_Model_Config
            'Ups_Eu_Woo_Model_Config' => [
                $this->models_interfaces,
                $this->models_entity_config,
                $this->utils_languages,
                $this->models_log_file
            ],
            //list library of Ups_Eu_Woo_Data_Api_Manage_Plugin
            'Ups_Eu_Woo_Data_Api_Manage_Plugin' => [
                $this->models_data_base,
                $this->models_config,
                $this->models_account,
                //$this->models_accessorial,
                $this->models_package_default,
                $this->models_services,
                $this->models_delivery_rate
            ],
            //list library of Ups_Eu_Woo_Data_Base
            'Ups_Eu_Woo_Data_Base' => [
                $this->models_entity_systems,
                $this->models_log_file
            ],
            //list library of Ups_Eu_Woo_Delivery_Rates
            'Ups_Eu_Woo_Delivery_Rates' => [
                $this->models_interfaces,
                $this->models_entity_delivery_rate,
                $this->utils_languages,
                $this->models_log_file
            ],
            //list library of Ups_Eu_Woo_Model_Product_Dimension
            'Ups_Eu_Woo_Model_Product_Dimension' => [
                $this->models_interfaces,
                $this->models_entity_product_dimension,
                $this->utils_languages,
                $this->models_log_file
            ],
            //list library of Ups_Eu_Woo_Fallback_Rates
            'Ups_Eu_Woo_Fallback_Rates' => [
                $this->models_interfaces,
                $this->models_entity_fallback_rate,
                $this->utils_languages,
                $this->models_log_file
            ],
            //list library of Ups_Eu_Woo_Init_Data_System
            'Ups_Eu_Woo_Init_Data_System' => [
                $this->models_config,
                $this->models_log_file,
                $this->models_accessorial,
                $this->models_services
            ],
            //list library of Ups_Eu_Woo_Model_License
            'Ups_Eu_Woo_Model_License' => [
                $this->models_interfaces,
                $this->models_entity_license,
                $this->models_log_file,
                $this->utils_languages
            ],
            //list library of Ups_Eu_Woo_Model_Log_Frontend
            'Ups_Eu_Woo_Model_Log_Frontend' => [
                $this->models_interfaces,
                $this->models_entity_log_frontend,
                $this->models_log_file
            ],
            //list library of Ups_Eu_Woo_Model_Logs_Api
            'Ups_Eu_Woo_Model_Logs_Api' => [
                $this->models_interfaces,
                $this->models_entity_logs_api,
                $this->utils_smarty
            ],
            //list library of Ups_Eu_Woo_Model_Options
            'Ups_Eu_Woo_Model_Options' => [
                $this->utils_languages,
                $woocommerce_plugin_main_file,
                $woocommerce_plugin_path . 'includes/class-wc-countries.php'
            ],
            //list library of Ups_Eu_Woo_Model_Orders
            'Ups_Eu_Woo_Model_Orders' => [
                $this->models_interfaces,
                $this->models_entity_orders,
                $this->models_services,
                $this->models_entity_languages,
                $this->utils_languages,
                $this->models_tracking,
                $this->models_shipments,
                $this->utils_smarty,
                $this->models_log_file,
                $woocommerce_plugin_main_file,
                $woocommerce_plugin_path . 'includes/class-wc-order-query.php',
                $woocommerce_plugin_path . 'includes/class-wc-order.php'
            ],
            //list library of Ups_Eu_Woo_Model_Package_Default
            'Ups_Eu_Woo_Model_Package_Default' => [
                $this->models_interfaces,
                $this->models_entity_package_default,
                $this->utils_languages
            ],
            //list library of Ups_Eu_Woo_Model_Retry_Api
            'Ups_Eu_Woo_Model_Retry_Api' => [
                $this->models_interfaces,
                $this->models_entity_retry_api,
                $this->models_log_file,
                $this->ups_eu_woo_main,
                $this->api_manage
            ],
            //list library of Ups_Eu_Woo_Model_Services
            'Ups_Eu_Woo_Model_Services' => [
                $this->models_interfaces,
                $this->models_entity_services,
                $this->utils_languages,
                $this->models_currency,
                $this->models_config,
                $this->models_delivery_rate
            ],
            //list library of Ups_Eu_Woo_Model_Shipments
            'Ups_Eu_Woo_Model_Shipments' => [
                $this->models_interfaces,
                $this->models_entity_shipments,
                $this->models_log_file,
                $woocommerce_plugin_main_file,
                $woocommerce_plugin_path . 'includes/class-wc-order.php'
            ],
            //list library of Ups_Eu_Woo_Model_Tracking
            'Ups_Eu_Woo_Model_Tracking' => [
                $this->models_interfaces,
                $this->models_entity_tracking,
                $this->utils_languages
            ],
            //list library of Ups_Eu_Woo_Model_Ups_Shipping_API
            'Ups_Eu_Woo_Model_Ups_Shipping_API' => [
                $this->models_bases_router_url,
                $this->models_config,
                $this->models_entity_api_request,
                $this->models_log_frontend,
                $this->models_package_default,
                $this->models_account,
                $this->models_entity_systems,
                $this->models_orders,
                $this->models_services,
                $this->utils_languages,
                $this->utils_smarty,
                $this->models_license
            ],
             //list library of Ups_Eu_Woo_Model_Package_Type
             'Ups_Eu_Woo_Model_Package_Type' => [
                $this->models_bases_router_url,
                $this->models_config,
                $this->models_entity_api_request,
                $this->models_log_frontend,
                $this->models_package_default,
                $this->models_account,
                $this->models_entity_systems,
                $this->models_orders,
                $this->models_services,
                $this->utils_languages,
                $this->utils_smarty,
                $this->models_license
            ],
            //list library of Ups_Eu_Woo_Ups_Eu_Shipping
            'Ups_Eu_Woo_Ups_Eu_Shipping' => [
                $this->models_config,
                $this->utils_languages,
                $woocommerce_plugin_main_file,
                $woocommerce_plugin_path . 'includes/abstracts/abstract-wc-shipping-method.php'
            ],
            //list library of Ups_Eu_Woo_Utils_Activator
            'Ups_Eu_Woo_Utils_Activator' => [
                $this->utils_resource_system,
                $this->models_config,
                $this->api_manage
            ],
            //list library of Ups_Eu_Woo_Utils_Ajax_Json
            'Ups_Eu_Woo_Utils_Ajax_Json' => [
                $this->models_entity_systems,
                $this->ajax_json_package,
                $this->ajax_json_shipments,
                $this->ajax_json_info,
                $this->ajax_json_syncups,
                $this->ajax_json_checkout,
                $this->api_ups_eshopper,
                $this->ajax_json_checkap
            ],
            //list library of Ups_Eu_Woo_Utils_Deactivator
            'Ups_Eu_Woo_Utils_Deactivator' => [
                $this->utils_resource_system
            ],
            //list library of Ups_Eu_Woo_Utils_Internationalization
            'Ups_Eu_Woo_Utils_Internationalization' => [
                $this->utils_languages
            ],
            //list library of Ups_Eu_Woo_Utils_Language
            'Ups_Eu_Woo_Utils_Language' => [
                $this->models_entity_languages,
                $this->lang_common,
                $this->lang_country,
                $this->lang_term_condition,
                $this->lang_none_account,
                $this->lang_account,
                $this->lang_shipping_services,
                $this->lang_cod,
                $this->lang_accessorial_services,
                $this->lang_package_dimension,
                $this->lang_delivery_rate,
                $this->lang_billing_preference,
                $this->lang_orders,
                $this->lang_open_orders,
                $this->lang_shipments,
                $this->lang_archived_orders,
                $this->lang_checkout,
                $this->lang_about_log_api
            ],
            //list library of Ups_Eu_Woo_Utils_Resource_Systems
            'Ups_Eu_Woo_Utils_Resource_Systems' => [
                $this->models_data_base,
                $this->models_log_file,
                $this->ups_eu_woo_main,
                $this->api_ups_systems,
                $this->models_entity_roles_capabilities,
                $this->models_retry_api,
                $this->models_init_data_system,
                $this->api_manage
            ],
            //list library of Ups_Eu_Woo_Utils_Smarty
            'Ups_Eu_Woo_Utils_Smarty' => [
                $this->models_entity_languages,
                $this->ups_eu_woo_main
            ],
            //list library of Ups_Eu_Woo_Ups_Pagination
            'Ups_Eu_Woo_Ups_Pagination' => [
                $this->pagination,
                $this->models_orders,
                $this->models_log_api
            ],
        ];
        return $list_library_loader["{$class_name}"];
    }

    private function ups_eu_woo_get_woocomerce_plugin_path()
    {
        $all_plugins = apply_filters('active_plugins', get_option('active_plugins'));
        //load woocommerce library
        $woocommerce_plugin = '';
        if (!empty($all_plugins) && is_array($all_plugins)) {
            foreach ($all_plugins as $items) {
                if (stripos($items, '/woocommerce.php')) {
                    $woocommerce_plugin = $items;
                }
            }
        }
        //get woocommerce dirname
        $woocommerce_plugin_main_file_path = plugin_dir_path(dirname(__FILE__, 2)) . $woocommerce_plugin;
        $woocommerce_plugin_dirname = '';
        if ($woocommerce_plugin !== '') {
            $woocommerce_plugin_dirname = explode('/', $woocommerce_plugin)[0];
        }
        //create woocommerce plugin path
        $woocommerce_plugin_path = plugin_dir_path(dirname(__FILE__, 2)) . $woocommerce_plugin_dirname . '/';

        $result = new \stdClass();
        $result->main = $woocommerce_plugin_main_file_path;
        $result->path = $woocommerce_plugin_path;
        return $result;
    }
}
