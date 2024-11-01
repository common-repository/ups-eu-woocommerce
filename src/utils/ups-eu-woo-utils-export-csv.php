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
 * ups-eu-woo-utils-export-csv.php - The core plugin class.
 *
 * This is used to export csv.
 */

class Ups_Eu_Woo_Export_CSV
{

    /**
     * @author  United Parcel Service of America, Inc. <noreply@ups.com>
     */
    public function ups_eu_woo_utils_export_csv_file($records, $filename = '')
    {
        foreach ($records as $key => &$list_item) {
            foreach ($list_item as &$value) {
                $value="\"{$value}\"";
            }
        }
        header('Content-type: text/csv');
        header('Content-Type: application/force-download; charset=UTF-8');
        header('Cache-Control: no-store, no-cache');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        ob_end_clean();
        $fh = fopen('php://output', 'w');
        fprintf($fh, chr(0xEF) . chr(0xBB) . chr(0xBF));
        $heading = false;
        if (!empty($records)) {
            foreach ($records as $row) {
                $row = str_replace(["'&amp;#xD", "&#xD;"], ['', ''], $row);
                if (!$heading) {
                    fwrite($fh, implode(",", $row));
                    $heading = true;
                } else {
                    fwrite($fh, "\n" . implode(",", $row));
                }
            }
            fclose($fh);
        }
        exit;
    }
}
