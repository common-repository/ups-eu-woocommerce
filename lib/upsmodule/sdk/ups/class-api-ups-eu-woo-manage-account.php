<?php

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
 * Account.php - The core plugin class.
 *
 * This is used to register account in the current version of the plugin
 */

class Ups_Eu_Woo_Manage_Account
{
    public function ups_eu_woo_api_account_registration_success($data, $upsSecurity)
    {
        include_once("entities/class-api-ups-eu-woo-request-entity.php");
        include_once("entities/class-api-ups-eu-woo-account-entity.php");
        $request_entity = new Ups_Eu_Woo_Request_Entity();
        $account_entity = new Ups_Eu_Woo_Account_Entity();

        $request_entity->setTransactionReference("false");
        $request_entity->setRequestOption("NULL");

        $account_entity->setShipperAccount($data);

        //_post_code
        $data->post_code = str_replace('-', '', $data->post_code);
        //check _ups_invoice_date
        if (! empty($data->ups_invoice_date)) {
            //_ups_invoice_date
            $data->ups_invoice_date = str_replace('-', '', $data->ups_invoice_date);
        }
        //request
        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;
        $request->ManageAccountRequest = new \stdClass();
        $request->ManageAccountRequest->Request = $request_entity->Request;
        
        $request->ManageAccountRequest->Username = $upsSecurity->UsernameToken->Username;
        $request->ManageAccountRequest->Password = $upsSecurity->UsernameToken->Password;
        $request->ManageAccountRequest->ShipperAccount = $account_entity->ShipperAccount;

        return $request;
    }

    public function ups_eu_woo_account_check_success_api($response_data)
    {
        //check_api
        $check_api = [];
        //check Code
        if (isset($response_data->Code)) {
            //check_api[]
            $check_api[] = [
                "Code" => $response_data->Code, //
                "Description" => $response_data->Description, //
            ];
            //check_api
            $check_api = json_decode(json_encode($check_api));
        } else {
            //check_api
            $check_api = $response_data;
        };
        //error_message
        $error_message = [];
        //success_api
        $success_api = 0;
        //code_success
        $code_success = ["010", "012", "040", "042"];   //"045"
        //check check_api
        foreach ($check_api as $key => $value) {
            //check $value->Code
            if (in_array((string)$value->Code, $code_success)) {
                $success_api++;
            } else {
                //error_message
                $error_message[] = $value->Description;
            }
        }
        //check success_api
        if ($success_api > 0) {
            $check = true;
            $error_message = '';
        } else {
            $check = false;
            $error_message = implode(", ", $error_message);
        }
        return [$check, $error_message];
    }
}
