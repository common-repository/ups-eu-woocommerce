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
 * Rate.php - The core plugin class.
 *
 * This is used to get rate's shipping.
 */

class Ups_Eu_Woo_Manage_Account_Entity
{
    public $ShipperAccount;
    public $AccountName = "AccountName";
    public $AccountNumber = "AccountNumber";
    public $CountryCode = "CountryCode";
    public $PostalCode = "PostalCode";
    public $ControlID = "ControlID";

    public $InvoiceInfo;
    public $InvoiceNumber = "InvoiceNumber";
    public $InvoiceDate = "InvoiceDate";
    public $CurrencyCode = "CurrencyCode";
    public $InvoiceAmount = "InvoiceAmount";

    public $PromoDiscountAgreementRequest;
    public $PromoCode = "PromoCode";

    public $CountryCodeInfo;
    public $AgreementAcceptanceCode = "AgreementAcceptanceCode";
    public $AccountInfo = "AccountInfo";
    public $AccountNotNeededIndicator = "AccountNotNeededIndicator";

    public $AccountCharacteristics;
    public $CustomerClassification;
    public $PickupInformation;
    public $PickupOption;
    public $Code = "Code";

    public function setShipperAccount($data)
    {
        include_once("class-api-ups-eu-woo-address-entity.php");
        $address_entity = new Ups_Eu_Woo_Address_Entity();
        $this->ShipperAccount =  new \stdClass();
        switch ($data->account_type) {
            case 1:
                $this->ShipperAccount->{$this->AccountName} = html_entity_decode($data->ups_account_name);
                $this->ShipperAccount->{$this->AccountNumber} = $data->ups_account_number;
                $this->ShipperAccount->{$this->CountryCode} = $data->country_code;
                $this->ShipperAccount->{$this->PostalCode} = $address_entity->reset_str($data->post_code);

                $this->InvoiceInfo = new \stdClass();
                $this->InvoiceInfo->{$this->InvoiceNumber} = $data->ups_invoice_number;
                if ($data->country_code == 'US') {
                    $this->InvoiceInfo->{$this->ControlID} = $data->ups_control_id;
                }
                $this->InvoiceInfo->{$this->InvoiceDate} = $address_entity->reset_str($data->ups_invoice_date);
                $this->InvoiceInfo->{$this->CurrencyCode} = $data->ups_currency;
                $this->InvoiceInfo->{$this->InvoiceAmount} = $data->ups_invoice_amount;

                $this->ShipperAccount->InvoiceInfo = $this->InvoiceInfo;
                break;
            case 2:
                $this->ShipperAccount->{$this->AccountName} = html_entity_decode($data->ups_account_name);
                $this->ShipperAccount->{$this->AccountNumber} = $data->ups_account_number;
                $this->ShipperAccount->{$this->CountryCode} = $data->country_code;
                $this->ShipperAccount->{$this->PostalCode} = $address_entity->reset_str($data->post_code);
                break;
            default:
                $this->ShipperAccount = (object) [];
                break;
        }
    }

    public function setCountryCodeInfo($data)
    {
        include_once("class-api-ups-eu-woo-request-entity.php");
        $request_entity = new Ups_Eu_Woo_Request_Entity();
        $request_entity->setLocale($data);
        $this->CountryCodeInfo = new \stdClass();
        $this->CountryCodeInfo->{$this->AgreementAcceptanceCode} = $data->check_acceptance_code;
        $this->CountryCodeInfo->{$this->PromoCode} = $data->promo_code;
        $this->CountryCodeInfo->Locale = $request_entity->Locale;
    }

    public function setAccountInfo($data)
    {
        $this->AccountInfo =  new \stdClass();
        $this->AccountInfo->{$this->AccountNumber} = $data->account_number;
        // $this->AccountInfo->{$this->AccountNotNeededIndicator} = $data->account_not_needed_indicator;
    }

    public function setAccountCharacteristics()
    {
        $this->AccountCharacteristics = new \stdClass();
        $this->CustomerClassification = new \stdClass();
        $this->CustomerClassification->{$this->Code} = "01";
        $this->AccountCharacteristics->{$this->CustomerClassification} = $this->CustomerClassification;
    }

    public function setPickupInformation()
    {
        $this->PickupInformation = new \stdClass();
        $this->PickupOption = new \stdClass();
        $this->PickupOption->{$this->Code} = "08";
        $this->PickupInformation->PickupOption = $this->PickupOption;
    }
}
