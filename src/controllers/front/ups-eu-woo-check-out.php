<?php namespace UpsEuWoocommerce\controllers\front;

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
 * ups-eu-woo-check-out.php - The core plugin class.
 *
 * This is used to config in the checkout page of the current plugin for woocommerce.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_CheckOut');

class Ups_Eu_Woo_CheckOut
{
    /* Init properties */

    public $_session_data_order_total = 'session_data_order_total';
    public $_fee_shipping ='_fee_shipping';
    public $_sesson_ups_eu_woocommerce_key = 'ups_eu_woocommerce_key';
    //private $_total = "total";
    private $_fun_get_id = "get_id";

    /**
     * Name function: ups_eu_woo_get_html
     * Params: empty
     * Return: type stirng html
     */
    public function ups_eu_woo_get_html()
    {
        /* Load all class or models */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        /* get value config by key ACCEPT_BILLING_PREFERENCE */
        $ACCEPT_BILLING_PREFERENCE = "";
        if ($model_config->ups_eu_woo_get_by_key("{$model_config->ACCEPT_BILLING_PREFERENCE}") === true) {
            $ACCEPT_BILLING_PREFERENCE = $model_config->value;
        }
        /* check accept billing preference */
        if (intval($ACCEPT_BILLING_PREFERENCE) === 1) {
            global $woocommerce;
            /* define neccesary data */
            $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
            $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
            $options = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Options();
            $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
            $dataObject = new \stdClass();
            /* set ups_eu_woocommerce_key value */
            $dataObject->ups_eu_woocommerce_key = md5(rand(0, 1000) . "" . microtime(true));
            $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key($model_config->lang_page_checkout);
            $dataObject->lang['ups_shipping'] = __("UPS Shipping", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
            $dataObject->lang['one_select'] = __("Please select an Access Point to process", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
            $dataObject->router_url = $router_url;
            /* get country list */
            $dataObject->country_list = $options->get_country_list();
            /* get country code list */
            $dataObject->country_code_list = $options->get_country_code_list();
            /* get config value by key COUNTRY_CODE */
            if ($model_config->ups_eu_woo_get_by_key("{$model_config->COUNTRY_CODE}") === true) {
                $dataObject->country = $model_config->value;
            } else {
                $dataObject->country = "PL";
            }

            $dataObject->map_credentials = "";
            if ($model_config->ups_eu_woo_get_by_key("{$model_config->ups_shipping_bing_map_key}") === true) {
                $dataObject->map_credentials = $model_config->value;
            }


            /* get cart total */
            //$total_cart_data = \WC()->cart->get_totals();
            $total_cart_data = \WC()->cart->subtotal;
            $total_data = \WC()->cart->get_totals();
            $dataObject->ups_flat_cal_discount = false;
            /* get discount total if its on */
            if ($model_config->ups_eu_woo_get_by_key("{$model_config->ups_flat_cal_discount}") === true && $model_config->ups_eu_woo_get_value_by_key("{$model_config->ups_flat_cal_discount}") == true) {
                $total_cart_data = $total_cart_data - \WC()->cart->get_discount_total();
                $dataObject->ups_flat_cal_discount = true;
            }

            if (!empty($total_cart_data)) {
                $dataObject->get_cart_total = $total_cart_data;
            } else {
                $dataObject->get_cart_total = 0;
            }

            /* get woocommerce currency symbol */
            $dataObject->get_woocommerce_currency_symbol = get_woocommerce_currency_symbol();
            /* get woocommerce currency */
            $dataObject->get_woocommerce_currency = get_woocommerce_currency();
            $dataObject->_javascript_ups_eu_woocommerce = json_encode($dataObject);
            /* get config value by key DELIVERY_TO_ACCESS_POINT */
            $dataObject->DELIVERY_TO_ACCESS_POINT = "";
            if ($model_config->ups_eu_woo_get_by_key("{$model_config->DELIVERY_TO_ACCESS_POINT}") === true) {
                $dataObject->DELIVERY_TO_ACCESS_POINT = $model_config->value;
            }
            /* get config value by key DELIVERY_TO_SHIPPING_ADDRESS */
            $dataObject->DELIVERY_TO_SHIPPING_ADDRESS = "";
            if ($model_config->ups_eu_woo_get_by_key("{$model_config->DELIVERY_TO_SHIPPING_ADDRESS}") === true) {
                $dataObject->DELIVERY_TO_SHIPPING_ADDRESS = $model_config->value;
            }
            /* render dataObject with smarty */
            $dataObject->base_url =  str_replace('src/controllers', 'assets', plugin_dir_url(__FILE__));
            $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
            return $smarty->fetch("front/checkout.tpl");
        } else {
            return "";
        }
    }

    /**
     * Name function: ups_eu_woo_custom_checkout_method_option
     * Params:
     * @ups_shipping_method_id: type stirng
     * @method: type string
     * Return: type stirng html
     */
    public function ups_eu_woo_custom_checkout_method_option($ups_shipping_method_id, $method)
    {
        /* Load all class or models */
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        /* get config value by key ACCEPT_BILLING_PREFERENCE */
        $accept_billing_preference = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_BILLING_PREFERENCE) === true) {
            $accept_billing_preference = $model_config->value;
        }
        $total_old = 0;
        $value_add = 0;
        $total_fee = 0;
        $format_price_shipping = "";
        if (intval($accept_billing_preference) === 1) {
            /* get ups shipping id */
            $ups_shipping_id = call_user_func_array(
                [
                new \UpsEuWoocommerce\setting_shipping\Ups_Eu_Woo_Ups_Eu_Shipping(),
                "{$this->_fun_get_id}"
                ],
                []
            );
            if ($method->method_id != $ups_shipping_id) {
                return "";
            }
            $chosen_shipping_methods = \WC()->session->get('chosen_shipping_methods');
            if (strpos("___{$chosen_shipping_methods[0]}", "{$ups_shipping_id}") === 3) {
                $total_old = $this->ups_eu_woo_get_total_old();
                $value_add = $this->ups_eu_woo_get_value_add();
                $coupon_Id = \WC()->cart->get_applied_coupons();
                $cart_coupon = \WC()->cart->get_coupon_discount_totals();
                $coupon_discount = 0;
                if (!empty($coupon_Id[0]) && !empty($cart_coupon[$coupon_Id[0]])) {
                    $coupon_discount = $cart_coupon[$coupon_Id[0]];
                }
                $car_tax = \WC()->cart->get_cart_contents_tax();
                if (floatval($value_add) >= 0) {
                    $total_fee = $total_old + $value_add + $car_tax - $coupon_discount;
                    \WC()->cart->set_total($total_fee);
                    /* get shipping price */
                    $format_price_shipping = wc_price($value_add);
                    $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
                    /* define necessary info */
                    $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
                    $dataObject = new \stdClass();
                    /* get language by key */
                    $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
                        $model_config->lang_page_checkout
                    );
                    $dataObject->method_id = $ups_shipping_method_id;
                    /* get woocommerce currency */
                    $dataObject->get_woocommerce_currency = get_woocommerce_currency();
                    /* get currency symbol */
                    $dataObject->get_woocommerce_currency_symbol = get_woocommerce_currency_symbol();
                    $dataObject->value_add = $value_add;
                    $dataObject->format_price_shipping = $format_price_shipping;
                    $dataObject->ACCEPT_BILLING_PREFERENCE = $accept_billing_preference;
                    $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
                    return $smarty->fetch("front/component/checkout_method_option.tpl");
                }
            }
        }
        return "";
    }

    /**
     * Name function: ups_eu_woo_get_total_old
     * Params: empty
     * Return: type float
     */
    private function ups_eu_woo_get_total_old()
    {
        /*$total_old_order = 0;
        $check = \WC()->session->get($this->_session_data_order_total);
        if (empty($check)) {
            $check = false;
        }
        if ($check) {
            $total_old_order = $check;
        } else {
            // get cart total
            $total_data = \WC()->cart->get_totals();
            $total_old_order = $total_data[$this->_total];
            //$total_old_order = $total_data['subtotal']; //sử dụng subtotal - total sẽ cộng thêm giá shipping
            // delete fee ar view cart
            \WC()->session->set($this->_session_data_order_total, $total_old_order);
        }*/
        /* get cart total */
        $total_data = \WC()->cart->get_totals();
        $total_old_order = $total_data['subtotal'];
        return $total_old_order;
    }

    /**
     * Name function: ups_eu_woo_get_value_add
     * Params: empty
     * Return: type float
     */
    private function ups_eu_woo_get_value_add()
    {
        $value_add = -1;
        $local_sesson_ups_eu_woocommerce_key = \WC()->session->get($this->_sesson_ups_eu_woocommerce_key);
        if (strlen($local_sesson_ups_eu_woocommerce_key) <= 0) {
            return $value_add;
        }

        $model_log_frontend = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Log_Frontend();
        /* get log frontend id */
        $model_log_frontend->id = $model_log_frontend->get_by_ups_eu_woocommerce_key(
            $local_sesson_ups_eu_woocommerce_key
        );
        if (!empty($model_log_frontend->content_encode_json)) {
            $info_content_frontend = json_decode($model_log_frontend->content_encode_json);
        } else {
            $info_content_frontend = false;
        }
        if (!empty($info_content_frontend->RateTimeInTransit)) {
            $check_RateTimeInTransit = $info_content_frontend->RateTimeInTransit;
        } else {
            $check_RateTimeInTransit = "";
        }
        if (!empty($info_content_frontend->service_id)) {
            $service_id = $info_content_frontend->service_id;
        } else {
            $service_id = 0;
        }
        if (intval($service_id) > 0 && strlen($check_RateTimeInTransit) > 0) {
            $RateTimeInTransit = json_decode(base64_decode($check_RateTimeInTransit));
            if (!empty($RateTimeInTransit->{$service_id})) {
                $itemRateTimeInTransit = $RateTimeInTransit->{$service_id};
                $value_add = $itemRateTimeInTransit->custom->monetary_value;
            } else {
                $get_checkout = \WC()->session->get('checkout_update');
                if ($get_checkout == '1') {
                    $value_add = $this->get_value_log_data($RateTimeInTransit, $service_id);
                }
            }
        }
        $value_add_session = $this->get_return_min_price_package_rate();
        if (-1 == $value_add && $value_add_session > 0) {
            $value_add = $value_add_session;
        }
        return $value_add;
    }

    /**
     * Name function: ups_eu_woo_update_open_order_models
     * Params:
     * @service_id: service_id
     * @info_content_frontend: type obejct class
     * @model_orders: type obejct class
     * Return: type void
     */
    private function ups_eu_woo_update_open_order_models($service_id, $info_content_frontend, &$model_orders)
    {
        /* define necessary info */
        $model_accessorial = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Accessorial();
        $model_services = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Services();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        /* get service by id */
        $model_services->ups_eu_woo_get_by_id($service_id);
        if (strtolower($model_services->service_type) === 'ap') {
            /* list_locator */
            if (!empty($info_content_frontend->list_locator)) {
                $check_list_locator = $info_content_frontend->list_locator;
            } else {
                $check_list_locator = "";
            }
            if (!empty($info_content_frontend->LocationID)) {
                $LocationID = $info_content_frontend->LocationID;
            } else {
                $LocationID = 0;
            }
            /* check location id and list locator */
            if ($LocationID > 0 && strlen($check_list_locator) > 0) {
                $list_locator = json_decode(base64_decode($info_content_frontend->list_locator));
                if (!empty($list_locator->{$LocationID})) {
                    $ItemshiptoAP = $list_locator->{$LocationID};
                } else {
                    $ItemshiptoAP = false;
                }

                if (!empty($ItemshiptoAP->AddressLine)) {
                    $model_orders->ap_address1 = $ItemshiptoAP->AddressLine;
                } else {
                    $model_orders->ap_address1 = "";
                }

                $model_orders->ap_address2 = "";
                $model_orders->ap_address3 = "";

                if (!empty($ItemshiptoAP->PostcodePrimaryLow)) {
                    $model_orders->ap_postcode = $ItemshiptoAP->PostcodePrimaryLow;
                } else {
                    $model_orders->ap_postcode = "";
                }

                if (!empty($ItemshiptoAP->CountryCode)) {
                    $model_orders->ap_country = $ItemshiptoAP->CountryCode;
                } else {
                    $model_orders->ap_country = "";
                }

                if (!empty($ItemshiptoAP->ConsigneeName)) {
                    $model_orders->ap_name = $ItemshiptoAP->ConsigneeName;
                } else {
                    $model_orders->ap_name = "";
                }

                if (!empty($ItemshiptoAP->PoliticalDivision2)) {
                    $model_orders->ap_city = $ItemshiptoAP->PoliticalDivision2;
                } else {
                    $model_orders->ap_city = "";
                }

                if (!empty($ItemshiptoAP->PublicAccessPointID)) {
                    $model_orders->access_point_id = $ItemshiptoAP->PublicAccessPointID;
                } else {
                    $model_orders->access_point_id = "";
                }

                if (!empty($ItemshiptoAP->PoliticalDivision1)) {
                    $model_orders->ap_state = $ItemshiptoAP->PoliticalDivision1;
                } else {
                    $model_orders->ap_state = "";
                }
            }
        } else {
            /* reset access point data when shipping to address */
            $model_orders->ap_name = "";
            $model_orders->ap_city = "";
            $model_orders->ap_address1 = "";
            $model_orders->ap_address2 = "";
            $model_orders->ap_address3 = "";
            $model_orders->ap_postcode = "";
            $model_orders->ap_country = "";
            $model_orders->ap_state = "";
        }
        // Set accessorial services
        $sat_deli_flg = false;

        if (strpos($model_services->service_key, $model_config->satDeli)) {
            $sat_deli_flg = true;
        }
        $model_orders->accessorial_service = $model_accessorial->ups_eu_woo_get_list_checked($sat_deli_flg);
    }

    /**
     * Name function: ups_eu_woo_update_open_order_rate_time_in_transit
     * Params:
     * @order_id: type int
     * Return: type void
     */
    private function ups_eu_woo_update_open_order_rate_time_in_transit($check_RateTimeInTransit, $service_id, &$order)
    {
        if (strlen($check_RateTimeInTransit) > 0) {
            /* get rate time in transit */
            $RateTimeInTransit = json_decode(base64_decode($check_RateTimeInTransit));
            $total_fee = 0;
            $value_add = 0;
            $car_tax = \WC()->cart->get_cart_contents_tax();

            $total_data = \WC()->cart->get_totals();
            if (!empty($total_data['subtotal'])) {
                $total_old = $total_data['subtotal'];
            } else {
                $total_old = 0;
            }
            // shipping fee
            if (!empty($RateTimeInTransit->{$service_id})) {
                $itemRateTimeInTransit = $RateTimeInTransit->{$service_id};
                $value_add = $itemRateTimeInTransit->custom->monetary_value;
            } else {
                $value_add = $this->get_value_log_data($RateTimeInTransit, $service_id);
            }

            $coupon_Id = \WC()->cart->get_applied_coupons();
            $cart_coupon = \WC()->cart->get_coupon_discount_totals();
            $coupon_discount = 0;
            if (!empty($coupon_Id[0]) && !empty($cart_coupon[$coupon_Id[0]])) {
                $coupon_discount = $cart_coupon[$coupon_Id[0]];
            }
            $total_fee = $total_old + $value_add + $car_tax - $coupon_discount;
            /* set order total price with ups shipping */
            $order->set_total($total_fee);
            /* set shipping total to order */
            $order->set_shipping_total($value_add);
            /* save woocommerce order info */
            $order->save();
        }
    }

    /**
     * Name function: processing
     * Params:
     * @order_id: type int
     * Return: type void
     */
    public function ups_eu_woo_front_processing($order_id)
    {
        $ups_eu_woocommerce_key = "";
        if (!empty($_POST[$this->_sesson_ups_eu_woocommerce_key])) {
            $ups_eu_woocommerce_key = $_POST[$this->_sesson_ups_eu_woocommerce_key];
        }
        if (strlen($ups_eu_woocommerce_key) > 0) {
            $chosen_shipping_methods = \WC()->session->get('chosen_shipping_methods');
            /* get ups shipping id */
            $ups_shipping_id = call_user_func_array(
                [
                new \UpsEuWoocommerce\setting_shipping\Ups_Eu_Woo_Ups_Eu_Shipping(),
                "{$this->_fun_get_id}"
                ],
                []
            );
            $forced_push = true;
            // if (strpos("___{$chosen_shipping_methods[0]}", "{$ups_shipping_id}") === 3) {
            if ($forced_push) {
                $model_log_frontend = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Log_Frontend();
                $model_log_frontend->id = $model_log_frontend->get_by_ups_eu_woocommerce_key($ups_eu_woocommerce_key);

                if ($model_log_frontend->id > 0) {
                    if (!empty($model_log_frontend->content_encode_json)) {
                        $info_content_frontend = json_decode($model_log_frontend->content_encode_json);
                    } else {
                        $info_content_frontend = false;
                    }

                    if (!empty($info_content_frontend->service_id)) {
                        $service_id = $info_content_frontend->service_id;
                    } else {
                        $service_id = 0;
                    }

                    if ((intval($service_id) > 0) || ($forced_push) ) {
                        /* define necessary info */
                        $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
                        $model_accessorial = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Accessorial();
                        $model_services = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Services();
                        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
                        /* get order woocommerce */
                        $order = wc_get_order($order_id);

                        /* get order data info */
                        $order_data = $order->get_data();
                        $check_RateTimeInTransit = "";
                        if (!empty($info_content_frontend->RateTimeInTransit)) {
                            $check_RateTimeInTransit = $info_content_frontend->RateTimeInTransit;
                        }

                        /* update open order rate time in transit */
                        // if (strpos("___{$chosen_shipping_methods[0]}", "{$ups_shipping_id}") === 3) {
                        //     $this->ups_eu_woo_update_open_order_rate_time_in_transit($check_RateTimeInTransit, $service_id, $order);
                        // }

                        $model_orders->order_id_magento = "{$order_id}";
                        /* get service by id */
                        $model_services->ups_eu_woo_get_by_id($service_id);
                        /* update order by type service ap or add */
                        $this->ups_eu_woo_update_open_order_models($service_id, $info_content_frontend, $model_orders);
                        /* get date created */
                        $model_orders->woo_tmp_order_date = date('Y-m-d H:i:s', $order->get_date_created()->getOffsetTimestamp());
                        /* get collect on delivery */
                        if (trim(strtolower($order->get_payment_method())) == 'cod') {
                            $model_orders->cod = 1;
                        } else {
                            $model_orders->cod = 0;
                        }

                        $model_orders->shipping_service = $service_id;
                        $model_orders->location_id = $info_content_frontend->LocationID;

                        $model_orders->status = 1;
                        $model_orders->package_type = '';
                        $package_type = \WC()->session->get('package_type');
                        if (!empty($package_type)) {
                            $model_orders->package_type = json_encode($package_type);
                            // check update
                            \WC()->session->set('checkout_update', '');
                        }
                        //$shipping_method = $order->get_shipping_method();
                        $ups_shipping_method = @array_shift($order->get_shipping_methods());
                        $shipping_method = $ups_shipping_method['method_id'];
                        if($shipping_method && $shipping_method != "ups_eu_shipping"){
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
                        }
                        /* save ups_order info */
                        $model_orders->ups_eu_woo_save();
                        
                        /* get config value by key AP_AS_SHIPTO */
                        $ap_as_ship_addr = "";
                        if ($model_config->ups_eu_woo_get_by_key($model_config->AP_AS_SHIPTO) === true) {
                            $ap_as_ship_addr = $model_config->value;
                        }
                        if (strtolower($model_services->service_type) === 'ap' && $ap_as_ship_addr == 1) {
                            $model_orders->ups_eu_woo_update_shipto();
                        }
                    }
                }
            }
        }
    }

    /**
     * Name function: custom_wp_print_scripts
     * Params: empty
     * Return: type strng html
     */
    public function custom_wp_print_scripts()
    {
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
        $dataObject = new \stdClass();
        $dataObject->router_url = $router_url;
        $dataObject->key_run = md5(microtime(true));
        $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
        return $smarty->fetch("admin/admin_footer_js_css.tpl");
    }

    /**
     * Name function: disable_ups_shipping_calc_on_cart
     * Params: empty
     * Return: type strng html
     */
    public function disable_ups_shipping_calc_on_cart()
    {
        $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
        $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
        $dataObject = new \stdClass();
        $ups_shipping_id = call_user_func_array(
            [
            new \UpsEuWoocommerce\setting_shipping\Ups_Eu_Woo_Ups_Eu_Shipping(),
            "{$this->_fun_get_id}"
            ],
            []
        );
        $dataObject->ups_shipping_id = $ups_shipping_id;
        $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
        return $smarty->fetch("front/disable_ups_shipping_calc_on_cart.tpl");
    }

    /**
     * Name function: ups_eu_woo_ajax_json
     * Params: empty
     * Return: type json
     */
    public function ups_eu_woo_ajax_json()
    {
        $ajaxJson = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Ajax_Json();
        $response = $ajaxJson->ups_eu_woo_processing_frontend();
        if ($response->check === true) {
            ob_end_clean();
            wp_send_json($response);
        }
    }

    /**
     * Name function: clear_session_data_order_total
     * Params: empty
     * Return: type void
     */
    public function clear_session_data_order_total()
    {
        \WC()->session->set($this->_session_data_order_total, "");
    }

    /**
     * Name function: update_session_ups_eu_woocommerce_key
     * Params:
     * @value: type string
     * Return: type void
     */
    public function update_session_ups_eu_woocommerce_key($value)
    {
        \WC()->session->set($this->_sesson_ups_eu_woocommerce_key, "{$value}");
    }


    /**
     * Name function: get_value_log_data
     * Params: empty
     * Return: float
     */
    public function get_value_log_data($rateTimeInTransit, $service_id)
    {
        $shipping_fee = 0;
        if (count($rateTimeInTransit) > 0) {
            foreach ($rateTimeInTransit as $item) {
                if ($service_id == $item->custom->service_id) {
                    $shipping_fee = $item->custom->monetary_value;
                    break;
                }
            }
        }
        return $shipping_fee;
    }

    private function get_return_min_price_package_rate()
    {
        $model_fallback_rates = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Fallback_Rates();

        $min_price = 0;
        $all_package_services = $model_fallback_rates->ups_eu_woo_get_all();
        if (count($all_package_services) > 0) {
            $min_price = $all_package_services[0]->fallback_rate;
            foreach ($all_package_services as $item) {
                if ($item->fallback_rate < $min_price) {
                    $min_price = $item->fallback_rate;
                }
            }
        }
        return $min_price;
    }
}
