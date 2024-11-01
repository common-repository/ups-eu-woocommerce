<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UpsEuWoocommerce\utils;

/**
 * Description of api
 *
 * @author ThinTV
 */
class AjaxJson
{

    public function processing()
    {
        $objectData = new \stdClass();
        $method = trim(strip_tags(empty($_REQUEST["method"]) ? "" : $_REQUEST["method"]));
        switch ($method) {
            case "create-single-shipment":
                $objectData = $this->create_single_shipment();
                break;
            case "create-single-merge-shipment":
                $objectData = $this->create_single_merge_shipment();
                break;
            case "create-batch-shipment":
                $objectData = $this->create_batch_shipment();
                break;
            case "info-order":
                $objectData = $this->info_order();
                break;
            case "test":
                $this->test();
                break;
        }
        return $objectData;
    }

    public function processing_frontend()
    {
        $objectData = new \stdClass();
        $method = trim(strip_tags(empty($_REQUEST["method"]) ? "" : $_REQUEST["method"]));
        $objectData->check = false;
        switch ($method) {
            case "checkout_update":
                $objectData->check = true;
                $objectData->data = $this->checkout_update();
                break;
            case "checkout_load":
                $objectData->check = true;
                $objectData->data = call_user_func_array([new UpsApi(), "checkout_load"], []);
                break;
            case "test":
                $objectData->check = true;
                $this->test();
                break;
        }
        return $objectData;
    }

    private function create_single_shipment()
    {
        $jsonObject = new \stdClass();
        $router_url = new \UpsEuWoocommerce\models\bases\RouterUrl();
        $UpsEuWoocommerceSmarty = new UpsEuWoocommerceSmarty();
        $merchant_controller = new \UpsEuWoocommerce\controllers\admin\MerchantCf();
        $model_account = new \UpsEuWoocommerce\models\Account();
        
        $dataObject = new \stdClass();
        $dataObject->lang = \UpsEuWoocommerce\utils\Language::get_lang_by_key("open_orders");
        $dataObject->router_url = $router_url;
        //get list account
        $dataObject->list_account = $model_account->get_all();

        $smarty = $UpsEuWoocommerceSmarty->get_smarty();
        $smarty->assign('dataObject', $dataObject);
        $jsonObject->html = $smarty->fetch("admin/merchant_cf/orders/popups/content_single_shipment.tpl");
        $jsonObject->code = "200";
        return $jsonObject;
    }

    //create-single-merge-shipment
    private function create_single_merge_shipment()
    {
        $jsonObject = new \stdClass();
        $router_url = new \UpsEuWoocommerce\models\bases\RouterUrl();
        $UpsEuWoocommerceSmarty = new UpsEuWoocommerceSmarty();
        $smarty = $UpsEuWoocommerceSmarty->get_smarty();
        $dataObject = new \stdClass();
        $dataObject->lang = \UpsEuWoocommerce\utils\Language::get_lang_by_key("open_orders");
        $dataObject->router_url = $router_url;
        $smarty->assign('dataObject', $dataObject);
        $jsonObject->html = $smarty->fetch("admin/merchant_cf/orders/popups/content_single_merge_shipment.tpl");
        $jsonObject->code = "200";
        return $jsonObject;
    }

    private function create_batch_shipment()
    {
        $jsonObject = new \stdClass();
        $router_url = new \UpsEuWoocommerce\models\bases\RouterUrl();
        $UpsEuWoocommerceSmarty = new UpsEuWoocommerceSmarty();
        $smarty = $UpsEuWoocommerceSmarty->get_smarty();
        $dataObject = new \stdClass();
        $dataObject->lang = \UpsEuWoocommerce\utils\Language::get_lang_by_key("open_orders");
        $dataObject->router_url = $router_url;
        $smarty->assign('dataObject', $dataObject);
        $jsonObject->html = $smarty->fetch("admin/merchant_cf/orders/popups/content_batch_shipment.tpl");
        $jsonObject->code = "200";
        return $jsonObject;
    }

