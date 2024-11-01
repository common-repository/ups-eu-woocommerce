<?php namespace UpsEuWoocommerce\libsystems\lang;

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
 * ups-eu-woo-lang-account.php - The core plugin class.
 *
 * This is used to load the Account's languages.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Account_Language');

class Ups_Eu_Woo_Account_Language extends Ups_Eu_Woo_Common_Language
{

    protected $list_lang;

    /*
     * Name function: __construct
     * Params:
     *  @domain: type string
     * Return: type void
     * * */

    public function __construct($domain)
    {
        parent::__construct($domain);
    }
    /*
     * Name function: ups_eu_woo_load_lang
     * Params: empty
     * Return: type array
     * * */

    public function ups_eu_woo_load_lang()
    {
        /* Get load  lang common */
        $lang_common = parent::ups_eu_woo_load_lang();
        $MSG_OPENACCOUNT = "";
        $MSG_OPENACCOUNT_STATUS = 0;

        if (isset($_SESSION['MSG_OPENACCOUNT']) && $_SESSION['MSG_OPENACCOUNT'] != "") {
            $MSG_OPENACCOUNT = $_SESSION['MSG_OPENACCOUNT'];
            $MSG_OPENACCOUNT_STATUS = $_SESSION['MSG_OPENACCOUNT_STATUS'];
            $_SESSION['MSG_OPENACCOUNT'] = "";
            $_SESSION['MSG_OPENACCOUNT_STATUS'] = 0;
        }

        /* Addition lang  */
        $page_lang = [
            "your_ups_profile" => __("Your UPS Profile", $this->domain),
            "form_title1" => __("Please choose one of the account linking options below and fill the necessary form fields to get started.", $this->domain),
            "invoice_number" => __("Invoice number", $this->domain),
            "invoice_amount" => __("Invoice amount", $this->domain),
            "tooltip_address_type" => __("Reference name that will be associate with an account. For example warehouse 1, warehouse 2,  Store 1, Store 2 etc. You can freely chose the name as per your requirement.", $this->domain),
            "tooltip_account_name" => __("The name associated with your UPS account. It can be found on the top on each page of your UPS invoice under 'Purchaser'", $this->domain),
            "tooltip_postal_code" => __("The postal code or zip code associated with your UPS account. It can be found on the top on each page of your UPS invoice under 'Purchaser'", $this->domain),
            "tooltip_account_number" => __("A unique six character alphanumeric number that identifies your account. It can be found on the top left side on each page of your UPS invoice", $this->domain),
            "tooltip_invoice_number" => __("A unique 12 digit number assigned by UPS to an invoice. It can be found on the top left side on each page of your UPS invoice", $this->domain),
            "tooltip_invoice_amount" => __("Total Amount Due for the given invoice. It can be found on the 'Summary of Charges' table on the first page on the invoice", $this->domain),
            "tooltip_invoice_date" => __("Date of issuing the invoice. It can be found on the top left side on each page of your UPS invoice", $this->domain),
            "full_name_success" => __("Full name", $this->domain),
            "company" => __("Company", $this->domain),
            "city" => __("City", $this->domain),
            "default_account" => __("Default Account", $this->domain),
            "your_payment_profile" => __("Your Payment Account", $this->domain),
            "add_another_account_number" => __("Add another account number", $this->domain),
            "des1" => __("Please enter the address attached to your account number", $this->domain),
            "address_type" => __("Address type", $this->domain),
            "address_type_des" => __("Example: Warehouse, Branch #1", $this->domain),
            "name_des" => __("Your business name", $this->domain),
            "address_des" => __("Street Address", $this->domain),
            "address_des1" => __("Apartment, Suite, Unit, Building, Floor, etc.", $this->domain),
            "address_des2" => __("Department, c/o, etc.", $this->domain),
            "phone" => __("Phone", $this->domain),
            "have_account_1" => __("I have a UPS Account Number WITH an invoice occurred in the last 45 days", $this->domain),
            "have_account_1_pls" => __("The invoice should be 1 of the last 3 issued by UPS in last 45 days", $this->domain),
            "invoice_date" => __("Invoice date", $this->domain),
            "have_account_without_invoice" => __("I have a UPS Account Number WITHOUT an invoice occurred in the last 45 days", $this->domain),
            "verify" => __("Verify", $this->domain),
            "remove" => __("Remove", $this->domain),
            "confirm_remove_account" => __("This account will be removed. Click Ok to confirm, close the dialog to cancel.", $this->domain),
            "RemoveAccount" => __("Remove Account", $this->domain),
            "MSG_OPENACCOUNT" => $MSG_OPENACCOUNT,
            "MSG_OPENACCOUNT_STATUS" => $MSG_OPENACCOUNT_STATUS,
            "reset_name" => __("UPS Username", $this->domain),
            "reset_pass" => __("UPS Password", $this->domain),
            "reset_name_des" => __("Enter UPS site login Username", $this->domain),
            "reset_pass_des" => __("Enter UPS site login Password", $this->domain),
            "tooltip_reset_name" => __("Username or user id that using on ups website for login your UPS account.", $this->domain),
            "tooltip_reset_pass" => __("Password that using on ups website for login your UPS account.", $this->domain),
            "procced_change" => __("Proceed to change", $this->domain)
        ];
        return array_merge($lang_common, $page_lang);
    }
}
