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
 * ups-eu-woo-ajax-json-shipcreate.php - The core plugin class.
 *
 * This is used to define some methods to handle the Create Shipment.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_ShipCreate_Ajax_Json');

class Ups_Eu_Woo_ShipCreate_Ajax_Json extends Ups_Eu_Woo_ShipBase_Ajax_Json
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

    public function ups_eu_woo_config_create_single_shipment()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            http_response_code(403);
        } else {
            $data_post = $_REQUEST;
            $jsonObject = new \stdClass();
            $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
            $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();

            //load neccessary model
            $model_service = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Services();
            $model_accessorial = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Accessorial();
            $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();

            $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
            $dataObject = new \stdClass();
            $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
                $UpsEuWoocommerceSmarty->lang_page_open_orders
            );
            $dataObject->router_url = $router_url;
            $dataObject->list_account = $this->ups_eu_woo_get_list_account();


            //get all shipping service
            $model_config->ups_eu_woo_get_by_key("COUNTRY_CODE");
            $country_code = $model_config->value;
            $services_to_ap = $model_service->get_list_data_by_condition([
                $model_service->col_country_code => $country_code,
                $model_service->col_service_type => 'AP'
            ]);
            $services_to_add = $model_service->get_list_data_by_condition([
                $model_service->col_country_code => $country_code,
                $model_service->col_service_type => 'ADD'
            ]);
            $dataObject->services_to_ap = [];
            if (!empty($services_to_ap)) {
                $dataObject->services_to_ap = $services_to_ap;
            }
            $dataObject->services_to_add = [];
            if (!empty($services_to_add)) {
                $dataObject->services_to_add = $services_to_add;
            }

            //get all accessorial
            $accessorial = $model_accessorial->ups_eu_woo_get_all();
            $accessorial_translate = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
                $UpsEuWoocommerceSmarty->lang_common
            );
            if (!empty($accessorial)) {
                foreach ($accessorial as $key => $item) {
                    $accessorial[$key]->accessorial_name = $accessorial_translate[$item->accessorial_key];
                }
            }
            $dataObject->list_accessorials = $accessorial;

            //get list country and state
            $country = new \WC_Countries();
            $dataObject->list_country = $country->get_countries();
            $dataObject->list_state = $country->get_states();

            $order_id = $data_post['list_id_orders'];
            $list_order = $this->ups_eu_woo_get_order_detail($order_id);
            if (strpos($order_id, ',') > 0) {
                $arr_order_id = explode(',', $order_id);
                $order_id_first = $arr_order_id[0];
                $package_type = json_decode($list_order[$order_id_first]->package_type);
                $package_id = $order_id_first;
                $order_detail = $list_order;
            } else {
                $package_type = json_decode($list_order[$order_id]->package_type);
                $package_id = $order_id;
                $order_detail = $list_order[$order_id];
            }
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
            $dataObject->list_package = $list_package;
            $dataObject->package_id = $package_id;

            $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
            $jsonObject->html = $smarty->fetch("admin/merchant_cf/orders/popups/content_single_shipment.tpl");
            $jsonObject->code = "200";
            $jsonObject->list_account = $dataObject->list_account;
            $jsonObject->order_detail = $order_detail;
            $jsonObject->address_text = $smarty->fetch("admin/merchant_cf/orders/component/info_shipto.tpl");
            return $jsonObject;
        }
    }

    public function ups_eu_woo_config_create_shipment()
    {
        $model_order = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
        $check = true;
        $message = "";
        $result_data = [];

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            http_response_code(403);
        } else {
            $data_post = $_REQUEST;
            $package = $data_post[$model_order->package];
            $package_all = [];
            foreach ($package as $key => $package_item) {
                if (!is_array($package_item)) {
                    $package_all[$key] = json_decode(stripcslashes($package_item));
                } else {
                    $package_all[$key] = (object) $package_item;
                }
            }
            $data_post[$model_order->package] = $package_all;
            $check_edit = $data_post[$model_order->edit_shipment];
            $ship_to = $data_post[$model_order->ship_to];
            $shipping_type = $data_post[$model_order->shipping_type];
            $validate_package = $this->ups_eu_woo_validate_package($package);
            $validate_edit = $this->ups_eu_woo_validate_edit_shipment($check_edit, $ship_to, $shipping_type);
            $error_message = $validate_edit[1];

            if ($validate_package[0] && $validate_edit[0]) {
                $create_result = $this->ups_eu_woo_exec_create_shipment($data_post);
                $check = $create_result[0];
                $message = $create_result[1];
            } else {
                $check = false;
                if ($validate_edit[0]) {
                    $message = $this->package_error;
                    $result_data = $validate_package[1];
                } elseif ($validate_package[0]) {
                    $message = implode($model_order->html_br, $this->ups_eu_woo_add_array($error_message));
                    $result_data = $validate_edit[2];
                } else {
                    $error_message[] = $this->package_error;
                    $message = implode($model_order->html_br, $this->ups_eu_woo_add_array($error_message));
                    $result_data = [$validate_edit[2], $validate_package[1]];
                }
            }

            $dataObject = new \stdClass();
            $dataObject->code = "200";
            $dataObject->check = $check;
            $dataObject->message = $message;
            $dataObject->result = $result_data;
            $dataObject->validate = [$validate_edit[0], $validate_package[0]];
            return $dataObject;
        }
    }

    public function ups_eu_woo_config_create_f_single_shipment()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            http_response_code(403);
        } else {
            $data_post = $_REQUEST;
            $jsonObject = [];
            // $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
            // $UpsEuWoocommerceSmarty = new \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Smarty();

            //load neccessary model
            // $model_service = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Services();
            // $model_accessorial = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Accessorial();
            // $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();

            // $smarty = $UpsEuWoocommerceSmarty->ups_eu_woo_get_smarty();
            $dataObject = new \stdClass();
            // $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
            //     $UpsEuWoocommerceSmarty->lang_page_open_orders
            // );
            // $dataObject->router_url = $router_url;
            $dataObject->list_account = $this->ups_eu_woo_get_list_account();

            $from_addr = [];
            if (isset($dataObject->list_account[0]->ups_account_name)) {
                $from_addr[0] = (string)$dataObject->list_account[0]->ups_account_name;
            } elseif (isset($dataObject->list_account[0]->fullname)) {
                $from_addr[0] = (string)$dataObject->list_account[0]->fullname;
            } else {
                $from_addr[0] = "";
            }

            $from_addr[1] = isset($dataObject->list_account[0]->company) ? (string)$dataObject->list_account[0]->company : '';
            $from_addr[2] = isset($dataObject->list_account[0]->ups_account_number) ? (string)$dataObject->list_account[0]->ups_account_number : '';
            $from_addr[3] = isset($dataObject->list_account[0]->phone_number) ? (string)$dataObject->list_account[0]->phone_number : '';
            $from_addr[4] = isset($dataObject->list_account[0]->address_1) ? (string)$dataObject->list_account[0]->address_1 : '';
            $from_addr[5] = isset($dataObject->list_account[0]->address_2) ? (string)$dataObject->list_account[0]->address_2 : '';
            $from_addr[6] = isset($dataObject->list_account[0]->address_3) ? (string)$dataObject->list_account[0]->address_3 : '';
            $from_addr[7] = isset($dataObject->list_account[0]->city) ? (string)$dataObject->list_account[0]->city : '';
            $from_addr[8] = isset($dataObject->list_account[0]->postal_code) ? (string)$dataObject->list_account[0]->postal_code : '';
            $from_addr[9] = isset($dataObject->list_account[0]->country) ? (string)$dataObject->list_account[0]->country : '';
            $from_addr[10] = isset($dataObject->list_account[0]->state) ? (string)$dataObject->list_account[0]->state : '';

            //get list country and state
            // $country = new \WC_Countries();
            // $dataObject->list_country = $country->get_countries();
            // $dataObject->list_state = $country->get_states();

            $order_id = $data_post['list_id_orders'];
            $list_order = $this->ups_eu_woo_get_order_detail($order_id);
            // echo '<pre>';print_r($list_order); die();
            $package_type = $list_order[$order_id]->package_type;
            $order_detail = $list_order[$order_id];

            $to_addr = [];
            if (!empty($order_detail)) {
                if ($order_detail->service_type == 'AP') {
                    $to_addr[0] = isset($order_detail->ap_name) ? (string)$order_detail->ap_name : '';
                    $to_addr[1] = isset($order_detail->ap_state) ? (string)$order_detail->ap_state : '';
                    $to_addr[2] = isset($order_detail->phone) ? (string)$order_detail->phone : '';
                    $to_addr[3] = isset($order_detail->ap_address1) ? (string)$order_detail->ap_address1 : '';
                    $to_addr[4] = isset($order_detail->ap_address2) ? (string)$order_detail->ap_address2 : '';
                    $to_addr[5] = isset($order_detail->ap_address3) ? (string)$order_detail->ap_address3 : '';
                    $to_addr[6] = isset($order_detail->ap_city) ? (string)$order_detail->ap_city : '';
                    $to_addr[7] = isset($order_detail->ap_postcode) ? (string)$order_detail->ap_postcode : '';
                    $to_addr[8] = isset($order_detail->ap_country) ? (string)$order_detail->ap_country : '';
                } else {
                    $to_addr[0] = isset($order_detail->woo_shipping['first_name']) ? (string)$order_detail->woo_shipping['first_name'] : '';
                    $to_addr[1] = isset($order_detail->woo_shipping['state']) ? (string)$order_detail->woo_shipping['state'] : '';
                    $to_addr[2] = isset($order_detail->phone) ? (string)$order_detail->phone : '';
                    $to_addr[3] = isset($order_detail->woo_shipping['address_1']) ? (string)$order_detail->woo_shipping['address_1'] : '';
                    $to_addr[4] = isset($order_detail->woo_shipping['address_2']) ? (string)$order_detail->woo_shipping['address_2'] : '';
                    $to_addr[5] = '';
                    $to_addr[6] = isset($order_detail->woo_shipping['city']) ? (string)$order_detail->woo_shipping['city'] : '';
                    $to_addr[7] = isset($order_detail->woo_shipping['postcode']) ? (string)$order_detail->woo_shipping['postcode'] : '';
                    $to_addr[8] = isset($order_detail->woo_shipping['country']) ? (string)$order_detail->woo_shipping['country'] : '';
                }
                
                $to_addr[9] = isset($order_detail->email) ? (string)$order_detail->email : '';
            }

            $tot_price = 0;

            if (isset($order_detail->id)) {
                $tot_price = $order_detail->total_price;
            }elseif(isset($order_detail->order_value)){
                $tot_price = $order_detail->order_value;
            } else {
                $tot_price = $order_detail->total_price;
            }

            $packs = !empty($package_type) ? json_decode($package_type, true) : [];
            $packs_json = [];

            if (!empty($packs) && isset($packs[0])) {
                foreach ($packs as $p_key => $pack) {
                    $packs_json[] = json_encode($pack);
                }
            } elseif (!empty($packs)) {
                $packs_json[] = json_encode($packs);
            }
            
            // $smarty->assign($UpsEuWoocommerceSmarty->dataObject, $dataObject);
            // $jsonObject->html = $smarty->fetch("admin/merchant_cf/orders/popups/content_single_shipment.tpl");
            // $jsonObject['code'] = "200";
            $jsonObject['ship_from'] = $from_addr;
            $jsonObject['ship_to'] = $to_addr;
            $jsonObject['package'] = $packs_json;
            $jsonObject['idorder'] = array($order_id);
            $jsonObject['order_value'] = $tot_price;
            // $jsonObject['list_account'] = $dataObject->list_account;
            $jsonObject['order_selected'] = (array)$order_detail;
            $jsonObject['cod'] = $order_detail->cod;
            $jsonObject['edit_shipment'] = 0;

            // $jsonObject->address_text = $smarty->fetch("admin/merchant_cf/orders/component/info_shipto.tpl");
            return $jsonObject;
        }
    }
}