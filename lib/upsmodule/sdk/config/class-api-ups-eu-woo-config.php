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
 * Common.php - The core plugin class.
 *
 * This is used to define and call to UPS's API.
 */

class Ups_Eu_Woo_Config
{
    //define constants
    public $ups_eu_woo_env = "UAT"; // UAT
    public $ups_eu_woo_pro = "PRO"; // PRO
    public $ups_eu_woo_domain_host_uri = 'localhost/wp-5';
    public $ups_eu_woo_timeout = 600;
    public $ups_eu_woo_apiurltool = [
        'DEV' => "https://fa-ecptools-dev.azurewebsites.net/api/",
        'UAT' => "https://fa-ecptools-uat.azurewebsites.net/api/",
        'PRO' => "https://fa-ecptools-prd.azurewebsites.net/api/"
    ];
    public $ups_eu_woo_apiurlanalytic = [
        'DEV' => "https://fa-ecpanalytics-dev.azurewebsites.net/api/",
        'UAT' => "https://fa-ecpanalytics-uat.azurewebsites.net/api/",
        'PRO' => "https://fa-ecpanalytics-prd.azurewebsites.net/api/"
    ];
    public $ups_eu_woo_apiurlups = [
        'DEV' => "https://onlinetools.ups.com/rest/",
        'UAT' => "https://onlinetools.ups.com/rest/",
        'PRO' => "https://onlinetools.ups.com/rest/"
    ];
}
