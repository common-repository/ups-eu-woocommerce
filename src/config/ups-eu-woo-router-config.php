<?php namespace UpsEuWoocommerce\config;

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
 * ups-eu-woo-router-config.php - The core plugin class.
 *
 * This is used to define and config menu, urls in the current version of the plugin
 */

include_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_RouterConfig');

class Ups_Eu_Woo_RouterConfig
{
    /*
     * Name function: ups_eu_woo_get_url_register
     * Params: emtpy
     * Return: void
     * * */

    public function ups_eu_woo_get_url_register()
    {
        /* define necessary info */
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();
        return [
            'menus' => [
                /* Submenu About */
                'About' => [
                    /* About title */
                    $model_config->menu_title => __(
                        "About",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    ),
                    /* capability manage options */
                    $model_config->capability => $roles_capabilities->cap_manage_ups_module_settings,
                    /* accept link About logs api */
                    $model_config->page_url => $router_url->page_about_logs_api,
                    /* function data */
                    $model_config->function => [
                        $model_config->class => $model_config->class_path,
                        $model_config->controller => 'ups_eu_woo_about_logs_api',
                    ],
                /* require check */
//                    $model_config->require_checks => [
//                        'finished_configuration' => 1,
//                    ]
                ],
                /* Submenu Configuration */
                'Configuration' => [
                    /* Configuration title */
                    $model_config->menu_title => __(
                        "Configuration",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    ),
                    /* capability manage options */
                    $model_config->capability => $roles_capabilities->cap_manage_ups_module_settings,
                    /* accept link Configuration */
                    $model_config->page_url => $router_url->page_configurations,
                    /* function data */
                    $model_config->function => [
                        $model_config->class => $model_config->class_path,
                        $model_config->controller => 'ups_eu_woo_country',
                    ],
                ],
                /* Submenu Country Setting */
                'Country Setting' => [
                    /* Country Setting title */
                    $model_config->menu_title => __(
                        "Country Setting",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    ),
                    /* capability manage options */
                    $model_config->capability => $roles_capabilities->cap_manage_ups_module_settings,
                    /* accept link Country Setting */
                    $model_config->page_url => $router_url->page_country,
                    /* function data */
                    $model_config->function => [
                        $model_config->class => $model_config->class_path,
                        $model_config->controller => 'ups_eu_woo_country',
                    ],
                    /* require checks */
                    $model_config->require_checks => [
                        $model_config->accepted_term_conditions => false,
                    ],
                ],
                /* Submenu UPS Terms and Conditions */
                'UPS Terms and Conditions' => [
                    /* UPS Terms and Conditions title */
                    $model_config->menu_title => __(
                        "UPS Terms and Conditions",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    ),
                    /* capability manage options */
                    $model_config->capability => $roles_capabilities->cap_manage_ups_module_settings,
                    /* accept link UPS Terms and Conditions */
                    $model_config->page_url => $router_url->page_terms_conditions,
                    /* function data */
                    $model_config->function => [
                        $model_config->class => $model_config->class_path,
                        $model_config->controller => 'ups_eu_woo_terms_conditions',
                    ],
                    /* require checks */
                    $model_config->require_checks => [
                        $model_config->accepted_term_conditions => false,
                    ]
                ],
                /* Submenu Account */
                'Account' => [
                    /* Account title */
                    $model_config->menu_title => __(
                        "Account",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    ),
                    /* capability manage options */
                    $model_config->capability => $roles_capabilities->cap_manage_ups_module_settings,
                    /* accept link Account */
                    $model_config->page_url => $router_url->page_account,
                    /* function data */
                    $model_config->function => [
                        $model_config->class => $model_config->class_path,
                        $model_config->controller => 'ups_eu_woo_account',
                    ],
                    /* require checks */
                    $model_config->require_checks => [
                        $model_config->accepted_term_conditions => true,
                    ]
                ],
                /* Submenu Shipping Services */
                'Shipping Services' => [
                    /* Shipping Services title */
                    $model_config->menu_title => __(
                        "Shipping Services",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    ),
                    /* capability manage options */
                    $model_config->capability => $roles_capabilities->cap_manage_ups_module_settings,
                    /* accept link Shipping Services */
                    $model_config->page_url => $router_url->page_shipping_service,
                    /* function data */
                    $model_config->function => [
                        $model_config->class => $model_config->class_path,
                        $model_config->controller => 'ups_eu_woo_shipping_service',
                    ],
                    /* require check */
                    $model_config->require_checks => [
                        $model_config->accepted_term_conditions => true,
                    ]
                ],
                /* Submenu Cash on Delivery (COD) */
                'Cash on Delivery (COD)' => [
                    /* Collect on Delivery (COD) title */
                    $model_config->menu_title => __(
                        "Collect on Delivery (COD)",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    ),
                    /* capability manage options */
                    $model_config->capability => $roles_capabilities->cap_manage_ups_module_settings,
                    /* accept link Collect on Delivery (COD) */
                    $model_config->page_url => $router_url->page_cod,
                    /* function data */
                    $model_config->function => [
                        $model_config->class => $model_config->class_path,
                        $model_config->controller => 'ups_eu_woo_cod',
                    ],
                    /* require check */
                    $model_config->require_checks => [
                        $model_config->accepted_term_conditions => true,
                    ]
                ],
                /* Submenu Accessorial Services */
                // 'Accessorial Services' => [
                //     $model_config->capability => $model_config->manage_options,
                //     $model_config->page_url => 'ups-eu-woocommerce-accessorial_services',
                //     $model_config->function => [
                //         $model_config->class => $model_config->class_path,
                //         $model_config->controller => 'ups_eu_woo_accessorial_services',
                //     ],
                //     $model_config->require_checks => [
                //         $model_config->accepted_term_conditions => true,
                //     ]
                // ],
                /* Submenu Package Dimensions */
                'Package Dimensions' => [
                    /* Package Dimensions title */
                    $model_config->menu_title => __(
                        "Package Dimensions",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    ),
                    /* capability manage options */
                    $model_config->capability => $roles_capabilities->cap_manage_ups_module_settings,
                    /* accept link Package Dimensions */
                    $model_config->page_url => $router_url->page_package_dimension,
                    /* function data */
                    $model_config->function => [
                        $model_config->class => $model_config->class_path,
                        $model_config->controller => 'ups_eu_woo_package_dimension',
                    ],
                    /* require check */
                    $model_config->require_checks => [
                        $model_config->accepted_term_conditions => true,
                    ]
                ],
                /* Submenu Delivery rates */
                'Delivery rates' => [
                    /* Checkout Shipping Rates title */
                    $model_config->menu_title => __(
                        "Checkout Shipping Rates",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    ),
                    /* capability manage options */
                    $model_config->capability => $roles_capabilities->cap_manage_ups_module_settings,
                    /* accept link Checkout Shipping Rates */
                    $model_config->page_url => $router_url->page_delivery_rate,
                    /* function data */
                    $model_config->function => [
                        $model_config->class => $model_config->class_path,
                        $model_config->controller => 'ups_eu_woo_delivery_rate',
                    ],
                    /* require check */
                    $model_config->require_checks => [
                        $model_config->accepted_term_conditions => true,
                    ]
                ],
                /* Submenu Billing Preference */
                'Billing Preference' => [
                    /* Complete Configuration title */
                    $model_config->menu_title => __(
                        "Complete Configuration",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    ),
                    /* capability manage options */
                    $model_config->capability => $roles_capabilities->cap_manage_ups_module_settings,
                    /* accept link Billing Preference */
                    $model_config->page_url => $router_url->page_billing_preference,
                    /* function data */
                    $model_config->function => [
                        $model_config->class => $model_config->class_path,
                        $model_config->controller => 'ups_eu_woo_billing_preference',
                    ],
                    /* require check */
                    $model_config->require_checks => [
                        $model_config->accepted_term_conditions => true,
                    ]
                ],
                /* Submenu Billing Preference */
                'Shipment management' => [
                    /* Shipment management title */
                    $model_config->menu_title => __(
                        "Shipment management",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    ),
                    /* capability manage options */
                    $model_config->capability => $roles_capabilities->cap_manage_ups_shipments,
                    /* accept link Shipment management */
                    $model_config->page_url => $router_url->page_shipment_management,
                    /* function data */
                    $model_config->function => [
                        $model_config->class => $model_config->class_path,
                        $model_config->controller => 'ups_eu_woo_shipment_managements',
                    ],
                ],
                /* Submenu Shipment Manager */
                'Shipment Manager' => [
                    /* Shipment Manager title */
                    $model_config->menu_title => __(
                        "Shipment Manager",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    ),
                    /* capability manage options */
                    $model_config->capability => $roles_capabilities->cap_manage_ups_shipments,
                    /* accept link Shipment Manager */
                    $model_config->page_url => $router_url->page_shipment_manager,
                    /* function data */
                    $model_config->function => [
                        $model_config->class => $model_config->class_path,
                        $model_config->controller => 'ups_eu_woo_shipment_managements',
                    ],
                    /* require check */
                    $model_config->require_checks => [
                        'finished_configuration' => 1,
                    ]
                ]
            ],
            'urls' => [
                /* url none account */
                [
                    /* none account title */
                    $model_config->title => __(
                        "none_account",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    ),
                    /* none account menu title */
                    $model_config->menu_title => __(
                        $model_config->none_account,
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    ),
                    /* capability manage options */
                    $model_config->capability => $roles_capabilities->cap_read,
                    /* accept link none account */
                    $model_config->page_url => $router_url->page_none_account,
                    /* function data */
                    $model_config->function => [
                        $model_config->class => $model_config->class_path,
                        $model_config->controller => 'ups_eu_woo_none_account',
                    ],
                ],
                /* url country */
                [
                    /* Country title */
                    $model_config->title => __(
                        "Country/Territory",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    ),
                    /* Country menu title */
                    $model_config->menu_title => __("Country/Territory", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                    /* capability manage options */
                    $model_config->capability => $roles_capabilities->cap_read,
                    /* accept link Country */
                    $model_config->page_url => $router_url->page_ajax_json,
                    /* function data */
                    $model_config->function => [
                        $model_config->class => $model_config->class_path,
                        $model_config->controller => 'ups_eu_woo_ajax_json',
                    ],
                ],
                /* url export csv */
                [
                    /* ExportCSV title */
                    $model_config->title => __(
                        "ExportCSV",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    ),
                    /* ExportCSV menu title */
                    $model_config->menu_title => __("ExportCSV", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                    /* capability manage options */
                    $model_config->capability => $roles_capabilities->cap_read,
                    /* accept link ExportCSV */
                    $model_config->page_url => $router_url->action_export_csv,
                    /* function data */
                    $model_config->function => [
                        $model_config->class => $model_config->class_path,
                        $model_config->controller => 'ups_eu_woo_export_csv',
                    ],
                ],
            ]
        ];
    }
}
