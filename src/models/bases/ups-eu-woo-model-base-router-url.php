<?php namespace UpsEuWoocommerce\models\bases;

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
 * ups-eu-woo-model-base-router-url.php - The core plugin class.
 *
 * This is used to handle the Router URL.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Router_Url');

class Ups_Eu_Woo_Router_Url extends \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Systems_Entity
{
    /* list url of systems */

    public $url_home = "";
    public $url_home_cf = "";
    public $url_home_sm = "";
    public $url_router = [];
    public $url_configurations;
    public $url_country;
    public $url_terms_conditions;
    public $url_none_account;
    public $url_account;
    public $url_shipping_service;
    public $url_cod;
    public $url_accessorial_services;
    public $url_package_dimension;
    public $url_delivery_rate;
    public $url_billing_preference;
    public $url_ajax_json;
    public $url_shipment_management;
    public $url_shipment_manager;
    public $url_open_orders;
    public $url_archived_orders;
    public $url_shipments;
    public $url_api_map_bing_com;
    public $url_frontend_api_json;
    public $url_about_logs_api;
    /* Name page block in systems */
    public $block_account = "account";
    public $block_billing_preference = "billing_preference";
    public $block_cod = "cod";
    public $block_delivery_rate = "delivery_rate";
    public $block_package_dimension = "package_dimension";
    public $block_shipping_service = "shipping_service";
    /* Name page main in system */
    public $page_configurations = "ups-eu-woocommerce-configurations";
    public $page_country = "ups-eu-woocommerce-country";
    public $page_terms_conditions = "ups-eu-woocommerce-terms_conditions";
    public $page_none_account = "ups-eu-woocommerce-none_account";
    public $page_account = "ups-eu-woocommerce-account";
    public $page_shipping_service = "ups-eu-woocommerce-shipping_service";
    public $page_cod = "ups-eu-woocommerce-cod";
    public $page_accessorial_services = "ups-eu-woocommerce-accessorial_services";
    public $page_package_dimension = "ups-eu-woocommerce-package_dimension";
    public $page_delivery_rate = "ups-eu-woocommerce-delivery_rate";
    public $page_billing_preference = "ups-eu-woocommerce-billing_preference";
    public $page_ajax_json = "ups-eu-woocommerce-ajax_json";
    public $page_shipment_management = "ups-eu-woocommerce-management";
    public $page_shipment_manager = "ups-eu-woocommerce-manager";
    public $page_about_logs_api = "ups-eu-woocommerce-about-logs-api";
    public $action_export_csv = "ups-eu-woocommerce-export_csv";
    private static $url_current;
    /* Protocol  http, https defined */
    private $upper_https = "HTTPS";
    private $lower_https = "https";
    /* Setup flag in system */
    private $flg_done = 'flg_done';
    private $flg_on = 'flg_on';
    private $flg_off = 'flg_off';
    private $flg_page_previous = 'flg_page_previous';
    private $flg_page_next = 'flg_page_next';
    private $key_db_setting = 'key_db_setting';
    /* Init variable list data roll back */
    private $list_data_rollback;
    public $page_setting = [];


    public function setPageSetting($data) {
        $this->page_setting = $data;
    }
 
    /*
     * Name function: _get_protocal
     * Return: get http or https
     * */

    public function ups_eu_woo_get_protocol()
    {
        if (!empty($_SERVER[$this->upper_https]) &&
            $_SERVER[$this->upper_https] !== 'off' ||
            $_SERVER['SERVER_PORT'] == 443
        ) {
            $protocol = $this->lower_https;
        } else {
            $protocol = "http";
        }
        return $protocol;
    }
    /*
      Name function: __constuct
     * Return: Void
     * */

