<?php

namespace UpsEuWoocommerce\models\entities;

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
 * ups-eu-woo-model-entity-account.php - The core plugin class.
 *
 * This is used to define the Account Entity.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Account_Entity');

class Ups_Eu_Woo_Account_Entity extends \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Base
{
    /* List colum name in table [account] database */

    public $col_account_id = "account_id";
    public $col_title = "title";
    public $col_fullname = "fullname";
    public $col_company = "company";
    public $col_email = "email";
    public $col_phone_number = "phone_number";
    public $col_address_type = "address_type";
    public $col_address_1 = "address_1";
    public $col_address_2 = "address_2";
    public $col_address_3 = "address_3";
    public $col_postal_code = "postal_code";
    public $col_state = "state";
    public $col_city = "city";
    public $col_country = "country";
    public $col_account_type = "account_type";
    public $col_ups_account_name = "ups_account_name";
    public $col_ups_account_number = "ups_account_number";
    public $col_ups_account_u_name = "ups_account_u_name";
    public $col_ups_account_password = "ups_account_password";
    public $col_ups_account_access = "ups_account_access";
    public $col_ups_invoice_number = "ups_invoice_number";
    public $col_ups_control_id = "ups_control_id";
    public $col_ups_invoice_amount = "ups_invoice_amount";
    public $col_ups_currency = "ups_currency";
    public $col_ups_invoice_date = "ups_invoice_date";
    public $col_account_default = "account_default";
    public $col_device_identity = "device_identity";
    public $col_ups_account_vatnumber = "ups_account_vatnumber";
    public $col_ups_account_promocode = "ups_account_promocode";
    /* extends */
    public $key_have_with_invoice = "have_with_invoice";
    public $key_have_without_invoice = "have_without_invoice";
    public $key_have_with_accpass = "have_with_accpass";
    public $key_accept_account = "ACCEPT_ACCOUNT";
    public $key_id_remove = "id_remove";
    public $key_mess_success = "mess_success";
}
