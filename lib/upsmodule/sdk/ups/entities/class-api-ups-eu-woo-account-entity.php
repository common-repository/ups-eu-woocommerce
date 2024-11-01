<?php

class Ups_Eu_Woo_Account_Entity
{
    public $ShipperAccount;
    public $AccountName = "AccountName";
    public $AccountNumber = "AccountNumber";
    public $CountryCode = "CountryCode";
    public $PostalCode = "PostalCode";

    public $InvoiceInfo;
    public $InvoiceNumber = "InvoiceNumber";
    public $ControlID = "ControlID";
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
    public $Locale = "Locale";
    public $CustomerServiceCode = "CustomerServiceCode";
    public $CustomerName = "CustomerName";
    public $Request = "Request";

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
        // if (isset($data->account_not_needed_indicator)) {
        //     $this->AccountInfo->{$this->AccountNotNeededIndicator} = $data->account_not_needed_indicator;
        // } else {
        //     $this->AccountInfo->{$this->AccountNotNeededIndicator} = "";
        // }
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