    private function info_order()
    {
        $jsonObject = new \stdClass();
        $language = \UpsEuWoocommerce\utils\Language::get_lang_by_key("open_orders");
        $router_url = new \UpsEuWoocommerce\models\bases\RouterUrl();
        $UpsEuWoocommerceSmarty = new UpsEuWoocommerceSmarty();
        $smarty = $UpsEuWoocommerceSmarty->get_smarty();
        $dataObject = new \stdClass();
        $dataObject->lang = \UpsEuWoocommerce\utils\Language::get_lang_by_key("open_orders");
        $dataObject->router_url = $router_url;
        //get order info by order_magento_id
        $order_id_magento = empty($_REQUEST["id_order"]) ? "" : $_REQUEST["id_order"];
        $model_orders = new \UpsEuWoocommerce\models\Orders();
        //$order = $model_Orders->get_list_data_by_condition(["order_id_magento = '{$order_id_magento}'"]);
        // Get data from DB
        $conditions = ["order_id_magento = {$order_id_magento}"];
        $order = $model_orders->pagination_list_data('open_order', [
            'type_get_data' => 'export_csv',
            'conditions' => $conditions,
            'limit' => 1,
        ]);

        if (!empty($order[$order_id_magento])) {
            $order = $order[$order_id_magento];
            $cod = '';
            $cod_amount = '';
            $cod_currency = '';
            $special_char_replace = '&amp;#xD';
            $total_paid = number_format($order->total_price, 2);

            if ($order->cod == 1) {
                $cod = $language['Yes'];
                $cod_amount = $total_paid;
                $cod_currency = $order->currency_code;
            }

            $accessorialValue = '';
            if (!empty($order->accessorial_service)) {
                foreach ($order->accessorial_service as $key => $value) {
                    $accessorial_array[$key] = $language[$key];
                }
                $accessorialShipment = array_values($accessorial_array);

                if ($order->cod == 1) {
                    if ($order->service_type == 'AP') {
                        $accessorialShipment[] = $language['UPS_ACSRL_ACCESS_POINT_COD'];
                    } else {
                        $accessorialShipment[] = $language['UPS_ACSRL_TO_HOME_COD'];
                    }
                }

                $accessorialValue = implode(',', $accessorialShipment);
            }
            $order->cod_currency = $cod_currency;
            $order->total_paid = $total_paid;
            $order->accessorial_service_text = $accessorialValue;
        }

        $dataObject->order = $order;
        $smarty->assign('dataObject', $dataObject);
        $jsonObject->html = $smarty->fetch("admin/merchant_cf/orders/popups/content_info_order.tpl");
        $jsonObject->code = "200";
        return $jsonObject;
    }

    //ups-shipment-frontend
    private function checkout_update()
    {
        $jsonObject = new \stdClass();
        $model_LogFrontend = new \UpsEuWoocommerce\models\LogFrontend();
        $ups_eu_woocommerce_key = empty($_REQUEST["ups_eu_woocommerce_key"]) ? "" : $_REQUEST["ups_eu_woocommerce_key"];
        $ups_eu_woocommerce_key = sanitize_text_field($ups_eu_woocommerce_key);
        $service_id = empty($_REQUEST["service_id"]) ? "" : $_REQUEST["service_id"];
        $service_id = intval($service_id);
        if ($model_LogFrontend->update_data_content_by_woocommerce_key($ups_eu_woocommerce_key, ["service_id" => $service_id]) == true) {
            $jsonObject->check = "ok";
        } else {
            $jsonObject->check = "error";
        }
        return $jsonObject;
    }

    function test()
    {
        $model_Orders = new \UpsEuWoocommerce\models\Orders();
        $model_LogFrontend = new \UpsEuWoocommerce\models\LogFrontend();
        $model_Orders->order_id_magento = "0121211";
        $model_Orders->status = 1;
        $model_Orders->save();
    }
}
