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

class Ups_Eu_Woo_Address_Entity
{
    public $Address;
    public $AddressLine = "AddressLine";
    public $AddressLine1 = "AddressLine1";
    public $AddressLine2 = "AddressLine2";
    public $AddressLine3 = "AddressLine3";
    public $City = "City";
    public $StateProvinceCode = "StateProvinceCode";
    public $PostalCode = "PostalCode";
    public $CountryCode = "CountryCode";

    public $BillingAddress;
    public $PickupAddress;
    public $ContactName = "ContactName";
    public $CompanyName = "CompanyName";
    public $StreetAddress = "StreetAddress";
    public $Phone = "Phone";
    public $Number = "Number";
    public $EmailAddress = "EmailAddress";

    public $OriginAddress;
    public $PhoneNumber = "PhoneNumber";
    public $AddressKeyFormat;
    public $SingleLineAddress = "SingleLineAddress";

    public function setAddress($data)
    {
        $this->Address = new \stdClass();
        $this->Address->{$this->AddressLine1} = $data->address_1;
        $this->Address->{$this->AddressLine2} = $data->address_2;
        $this->Address->{$this->AddressLine3} = $data->address_3;
        $this->Address->{$this->City} = $data->city;
        $this->Address->{$this->StateProvinceCode} = !empty($data->state) ? $data->state : "XX";
        $this->Address->{$this->PostalCode} = $this->reset_str($data->post_code);
        $this->Address->{$this->CountryCode} = $data->country_code;
    }

    public function setAddress2($data)
    {
        $this->Address = new \stdClass();
        $address_line = [$data->address_1, $data->address_2, $data->address_3];

        $this->Address->{$this->AddressLine} = $this->createAddressLine($address_line);
        $this->Address->{$this->City} = $data->city;
        $this->Address->{$this->StateProvinceCode} = !empty($data->state) ? $data->state : "XX";
        $this->Address->{$this->PostalCode} = $this->reset_str($data->post_code);
        $this->Address->{$this->CountryCode} = $data->country_code;
    }

    public function setBillingAddress($data)
    {
        $this->BillingAddress = new \stdClass();
        $this->BillingAddress->{$this->ContactName} = $this->refix_str($data->full_name, 20);
        $this->BillingAddress->{$this->CompanyName} = $this->refix_str($data->company, 30);
        $this->BillingAddress->{$this->StreetAddress} = $this->refix_str($data->street_address, 30);
        if (! empty($data->state) && $data->state != 'XX') {
            $this->BillingAddress->{$this->StateProvinceCode} = $data->state;
        }
        $this->BillingAddress->{$this->City} = $data->city;
        $this->BillingAddress->{$this->CountryCode} = $data->country_code;
        $this->BillingAddress->{$this->PostalCode} = $data->post_code;
        $this->Phone = new \stdClass();
        $this->Phone->{$this->Number} = $data->phone_number;
        $this->BillingAddress->Phone = $this->Phone;
    }

    public function setPickupAddress($data)
    {
        $this->PickupAddress = new \stdClass();
        $this->PickupAddress->{$this->ContactName} = $this->refix_str($data->full_name, 20);
        $this->PickupAddress->{$this->CompanyName} = $this->refix_str($data->company, 30);
        $this->PickupAddress->{$this->StreetAddress} = $this->refix_str($data->street_address, 30);
        if (! empty($data->state) && $data->state != 'XX') {
            $this->PickupAddress->{$this->StateProvinceCode} = $data->state;
        }
        $this->PickupAddress->{$this->City} = $data->city;
        $this->PickupAddress->{$this->CountryCode} = $data->country_code;
        $this->PickupAddress->{$this->PostalCode} = $data->post_code;
        $this->Phone = new \stdClass();
        $this->Phone->{$this->Number} = $data->phone_number;
        $this->PickupAddress->Phone = $this->Phone;
        $this->PickupAddress->{$this->EmailAddress} = $data->email;
    }

    public function setOriginAddress($data)
    {
        $this->OriginAddress = new \stdClass();
        $this->OriginAddress->{$this->PhoneNumber} = isset($data->phone_number) ? $data->phone_number : "";
        $this->AddressKeyFormat = new \stdClass();
        $this->AddressKeyFormat->{$this->SingleLineAddress} = $data->address;
        $this->AddressKeyFormat->{$this->CountryCode} = $data->country_code;
        if ($data->country_code == 'ES') {
            if ((strpos($data->address, ', GC,') > -1) || (strpos($data->address, ', TF,') > -1)) {
                $this->AddressKeyFormat->{$this->CountryCode} = 'IC';
            }
        }
        $this->OriginAddress->AddressKeyFormat = $this->AddressKeyFormat;
    }

    private function refix_str($text, $option2, $option1 = 0)
    {
        return substr($text, $option1, $option2);
    }

    public function reset_str($text, $pattern = '-', $goal = '')
    {
        return str_replace($pattern, $goal, $text);
    }

    private function createAddressLine($address_line)
    {
        $address = [];
        foreach ($address_line as $key => $value) {
            if ($value != "") {
                array_push($address, $value);
            }
        }
        return $address;
    }
}
