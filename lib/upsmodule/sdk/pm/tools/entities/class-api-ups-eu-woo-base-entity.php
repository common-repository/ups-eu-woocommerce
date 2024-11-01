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

class Ups_Eu_Woo_Base_Entity
{
    /* class entity name */
    public $LicenseEntity = "LicenseEntity";
    public $UserEntity = "UserEntity";
    public $RequestEntity = "RequestEntity";
    public $AccessTokenEntity = "AccessTokenEntity";

    /* common key */
    public $PrimaryContact;
    public $SecondaryContact;
    public $Name = "Name";
    public $Title = "Title";
    public $EMailAddress = "EMailAddress";
    public $PhoneNumber = "PhoneNumber";
    public $FaxNumber = "FaxNumber";

    public $ClientSoftwareProfile;
    public $SoftwareInstaller = "SoftwareInstaller";
    public $SoftwareProductName = "SoftwareProductName";
    public $SoftwareProvider = "SoftwareProvider";
    public $SoftwareVersionNumber = "SoftwareVersionNumber";

    public $EndUserInformation;
    public $EndUserIPAddress = "EndUserIPAddress";
    public $EndUserEmail = "EndUserEmail";
    public $EndUserMyUPSID;
    public $Username = "Username";
    public $VatTaxID = "VatTaxID";
    public $DeviceIdentity = "DeviceIdentity";

    public $REMOTE_ADDR = "REMOTE_ADDR";
    public $HTTP_CLIENT_IP = "HTTP_CLIENT_IP";
    public $HTTP_FORWARDED = "HTTP_FORWARDED";
    public $HTTP_FORWARDED_FOR = "HTTP_FORWARDED_FOR";
    public $HTTP_X_FORWARDED = "HTTP_X_FORWARDED";
    public $HTTP_X_FORWARDED_FOR = "HTTP_X_FORWARDED_FOR";
    public $UNKNOWN = "UNKNOWN";
    public $LOCALHOST = "127.0.0.1";

    public function setPrimaryContact($data)
    {
        $this->PrimaryContact =  new \stdClass();
        $this->PrimaryContact->{$this->Name} = $data->customer_name;
        $this->PrimaryContact->{$this->Title} = $data->title;
        $this->PrimaryContact->{$this->EMailAddress} = $data->email;
        $this->PrimaryContact->{$this->PhoneNumber} = $data->phone_number;
        $this->PrimaryContact->{$this->FaxNumber} = $data->fax;
    }

    public function setSecondaryContact($data)
    {
        $this->SecondaryContact =  new \stdClass();
        $this->SecondaryContact->{$this->Name} = $data->customer_name;
        $this->SecondaryContact->{$this->Title} = $data->title;
        $this->SecondaryContact->{$this->EMailAddress} = $data->email;
        $this->SecondaryContact->{$this->PhoneNumber} = $data->phone_number;
        $this->SecondaryContact->{$this->FaxNumber} = $data->fax;
    }

    public function setClientSoftwareProfile($data)
    {
        $this->ClientSoftwareProfile =  new \stdClass();
        $this->ClientSoftwareProfile->{$this->SoftwareInstaller} = $data->soft_install;
        $this->ClientSoftwareProfile->{$this->SoftwareProductName} = $data->soft_product_name;
        $this->ClientSoftwareProfile->{$this->SoftwareProvider} = $data->soft_provider;
        $this->ClientSoftwareProfile->{$this->SoftwareVersionNumber} = $data->version;
    }

    public function setEndUserInformation($data)
    {
        $this->EndUserInformation = new \stdClass();
        $this->EndUserMyUPSID = new \stdClass();
        $ipclinent = $this->ups_eu_woo_account_get_client_ip();
        //"EndUserIPAddress":"2.30.29.26, 2.30.29.26"
        $last_index_ip = strpos($ipclinent, ",");
        if ($last_index_ip > -1) {
            $ipArray = explode(",", $ipclinent);
            $countIP = count($ipArray);
            if ($countIP > 0) {
                $ipclinent = trim($ipArray[0]);
            }
        }
        $this->EndUserInformation->{$this->EndUserIPAddress} = $ipclinent;
        $this->EndUserInformation->{$this->EndUserEmail} = $data->email;
        $this->EndUserMyUPSID->{$this->Username} = $data->username;
        $this->EndUserInformation->EndUserMyUPSID = $this->EndUserMyUPSID;
        $this->EndUserInformation->VatTaxID = $data->ups_account_vatnumber;
        $this->EndUserInformation->DeviceIdentity = $data->device_identity;
    }

    public function ups_eu_woo_account_get_client_ip()
    {
        //ipaddress
        $ipaddress = $_SERVER[$this->REMOTE_ADDR];
        //check HTTP_CLIENT_IP
        if (isset($_SERVER[$this->HTTP_CLIENT_IP])) {
            //ipaddress
            $ipaddress = $_SERVER[$this->HTTP_CLIENT_IP];
        } elseif (isset($_SERVER[$this->HTTP_X_FORWARDED_FOR])) {
            //ipaddress
            $ipaddress = $_SERVER[$this->HTTP_X_FORWARDED_FOR];
        } elseif (isset($_SERVER[$this->HTTP_X_FORWARDED])) {
            //ipaddress
            $ipaddress = $_SERVER[$this->HTTP_X_FORWARDED];
        } elseif (isset($_SERVER[$this->HTTP_FORWARDED_FOR])) {
            //ipaddress
            $ipaddress = $_SERVER[$this->HTTP_FORWARDED_FOR];
        } elseif (isset($_SERVER[$this->HTTP_FORWARDED])) {
            //ipaddress
            $ipaddress = $_SERVER[$this->HTTP_FORWARDED];
        } elseif (isset($_SERVER[$this->REMOTE_ADDR])) {
            //ipaddress
            $ipaddress = $_SERVER[$this->REMOTE_ADDR];
        } else {
            //ipaddress
            $ipaddress = $this->UNKNOWN;
        }
        //check ipaddress
        if (filter_var($ipaddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $ipaddress = $this->LOCALHOST;
        }
        $lastIndex = strpos($ipaddress, ",");
        if ($lastIndex > -1) {
            $ipArray = explode(",", $ipaddress);
            $countIP = count($ipArray);
            if ($countIP > 0) {
                $ipaddress = trim($ipArray[0]);
            }
        }
        return $ipaddress;
    }
}
