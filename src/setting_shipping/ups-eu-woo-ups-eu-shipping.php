<?php namespace UpsEuWoocommerce\setting_shipping;

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
 * ups-eu-woo-ups-eu-shipping.php - The core plugin class.
 *
 * This is used to calculate the shipping.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Ups_Eu_Shipping');

class Ups_Eu_Woo_Ups_Eu_Shipping extends \WC_Shipping_Method
{
    /**
     * Constructor.
     *
     * @param int $instance_id
     */
    private $ups_shipping = 'UPS Shipping';
    private $var_title = 'title';
    private $fee_shipping = '_fee_shipping';

    public function __construct($instance_id = 0)
    {
        $this->id = 'ups_eu_shipping';
        $this->instance_id = absint($instance_id);
        $this->method_title = __($this->ups_shipping, \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        $this->method_description = __(
            'Description about admin of [UPS Shipping]',
            \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
        );
        $this->supports = [
            'shipping-zones',
            'instance-settings',
            'instance-settings-modal',
        ];
        $this->init();
    }

    /**
     * Initialize local pickup.
     */
    public function init()
    {
        // Load the settings.
        $this->init_form_fields();
        $this->init_settings();

        // Define user set variables
        $this->title = $this->get_option($this->var_title);
        $this->tax_status = $this->get_option( 'tax_status' );  //It enables tax included text woo tax and cus tax settings
        $this->cost = $this->get_option('cost');
        if (isset($this->settings['enabled'])) {
            $this->enabled = $this->settings['enabled'];
        } else {
            $this->enabled = 'yes';
        }
        $this->availability = 'including';
        // Actions
        add_action('woocommerce_update_options_shipping_' . $this->id, [$this, 'process_admin_options']);
    }

    /**
     * calculate_shipping function.
     * Calculate local pickup shipping.
     *
     * @param array $package
     */
    public function calculate_shipping($package = [])
    {
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        $ACCEPT_BILLING_PREFERENCE = "";
        if ($model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_BILLING_PREFERENCE) === true) {
            $ACCEPT_BILLING_PREFERENCE = $model_config->value;
        }
        if (intval($ACCEPT_BILLING_PREFERENCE) !== 1) {
            return;
        }
        $fee_shipping = 0;
        if (!empty($package['destination']) && !empty($package['cart_subtotal']) && $package['cart_subtotal'] > 0) {
            $address_string = $package['destination'];
            $check_address = true;
            if (empty($address_string['country'])) {
                $check_address = false;
            }
            // if (empty($address_string['postcode'])) {
            //     $check_address = false;
            // }

            if ($address_string['country'] == 'US' && empty($address_string['state'])) {
                $check_address = false;
            }
            if ($address_string['country'] != 'US' && empty($address_string['city'])) {
                $check_address = false;
            }
            if ($check_address) {
                $_REQUEST['billing_address_1'] = $address_string['address_1'];
                $_REQUEST['billing_address_2'] = $address_string['address_2'];
                $_REQUEST['billing_country'] = $address_string['country'];
                $_REQUEST['billing_city'] = $address_string['city'];
                $_REQUEST['billing_postcode'] = $address_string['postcode'];
                $_REQUEST['billing_state'] = $address_string['state'];
                $_REQUEST['billing_name_state'] = $address_string['state'];
                $_REQUEST['billing_phone'] = '098765432';
                $_REQUEST['get_cart_total'] = $package['cart_subtotal'];
                $_REQUEST['get_woocommerce_currency_symbol'] = get_woocommerce_currency_symbol();
                $_REQUEST['get_woocommerce_currency'] = get_woocommerce_currency();
                $_REQUEST['ups_shipping_text_search'] = '';
                $_REQUEST['ups_shipping_select_search_country'] = $address_string['country'];
                $objectData = new \stdClass();
                $objectData->check = true;
                $objectData->data = call_user_func_array(
                    [
                    new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_EShopper_Api_Ups(),
                    "ups_eu_woo_checkout_load"
                    ],
                    []
                );
                $local_sesson_ups_eu_woocommerce_key = \WC()->session->get("ups_eu_woocommerce_key");
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
                if (!empty($info_content_frontend->service_id)) {
                    $service_id = $info_content_frontend->service_id;
                } else {
                    $service_id = 0;
                }
                if ($service_id > 0 && isset($objectData->data->RateTimeInTransit[$service_id]->custom->monetary_value)) {
                    $fee_shipping = $objectData->data->RateTimeInTransit[$service_id]->custom->monetary_value;
                } else {
                    $fee_shipping = $objectData->data->min_total_price_service->min_price_total;
                }
                //100000000000000
                if ($fee_shipping == 100000000000000) {
                    $fee_shipping = 0;
                }
            }
        }
        //\WC()->session->set($this->fee_shipping, $fee_shipping);
        $ap_html = isset($objectData->data->html->html_AP) ? str_replace(" ", "", $objectData->data->html->html_AP) : "";
        $add_html = isset($objectData->data->html->html_ADD) ? str_replace(" ", "", $objectData->data->html->html_ADD) : "";
        if (empty($ap_html) && empty($add_html)) {
            return;
        }
        $this->add_rate([
            'label' => $this->title,
            'package' => $package,
            'cost' => $fee_shipping,
            'taxes' => ''
            //'cost' => $this->cost,
        ]);
    }

    /**
     * Init form fields.
     */
    public function init_form_fields()
    {
        $this->instance_form_fields = array(
			'title'      => array(
				'title' => __($this->ups_shipping, \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                'type' => 'hidden',
                'description' => __(
                    'Description about frontend [ups eu shipping].',
                    \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                ),
                'default' => __($this->ups_shipping, \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                'desc_tip' => true,
			),
			'tax_status' => array(
				'title'   => __( 'Tax class', 'woocommerce' ),
				'type'    => 'select',
				'class'   => 'wc-enhanced-select',
				'default' => 'None',
				'options' => array(
                    'taxable' => __( 'Taxable', 'woocommerce' ),
                    'none'    => _x( 'None', 'Tax status', 'woocommerce' ),
                ),
			),
			
		);
	}

    public function get_id()
    {
        return $this->id;
    }
}
