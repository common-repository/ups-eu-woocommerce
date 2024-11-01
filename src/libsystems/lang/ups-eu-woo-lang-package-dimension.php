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
 * ups-eu-woo-lang-package-dimension.php - The core plugin class.
 *
 * This is used to load the Package Dimension's languages.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Package_Dimension_Language');

class Ups_Eu_Woo_Package_Dimension_Language extends Ups_Eu_Woo_Common_Language
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
        /* Get load lang common */
        $lang_common = parent::ups_eu_woo_load_lang();
        /* Addition lang */
        $page_lang = [
            "DefaultPackage" => __("Default package", $this->domain),
            "DefaultPackageSetting" => __("Default package setting", $this->domain),
            "PlsEnterPackage" => __("Please select an option", $this->domain),
            "PlsMessageDefaultPackage" => __("Add default packages if you would like the package size used for rating to change based on the number of items in the e-shopper’s order", $this->domain),
            "PlsNoteDefaultPackage" => __("Note: if the number of items in the e-shopper order do not match any of your entries, then the size of the package used for rating will be based on that of the highest item count exceeded by the e-shopper order.", $this->domain),
            "PackageSettingOption1" => __("Number of items in the order determine the package size", $this->domain),
            "PackageSettingOption2" => __("Weights and dimensions of the products in the order determine the package size", $this->domain),
            "IncludeDimensionsSetting" => __("Include dimensions in rating", $this->domain),
            "IncludeDimensionsSettingNote" => __("If set to “No”, rates will be based on product weights only.  If set to “Yes”, product dimensions must be entered in the product settings of your shop", $this->domain),
            "FallbackRate" => __("Backup Rate", $this->domain),
            "AddFallbackRate" => __("Add Backup Rate", $this->domain),
            "AddFallbackRateNote" => __("Backup Rate will only display to e-shoppers if there is an issue within product settings, such as weights missing or if weights/dimensions exceed UPS limits", $this->domain),
            "PackageSettingOption2Note" => __("Warning! To use this option you must enter product weights in the product settings of your shop", $this->domain),
            "ServiceName" => __("Service Name", $this->domain),
            "PackageRate" => __("Rate", $this->domain),
            'NumberItemsOrder' => __("Number of items in order", $this->domain),
            "AddNewPackage" => __("Add New Package", $this->domain),
            "AddPackage" => __("Add Package", $this->domain),
            "RemovePackage" => __("Remove Package", $this->domain),
            "confirm_remove" => __("You are going to remove this default package from your profile.<br>Click Ok to confirm, close the dialog to cancel.", $this->domain),
            "InputMissing" => __("Input missing", $this->domain),
            "PlsInputAtLeastOne" => __("Please input at least one default package to continue", $this->domain),
            "PackageName" => __("Package name", $this->domain),
            "Name" => __("Name", $this->domain),
            "warningWeightPackageMaximum" => __("Warning! Maximum allowable per package weight for shipments created for UPS Access Points is 20.00 kgs or 44.09 lbs.", $this->domain),
            "warningUSWeightPackageMaximum" => __("Warning! Maximum allowable per package weight for shipments created for UPS Access Point is 44lbs.", $this->domain),
            "errorWeightPackageMaximum" => __("Error! Maximum allowable per package weight is 70.00 kgs or 154.32 lbs.", $this->domain),
            "errorUSWeightPackageMaximum" => __("Error! Maximum allowable weight per package weight is 150lbs.", $this->domain),
            "errorDimension" => __("Error! Package exceeds the maximum allowable size of 400 cm or 157.48 inches (the maximum allowable size calculation = length + 2 * width + 2 * height).", $this->domain),
            "errorUSDimension" => __("Error! Package exceeds the maximum allowable size of 165 inches (the maximum allowable size calculation = length + 2 * width + 2 * height).", $this->domain),
            "warningDimension" => __("Warning! Maximum allowable per package size for shipments created for UPS Access Points is 330 cm or 129.92 inches (the maximum allowable size calculation = length + 2 * width + 2 * height).", $this->domain),
            "warningUSDimension" => __("Warning! Maximum allowable per package size for shipments created for UPS Access Point is 130 inches (the maximum allowable size calculation = length + 2 * width + 2 * height).", $this->domain),
            "warningUSLongestSide" => __("Warning! Maximum allowable package length for shipments created for UPS Access Point is 38 inches.", $this->domain),
            "errorUSLongestSide" => __("Error! Maximum allowable package length is 108 inches.", $this->domain),
            "errorCommonMassage" => __("Some of the data you entered were not valid. Please check again.", $this->domain),
            "errorDuplicateMassage" => __("The package item has been exist. Please check again.", $this->domain),
            "Un-Archiving Orders" => __("Un-Archiving Orders", $this->domain),
            "placeholder_example" => __("Example: Standard, Large, Phone box, etc.", $this->domain),
            "EditDefaultPackage" => __("Editing Default Package", $this->domain),
            "AddNewPackage2" => __("Add new package", $this->domain),
            "AddNewPackageNote" => __("Note: the plugin will create a custom package size if an e-shopper order is larger than the packages you enter", $this->domain),
            "PackageDimensionText" => __("Package dimensions", $this->domain),
            "MaxWeight" => __("Maximum Weight", $this->domain),
            "choosePack" => __("Choose packing algorithm", $this->domain),
            "dimUnitPack" => __("Package dimension unit", $this->domain),
            "wegUnitPack" => __("Package weight unit", $this->domain),
            "maxWeightPack" => __("Maximum weight per pack", $this->domain),
        ];
        return array_merge($lang_common, $page_lang);
    }
}
