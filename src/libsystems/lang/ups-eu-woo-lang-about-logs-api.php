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
 * ups-eu-woo-lang-about-logs-api.php - The core plugin class.
 *
 * This is used to load About's languages.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_About_Logs_Api_Language');

class Ups_Eu_Woo_About_Logs_Api_Language extends Ups_Eu_Woo_Common_Language
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
        if (isset($_POST['downloadlog'])) {
            $file = fopen("Upslogs.csv","w");
            global $wpdb;
            $logsfrmdb_sql = "SELECT id , method , full_uri ,  request ,  response ,  time_request, time_response FROM ".$wpdb->prefix."ups_shipping_logs_api order by `id` desc limit 0, 100"; 
            $logsfrmdb = $wpdb->get_results($logsfrmdb_sql);
            fputcsv($file, array("id", "method" ,"full_uri", "request", "response", "time_request", "time_response"));
            if(!empty($logsfrmdb)){
                foreach($logsfrmdb as $l){
                    fputcsv($file, array($l -> id, $l -> method ,$l -> full_uri , $l ->  request , $l ->  response , $l ->  time_request , $l->  time_response ));
                }
            }
            fclose($file);
            $url = "Upslogs.csv";
            $file_name = basename($url); 
            $info = pathinfo($file_name);
            
            // Checking if the file is a
            // CSV file or not
            if ($info["extension"] == "csv") {
            
                /* Informing the browser that
                the file type of the concerned
                file is a MIME type (Multipurpose
                Internet Mail Extension type).
                Hence, no need to play the file
                but to directly download it on
                the client's machine. */
                header("Content-Description: File Transfer"); 
                header("Content-Type: application/octet-stream"); 
                header(
                "Content-Disposition: attachment; filename=\""
                . $file_name . "\"");
                ob_clean();
                flush();
                readfile ($url);
                
            } 
            unlink("Upslogs.csv");
            exit();
        }
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
        /* Additions lang */
        $model_logs_api = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();

        /** release */
        $version            = '3.8.0';
        $dateRelease        = ['11', 'April', '2023'];
        $textDateRelease    = __("Release date April 11, 2023", $this->domain);
        $textDateConvert    = str_replace("dd", $dateRelease[0], $textDateRelease);
        $textDateConvert    = str_replace("mm", __($dateRelease[1], $this->domain), $textDateConvert);
        $textDateConvert    = str_replace("yy", $dateRelease[2], $textDateConvert);

        $page_lang = [
            $model_logs_api->col_id => __("ID", $this->domain),
            $model_logs_api->col_method => __("method", $this->domain),
            $model_logs_api->col_full_uri => __("Full url", $this->domain),
            $model_logs_api->col_response => __("Response", $this->domain),
            $model_logs_api->col_request => __("Request", $this->domain),
            $model_logs_api->col_response => __("Response", $this->domain),
            $model_logs_api->col_time_request => __("Time Request", $this->domain),
            $model_logs_api->col_time_response => __("Time Response", $this->domain),
            "title_about_logs_api" => __("About", $this->domain),
            "version_title" => __("Module version number and release date", $this->domain),
            "plugin_version" => sprintf(__("Module version v3.8.0", $this->domain), $version),
            "minor_bug_fixes" => __("checkout language issue fixed.", $this->domain),
            "plugin_release_date" => $textDateConvert,
            "for_more_infomation_1" => __("For more information visit %s", $this->domain),
            "compatible" => __("Compatible with WooCommerce versions 3.2, 3.3, 4.x, 5.x", $this->domain),
            "Support_information" => __("Installation Support:", $this->domain),
            "Support_information_1" => __("For installation instructions please visit<br/><a href='https://support.ecommerce.help/hc/en-us/sections/4405591774481-Official-Extension-for-WooCommerce'>https://support.ecommerce.help/hc/en-us/sections/4405591774481-Official-Extension-for-WooCommerce</a><br/><br/>For technical issues please visit <br/><a href='https://ecommerce.help/product/ups-plugins'>https://ecommerce.help/product/ups-plugins</a><br/><br/>and open up a support case. Our support team will take care of your issue.<br/><br/><b>Telephone Support</b><br><br>", $this->domain),
            "changelog" => __("Changelog", $this->domain),
            "platfrom_capatibility" => __("Platform compatibility statement", $this->domain),
            "back_link" => __("UPS Shipping Module website", $this->domain),
            "dwnld_log" => __("Download Log",$this->domain),
            "dwnld_info" => __("To Print Log click the Download Log button here:", $this->domain),
        ];
        return array_merge($lang_common, $page_lang);
    }
}
