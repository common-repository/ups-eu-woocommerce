<?php namespace UpsEuWoocommerce\utils;

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
 * ups-eu-woo-utils-smarty.php - The core plugin class.
 *
 * This is used to load the Ups_Eu_Woo_Utils_Smarty.
 */

include_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Utils_Smarty');

class Ups_Eu_Woo_Utils_Smarty extends \UpsEuWoocommerce\models\entities\Ups_Eu_Woo_Language_Entity
{

    private static $smarty;
    private $views = '/../views';
    public $dataObject = 'dataObject';

    public function ups_eu_woo_get_smarty()
    {
        if (empty(self::$smarty)) {
            self::$smarty = new \Smarty();
            try {
                self::$smarty->debugging = true;
                self::$smarty->caching = false;
                self::$smarty->cache_lifetime = 120;
                self::$smarty->compile_check = true;
                self::$smarty->force_compile = true;
                self::$smarty->setTemplateDir(dirname(__FILE__) . $this->views);
                self::$smarty->setCompileDir(get_temp_dir() . 'smarty/templates_c');
                self::$smarty->setCacheDir(get_temp_dir() . 'smarty/cache');
            } catch (Exception $e) {
                wp_send_json([
                    "Message UPS Shipping" => "You don't have permission to write the file to the folder temp of the system. Pls, check again permission for the temp folder.",
                    "Exception" => $e]);
                return false;
            }
            self::$smarty->assign('img_url', \UpsEuWoocommerce\Ups_Eu_Woo_Main::ups_eu_woo_plugin_url_ups() . '/assets/admin/images/');
            $objectSys = new \stdClass();
            $objectSys->request = $_REQUEST;
            self::$smarty->assign('objectSys', $objectSys);
        }
        return self::$smarty;
    }
}
