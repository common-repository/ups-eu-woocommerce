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

class Ups_Eu_Woo_Pm_Request_Entity
{
    public $UPSSecurity;    //type object entity UPSSecurity
    public $UsernameToken;  //type object entity UsernameToken
    public $Username = "Username";
    public $Password = "Password";
    public $ServiceAccessToken;  //type object entity ServiceAccessToken
    public $AccessLicenseNumber = "AccessLicenseNumber";

    public $AccessLicenseAgreementRequest;  //type object entity ServiceAccessToken
    public $Request;  //type object entity Request
    public $RequestAction = "RequestAction";
    public $RequestOption = "RequestOption";
    public $TransactionReference;  //type object entity Request
    public $CustomerContext = "CustomerContext";
    public $TransactionIdentifier = "TransactionIdentifier";
    public $DeveloperLicenseNumber = "DeveloperLicenseNumber";
    public $AccessLicenseProfile;  //type object entity ServiceAccessToken
    public $CountryCode = "CountryCode";
    public $LanguageCode = "LanguageCode";
    public $AccessLicenseText = "AccessLicenseText";

    public $Locale;

    public function setUsernameToken($username, $password)
    {
        $this->UsernameToken = new \stdClass();
        $this->UsernameToken->{$this->Username} = $username;
        $this->UsernameToken->{$this->Password} = $password;
    }
    
    public function setServiceAccessToken($access_license_number)
    {
        $this->ServiceAccessToken = new \stdClass();
        $this->ServiceAccessToken->{$this->AccessLicenseNumber} = $access_license_number;
    }
    
    public function setRequestOption($option = "", $action = "")
    {
        $this->Request = new \stdClass();
        if ($action != "") {
            $this->Request->{$this->RequestAction} = $action;
        }
        if ($option != "NULL") {
            $this->Request->{$this->RequestOption} = $option;
        }
        $this->Request->TransactionReference = $this->TransactionReference;
    }
    
    public function setTransactionReference($option = true)
    {
        $this->TransactionReference = new \stdClass();
        $this->TransactionReference->{$this->CustomerContext} = $this->CustomerContext;
        if ($option) {
            $this->TransactionReference->{$this->CustomerContext} = "";
            $this->TransactionReference->{$this->TransactionIdentifier} = "";
        }
    }
    
    public function setAccessLicenseProfile($data)
    {
        $this->AccessLicenseProfile = new \stdClass();
        $this->AccessLicenseProfile->{$this->CountryCode} = $data->country_code;
        $this->AccessLicenseProfile->{$this->LanguageCode} = $data->language_code;
        if (isset($data->access_license_text)) {
            $this->AccessLicenseProfile->{$this->AccessLicenseText} = $data->access_license_text;
        }
    }
    
    public function setLocale($data)
    {
        $this->Locale = new \stdClass();
        $this->Locale->{$this->CountryCode} = $data->country_code;
        $this->Locale->{$this->LanguageCode} = $data->language_code;
    }

    public function setLocaleOpenAccount($data)
    {
        $this->Locale = $data->language_code;
    }
}