    public function __construct()
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $check_https = $this->ups_eu_woo_get_protocol();
        /* Setup link url bing map */
        if ($check_https === $this->lower_https) {
            $this->url_api_map_bing_com = "https://www.bing.com/api/maps/mapcontrol";
        } else {
            $this->url_api_map_bing_com = "http://www.bing.com/api/maps/mapcontrol";
        }
        /* Setup url system */
        if ("{$check_https}" === $this->lower_https) {
            $this->url_home = home_url('', $this->lower_https);
        } else {
            $this->url_home = home_url();
        }
        $this->url_configurations = admin_url("admin.php?page={$this->page_configurations}", true);
        $this->url_country = admin_url("admin.php?page={$this->page_country}", true);
        $this->url_terms_conditions = admin_url("admin.php?page={$this->page_terms_conditions}", true);
        $this->url_none_account = admin_url("admin.php?page={$this->page_account}", true) . "&tab=none_account";
        $this->url_account = admin_url("admin.php?page={$this->page_account}", true) . "&tab=success_account";
        $this->url_shipping_service = admin_url("admin.php?page={$this->page_shipping_service}", true);
        $this->url_cod = admin_url("admin.php?page={$this->page_cod}", true);
        $this->url_accessorial_services = admin_url("admin.php?page={$this->page_accessorial_services}", true);
        $this->url_package_dimension = admin_url("admin.php?page={$this->page_package_dimension}", true);
        $this->url_delivery_rate = admin_url("admin.php?page={$this->page_delivery_rate}", true);
        $this->url_billing_preference = admin_url("admin.php?page={$this->page_billing_preference}", true);
        $this->url_ajax_json = admin_url("admin.php?page={$this->page_ajax_json}", true);
        $this->url_shipment_management = admin_url("admin.php?page={$this->page_shipment_management}", true);
        $this->url_shipment_manager = admin_url("admin.php?page={$this->page_shipment_manager}", true);
        $this->url_about_logs_api = admin_url("admin.php?page={$this->page_about_logs_api}", true);
        $this->url_open_orders = admin_url("admin.php?page={$this->page_shipment_manager}", true) . "&tab=open_orders";
        $this->url_shipments = admin_url("admin.php?page={$this->page_shipment_manager}", true) . "&tab=shipments";
        $this->url_archived_orders = admin_url("admin.php?page={$this->page_shipment_manager}", true) . "&tab=archived_orders";
        $this->url_frontend_api_json = home_url("?frontend-ajax-json=ups", true);
        
