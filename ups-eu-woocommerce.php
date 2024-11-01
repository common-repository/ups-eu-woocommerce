<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.ups.com
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       UPS Shipping and UPS Access Point™ : Official Plugin

 * Description:       This module allows you to easily integrate UPS services into your store with a range of guaranteed delivery services (including deliveries to UPS Access Points™) to meet your customers' need for speed and budget.
 * Version:           3.8.0
 * Author:            UPS
 * Author URI:        https://www.ups.com/pl/en/services/technology-integration/ecommerce-plugins.page
 * License:           GPL-2.0+
 * Text Domain:       ups-eu-woocommerce
 * Domain Path:       /languages
 */
namespace UpsEuWoocommerce;

include_once('src/ups-eu-woo-autoloader.php');
new Ups_Eu_Woo_Main_Autoloader('UpsEuWoocommerce');
//---------------------------------------------------------------------------------------------
/**
 * Check if WooCommerce is active
 * */
$all_plugins = apply_filters('active_plugins', get_option('active_plugins'));
if (stripos(implode($all_plugins), '/woocommerce.php')) {
    if (!defined('UPS_EU_WOO_IMG_PATH')) {
        define('UPS_EU_WOO_IMG_PATH', plugin_dir_url(__FILE__) . 'assets/images/');
    }
    // Define WC_PLUGIN_FILE.
    if (!defined('UPS_EU_WOO_SHIPPING_FILE')) {
        define('UPS_EU_WOO_SHIPPING_FILE', __FILE__);
    }
    // We load Composer's autoload file
    include_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-ups-eu-woocommerce-activator.php
     */
    function activate_plugin_name()
    {
        utils\Ups_Eu_Woo_Utils_Activator::ups_eu_woo_activate();
    }

    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-ups-eu-woocommerce-deactivator.php
     */
    function deactivate_plugin_name()
    {
        utils\Ups_Eu_Woo_Utils_Deactivator::ups_eu_woo_deactivate();
    }
    register_activation_hook(__FILE__, '\UpsEuWoocommerce\activate_plugin_name');
    register_deactivation_hook(__FILE__, '\UpsEuWoocommerce\deactivate_plugin_name');

    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since 1.0.0
     */
    function run_plugin_name()
    {
        $plugin = new Ups_Eu_Woo_Main(new utils\Ups_Eu_Woo_Utils_Loader());
        $plugin->ups_eu_woo_main_run();
    }
    run_plugin_name();

    add_action('admin_footer', "\UpsEuWoocommerce\custom_wp_print_scripts");

    function custom_wp_print_scripts()
    {
        echo call_user_func_array(
            [
            new controllers\front\Ups_Eu_Woo_CheckOut()
            , "custom_wp_print_scripts"
            ],
            []
        );
    }
    add_filter('woocommerce_shipping_methods', '\UpsEuWoocommerce\add_ups_eu_shipping_method');

    function ups_eu_woo_upgrade_new_version()
    {
        utils\Ups_Eu_Woo_Utils_Activator::ups_eu_woo_init();
    }
    add_action('plugins_loaded', '\UpsEuWoocommerce\ups_eu_woo_upgrade_new_version');

    function add_ups_eu_shipping_method($methods)
    {
        $methods["ups_eu_shipping"] = "\UpsEuWoocommerce\setting_shipping\Ups_Eu_Woo_Ups_Eu_Shipping";
        return $methods;
    }
    add_action('woocommerce_review_order_before_payment', '\UpsEuWoocommerce\ups_eu_woo_shipping_build_eshopper');

    function ups_eu_woo_shipping_build_eshopper()
    {
        echo call_user_func_array(
            [
            new controllers\front\Ups_Eu_Woo_CheckOut()
            , "ups_eu_woo_get_html"
            ],
            []
        );
    }
    add_action('woocommerce_checkout_update_order_meta', '\UpsEuWoocommerce\ups_eu_woocommerce_save_update_order_success');

    function ups_eu_woocommerce_save_update_order_success($order_id)
    {
        call_user_func_array(
            [
            new controllers\front\Ups_Eu_Woo_CheckOut()
            , "ups_eu_woo_front_processing"
            ],
            [
            $order_id
            ]
        );
    }
    add_action('woocommerce_cancelled_order', '\UpsEuWoocommerce\ups_eu_woo_shipping_change_status_to_refund');

    function ups_eu_woo_shipping_change_status_to_refund($order_id)
    {
        call_user_func_array(
            [
            new controllers\front\Ups_Eu_Woo_CheckOut()
            , "cancel_order"
            ],
            [
            $order_id
            ]
        );
    }
    add_action('wp_loaded', "\UpsEuWoocommerce\ups_eu_woo_shipping_ajax_json");

    function ups_eu_woo_shipping_ajax_json()
    {
        $model_RouterUrl = new models\bases\Ups_Eu_Woo_Router_Url();
        $check_frontend_api_json = str_replace(
            $model_RouterUrl->url_home,
            "",
            $model_RouterUrl->url_frontend_api_json
        );
        if (strpos($model_RouterUrl->ups_eu_woo_current_location(), $check_frontend_api_json . "&method=") > 0) {
            echo call_user_func_array(
                [
                new controllers\front\Ups_Eu_Woo_CheckOut()
                , "ups_eu_woo_ajax_json"
                ],
                []
            );
        }
    }
    add_action('woocommerce_after_shipping_rate', '\UpsEuWoocommerce\ups_eu_woo_shipping_method_custom_fields');

    function ups_eu_woo_shipping_method_custom_fields($method)
    {
        if (!is_checkout()) {
            call_user_func_array(
                [
                new controllers\front\Ups_Eu_Woo_CheckOut()
                , "clear_session_data_order_total"
                ],
                []
            );
            return;
        }
        // echo call_user_func_array(
        //     [
        //     new controllers\front\Ups_Eu_Woo_CheckOut()
        //     , "ups_eu_woo_custom_checkout_method_option"
        //     ],
        //     [
        //     "{$method->method_id}_{$method->instance_id}"
        //     , $method
        //     ]
        // );
    }

    //Refresh rate cache
    add_action('woocommerce_checkout_update_order_review', '\UpsEuWoocommerce\mc_checkout_update_refresh_shipping_methods', 10, 1);
    function mc_checkout_update_refresh_shipping_methods( $post_data ) {
        $packages = WC()->cart->get_shipping_packages();
        foreach ($packages as $package_key => $package ) {
             WC()->session->set( 'shipping_for_package_' . $package_key, false ); // Or true
        }
    }
    /* Hide the text "calculate shipping" on the cart page */

    function disable_ups_shipping_calc_on_cart($show_shipping)
    {
        if (is_cart()) {
            echo call_user_func_array(
                [
                new controllers\front\Ups_Eu_Woo_CheckOut()
                , "disable_ups_shipping_calc_on_cart"
                ],
                []
            );
            return $show_shipping;
        }
        return $show_shipping;
    }
    

    add_action( 'add_meta_boxes', '\UpsEuWoocommerce\create_ups_shipping_official_meta_box');
    add_action( 'save_post', '\UpsEuWoocommerce\create_ups_shipping_official_meta_post');

    function create_ups_shipping_official_meta_box()
    {
        add_meta_box( 'ups_official_shipping', __('UPS Official','UpsEuWoocommerce'), '\UpsEuWoocommerce\create_ups_offi_shipping_label_genetation', 'shop_order', 'side', 'core' );   
    }

    function create_ups_offi_shipping_label_genetation($post)
    {
        if($post->post_type != 'shop_order' ){
            return;
        }
        
        $order = wc_get_order( $post->ID );
        $order_id = $order->get_id();

        $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
        $conditions = ["order_id_magento IN ($order_id)"];
        $order = $model_orders->ups_eu_woo_pagination_list_data('create_shipment', [
            $model_orders->var_conditions => $conditions
        ]);
        $order_rate_code = '';
        foreach ($order as $order_data) {
            if(isset($order_data->rate_code)){
                $order_rate_code = $order_data->rate_code;
            }
        }

        $order_status = get_option('ups_offi_shipment_status_'.$order_id);
        $label_dwnld_status = get_option("ups_offi_label_status", "");
        echo '<div style="padding:5px;">';
        if (!empty($order_status)) {
            $decoded_status = json_decode($order_status, true);
            if ($decoded_status['status'] == "success") {
                echo '<p style="color:green;">Shipment Created Succesfully.</p>';
            } else {
                echo '<p style="color:red;">'.$decoded_status['status'].'</p>';
            }
            
            delete_option('ups_offi_shipment_status_'.$order_id);
        }

        if (!empty($label_dwnld_status)) {
            echo '<p style="color:red;">'.$label_dwnld_status.'</p>';
            delete_option("ups_offi_label_status");
        }
        //load neccessary model
        $model_service = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Services();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();

        //get non-ap shipping service
        $model_config->ups_eu_woo_get_by_key("COUNTRY_CODE");
        $country_code = $model_config->value;
        $services_to_add = $model_service->get_list_data_by_condition([
                        $model_service->col_country_code => $country_code,
                        $model_service->col_service_type => 'ADD'
                    ]);
        $get_label_data = $model_orders->ups_eu_woo_pagination_list_data('info_shipment', [
            $model_orders->var_conditions => $conditions
            ]);
        $trk_no = '';
        if (!empty($get_label_data)) {
            foreach ($get_label_data as $o_n_l_key => $label_data) {
                $trk_no = $label_data->shipment_number;
            }
        }
        if (!empty($trk_no)) {
            echo '<b style="color:#330000;">Select Label Format: </b><br/><select style="color:#330000;border-color:#330000;margin-top:2px;min-height:25px !important;height:25px;line-height:1 !important;width:100%;" name="ups_off_f_label_format"><option value="PDF">PDF</option><option value="ZPL">ZPL</option></select>';
            // echo '<br/><br/><button style="border-radius:5px;color:#ffbe00;background-color:#330000;border:none;cursor:pointer;height:25px;padding:1px 20px 1px 20px;font-weight:bold;" name="ups_official_dwnld_label" value="'.$trk_no.'">Download Label</button>';
            echo '<br/><br/><button style="border-radius:5px;color:#330000;background-color:#ffbe00;border:none;cursor:pointer;height:25px;padding:1px 20px 1px 20px;font-weight:bold;" name="ups_official_dwnld_label" value="'.$trk_no.'">Download Label</button>';
        }       
        else if (isset($order[$order_id])) {
            if (!empty($services_to_add)) {
                $order_rates = get_option('ups_offi_shipment_rates_'.$order_id);
                if (!empty($order_rates)) {
                    $decoded_rates = json_decode($order_rates, true);
                    $rate_html = "";
                    foreach ($decoded_rates as $k => $r) {
                        $rate_html .= '<br/><input type="radio" id="'.$k.'" name="ups_offi_rate_radio" value="'.$r["rate_code"].'-0-'.$r["rate_des"].'"><label for="'.$k.'" style="margin-left:2px;">'.$r["rate_des"].' - '.$r["rate"].' '.$r["currency"].'</label>';
                    }
                    echo $rate_html;
                    delete_option('ups_offi_shipment_rates_'.$order_id);
                } else {
                // echo '<label>Enable COD: <input type="checkbox" name="ups_off_f_cod" value="true"/>';
                    echo '<b style="color:#330000;">Select Service: </b><select style="color:#330000;border-color:#330000;margin-top:2px;min-height:25px !important;height:25px;line-height:1 !important;width:100%;" name="ups_off_f_service">';
                    $flag = false;
                    foreach ($services_to_add as $key => $service_add) {
                        if (($service_add->service_selected == true)) {
                            if (!empty($order_rate_code)){
                                if ($order_rate_code != $service_add->rate_code) {
                                    echo '<option value="'.$service_add->rate_code.'-'.$service_add->id.'-'.$service_add->service_name.'">'.$service_add->service_name.'</option>';
                                }
                                if ($order_rate_code == $service_add->rate_code) {
                                    echo '<option selected value="'.$service_add->rate_code.'-'.$service_add->id.'-'.$service_add->service_name.'">'.$service_add->service_name.'</option>';
                                    $flag = true;
                                } else if (!$flag) {
                                    continue;
                                }
                            } else {
                                echo '<option value="'.$service_add->rate_code.'-'.$service_add->id.'-'.$service_add->service_name.'">'.$service_add->service_name.'</option>';
                            }
                        }
                    }
                    echo '</select>';
                    echo '<br/><br/><button style="border-radius:5px;color:#330000;background-color:#ffbe00;border:none;cursor:pointer;padding:5px 20px;font-weight:bold;" id="ups_get_shipping_rates" name="ups_get_shipping_rates">Calculate Shipping cost</button>';
                }
                // echo '<br/><br/><button style="border-radius:5px;color:#ffbe00;background-color:#330000;border:none;cursor:pointer;height:25px;padding:1px 20px 1px 20px;font-weight:bold;" name="ups_official_create_shipment">Create Shipment</button>';
                echo '<br/><br/><button style="border-radius:5px;color:#330000;background-color:#ffbe00;border:none;cursor:pointer;height:25px;padding:1px 20px 1px 20px;font-weight:bold;" name="ups_official_create_shipment">Create Shipment</button>';
            } else {
                echo '<p style="color:red;">Enable non-access point services to continue...</p>';
            }
        } else {
            echo '<br/><br/><button style="border-radius:5px;color:#330000;background-color:#ffbe00;border:none;cursor:pointer;height:25px;padding:1px 20px 1px 20px;font-weight:bold;" name="ups_official_generate">Generate Packages</button>';
            //echo '<p style="color:red;">No data found for this order.</p>';
        }
        echo '</div>';
    }

    function create_ups_shipping_official_meta_post($order_id)
    {
        $post = get_post($order_id);
        if($post->post_type != 'shop_order' ){
            return;
        }
        $err_msg = [];
        if (isset($_POST['ups_official_create_shipment']) && isset($post->ID)) {
            $_REQUEST['list_id_orders'] = $post->ID;
           
            $shipment_obj = new \UpsEuWoocommerce\libsystems\ajax_json\Ups_Eu_Woo_Shipments_Ajax_Json();
            $shipment_data = $shipment_obj->ups_eu_woo_create_f_single_shipment();

            if (!empty($shipment_data) && is_array($shipment_data)) {
                $ship_service = isset($_POST['ups_offi_rate_radio']) ? explode("-", sanitize_text_field($_POST['ups_offi_rate_radio'])) : [];
                if (empty($ship_service)) {
                    $ship_service = isset($_POST['ups_off_f_service']) ? explode("-", sanitize_text_field($_POST['ups_off_f_service'])) : [];
                }
                $shipment_data['shipping_type'][0] = 'ADD';
                $shipment_data['shipping_type'][1] = isset($ship_service[0]) ? $ship_service[0] : '';
                $shipment_data['shipping_type'][2] = isset($ship_service[1]) ? $ship_service[1] : '';
                $shipment_data['shipping_type'][3] = isset($ship_service[2]) ? $ship_service[2] : '';
                // $shipment_data['cod'] = isset($_POST['ups_off_f_cod']) ? 1 : 0;
                $_REQUEST = array_merge($_REQUEST, $shipment_data);
                $create_shipment = $shipment_obj->ups_eu_woo_create_shipment();

                if (isset($create_shipment->message) && !empty($create_shipment->message)) {
                    $err_msg['status'] = $create_shipment->message;
                } else {
                    $err_msg['status'] = "success";
                }
            } else {
                $err_msg['status'] = "Unable to fetch order data. Please try again later.";
            }
        }

        if(isset($_POST['ups_get_shipping_rates']) && isset($post->ID)){
            $_REQUEST['list_id_orders'] = $post->ID;
            $data = $_REQUEST;
            $order = wc_get_order( $post->ID );
            $order_id = $order->get_id();

            $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
            $conditions = ["order_id_magento IN ($order_id)"];
            $order = $model_orders->ups_eu_woo_pagination_list_data('create_shipment', [
                $model_orders->var_conditions => $conditions
            ]);

            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            $model_account = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Account();
            $account_default = $model_account->ups_eu_woo_get_default_account();
            
            


            
            // include_once \UpsEuWoocommerce\Ups_Eu_Woo_Main::ups_eu_woo_plugin_path_ups() . '/lib/upsmodule/sdk/class-api-ups-eu-woo-ups.php';
            //$model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            $upsapi_shipment = new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Shipments_Api_Ups();
            $model_package = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Package_Default();
            $system_entity = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Systems_Entity();
            

            //$lib_api_ups = new \Ups_Eu_Woo_UPS();
            $data = new \stdClass();
            
            $data->shipper = new \stdClass();
            $data->shipper->name = "";
            $data->shipper->shipper_number = $account_default['ups_account_number'];
            $data->shipper->address_line = [$account_default['address_1'], $account_default['address_2'], $account_default['address_3']];
            $data->shipper->city = $account_default['city'];
            $data->shipper->state_code = $account_default['state']; // "XX";
            $data->shipper->post_code = implode("", explode(" ", $account_default['postal_code']));
            $data->shipper->country_code = $account_default['country'];

            $data->shipto = new \stdClass();
            $data->shipto->name = "";
            $data->shipto->address_line = [$_REQUEST['_shipping_address_1'], $_REQUEST['_shipping_address_2']];
            $data->shipto->city = $_REQUEST['_shipping_city'];
            $data->shipto->state_code = $_REQUEST['_shipping_state'];
            $data->shipto->post_code = $_REQUEST['_shipping_postcode'];
            $data->shipto->country_code = $_REQUEST['_shipping_country'];

            $data->shipfrom = new \stdClass();
            $data->shipfrom->name = "";
            $data->shipfrom->shipper_number = $account_default['ups_account_number'];
            $data->shipfrom->address_line = [$account_default['address_1'], $account_default['address_2'], $account_default['address_3']];
            $data->shipfrom->city = $account_default['city'];
            $data->shipfrom->state_code = $account_default['state']; // "XX";
            $data->shipfrom->post_code = implode("", explode(" ", $account_default['postal_code']));
            $data->shipfrom->country_code = $account_default['country'];

            $data->PaymentDetails = new \stdClass();
            $data->PaymentDetails->ShipmentCharge = [];
            $shipment_charge_item = new \stdClass();
            $shipment_charge_item->Type = "01";
            $shipment_charge_item->BillShipper = new \stdClass();
            $shipment_charge_item->BillShipper->AccountNumber = $account_default['ups_account_number'];
            $data->PaymentDetails->ShipmentCharge[] = $shipment_charge_item;
            $data->ShipmentRatingOptions = new \stdClass();
            $data->ShipmentRatingOptions->NegotiatedRatesIndicator = "";
            $data->request_option = 'SHOPTIMEINTRANSIT';
            $data->account_number = $account_default['ups_account_number'];
            $data->shipping_type = 'ADD';
            $data->pickup_date = $model_config->ups_eu_woo_get_cut_off_time();
            
            $data->invoice_line_total = new \stdClass();
            $data->invoice_line_total->currency_code = $order[$order_id]->currency_code;
            $data->invoice_line_total->monetary_value = $order[$order_id]->total_price;
            
            $package = json_decode($order[$order_id]->package_type, true);
            
            $package_api = [];
            $descriptions = [
                'kgs' => "kilograms",
                'lbs' => "Pounds",
                'cm' => "centimeter",
                'inch' => "inch"
            ];
            
			if(isset($package['weight_unit'])){
				$package_info = new \stdClass();
				$package_info->package_weight = new \stdClass();
				$package_info->package_weight->code = strtoupper($package['weight_unit']);
				$package_info->package_weight->description = $descriptions[$package['weight_unit']];
				$package_info->package_weight->weight = "{$package['weight']}";

                if (isset($package['length']) && isset($package['width']) && isset($package['height'])) {
                    $package_info->dimension = new \stdClass();
                    $package_info->dimension->code = strtoupper($package['dimension_unit']);
                    $package_info->dimension->description = $descriptions[$package['dimension_unit']];
                    $package_info->dimension->length = "{$package['length']}";
                    $package_info->dimension->width = "{$package['width']}";
                    $package_info->dimension->height = "{$package['height']}";
                    $package_info->dimension->package_item = "{$package['include']}";
                }
				
	            $package_api[] = $package_info;
            
			}else{
				if(is_array($package)){
					foreach($package as $pack){
						
						$package_info = new \stdClass();
						$package_info->package_weight = new \stdClass();
						$package_info->package_weight->code = strtoupper($pack['unit_weight']);
						$package_info->package_weight->description = $descriptions[$pack['unit_weight']];
						$package_info->package_weight->weight = "{$pack['weight']}";

						if (isset($pack['length']) && isset($pack['width']) && isset($pack['height'])) {
                            $package_info->dimension = new \stdClass();
                            $package_info->dimension->code = strtoupper($pack['unit_dimension']);
                            $package_info->dimension->description = $descriptions[$pack['unit_dimension']];
                            $package_info->dimension->length = "{$pack['length']}";
                            $package_info->dimension->width = "{$pack['width']}";
                            $package_info->dimension->height = "{$pack['height']}";
                            $package_info->dimension->package_item = "{$pack['include']}";
                        }
						
            			$package_api[] = $package_info;

					}
				}
			}
            
            
            $data->package = $package_api;
	
            $rate_res_json = $upsapi_shipment->ups_eu_woo_call_api_get_rate($data);
            if (!empty($rate_res_json)) {
                $rate_res = json_decode($rate_res_json);
            }

            global $wpdb;
            $service_sql = "SELECT service_name , rate_code FROM ".$wpdb->prefix."ups_shipping_services WHERE service_type = 'ADD' AND service_selected = 1"; 
            $services = $wpdb->get_results($service_sql);

            if (!empty($services) && !empty($rate_res)) {
                $final_rates = [];
                if (isset($rate_res->RateResponse->RatedShipment)) {
                    foreach ($rate_res->RateResponse->RatedShipment as $rates) {
                        $rate_code_check = check_rate_code_availablity((string)$rates->Service->Code, $services);
                        if ($rate_code_check) {
                            $curr_rates = [];
                            $curr_rates['rate_des'] = (string)$rates->TimeInTransit->ServiceSummary->Service->Description;
                            $curr_rates['rate_code'] = (string)$rates->Service->Code;
                            $curr_rates['currency'] = isset($rates->NegotiatedRateCharges->TotalCharge->CurrencyCode) ? (string)$rates->NegotiatedRateCharges->TotalCharge->CurrencyCode : (string)$rates->TotalCharges->CurrencyCode;
                            $curr_rates['rate'] = isset($rates->NegotiatedRateCharges->TotalCharge->MonetaryValue) ? (string)$rates->NegotiatedRateCharges->TotalCharge->MonetaryValue : (string)$rates->TotalCharges->MonetaryValue;
                            $final_rates[] = $curr_rates;
                        }
                    }
                    if (!empty($final_rates)) {
                        update_option('ups_offi_shipment_rates_'.$order_id, json_encode($final_rates));
                    }
                } else {
                    if (isset($rate_res->Fault->faultstring)) {
                        $err_msg['status'] = (string)$rate_res->Fault->faultstring;
                    } else {
                        $err_msg['status'] = "Unknown error/response found.";
                    }
                }
            } else {
                $err_msg['status'] = "No rates available for services enabled.";
            }
        }

        if (!empty($err_msg)) {
            update_option('ups_offi_shipment_status_'.$order_id, json_encode($err_msg));
        }

        if (isset($_POST['ups_official_dwnld_label'])) {
            $trk_no_of_order = sanitize_text_field($_POST['ups_official_dwnld_label']);
            $label_format = sanitize_text_field($_POST['ups_off_f_label_format']);
            $print_label_obj = new \UpsEuWoocommerce\controllers\admin\Ups_Eu_Woo_Config_Billing_Preference();
            $print_label_obj->ups_eu_woo_config_print_label($trk_no_of_order, $label_format);
        }

        if (isset($_POST['ups_official_generate'])) {
            manual_order_generate_packages($order_id);
        }
        
    }

    function check_rate_code_availablity($rate_code = '', $services = array())
    {
        $check = false;
        foreach ($services as $service) {
            if ($service->rate_code == $rate_code) {
                $check = true;
                return $check;
            }
        }
        return $check;
    }
    /*start manual order generate in generate pckages and add new order create button */
    add_action('woocommerce_process_shop_order_meta', '\UpsEuWoocommerce\order_generate_packages');

    function order_generate_packages($order_id)
    {
        $order = wc_get_order( $order_id ); 
        $item_quantity = '';
        foreach ($order->get_items() as $item_id => $item ) {
            $item_quantity  = $item->get_quantity(); 
        }
        $number_item = $item_quantity;
        if(0<$number_item){
            manual_order_generate_packages($order_id); 
        }
    }

    function manual_order_generate_packages($order_id)
    {  
        $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
        $model_package = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Package_Default();
        $model_pack = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Package_Type();
        //$model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $model_orders->order_id_magento = "{$order_id}";
        $model_orders->status = 1;
        $package_type =$model_pack->ups_eu_woo_pack_order_items($order_id);
        $model_orders->package_type = json_encode($package_type);
        
        $order = wc_get_order($order_id);
        $model_orders->woo_tmp_order_date =  date('Y-m-d H:i:s', $order->get_date_modified()->getOffsetTimestamp());
        $model_orders->shipping_service = "";
        $model_orders->ap_name = "";
        $model_orders->ap_address1 = "";
        $model_orders->ap_address2 = "";
        $model_orders->ap_address3 = "";
        $model_orders->ap_state = "";
        $model_orders->ap_postcode = "";
        $model_orders->ap_city = "";
        $model_orders->ap_country = "";
        $model_orders->location_id = "";
        $model_orders->access_point_id = ""; 
        $model_orders->ups_eu_woo_save();
    }
    /*End */

    //    add_filter('woocommerce_cart_ready_to_calc_shipping', '\UpsEuWoocommerce\disable_ups_shipping_calc_on_cart');
        /* Upgrage version , by click the button "update now" on the plugin page */
    //    add_action('pre_set_site_transient_update_plugins', array(__CLASS__, 'ups_eu_woo_transient_update_plugins'), 21, 1);
    //    add_action('ups_eu_woo_upgrader_process_complete', array(__CLASS__, 'ups_eu_woo_upgrader_process_complete'));
} else {
    echo "<h1 class='wp-heading-inline'>Pls, install Woocommerce version 3.2++, before using service the UPS Shipping plugin.</h1>";
    return;
}
