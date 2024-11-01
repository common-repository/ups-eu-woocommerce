<?php namespace UpsEuWoocommerce\libsystems\ajax_json;

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
 * ups-eu-woo-ajax-json-shipbatch.php - The core plugin class.
 *
 * This is used to define some methods to handle the Shipment Batch.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_ShipBatch_Ajax_Json');

class Ups_Eu_Woo_ShipBatch_Ajax_Json extends Ups_Eu_Woo_ShipBase_Ajax_Json
{
    /*
     * Name function: __construct
     * Params:
     *  @domain: type string
     * Return: type void
     * * */

    public function __construct()
    {
        /* call parent construct */
        parent::__construct();
    }

    public function ups_eu_woo_config_create_batch_shipment()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            http_response_code(403);
        } else {
            $data_post = $_REQUEST;
            $jsonObject = new \stdClass();
            $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
            $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();
            $model_account = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Account();
            $model_package = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Package_Default();

            $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
            $dataObject = new \stdClass();
            $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
                $UpsEuWoocommerceSmarty->lang_page_open_orders
            );
            $dataObject->router_url = $router_url;
            $dataObject->list_account = $this->ups_eu_woo_get_list_account();
            $account_default = $model_account->ups_eu_woo_get_default_account();
            $account_default_id = 1;
            if (!empty($account_default)) {
                $account_default_id = $account_default["account_id"];
            }
            $dataObject->list_package = $model_package->ups_eu_woo_get_all();

            $list_order = explode(',', trim(strip_tags($data_post['list_id_orders'])));
            if (! empty($list_order)) {
                $index = 1;
                foreach ($list_order as $key => $item) {
                    if (ctype_digit(trim($item))) {
                        $list_order[$key] = '&nbsp' . $index . '. ' . $item;
                        $index++;
                    } else {
                        $router_url->ups_eu_woo_redirect_not_found_page();
                    }
                }
            }

            $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
            $jsonObject->html = $smarty->fetch("admin/merchant_cf/orders/popups/content_batch_shipment.tpl");
            $jsonObject->code = "200";
            $jsonObject->list_account = $dataObject->list_account;
            $jsonObject->list_order = implode('<br>', $list_order);
            $jsonObject->account_default_id = $account_default_id;
            return $jsonObject;
        }
    }

    public function ups_eu_woo_config_exec_create_batch_shipment()
    {
        $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            http_response_code(403);
        } else {
            $data_post = $_REQUEST;
            $data = [];
            $data[$model_orders->ship_from] = $data_post[$model_orders->ship_from];
            $list_order = $data_post[$model_orders->idorder];

            //get package default
            /*$package_default = $model_package->ups_eu_woo_get_by_id(1);
            $data[$model_orders->package] = array($package_default->package_id);*/

            $result = [];
            $list_error = [];
            $list_order_new = [];
            if (! empty($list_order)) {
                $index = 1;
                $error = 1;
                foreach ($list_order as $item) {
                    if (ctype_digit($item)) {
                        $order_info = $this->ups_eu_woo_get_order_detail($item);
                        $order = $order_info[$item];
                        if (! empty($order)) {
                            if (strtolower($order->service_type) == "ap") {
                                $ship_to = [
                                    $order->ap_name,
                                    $order->ap_state,
                                    $order->phone,
                                    $order->ap_address1,
                                    $order->ap_address2,
                                    $order->ap_address3,
                                    $order->ap_city,
                                    $order->ap_postcode,
                                    $order->ap_country,
                                    $order->email
                                ];
                            } else {
                                $customer_name = $order->woo_shipping[$model_orders->first_name] . ' ' .
                                    $order->woo_shipping[$model_orders->last_name];
                                $ship_to = [
                                    $customer_name,
                                    $order->woo_shipping[$model_orders->state],
                                    $order->phone,
                                    $order->woo_shipping[$model_orders->var_address_1],
                                    $order->woo_shipping[$model_orders->var_address_2],
                                    "",
                                    $order->woo_shipping[$model_orders->city],
                                    $order->woo_shipping[$model_orders->postcode],
                                    $order->woo_shipping[$model_orders->country],
                                    $order->email
                                ];
                            }
                            $data[$model_orders->ship_to] = $ship_to;
                            $shipping_type = [
                                $order->service_type,
                                $order->rate_code,
                                $order->shipping_service,
                                $order->service_name
                            ];
                            $data[$model_orders->shipping_type] = $shipping_type;
                            $data[$model_orders->col_accessorial_service] = $order->accessorial_service;
                            $data[$model_orders->edit_shipment] = 0;
                            $data[$model_orders->order_selected] = (array) $order;
                            $data[$model_orders->col_cod] = $order->cod;
                            $data[$model_orders->order_value] = $order_info[$model_orders->order_value];
                            $data[$model_orders->idorder] = [$item];
                            // modify package data
                            $package_type = json_decode($order->package_type);
                            $list_package = [];
                            if (is_array($package_type)) {
                                $list_package = $package_type;
                            } elseif (is_object($package_type)) {
                                // Handle for setting default package dimension or old order record
                                $package_item = new \stdClass();
                                $package_item->length = $package_type->length;
                                $package_item->width  = $package_type->width;
                                $package_item->height = $package_type->height;
                                $package_item->unit_dimension = property_exists($package_type, 'dimension_unit') ? $package_type->dimension_unit : $package_type->unit_dimension;
                                $package_item->weight = $package_type->weight;
                                $package_item->unit_weight = property_exists($package_type, 'weight_unit') ? $package_type->weight_unit : $package_type->unit_weight;
                                $list_package[] = $package_item;
                            }
                            $data[$model_orders->package] = $list_package;
                            $create_result = $this->ups_eu_woo_exec_create_shipment($data);

                            if ($create_result[0]) {
                                $result[] = $model_orders->space_key . $index . '. ' . $item .
                                    ' <i class="fa fa-check" aria-hidden="true" style="color: #4cb64c;"></i>';
                            } else {
                                $result[] = $model_orders->space_key . $index . '. ' . $item .
                                    ' <i class="fa fa-times" aria-hidden="true" style="color: red;"></i> ' . $create_result[1];
                                $list_error[] = $model_orders->space_key . $error . '. ' . $item;
                                $list_order_new[] = $item;
                                $error++;
                            }
                        } else {
                            $result[] = $model_orders->space_key . $index . '. ' . $item .
                                ' <i class="fa fa-times" aria-hidden="true" style="color: red;"></i>';
                            $list_error[] = $model_orders->space_key . $error . '. ' . $item;
                            $list_order_new[] = $item;
                            $error++;
                        }
                    } else {
                        http_response_code(403);
                        wp_die(__('Sorry, order id must be an numeric type'), 403);
                    }
                    $index++;
                }
            }

            $dataObject = new \stdClass();
            $dataObject->code = "200";
            $dataObject->result = implode($model_orders->html_br, $result);
            $dataObject->list_error = implode($model_orders->html_br, $list_error);
            $dataObject->list_order = $list_order_new;
            return $dataObject;
        }
    }
}