        /* Setup list  link data roll back */
        $this->list_data_rollback = [
            "{$model_config->ACCEPT_TERM_CONDITION}" => $this->url_country,
            "{$model_config->ACCEPT_ACCOUNT}" => $this->url_terms_conditions,
            "{$model_config->ACCEPT_SHIPPING_SERVICE}" => $this->url_account,
            "{$model_config->ACCEPT_CASH_ON_DELIVERY}" => $this->url_shipping_service,
            // "ACCEPT_ACCESSORIAL" => $this->url_cod,
            "{$model_config->ACCEPT_PACKAGE_DIMENSION}" => $this->url_accessorial_services,
            "{$model_config->ACCEPT_DELIVERY_RATES}" => $this->url_package_dimension,
            "{$model_config->ACCEPT_BILLING_PREFERENCE}" => $this->url_delivery_rate
        ];
        /* Init page setting */
        $this->page_setting = [
            "{$model_config->COUNTRY_CODE}" => [
                // $this->flg_on => 'string',
                $this->flg_done => true,
                $this->flg_off => '0',
                $this->flg_page_previous => false,
                $this->flg_page_next => $model_config->ACCEPT_TERM_CONDITION,
                'url' => $this->url_country
            ],
            "{$model_config->ACCEPT_TERM_CONDITION}" => [
                $this->flg_on => '2',
                $this->flg_done => '1',
                $this->flg_off => '0',
                $this->flg_page_previous => $model_config->COUNTRY_CODE,
                $this->flg_page_next => $model_config->ACCEPT_ACCOUNT_NONE,
                'url' => $this->url_terms_conditions
            ],
            "{$model_config->ACCEPT_ACCOUNT_NONE}" => [
                $this->key_db_setting => $model_config->ACCEPT_ACCOUNT,
                $this->flg_on => '2',
                $this->flg_done => ['1', '3'],
                $this->flg_off => '0',
                $this->flg_page_previous => $model_config->ACCEPT_TERM_CONDITION,
                $this->flg_page_next => $model_config->ACCEPT_ACCOUNT_SUCCESS,
                'url' => $this->url_none_account
            ],
            "{$model_config->ACCEPT_ACCOUNT_SUCCESS}" => [
                $this->key_db_setting => $model_config->ACCEPT_ACCOUNT,
                $this->flg_on => '1',
                $this->flg_done => '3',
                $this->flg_off => '2',
                $this->flg_page_previous => $model_config->ACCEPT_ACCOUNT_NONE,
                $this->flg_page_next => $model_config->ACCEPT_SHIPPING_SERVICE,
                'url' => $this->url_account
            ],
            "{$model_config->ACCEPT_SHIPPING_SERVICE}" => [
                $this->flg_on => '2',
                $this->flg_done => '1',
                $this->flg_off => '0',
                $this->flg_page_previous => $model_config->ACCEPT_ACCOUNT_SUCCESS,
                $this->flg_page_next => $model_config->ACCEPT_CASH_ON_DELIVERY,
                'url' => $this->url_shipping_service
            ],
            "{$model_config->ACCEPT_CASH_ON_DELIVERY}" => [
                $this->flg_on => '2',
                $this->flg_done => '1',
                $this->flg_off => '0',
                $this->flg_page_previous => $model_config->ACCEPT_SHIPPING_SERVICE,
                $this->flg_page_next => $model_config->ACCEPT_PACKAGE_DIMENSION,
                // $this->flg_page_next => 'ACCEPT_ACCESSORIAL',
                'url' => $this->url_cod
            ],
            // "ACCEPT_ACCESSORIAL" => [
            //     $this->flg_on => '2',
            //     $this->flg_done => '1',
            //     $this->flg_off => '0',
            //     $this->flg_page_previous => 'ACCEPT_CASH_ON_DELIVERY',
            //     $this->flg_page_next => 'ACCEPT_PACKAGE_DIMENSION',
            //     'url' => $this->url_accessorial_services
            // ],
            "{$model_config->ACCEPT_PACKAGE_DIMENSION}" => [
                $this->flg_on => '2',
                $this->flg_done => '1',
                $this->flg_off => '0',
                // $this->flg_page_previous => 'ACCEPT_ACCESSORIAL',
                $this->flg_page_previous => $model_config->ACCEPT_CASH_ON_DELIVERY,
                $this->flg_page_next => $model_config->ACCEPT_DELIVERY_RATES,
                'url' => $this->url_package_dimension
            ],
            "{$model_config->ACCEPT_DELIVERY_RATES}" => [
                $this->flg_on => '2',
                $this->flg_done => '1',
                $this->flg_off => '0',
                $this->flg_page_previous => $model_config->ACCEPT_PACKAGE_DIMENSION,
                $this->flg_page_next => $model_config->ACCEPT_BILLING_PREFERENCE,
                'url' => $this->url_delivery_rate,
            ],
            "{$model_config->ACCEPT_BILLING_PREFERENCE}" => [
                $this->flg_on => '2',
                $this->flg_done => '1',
                $this->flg_off => '0',
                $this->flg_page_previous => $model_config->ACCEPT_DELIVERY_RATES,
                $this->flg_page_next => false,
                'url' => $this->url_billing_preference,
            ]
        ];
        /* Init url router */
        $this->url_router = [
            'url_home' => $this->url_home,
            'url_country' => $this->url_country,
            'url_terms_conditions' => $this->url_terms_conditions,
            'url_none_account' => $this->url_none_account,
            'url_account' => $this->url_account,
            'url_shipping_service' => $this->url_shipping_service,
            'url_cod' => $this->url_cod,
            'url_accessorial_services' => $this->url_accessorial_services,
            'url_package_dimension' => $this->url_package_dimension,
            'url_delivery_rate' => $this->url_delivery_rate,
            'url_billing_preference' => $this->url_billing_preference,
            'url_ajax_json' => $this->url_ajax_json,
            'url_open_orders' => $this->url_open_orders,
            'url_archived_orders' => $this->url_archived_orders
        ];
    }

    /**
     * ups_eu_woo_permission_url : check permission access by setting page
     * */
    public function ups_eu_woo_permission_url($key, $flg_reconfig = true)
    {
        $key_db_setting = $this->ups_eu_woo_get_key_db_setting($key);
        $page_setting = $this->page_setting[$key];
        /*
         * Back to previous page if it not alrealy done
         */

        $this->ups_eu_woo_check_back_link_accepted($key);

        /*
         * If current page had configured, refirect to next page config
         */
        if ($flg_reconfig === false) {
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            if ($model_config->ups_eu_woo_get_by_key($key_db_setting) === true) {
                $flg_config = $model_config->value;
            } else {
                $flg_config = $page_setting[$this->flg_off];
            }
            $flag_done = $page_setting[$this->flg_done];
            $is_done = (is_array($flag_done) &&
                in_array($model_config->value, $flag_done)) || ($model_config->value == $flag_done);

            if (($page_setting[$this->flg_done] === true && $flg_config != $page_setting[$this->flg_off]) || $is_done) {
                $key_next = $this->page_setting[$key][$this->flg_page_next];
                $this->ups_eu_woo_redirect($this->page_setting[$key_next]['url']);
            }
        }
    }

    /**
     * getKey
     * */
    private function ups_eu_woo_get_key_db_setting($key)
    {
        $key_db_setting = false;
        if ($key != '' && array_key_exists($key, $this->page_setting)) {
            if (array_key_exists($this->key_db_setting, $this->page_setting[$key])) {
                $key_db_setting = $this->page_setting[$key][$this->key_db_setting];
            } else {
                $key_db_setting = $key;
            }
        }
        return $key_db_setting;
    }

    /**
     * ups_eu_woo_check_back_link_accepted
     * */
    public function ups_eu_woo_check_back_link_accepted($key)
    {
        $key_previous = $this->page_setting[$key][$this->flg_page_previous];
        // Use for step page is country, not check previous page
        if ($key_previous !== false) {
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            $check = false;
            $url_redirect = "";
            $key_previous = $this->page_setting[$key][$this->flg_page_previous];
            $has_flg_on = false;
            if (array_key_exists($this->flg_on, $this->page_setting[$key])) {
                $has_flg_on = $this->page_setting[$key][$this->flg_on];
            }

            // Check by flg of previous page
            if ($has_flg_on != false) {
                $key_previous_db_setting = $this->ups_eu_woo_get_key_db_setting($key);
                $url_redirect = $this->page_setting[$key_previous]['url'];
                // Check setting config of previous page
                if ($model_config->ups_eu_woo_get_by_key("{$key_previous_db_setting}") === true) {
                    // Check if flag previous page config was'nt on, redirect back it
                    $flag_done = $this->page_setting[$key][$this->flg_done];
                    $flag_on = $this->page_setting[$key][$this->flg_on];
                    $is_done = (is_array($flag_done) &&
                        in_array($model_config->value, $flag_done)) || ($model_config->value == $flag_done);

                    if ($model_config->value == $flag_on || $is_done) {
                        $check = true;
                    }
                }
            } else {
                $check = true;
            }

            // Redirect to previous page config
            if (!$check) {
                $this->ups_eu_woo_redirect($url_redirect);
            }
        }
    }
    /*
     * Name function: ups_eu_woo_get_key_previous
     * Params:
     *  @key: type string
     * Return: get string
     * * */

    private function ups_eu_woo_get_key_previous($key)
    {
    }
    /*
     * Name function: redirect
     * Params:
     *  @url_link: type string
     * Return: redirect to url_link
     *
     * * */

    public function ups_eu_woo_redirect($url_link)
    {
        wp_redirect("{$url_link}");
    }
    /*
     * Name function: ups_eu_woo_check_method_post
     * Params: empty
     * Return: type boolean
     *     * */

    public function ups_eu_woo_check_method_post()
    {
        $result = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = true;
        }
        return $result;
    }
    /*
     * Name function: ups_eu_woo_rollback_link
     * Params:
     *  @key: type string
     * Return: void
     * * */

    public function ups_eu_woo_rollback_link($key)
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        if ($model_config->ups_eu_woo_get_by_key("{$key}") === true && (intval($model_config->value) !== 2) && (intval($model_config->value) !== 1)) {
            $this->ups_eu_woo_redirect($this->page_setting[$key]['back']);
        }
    }
    /*
     * Name funciton: ups_eu_woo_get_number_block_show
     * Params:
     *  @page: type string
     *  @index: type int
     * Return: type int
     * * */

    public function ups_eu_woo_get_number_block_show($page, $index = 7)
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->ACCEPT_BILLING_PREFERENCE}") === true && (intval($model_config->value) === 1 || intval($model_config->value) === 2)) {
            return 7;
        }
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->ACCEPT_DELIVERY_RATES}") === true && (intval($model_config->value) === 1 || intval($model_config->value) === 2)) {
            return 6;
        }
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->ACCEPT_PACKAGE_DIMENSION}") === true && (intval($model_config->value) === 1 || intval($model_config->value) === 2)) {
            return 5;
        }
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->ACCEPT_ACCESSORIAL}") === true && (intval($model_config->value) === 1 || intval($model_config->value) === 2)) {
            return 4;
        }
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->ACCEPT_CASH_ON_DELIVERY}") === true && (intval($model_config->value) === 1 || intval($model_config->value) === 2)) {
            return 3;
        }
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->ACCEPT_SHIPPING_SERVICE}") === true && (intval($model_config->value) === 1 || intval($model_config->value) === 2)) {
            return 2;
        }
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->ACCEPT_ACCOUNT}") === true && (intval($model_config->value) === 1)) {
            return 1;
        }

        return $index;
    }
    /*
     * Name function: ups_eu_woo_get_all_link_form
     * Params: empty
     * Return: type object
     * * */

    public function ups_eu_woo_get_all_link_form()
    {
        $objectLink = new \stdClass();
        foreach ($this->url_router as $key => $value) {
            $objectLink->{$key} = $value;
        }
        return $objectLink;
    }
    /*
     * Name function: ups_eu_woo_current_location
     * Params: Empty
     * Return: type string
     * * */

    public function ups_eu_woo_current_location()
    {
        if (empty(self::$url_current)) {
            if (isset($_SERVER[$this->upper_https]) && ($_SERVER[$this->upper_https] == 'on' || $_SERVER[$this->upper_https] == 1)) {
                $protocol = 'https://';
            } else {
                if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == $this->lower_https) {
                    $protocol = 'https://';
                } else {
                    $protocol = 'http://';
                }
            }
            self::$url_current = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }
        return self::$url_current;
    }

    /*
     * Name function: ups_eu_woo_current_location
     * Params: Empty
     * Return: type string
     * * */

    public function ups_eu_woo_redirect_not_found_page()
    {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ./404.php");
    }
}
