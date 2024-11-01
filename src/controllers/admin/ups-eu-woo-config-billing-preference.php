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
 * ups-eu-woo-config-billing-preference.php - The core plugin class.
 *
 * This is used to config Billing Preference.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Config_Billing_Preference');

class Ups_Eu_Woo_Config_Billing_Preference
{

    /**
     * Name function: billing_preference
     * Params: empty
     * Return: $dataObject
     */
    public function ups_eu_woo_config_billing_preference()
    {
        /* Load all class and models */
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        /* get value config ACCEPT_BILLING_PREFERENCE */
        $model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_BILLING_PREFERENCE);
        /* check method post */
        if ($router_url->ups_eu_woo_check_method_post() === true) {
            $btn_controller = "";
            if (!empty($_REQUEST[$router_url->btn_controller])) {
                $btn_controller = trim(sanitize_text_field(strip_tags($_REQUEST[$router_url->btn_controller])));
            }
            /* check config is complete */
            if ($model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_BILLING_PREFERENCE) === true &&
                $btn_controller == 'complete') {
                if (intval($model_config->value) === 2) {
                    /* save config value */
                    $model_config->value = 1;
                    $model_config->ups_eu_woo_save();
                }
                /* transfer merchant info */
                $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
                if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_transfer_info_already_done) !== true) {
                    call_user_func_array([
                        new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Retry_Api(), "ups_eu_woo_transfer_merchant_info"
                    ], []);
                    /*save check manage key */
                    $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
                    if ($model_config->ups_eu_woo_get_by_key($model_config->ups_shipping_check_manage) === true) {
                        $model_config->value = 1;
                        $model_config->ups_eu_woo_save();
                    } else {
                        $model_config->key = 'ups_shipping_check_manage';
                        $model_config->value = 1;
                        $model_config->scope = "default";
                        $model_config->ups_eu_woo_save();
                        $this->ups_eu_woo_get_bing_map_key();
                    }
                }
                /*old order package generate*/
                $this->ups_eu_woo_import_existing_orders();
                /*redirect to open order page */
                $router_url->ups_eu_woo_redirect($router_url->url_open_orders);
            }
        }

        $dataObject = new \stdClass();
        /* get language by key */
        $dataObject->lang = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key(
            $model_config->lang_page_billing_preference
        );
        $dataObject->number_block_show = $router_url->ups_eu_woo_get_number_block_show(
            $router_url->block_billing_preference,
            7
        );
        /* get link action form */
        $dataObject->action_form = $router_url->url_billing_preference;
        /* get all link form */
        $dataObject->links_form = $router_url->ups_eu_woo_get_all_link_form();
        /* set language code */
        if (!empty(get_locale())) {
            $dataObject->language = $language_code = strtoupper(substr(get_locale(), 0, 2));
        } else {
            $dataObject->language = $language_code = 'EN';
        }
        /* set page */
        $dataObject->page = $router_url->block_billing_preference;
        /* return data */
        return $dataObject;
    }
    
    /* start old orders packages generate in complete confiquration*/
    public function ups_eu_woo_import_existing_orders()
    {
        global $wpdb;
        $order = $wpdb->get_results("
            SELECT wc_order_stats.order_id
            FROM ".$wpdb->prefix."wc_order_stats AS wc_order_stats
            LEFT JOIN ".$wpdb->prefix."ups_shipping_orders AS ups_shipping_orders
            ON wc_order_stats.order_id =  ups_shipping_orders.order_id_magento
            WHERE wc_order_stats.status='wc-processing' AND ups_shipping_orders.order_id_magento IS NULL ");
        $pack = $wpdb->get_results("SELECT order_id_magento FROM ".$wpdb->prefix."ups_shipping_orders WHERE package_type IS NULL ");
        if(!empty($pack)){
            $this->ups_eu_woo_pack_validate($pack);
        }
        foreach ($order as $order) { 	
            $order_id=$order->order_id;
            $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
            $model_package = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Package_Default();
            $model_pack = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Package_Type();
            //$model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
            //$this->ups_eu_woo_pack_validate();
            $model_orders->order_id_magento = $order_id;
            $model_orders->status = 1;
            $package_type =$model_pack->ups_eu_woo_pack_order_items($order_id);
            $model_orders->package_type = json_encode($package_type);
            $order = wc_get_order($order_id);
            $model_orders->woo_tmp_order_date = $order->order_date; 
            $model_orders->ups_eu_woo_save();
        }
    }
    
    /* end*/ 

    public function ups_eu_woo_pack_validate($pack)
    {
        $model_package = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Package_Default();
        $model_pack = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Package_Type();
        global $wpdb;
        foreach($pack as $pack){
            $order_id = $pack->order_id_magento;
            $package =$model_pack->ups_eu_woo_pack_order_items($order_id);
            $package_type = json_encode($package);
            $wpdb->query("UPDATE ".$wpdb->prefix."ups_shipping_orders SET package_type='$package_type' WHERE order_id_magento=$order_id ");
        }
       
    }

    /**
     * Name function: ups_eu_woo_get_registered_token_and_bing_map_key
     * Params: empty
     * Return: void
     */
    public function ups_eu_woo_get_bing_map_key()
    {
        /* call plugin manage api */
        call_user_func_array([
            new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Manage_Api_Ups(),
            "ups_eu_woo_call_api_get_bing_map_credential"
            ], []);
    }

    /**
     * Name function: check_api_response
     * Params:
     * @labelRecovery: type object
     * Return:  type object
     */
    private function ups_eu_woo_check_api_response(&$labelRecovery)
    {
        $labelResultsPrint = [];
        /* check response print label */
        if (isset($labelRecovery->LabelRecoveryResponse->Response->ResponseStatus->Code) &&
            ($labelRecovery->LabelRecoveryResponse->Response->ResponseStatus->Code == 1) &&
            isset($labelRecovery->LabelRecoveryResponse->LabelResults)) {
            /* check result data */
            if (is_array($labelRecovery->LabelRecoveryResponse->LabelResults)) {
                foreach ($labelRecovery->LabelRecoveryResponse->LabelResults as $item) {
                    if (isset($item->LabelImage->GraphicImage)) {
                        $labelResultsPrint[] = $item;
                    }
                }
            } elseif (isset($labelRecovery->LabelRecoveryResponse->LabelResults->LabelImage->GraphicImage)) {
                $labelResultsPrint[] = $labelRecovery->LabelRecoveryResponse->LabelResults;
            }
        } elseif (isset($labelRecovery->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description)) {
            update_option("ups_offi_label_status", (string)$labelRecovery->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description);
        } else {
            update_option("ups_offi_label_status", "Unknown error occurred while downloading label");
        }
        return $labelResultsPrint;
    }

    /**
     * Name function: ups_eu_woo_config_print_label
     * Params:
     * @listShipmentNumbers: type string
     * @labelOption: type string
     * Return: type void
     */
    public function ups_eu_woo_config_print_label($listShipmentNumbers, $labelOption)
    {
        $shipmentNumbers = explode(',', $listShipmentNumbers);
        $fileExt = '.' . strtolower($labelOption);
        /* set api library */
        $upsapi_config = new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Configurations_Api_Ups();
        $enity_language = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Language_Entity();
        $entity_shipment = new \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Shipments_Entity();

        /* get language by key */
        $language = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::ups_eu_woo_get_lang_by_key($enity_language->lang_page_shipments);
        $shipmentNumbers = array_unique($shipmentNumbers);
        foreach ($shipmentNumbers as $key2 => $value) {
            $data = new \stdClass();
            $data->tracking_number = $value;
            $data->label_option = $labelOption;
            /* call api to get data print label */
            $labelRecovery = json_decode($upsapi_config->ups_eu_woo_print_label($data));
            $decode = "";
            /* check api response and get data label to print */
            $labelResultsPrint = $this->ups_eu_woo_check_api_response($labelRecovery);
            if (empty($labelResultsPrint)) {
                return false;
            }
            /* decode data */
            $decoded = "";
            foreach ($labelResultsPrint as $labelResult) {
                $decoded .= base64_decode($labelResult->LabelImage->GraphicImage);
            }
            $tempName = tempnam(sys_get_temp_dir(), $language[$entity_shipment->LabelShipment] . $key2);
            rename($tempName, $tempName . $fileExt);
            /* put contents */
            file_put_contents($tempName, $decoded);
            $arrayList[] = [$tempName, $value];
        }
        //zip file
        $zip = new \ZipArchive();
        $linkzip = tempnam(sys_get_temp_dir(), $language[$entity_shipment->LabelShipment]);
        /* create print label zip file */
        rename($linkzip, $linkzip .= '.zip');
        if ($zip->open($linkzip, \ZipArchive::CREATE) === true) {
            foreach ($arrayList as $key3 => $value) {
                $linkfile = $value[0];
                $zip->addFile($linkfile, $language[$entity_shipment->LabelShipment] . $key3 . '_' . $value[1] . $fileExt);
            }
            $zip->close();
            foreach ($arrayList as $value) {
                $linkfile = $value[0];
                $this->ups_eu_woo_config_unlink_file($linkfile);
            }
            header("Content-type: application/zip");
            header("Content-Disposition: attachment; filename=" . $language[$entity_shipment->LabelShipment] . ".zip");
            header("Pragma: no-cache");
            header("Expires: 0");
            ob_end_clean();
            flush();
            readfile($linkzip);
            $this->ups_eu_woo_config_unlink_file($linkzip);
        }
        wp_send_json([]);
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
}
