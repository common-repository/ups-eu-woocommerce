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
 * Locator.php - The core plugin class.
 *
 * This is used to get location shipping in Bing map.
 */

class Ups_Eu_Woo_Locator_Entity
{
    public $AccessRequest;
    public $AccessLicenseNumber = "AccessLicenseNumber";
    public $Username = "Username";
    public $Password = "Password";

    public $LocatorRequest;
    public $Request;
    public $RequestAction = "RequestAction";
    public $RequestOption = "RequestOption";
    public $TransactionReference = "TransactionReference";

    public $Translate;
    public $Locale = "Locale";

    public $UnitOfMeasurement;
    public $Code = "Code";

    public $LocationSearchCriteria;
    public $MaximumListSize = "MaximumListSize";
    public $SearchRadius = "SearchRadius";

    public function setAccessRequest($data)
    {
        $this->AccessRequest = new \stdClass();
        $this->AccessRequest->{$this->AccessLicenseNumber} = $data->ServiceAccessToken->AccessLicenseNumber;
        $this->AccessRequest->{$this->Username} = $data->UsernameToken->{$this->Username};
        $this->AccessRequest->{$this->Password} = $data->UsernameToken->{$this->Password};
    }

    public function setTranslate($data)
    {
        $this->Translate = new \stdClass();
        $this->Translate->{$this->Locale} = !empty($data->locale) ? $data->locale : "en_US";
    }

    public function setUnitOfMeasurement($data)
    {
        $this->UnitOfMeasurement = new \stdClass();
        $this->UnitOfMeasurement->{$this->Code} = $data->unit_of_measurement;
    }

    public function setLocationSearchCriteria($data)
    {
        $this->LocationSearchCriteria = new \stdClass();
        $this->LocationSearchCriteria->{$this->MaximumListSize} = $data->maximum_list_size;
        $this->LocationSearchCriteria->{$this->SearchRadius} = $data->nearby;
    }
}
