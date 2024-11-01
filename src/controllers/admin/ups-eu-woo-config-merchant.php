<?php namespace UpsEuWoocommerce\controllers\admin;

/**
 * _USER_TECHNICAL_AGREEMENT
 *
 * @category  ups-shipping-for-woocommerce
 * @package   UPS Shipping and UPS Access Point™ : Official Plugin For WooCommerce
 * @author      United Parcel Service of America, Inc. <noreply@ups.com>
 * @copyright   (c) 2019, United Parcel Service of America, Inc., all rights reserved
 * @link        https://www.ups.com/pl/en/services/technology-integration/ecommerce-plugins.page
 *
 * _LICENSE_TAG
 *
 * ups-eu-woo-config-merchantcf.php - The core plugin class.
 *
 * This is used to handle the controller, model and content of pages in current plugin.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_MerchantCf');

class Ups_Eu_Woo_MerchantCf
{
    /* Init  properties fields */

    private $list_form_container = [
        "#container_form_account#",
        "#container_form_shipping_service#",
        "#container_form_cod#",
        "#container_form_accessorial_services#",
        "#container_form_package_dimension#",
        "#container_form_delivery_rate#",
        "#container_form_billing_preference#"
    ];
    /* List forms main in shipment manager */
    private $list_form_sm = [
        "@#open_orders_active#@",
        "@#open_orders_content#@",
        "@#shipments_active#@",
        "@#shipments_content#@",
        "@#archived_orders_active#@",
        "@#archived_orders_content#@",
    ];
    private $shipments = 'shipments';
    private $archived_orders = 'archived_orders';
    private $active = 'active';
    private $order_path = "admin/merchant_cf/orders.tpl";
    private $shipping_config_path = "admin/merchant_cf/shipping_config/shipping_config.tpl";

    /**
     * arr Release
     * pl, gb, fr, de, es, it, nl, be, us
     */
    const release = ['pl', 'fr', 'gb', 'de', 'es', 'it', 'nl', 'be', 'us', 'at', 'bg', 'hr', 'cy', 'cz', 'dk', 'ee', 'fi', 'gr', 'hu', 'ie', 'lv', 'lt', 'lu', 'mt', 'pt',  'ro', 'sk', 'si', 'se', 'no', 'rs', 'ch', 'is', 'je', 'tr'];

    /**
     * Name function: ups_eu_woo_load_css_js
     * Params: empty
     * Return: type void
     */
    private function ups_eu_woo_load_css_js()
    {
//        /* Load file js */
//        wp_enqueue_script('ups-eu-woocommerce-popper');
//        wp_enqueue_script('ups-eu-woocommerce-boostrap');
//        wp_enqueue_script('ups-eu-woocommerce');
//        wp_enqueue_script('jquery-validation');
//        wp_enqueue_script("ups-eu-woocommerce_datepicker");
//        /* Load file css */
//        wp_enqueue_style("ups-eu-woocommerce-boostrap");
//        wp_enqueue_style("ups-eu-woocommerce");
//        wp_enqueue_style("ups-eu-woocommerce-fontawesome");
//        wp_enqueue_style("'ups-eu-woocommerce_datepicker");
    }

    /**
     * Name function: ups_eu_woo_ajax_json
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_ajax_json()
    {
        /* Clear all */
        ob_end_clean();
        $ajaxJson = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Ajax_Json();
        $response = $ajaxJson->ups_eu_woo_processing();
        /* Send type json */
        wp_send_json($response);
    }

    /**
     * Name function: ups_eu_woo_dont_had_permission
     * Params: empty
     * Return: type void
     */
    private function ups_eu_woo_dont_had_permission($tmpArray = [])
    {

        $obj_smarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $smarty = $obj_smarty->ups_eu_woo_get_smarty();
        /* Assigned data to view smarty */
        $smarty->assign($obj_smarty->dataObject, [
            "message" => __("You do not have permission access the page this", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            "title_ups_shipping" => __("UPS Shipping", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain)
        ]);
        /* Show smarty */
        echo $smarty->fetch("admin/merchant_cf/dont_permission.tpl");
    }

    /**
     * Name function: ups_eu_woo_country
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_country()
    {
        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();
        if ($roles_capabilities->check_permision_module_settings() == true) {
            $check_status = $this->preCheck();
            if($check_status){
                /* Loadd all class or models */
                $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
                /* Load css and js */
                $this->ups_eu_woo_load_css_js();
                /* Check permission accept link */
                $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
                $router_url->ups_eu_woo_permission_url($model_config->COUNTRY_CODE, false);
                /* Load controller */
                $controler = new \UpsEuWoocommerce\controllers\admin\Ups_Eu_Woo_Config_Country();
                $dataObject = $controler->ups_eu_woo_config_country();
                /* Load smarty */
                $obj_smarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
                $smarty = $obj_smarty->ups_eu_woo_get_smarty();
                /* Assigned data to view smarty */
                $smarty->assign($obj_smarty->dataObject, $dataObject);
                /* Show smarty */
                echo $smarty->fetch("admin/merchant_cf/shipping_config/country.tpl");
                return;
            }
            return;
        } else {
            $this->ups_eu_woo_dont_had_permission();
        }
    }

    public function preCheck() {
        $no_error = true;

        //SSL INFO
        $ssl_info = '<span class="dashicons dashicons-yes-alt" style="color:green;"></span>';
        if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
           $ssl_info = '<span class="dashicons dashicons-dismiss" style="color:red;"></span>';
           $no_error = false;
        }
        //MAINTAINACE INFO
        $maintainance_info = '<span class="dashicons dashicons-yes-alt" style="color:green;"></span>';
        if (function_exists("wp_is_maintenance_mode") && wp_is_maintenance_mode()) {
            $maintainance_info = '<span class="dashicons dashicons-dismiss" style="color:red;"></span>';
            $no_error = false;
        }
        //URL CHECK
        $url_check_info_1 = 'https://fa-ecptools-prd.azurewebsites.net';
        $url_check_info_2 = 'https://onlinetools.ups.com/';
        $url_check_info_3 = 'https://fa-ecpanalytics-prd.azurewebsites.net';
        $res1 = $this->ProcessCurl($url_check_info_1);
        $res2 = $this->ProcessCurl($url_check_info_2);
        $res3 = $this->ProcessCurl($url_check_info_3);
        
        if ($res1 != '200') {
            $no_error = false;
            $url_check_info_1 = '<i class="icon-check-circle" style="color: red;"></i>';
            
        } else {
            $url_check_info_1 = '<span class="dashicons dashicons-yes-alt" style="color:green;"></span>';
        }

        if ($res1 != '200') {
            $url_check_info_2 = '<i class="icon-check-circle" style="color: red;"></i>';
            $no_error = false;
        } else {
            $url_check_info_2 = '<span class="dashicons dashicons-yes-alt" style="color:green;"></span>';
        }

        if ($res1 != '200') {
            $url_check_info_3 = '<i class="icon-check-circle" style="color: red;"></i>';
            $no_error = false;
        } else {
            $url_check_info_3 = '<span class="dashicons dashicons-yes-alt" style="color:green;"></span>';
        }
        
       if(!$no_error) {
        /* Load css and js */
        $this->ups_eu_woo_load_css_js();
       
        $obj_smarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $smarty = $obj_smarty->ups_eu_woo_get_smarty();
        $dataObject = new \stdClass();
        $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();

        $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
            $UpsEuWoocommerceSmarty->lang_page_shipments
        );
        
        $dataObject->ssl = $ssl_info;
        $dataObject->maintainance = $maintainance_info;
        $dataObject->url1 = $url_check_info_1;
        $dataObject->url2 = $url_check_info_2;
        $dataObject->url3 = $url_check_info_3;
        /* Assigned data to view smarty */
        $smarty->assign($obj_smarty->dataObject, $dataObject);
        /* Show smarty */
        echo $smarty->fetch("admin/merchant_cf/shipping_config/precheck_status.tpl");
        return $no_error;
       }
       return $no_error;
    }

    //Process Curl for UPS Links
    public function ProcessCurl($url_check_info) {
        $response = wp_remote_get( $url_check_info,
            array(
                'timeout'     => 120,
                'httpversion' => '1.1',
            )
        );
        $response_code =  wp_remote_retrieve_response_code( $response );
        if($response_code == ''){
            $response_code = '404';
        }
        return $response_code;
    }

    /**
     * Name function: ups_eu_woo_terms_conditions
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_terms_conditions()
    {
        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();
        if ($roles_capabilities->check_permision_module_settings() == true) {
            /* Load config system */
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            /* Load js and css */
            $this->ups_eu_woo_load_css_js();
            /* Check permmision accepted link */
            $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
            $router_url->ups_eu_woo_permission_url($model_config->ACCEPT_TERM_CONDITION, false);
            /* Load controller */
            $controler = new \UpsEuWoocommerce\controllers\admin\Ups_Eu_Woo_Config_Terms_Condition();
            /* get data from controller */
            $dataObject = $controler->ups_eu_woo_config_terms_conditions();
            /* Load smarty */
            $obj_smarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
            $smarty = $obj_smarty->ups_eu_woo_get_smarty();
            /* Assinged data to view smarty */
            $smarty->assign($obj_smarty->dataObject, $dataObject);
            echo $smarty->fetch("admin/merchant_cf/shipping_config/terms_conditions.tpl");
            return;
        } else {
            $this->ups_eu_woo_dont_had_permission();
        }
    }

    /**
     * Name function: ups_eu_woo_none_account
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_none_account()
    {
        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();
        if ($roles_capabilities->check_permision_module_settings() == true) {
            /* Load models config system */
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            /* Load file css and js */
            $this->ups_eu_woo_load_css_js();
            /* Check permmision access by link */
            $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
            $router_url->ups_eu_woo_permission_url($model_config->ACCEPT_ACCOUNT_NONE, false);
            /* Load controller */
            $controler = new \UpsEuWoocommerce\controllers\admin\Ups_Eu_Woo_Config_Account();
            /* Get data from controller */
            $dataObject = $controler->ups_eu_woo_config_none_account();
            /* Use smarty render view */
            $obj_smarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
            $smarty = $obj_smarty->ups_eu_woo_get_smarty();

            $smarty->assign($obj_smarty->dataObject, $dataObject);
            echo $smarty->fetch("admin/merchant_cf/shipping_config/none_account.tpl");
            return;
        } else {
            $this->ups_eu_woo_dont_had_permission();
        }
    }

    /**
     * Name function: ups_eu_woo_success_account
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_success_account()
    {
        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();
        if ($roles_capabilities->check_permision_module_settings() == true) {
            /* Load models */
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            $this->ups_eu_woo_load_css_js();
            //Permission access link
            $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
            $router_url->ups_eu_woo_permission_url($model_config->ACCEPT_ACCOUNT_SUCCESS);

            $controler = new \UpsEuWoocommerce\controllers\admin\Ups_Eu_Woo_Config_Account();
            $dataObject = $controler->ups_eu_woo_config_account();

            $obj_smarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
            $smarty = $obj_smarty->ups_eu_woo_get_smarty();

            $smarty->assign($obj_smarty->dataObject, $dataObject);
            $html_form = $smarty->fetch("admin/merchant_cf/shipping_config/forms/account.tpl");
            $page_shipping_config_html = $smarty->fetch($this->shipping_config_path);
            echo str_replace(
                $this->list_form_container,
                ["{$html_form} ", "", "", "", "", "", ""],
                $page_shipping_config_html
            );

            return;
        } else {
            $this->ups_eu_woo_dont_had_permission();
        }
    }

    /**
     * Name function: ups_eu_woo_account
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_account()
    {
        $tab = 'none_account';
        if (isset($_REQUEST['tab'])) {
            $tab = $_REQUEST['tab'];
        }
        switch ($tab) {
            case 'success_account':
                $this->ups_eu_woo_success_account();
                break;
            default:
                $this->ups_eu_woo_none_account();
                break;
        }
    }

    /**
     * Name function: ups_eu_woo_shipping_service
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_shipping_service()
    {
        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();
        if ($roles_capabilities->check_permision_module_settings() == true) {
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            $this->ups_eu_woo_load_css_js();
            //Permission access link
            $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
            $router_url->ups_eu_woo_permission_url($model_config->ACCEPT_SHIPPING_SERVICE);

            $controler = new \UpsEuWoocommerce\controllers\admin\Ups_Eu_Woo_Config_Shipping_Service();
            $dataObject = $controler->ups_eu_woo_config_shipping_service();

            $obj_smarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
            $smarty = $obj_smarty->ups_eu_woo_get_smarty();

            $smarty->assign($obj_smarty->dataObject, $dataObject);
            $html_form = $smarty->fetch("admin/merchant_cf/shipping_config/forms/shipping_service.tpl");
            $page_shipping_config_html = $smarty->fetch($this->shipping_config_path);
            echo str_replace(
                $this->list_form_container,
                ["", "{$html_form} ", "", "", "", "", ""],
                $page_shipping_config_html
            );
            return;
        } else {
            $this->ups_eu_woo_dont_had_permission();
        }
    }

    /**
     * Name function: ups_eu_woo_cod
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_cod()
    {
        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();
        if ($roles_capabilities->check_permision_module_settings() == true) {
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            $this->ups_eu_woo_load_css_js();
            //Permission access link
            $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
            $router_url->ups_eu_woo_permission_url($model_config->ACCEPT_CASH_ON_DELIVERY);

            // Call controller processing
            $controler = new \UpsEuWoocommerce\controllers\admin\Ups_Eu_Woo_Config_Cash_On_Delivery();
            $dataObject = $controler->ups_eu_woo_config_cod();
            
            // Get smarty
            $obj_smarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
            $smarty = $obj_smarty->ups_eu_woo_get_smarty();

            // Push data to template
            $smarty->assign($obj_smarty->dataObject, $dataObject);
            $html_form = $smarty->fetch("admin/merchant_cf/shipping_config/forms/cod.tpl");
            $page_shipping_config_html = $smarty->fetch($this->shipping_config_path);
            echo str_replace(
                $this->list_form_container,
                ["", "", "{$html_form} ", "", "", "", ""],
                $page_shipping_config_html
            );
            return;
        } else {
            $this->ups_eu_woo_dont_had_permission();
        }
    }

    /**
     * Name function: ups_eu_woo_accessorial_services
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_accessorial_services()
    {
        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();
        if ($roles_capabilities->check_permision_module_settings() == true) {
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            $this->ups_eu_woo_load_css_js();
            /* Permission access link */
            $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
            $router_url->ups_eu_woo_permission_url($model_config->ACCEPT_ACCESSORIAL);

            /* Call controller processing */
            $controler = new \UpsEuWoocommerce\controllers\admin\Ups_Eu_Woo_Config_Accessorial_Service();
            $dataObject = $controler->ups_eu_woo_config_accessorial_services();

            /* Get smarty */
            $obj_smarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
            $smarty = $obj_smarty->ups_eu_woo_get_smarty();

            /* Push data to template */
            $smarty->assign($obj_smarty->dataObject, $dataObject);
            $html_form = $smarty->fetch("admin/merchant_cf/shipping_config/forms/accessorial_services.tpl");
            $page_shipping_config_html = $smarty->fetch($this->shipping_config_path);

            echo str_replace(
                $this->list_form_container,
                ["", "", "", "{$html_form} ", "", "", ""],
                $page_shipping_config_html
            );
            return;
        } else {
            $this->ups_eu_woo_dont_had_permission();
        }
    }

    /**
     * Name function: ups_eu_woo_package_dimension
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_package_dimension()
    {
        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();
        if ($roles_capabilities->check_permision_module_settings() == true) {
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            $this->ups_eu_woo_load_css_js();
            /* Permission access link */
            $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
            $router_url->ups_eu_woo_permission_url($model_config->ACCEPT_PACKAGE_DIMENSION);

            /* Call controller processing */
            $controler = new \UpsEuWoocommerce\controllers\admin\Ups_Eu_Woo_Config_Package_Dimension();
            $dataObject = $controler->ups_eu_woo_config_package_dimension();

            $obj_smarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
            $smarty = $obj_smarty->ups_eu_woo_get_smarty();

            $smarty->assign($obj_smarty->dataObject, $dataObject);
            $html_form = $smarty->fetch("admin/merchant_cf/shipping_config/forms/package_dimension.tpl");
            $page_shipping_config_html = $smarty->fetch($this->shipping_config_path);
            echo str_replace(
                $this->list_form_container,
                ["", "", "", "", "{$html_form} ", "", ""],
                $page_shipping_config_html
            );
            return;
        } else {
            $this->ups_eu_woo_dont_had_permission();
        }
    }

    /**
     * Name function: ups_eu_woo_delivery_rate
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_delivery_rate()
    {
        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();
        if ($roles_capabilities->check_permision_module_settings() == true) {
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            $this->ups_eu_woo_load_css_js();
            /* Permission access link */
            $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
            $router_url->ups_eu_woo_permission_url($model_config->ACCEPT_DELIVERY_RATES);

            /* Call controller processing */
            $controler = new \UpsEuWoocommerce\controllers\admin\Ups_Eu_Woo_Config_Delivery_Rate();
            $dataObject = $controler->ups_eu_woo_config_delivery_rate();

            $obj_smarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
            $smarty = $obj_smarty->ups_eu_woo_get_smarty();

            $smarty->assign($obj_smarty->dataObject, $dataObject);
            $html_form = $smarty->fetch("admin/merchant_cf/shipping_config/forms/delivery_rate.tpl");
            $page_shipping_config_html = $smarty->fetch($this->shipping_config_path);
            echo str_replace(
                $this->list_form_container,
                ["", "", "", "", "", "{$html_form} ", ""],
                $page_shipping_config_html
            );
            return;
        } else {
            $this->ups_eu_woo_dont_had_permission();
        }
    }

    /**
     * Name function: ups_eu_woo_billing_preference
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_billing_preference()
    {
        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();
        if ($roles_capabilities->check_permision_module_settings() == true) {
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            $this->ups_eu_woo_load_css_js();
            /* Permission access link */
            $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
            $router_url->ups_eu_woo_permission_url($model_config->ACCEPT_BILLING_PREFERENCE);

            /* Call controller processing */
            $controler = new \UpsEuWoocommerce\controllers\admin\Ups_Eu_Woo_Config_Billing_Preference();
            $dataObject = $controler->ups_eu_woo_config_billing_preference();
            $dataObject->plugin_url_ups = \UpsEuWoocommerce\Ups_Eu_Woo_Main::ups_eu_woo_plugin_url_ups();

            $obj_smarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
            $smarty = $obj_smarty->ups_eu_woo_get_smarty();

            $smarty->assign($obj_smarty->dataObject, $dataObject);
            $html_form = $smarty->fetch("admin/merchant_cf/shipping_config/forms/billing_preference.tpl");
            $page_shipping_config_html = $smarty->fetch($this->shipping_config_path);
            echo str_replace(
                $this->list_form_container,
                ["", "", "", "", "", "", "{$html_form}"],
                $page_shipping_config_html
            );
            return;
        } else {
            $this->ups_eu_woo_dont_had_permission();
        }
    }

    /**
     * Name function: ups_eu_woo_shipment_managements
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_shipment_managements()
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();
        if ($roles_capabilities->check_permision_shipments() == true) {
            $tab = 'open_orders';
            if (isset($_REQUEST['tab'])) {
                $tab = $_REQUEST['tab'];
            }
            switch ($tab) {
                /* load shipment content */
                case $this->shipments:
                    $this->ups_eu_woo_shipments();
                    break;
                /* load archived order content */
                case $this->archived_orders:
                    $this->ups_eu_woo_archived_orders();
                    break;
                default:
                    call_user_func_array([
                        new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Manage_Api_Ups()
                        , "ups_eu_woo_upgrade_plugin_version"
                    ], []);
                    if ($tab !== 'open_orders') {
                        $router_url->ups_eu_woo_redirect_not_found_page();
                    }
                    /* load javascript and css library */
                    $this->ups_eu_woo_load_css_js();

                    $controler = new \UpsEuWoocommerce\controllers\admin\Ups_Eu_Woo_Shipment_Open_Order();
                    /* load open order content */
                    $dataObject = $controler->ups_eu_woo_open_orders();

                    $obj_smarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
                    $smarty = $obj_smarty->ups_eu_woo_get_smarty();

                    $smarty->assign($obj_smarty->dataObject, $dataObject);
                    $html_form = $smarty->fetch("admin/merchant_cf/orders/open.tpl");
                    $page_order = $smarty->fetch($this->order_path);
                    echo str_replace(
                        $this->list_form_sm,
                        [$this->active, "{$html_form}", "", "", "", ""],
                        $page_order
                    );
                    return;
            }
        } else {
            $this->ups_eu_woo_dont_had_permission();
        }
    }

    /**
     * Name function: ups_eu_woo_export_csv
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_export_csv()
    {
        $controler = new \UpsEuWoocommerce\controllers\admin\Ups_Eu_Woo_Shipment_Open_Order();
        $dataObject = $controler->ups_eu_woo_config_export_csv();
    }

    /**
     * Name function: shipments
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_shipments()
    {
        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();
        if ($roles_capabilities->check_permision_shipments() == true) {
            $this->ups_eu_woo_load_css_js();
            $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
            $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
            $ups_pagination = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Ups_Pagination();
            $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();

            $dataObject = new \stdClass();
            /* get language by key */
            $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
                $UpsEuWoocommerceSmarty->lang_page_shipments
            );
            $dataObject->router_url = $router_url;
            $dataObject->pagination = $ups_pagination->ups_eu_woo_build_lists('shipment');
            $dataObject->title = 'shipments';
            $dataObject->action_form = $router_url->url_shipments;
            /* check method post */
            if ($router_url->ups_eu_woo_check_method_post() === true) {
                $btn_controller = "";
                if (!empty($_REQUEST[$router_url->btn_controller])) {
                    $btn_controller = trim(sanitize_text_field(strip_tags($_REQUEST[$router_url->btn_controller])));
                }
                /* Get param */
                $checked_ids = "";
                if (array_key_exists($router_url->textbox_checked_ids, $_REQUEST)) {
                    $checked_ids = $_REQUEST[$router_url->textbox_checked_ids];
                }
                $tracking_ids = "";
                if (array_key_exists($router_url->textbox_tracking_ids, $_REQUEST)) {
                    $tracking_ids = $_REQUEST[$router_url->textbox_tracking_ids];
                }
                $label_option = "";
                if (array_key_exists($router_url->label_option, $_REQUEST)) {
                    $label_option = $_REQUEST[$router_url->label_option];
                }

                $this->ups_eu_woo_print_label_csv($btn_controller, $checked_ids, $tracking_ids, $label_option);
            }
            $dataObject->label_err = get_option("ups_offi_label_status", "");
            delete_option("ups_offi_label_status");
            $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
            $html_form = $smarty->fetch("admin/merchant_cf/orders/shipments.tpl");
            $page_order = $smarty->fetch($this->order_path);
            echo str_replace($this->list_form_sm, ["", "", $this->active, "{$html_form}", "", ""], $page_order);
            return;
        } else {
            $this->ups_eu_woo_dont_had_permission();
        }
    }

    /**
     * Name function: ups_eu_woo_print_label_csv
     * Params:
     * @btn_controller: type string
     * @checked_ids: type string
     * @tracking_ids: type string
     * @label_option: type string
     * Return: type void
     */
    private function ups_eu_woo_print_label_csv($btn_controller, $checked_ids, $tracking_ids, $label_option)
    {
        if ($btn_controller && $checked_ids) {
            switch ($btn_controller) {
                /* exe export shipment */
                case "export-shipments-csv":
                    $this->ups_eu_woo_export_shipment_csv($tracking_ids);
                    break;
                /* exe print label */
                case "print-label":
                    $contrl_billing_preference = new Ups_Eu_Woo_Config_Billing_Preference();
                    $contrl_billing_preference->ups_eu_woo_config_print_label($checked_ids, $label_option);
                    break;
                default:
                    break;
            }
        }
    }

    /**
     * Name function: ups_eu_woo_config_unlink_file
     * Params:
     * @link: type string
     * Return: type void
     */
    public function ups_eu_woo_config_unlink_file($link)
    {
        /* Check file existing */
        if (file_exists($link)) {
            /* Remove file */
            unlink($link);
        }
    }

    /**
     * Name function: ups_eu_woo_export_shipment_csv
     * Params:
     * @str_list_tracking_id: type string
     * Return: type void
     */
    private function ups_eu_woo_export_shipment_csv($str_list_tracking_id)
    {
        $model_shipment_open_order = new Ups_Eu_Woo_Shipment_Open_Order();
        $model_shipment_open_order->ups_eu_woo_config_export_shipment_csv($str_list_tracking_id);
    }

    /**
     * Name function: ups_eu_woo_archived_orders
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_archived_orders()
    {
        $roles_capabilities = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Roles_Capabilities_Entity();

        /* Load models class */
        $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
        $router_url   = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        /* submit form */
        if ($router_url->ups_eu_woo_check_method_post() === true) {
            $ids_archived = explode(',', $_REQUEST['id_archived']);
            if (! empty($ids_archived) && $ids_archived[0] != '') {
                $model_orders->ups_eu_woo_set_to_comback_archive_order($ids_archived);
                return;
            }
        }

        if ($roles_capabilities->check_permision_shipments() == true) {
            $this->ups_eu_woo_load_css_js();
            $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
            $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
            $ups_pagination = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Ups_Pagination();
            $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();

            $dataObject = new \stdClass();
            $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
                $UpsEuWoocommerceSmarty->lang_page_archived_orders
            );
            $dataObject->router_url = $router_url;
            $dataObject->pagination = $ups_pagination->ups_eu_woo_build_lists('archived_order');
            $dataObject->title = $this->archived_orders;
            $dataObject->action_form = $router_url->url_archived_orders;

            $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
            $html_form  = $smarty->fetch("admin/merchant_cf/orders/archived.tpl");
            $page_order = $smarty->fetch($this->order_path);
            echo str_replace($this->list_form_sm, ["", "", "", "", $this->active, "{$html_form}"], $page_order);
            return;
        } else {
            $this->ups_eu_woo_dont_had_permission();
        }
    }

    /**
     * Name function: ups_eu_woo_about_logs_api
     * Params: empty
     * Return: type void
     */
    public function ups_eu_woo_about_logs_api()
    {
        $this->ups_eu_woo_load_css_js();
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $ups_pagination = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Ups_Pagination();
        $model_logs_api = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();
        $model_config   = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();

        /* Get contry_code */
        $model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE);

        /* set country_code value */
        if (! empty($model_config->value)) {
            $country_code = $model_config->value;
        } else {
            $country_code = "GB";
        }

        $languagesCur = get_bloginfo("language");

        $arrLanguages = [
            'pl-PL' => 'pl',
            'en-GB' => 'gb',
            'de-DE' => 'de',
            'en-ES' => 'es',
            'es'    => 'es',
            'fr-FR' => 'fr',
            'it-IT' => 'it',
            'nl-NL' => 'nl',
            'nl'    => 'nl',
            'en-BE' => 'gb',
            'fr-BE' => 'fr',
            'nl-BE' => 'nl',
            'en-AT' => 'at',
            'en-AT' => 'at',
            'en-BG' => 'bg',
            'en-HR' => 'hr',
            'en-CY' => 'cy',
            'en-CZ' => 'cz',
            'en-DK' => 'dk',
            'en-EE' => 'ee',
            'en-FI' => 'fi',
            'en-GR' => 'gr',
            'en-HU' => 'hu',
            'en-IE' => 'ie',
            'en-PT' => 'pt',
            'en-LV' => 'lv',
            'en-LT' => 'lt',
            'en-LU' => 'lu',
            'en-MT' => 'mt',
            'en-RO' => 'ro',
            'en-SK' => 'sk',
            'en-SI' => 'si',
            'en-SE' => 'se',
            'en-NO' => 'no',
            'en-RS' => 'rs',
            'en-CH' => 'ch',
            'en-IS' => 'is',
            'en-JE' => 'je',
            'en-TR' => 'tr',
        ];

        $arrTextShow = [
            'be' => __("Belgium", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'fr' => __("France", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'de' => __("Germany", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'it' => __("Italy", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'nl' => __("Netherlands", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'pl' => __("Poland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'es' => __("Spain", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'gb' => __("United Kingdom", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'at' => __("Austria", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            // 'bg' => __("Bulgaria", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            // 'hr' => __("Croatia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
            // 'cy' => __("Cyprus", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
            'cz' => __("CzechRepublic", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
            'dk' => __("Denmark", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
          //  'ee' => __("Estonia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
            'fi' => __("Finland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
            'gr' => __("Greece", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
            'hu' => __("Hungary", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
            'ie' => __("Ireland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
           // 'lv' => __("Latvia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
           // 'lt' => __("Lithuania", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
            'lu' => __("Luxembourg", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
           // 'mt' => __("Malta", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
            'pt' => __("Portugal", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),  
            'ro' => __("Romania", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
           // 'sk' => __("Slovakia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
            'si' => __("Slovenia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
            'se' => __("Sweden", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'no' => __("Norway", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
           // 'rs' => __("Serbia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
            'ch' => __("Switzerland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            'is' => __("Iceland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
            'je' => __("Jersey", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain), 
            'tr' => __("Turkey", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain)
        ];

        $arrPhone = [
            'be' => '<li>'. __("Belgium:", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +32 78 48 49 16</li>',
            'fr' => '<li>'. __("France:", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +33 805 11 96 92</li>',
            'de' => '<li>'. __("Germany:", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>',
            'it' => '<li>'. __("Italy:", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +39 800 725 920</li>',
            'nl' => '<li>'. __("Netherlands:", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +31 85 107 0232</li>',
            'pl' => '<li>'. __("Poland:", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +48 22 103 24 55</li>',
            'es' => '<li>'. __("Spain:", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +34 518 90 05 99</li>',
            'gb' => '<li>'. __("United Kingdom:", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +44 808 258 0323</li>',
            'at' => '<li>'. __("Austria:", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>',
            //'bg' => '<li>'. __("Bulgaria", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>',
           // 'hr' => '<li>'. __("Croatia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
           // 'cy' => '<li>'. __("Cyprus", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
            'cz' => '<li>'. __("CzechRepublic", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
            'dk' => '<li>'. __("Denmark", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
            //'ee' => '<li>'. __("Estonia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
            'fi' => '<li>'. __("Finland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
            'gr' => '<li>'. __("Greece", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
            'hu' => '<li>'. __("Hungary", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
            'ie' => '<li>'. __("Ireland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
           // 'lv' => '<li>'. __("Latvia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
           // 'lt' => '<li>'. __("Lithuania", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
            'lu' => '<li>'. __("Luxembourg", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
           // 'mt' => '<li>'. __("Malta", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
            'pt' => '<li>'. __("Portugal", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>',  
            'ro' => '<li>'. __("Romania", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
           // 'sk' => '<li>'. __("Slovakia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
            'si' => '<li>'. __("Slovenia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
            'se' => '<li>'. __("Sweden", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>',
            'no' => '<li>'. __("Norway", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
           // 'rs' => '<li>'. __("Serbia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
            'ch' => '<li>'. __("Switzerland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>',
            'is' => '<li>'. __("Iceland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
            'je' => '<li>'. __("Jersey", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>', 
            'tr' => '<li>'. __("Turkey", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain) .' +49 32 221097485</li>'
        ];

        /** url default */
        $url_more_infomation = [];
        $arr_phone_active    = [];
        foreach ($arrTextShow as $key => $value) {
            if (in_array($key, self::release)) {
                $urlSupport  = 'https://www.ups.com/'. $key .'/en/services/technology-integration/ecommerce-plugins.page';
                if (array_key_exists($languagesCur, $arrLanguages) || in_array($languagesCur, $arrLanguages)) {
                    if (($key == $arrLanguages[$languagesCur]) || ($key == $languagesCur)) {
                        $urlSupport = 'https://www.ups.com/'. strtolower($country_code) .'/'. $key .'/services/technology-integration/ecommerce-plugins.page';
                    }
                }
                $checkBE = explode('-', $languagesCur);
                if (isset($checkBE[1]) && $checkBE[1] == 'BE' && $key == 'be') {
                    $urlSupport = 'https://www.ups.com/be/'. strtolower($checkBE[0]) .'/services/technology-integration/ecommerce-plugins.page';
                }

                if ($country_code == 'US') {
                    $urlSupport = 'https://www.ups.com/plugins';
                }

                $url_more_infomation[] = '<a target="__blank" href="'. $urlSupport .'">'. $value .'</a>';
                $arr_phone_active[]    = $arrPhone[$key];
            }
        };

        $dataObject = new \stdClass();
        /* get language by key */
        $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
            $UpsEuWoocommerceSmarty->lang_page_about_logs_api
        );
        $dataObject->lang['Support_information_2'] = implode('', $arr_phone_active);
        $dataObject->router_url = $router_url;
        $dataObject->title = 'UpsShippingModule';
        $dataObject->pagination = $ups_pagination->ups_eu_woo_build_lists_logs_api();
        $dataObject->list_object_javascript = json_encode($dataObject->pagination->list_data->list_main);
        $dataObject->action_form = $router_url->url_about_logs_api;
        $dataObject->version = \UpsEuWoocommerce\Ups_Eu_Woo_Main::$version;


        $dataObject->urlSupport = sprintf($dataObject->lang['for_more_infomation_1'], implode(", ", $url_more_infomation));
        $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
        echo $smarty->fetch("admin/merchant_cf/about_logs_api.tpl");
        return;
    }
}
