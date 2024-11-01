<?php namespace UpsEuWoocommerce\controllers\admin;

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
 * ups-eu-woo-admin-config-controller.php - The core plugin class.
 *
 * This is used to config and register plugin's menus, library, urls.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Admin_Config_Controller');

class Ups_Eu_Woo_Admin_Config_Controller
{
    private $plugin_name;
    private $version;

    /**
     * Name function: __construct
     * Params:
     * @plugin_name: type string
     * @version: type string
     * Return: type void
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Name function: ups_eu_woo_add_sub_item_menu
     * Params:
     * @parent_slug: type string
     * @menus: type array
     * Return: type void
     */
    private function ups_eu_woo_add_sub_item_menu($parent_slug, $menus)
    {
        /* Load models class */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        /* Check contry code */
        $check_country = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            $check_country = $model_config->value;
        }
        /* Check termconditions */
        $check_termconditions = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_TERM_CONDITION) === true) {
            $check_termconditions = $model_config->value;
        }
        /* Check accepted term conditions */
        if ((strlen($check_country) > 0) && (intval($check_termconditions) === 1)) {
            $accepted_term_conditions = true;
        } else {
            $accepted_term_conditions = false;
        }
        /* Check finished configuration */
        $finished_configuration = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_BILLING_PREFERENCE) === true) {
            $finished_configuration = $model_config->value;
        }
        /* check menu config */
        foreach ($menus as $menu_title => $config) {
            $check = true;
            if (isset($config[$model_config->require_checks])) {
                /* check accept term condition */
                if (array_key_exists(
                    $model_config->accepted_term_conditions,
                    $config[$model_config->require_checks]
                )) {
                    $check = $config[$model_config->require_checks][$model_config->accepted_term_conditions] ==
                        $accepted_term_conditions;
                }
                /* check finish configuration */
                if ($check &&
                    array_key_exists(
                        $model_config->finished_configuration,
                        $config[$model_config->require_checks]
                    )) {
                    $check = $config[$model_config->require_checks][$model_config->finished_configuration] ==
                        $finished_configuration;
                }
            }

            if ($check == true) {
                $get_parent_slug = $parent_slug;
            } else {
                $get_parent_slug = null;
            }
            $var_title = $config[$model_config->menu_title];
            /* add sub menu to system administrator */
            add_submenu_page(
                $get_parent_slug,
                $var_title,
                $var_title,
                $config[$model_config->capability],
                $config[$model_config->page_url],
                [
                new $config[$model_config->function][$model_config->class](),
                $config[$model_config->function][$model_config->controller]
                ]
            );
        }
    }

    /**
     * Name function: __construct
     * Params:
     * @plugin_name: type string
     * @version: type string
     * Return: type void
     */
    private function ups_eu_woo_register_url($urls)
    {
        /* Load all class models */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        foreach ($urls as $config) {
            $var_title = $config[$model_config->menu_title];
            /* add sub menu to system adminstrator */
            add_submenu_page(
                null,
                $var_title,
                $var_title,
                $config[$model_config->capability],
                $config[$model_config->page_url],
                [
                new $config[$model_config->function][$model_config->class](),
                $config[$model_config->function][$model_config->controller]
                ]
            );
        }
    }

    /**
     * Name function: ups_eu_woo_admin
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_admin()
    {
        /* Load all class model */
        $model_RouterUrl = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $router_config = new \UpsEuWoocommerce\config\Ups_Eu_Woo_RouterConfig();

        $parent_slug = $model_RouterUrl->ups_plugin_name;
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();

        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();
        /* add menu page UPS Shipping */
        $menu_logo_icon= \UpsEuWoocommerce\Ups_Eu_Woo_Main::ups_eu_woo_plugin_url_ups() . '/assets/admin/images/menu_logo_icon.png';
        add_menu_page(
            $model_RouterUrl->ups_plugin_name,
            __('UPS Shipping', \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            $roles_capabilities->cap_read,
            $parent_slug,
            [new Ups_Eu_Woo_MerchantCf(), 'account'],
            $menu_logo_icon
        );

        $url_regists = $router_config->ups_eu_woo_get_url_register();
        /* Show menu to page */
        if (isset($url_regists['menus'])) {
            $this->ups_eu_woo_add_sub_item_menu(
                $parent_slug,
                $url_regists['menus']
            );
        }
        /* Accept url for page */
        if (isset($url_regists['urls'])) {
            $this->ups_eu_woo_register_url($url_regists['urls']);
        }
        /* set submenu */
        global $submenu;
        if (!empty($submenu[$model_RouterUrl->ups_plugin_name])) {
            foreach ($submenu[$model_RouterUrl->ups_plugin_name] as &$item) {
                if (($item[2] === "{$model_RouterUrl->page_configurations}") || ($item[2] === "{$model_RouterUrl->page_shipment_management}")) {
                    $item[2] = 'javascript:;';
                }
            }
            unset($submenu[$model_RouterUrl->ups_plugin_name][0]);
        }
        add_action('admin_enqueue_scripts', [ $this, 'register_plugin_styles' ]);
    }

    /**
     * Registers and enqueues stylesheet.
     */
    public function register_plugin_styles()
    {
        wp_register_style('jquery-ui-datepicker', \UpsEuWoocommerce\Ups_Eu_Woo_Main::ups_eu_woo_plugin_url_ups() . '/assets/admin/css/jquery-ui.min.css');
        wp_enqueue_style('jquery-ui-datepicker');
    }

    /**
     * Name function: ups_eu_woo_display_default
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_display_default()
    {
        /* Load all class models */
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        /* load file script and css */
        wp_enqueue_script($router_url->bootstrap_lib);
        wp_enqueue_script($router_url->ups_plugin_name);
        wp_enqueue_style($router_url->bootstrap_lib);
        wp_enqueue_style($router_url->ups_plugin_name);
        /* init smarty */
        $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
        echo $smarty->fetch("admin/default.tpl");
        return;
    }

    /**
     * Name function: ups_eu_woo_enqueue_styles
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_enqueue_styles()
    {
        $this->ups_eu_woo_register_css();
    }

    /**
     * Name function: ups_eu_woo_enqueue_scripts
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_enqueue_scripts()
    {
        $this->ups_eu_woo_register_javascript();
    }

    /**
     * Name function: ups_eu_woo_register_javascript
     * Params: empty
     * Return: type void
     */
    private function ups_eu_woo_register_javascript()
    {
        /* Load all class models */
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        /* init variable */
        $scripts = [];
//        $scripts[] = [
//            $router_url->handle => $router_url->datepicker_lib,
//            $router_url->src => \UpsEuWoocommerce\Ups_Eu_Woo_Main::ups_eu_woo_plugin_url_ups() .
//            '/assets/datepicker/bootstrap-datepicker.min.js?v=' . $this->version,
//            $router_url->deps => array($router_url->jquery)
//        ];
        /* Accept  all javascript library for page */
        if (count($scripts) > 0) {
            foreach ($scripts as $script) {
                /* register javascript library */
                wp_register_script(
                    $script[$router_url->handle],
                    $script[$router_url->src],
                    $script[$router_url->deps],
                    $this->version
                );
            }
        }
    }

    /**
     * Name function: ups_eu_woo_register_css
     * Params: empty
     * Return: type void
     */
    private function ups_eu_woo_register_css()
    {
        /* Load all class models */
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        /* register acf styles */
        $styles = [];
        /* Accept all style css library for page */
        if (count($styles) > 0) {
            foreach ($styles as $k => $v) {
                /* register style css */
                wp_register_style($k, $v, false, $this->version);
            }
        }
    }
}
