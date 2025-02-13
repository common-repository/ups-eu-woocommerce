<?php namespace UpsEuWoocommerce\libsystems;

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
 * ups-eu-woo-pagination.php - The core plugin class.
 *
 * This is used to handle the Pagination.
 */

class Ups_Eu_Woo_Pagination
{
    public static $current;
    protected $queryString;
    protected static $page;
    protected static $pageURL;
    protected static $lastpage;
    protected static $totalPages;
    public $pagerClass = 'pagination justify-content-center';
    public $liClass = 'page-item';
    public $liActiveClass = 'active';
    public $aClass = 'page-link';
    public $aActiveClass = '';

    /**
     * Sets the class assigned to the UL element of the pagination object
     * @param string $class This should be the class or classes that you wish to give to the pagination object
     * @return $this
     */
    public function ups_eu_woo_set_pagination_class($class)
    {
        if (!empty(trim($class))) {
            $this->pagerClass = $class;
        }
        return $this;
    }

    /**
     * Returns the class to give to the pagination object
     * @return string The pagination class will be returned
     */
    public function ups_eu_woo_get_pagination_class()
    {
        return $this->pagerClass;
    }

    /**
     * Sets the default li class
     * @param string $class This should be the class that you want to all to all li elements
     * @return $this
     */
    public function ups_eu_woo_set_li_class($class)
    {
        $this->liClass = trim($class);
        return $this;
    }

    /**
     * Gets the current li class
     * @return string This should be the class to assign on li elements
     */
    public function ups_eu_woo_get_li_class()
    {
        return $this->liClass;
    }

    /**
     * Sets the active class to assign on the li elements
     * @param string $class This should be the class to assign on active elements
     * @return $this
     */
    public function ups_eu_woo_set_li_active_class($class)
    {
        $this->liActiveClass = trim($class);
        return $this;
    }

    /**
     * Returns the class to assign to active li elements
     * @return string This should be the class to assign on active elements
     */
    public function ups_eu_woo_get_li_active_class()
    {
        return $this->liActiveClass;
    }

    /**
     * Sets the default class on a elements
     * @param string $class This should be the class to add to a elements
     * @return $this
     */
    public function ups_eu_woo_set_a_class($class)
    {
        $this->aClass = trim($class);
        return $this;
    }

    /**
     * Returns the class assigned to a elements
     * @return string Returns the class assigned to a elements
     */
    public function ups_eu_woo_get_a_class()
    {
        return $this->aClass;
    }

    /**
     * Sets the class to assign to active a elements
     * @param string $class This should be the class to add to active a elements
     * @return $this
     */
    public function ups_eu_woo_set_a_active_class($class)
    {
        $this->aActiveClass = trim($class);
        return $this;
    }

    /**
     * Returns the class assigned to active a elements
     * @return string This should be the class to add to active a elements
     */
    public function ups_eu_woo_get_a_active_class()
    {
        return $this->aActiveClass;
    }

    /**
     * Returns paging buttons for the number of records
     * @param int $records The total number of records
     * @param string $pageURL The URL of the page you are creating the paging for
     * @param int $start The start number for the results
     * @param int $maxshown The number of records that are shown on each page
     * @param int $numpagesshown The number of pagination buttons to display
     * @param boolean $arrows If you want arrows to display before and after for next and previous set to true
     * (default) else set to false
     * @param array $additional Any additional get values to include in the URL
     * @return string|false Returns the pagination menu if required else will return false
     */
    public function ups_eu_woo_paging(
        $records,
        $pageURL,
        $start = 0,
        $maxshown = 50,
        $numpagesshown = 11,
        $arrows = true,
        $additional = []
    ) {
        self::$pageURL = $pageURL;
        $this->queryString = $additional;
        if ($records > $maxshown) {
            self::$current = $start >= 1 ? intval($start) : 1;
            self::$totalPages = ceil(intval($records) / ($maxshown >= 1 ? intval($maxshown) : 1));
            self::$lastpage = self::$totalPages;
            $this->ups_eu_woo_get_page($records, $maxshown, $numpagesshown);

            $paging = '<ul class="' . $this->ups_eu_woo_get_pagination_class() . '">' . $this->ups_eu_woo_pre_links($arrows);
            while (self::$page <= self::$lastpage) {
                $paging .= $this->ups_eu_woo_build_link(self::$page, self::$page, (self::$current == self::$page));
                self::$page = (self::$page + 1);
            }
            return $paging . $this->ups_eu_woo_post_links($arrows) . '</ul>';
        }
        return false;
    }

    /**
     * Build a link item with the given values
     * @param string $link This should be any additional items to be included as part of the link
     * @param mixed $page This should be the link test on the link normally set as numbers but may be
     * anything like arrows or dots etc
     * @param boolean $current If this is the current link item set this as true so the class is added to the link item
     * @return string This will return the paging item as a string
     */
    protected function ups_eu_woo_build_link($link, $page, $current = false)
    {
        return '<li' . (
            !empty($this->ups_eu_woo_get_li_class()) ||
            ($current === true && !empty($this->ups_eu_woo_get_li_active_class())) ?
                ' class="' . trim($this->ups_eu_woo_get_li_class() .
                    (($current === true && !empty($this->ups_eu_woo_get_li_active_class())) ?
                        ' ' . $this->ups_eu_woo_get_li_active_class() : '') . '"') : ''
            ) . '><a href="' . self::$pageURL .
            (!empty($this->ups_eu_woo_build_query_string($link)) ? '&' . $this->ups_eu_woo_build_query_string($link) : '') .
            '" title="Page ' . $page . '"' . (
            !empty($this->ups_eu_woo_get_a_class()) ||
            ($current === true && !empty($this->ups_eu_woo_get_a_active_class())) ?
                ' class="' . trim($this->ups_eu_woo_get_a_class() .
                    (($current === true && !empty($this->ups_eu_woo_get_a_active_class())) ?
                        ' ' . $this->ups_eu_woo_get_a_active_class() : '')) . '"' : ''
            ) .
            '>' . $page . '</a></li>';
    }

    /**
     * Builds the query string to add to the URL
     * @param mixed $page If the page variable is set to a number will add the page number to the query string else
     * will not add any additional items
     * @return string The complete string will be returned to add to the link item
     */
    protected function ups_eu_woo_build_query_string($page)
    {
        $pageInfo = [];
        if (is_numeric($page)) {
            $pageInfo = ['__page' => $page];
        }
        return http_build_query(array_filter(array_merge($pageInfo, $this->queryString)), '', '&amp;');
    }

    /**
     * Gets the current page
     * @param int $records The total number of records
     * @param int $maxshown The number of records that are shown on each age
     * @param int $numpages The number of pagination buttons to display
     * return void Nothing is returned
     */
    protected function ups_eu_woo_get_page($records, $maxshown, $numpages)
    {
        $show = floor($numpages / 2);
        if (self::$lastpage > $numpages) {
            self::$page = (self::$current > $show ? (self::$current - $show) : 1);
            if (self::$current < (self::$lastpage - $show)) {
                if (self::$current <= $show) {
                    self::$lastpage = (self::$current + ($numpages - self::$current));
                } else {
                    self::$lastpage = (self::$current + $show);
                }
            } else {
                self::$page = self::$current - ($numpages - ((ceil(intval($records) / ($maxshown >= 1 ?
                            intval($maxshown) : 1)) - self::$current)) - 1);
            }
        } else {
            self::$page = 1;
        }
    }

    /**
     * Returns the previous arrows as long as arrows is set to true and the page is not the first page
     * @param boolean $arrows If you want to display previous arrows set to true else set to false
     * @return string Any previous link arrows will be returned as a string
     */
    protected function ups_eu_woo_pre_links($arrows = true)
    {
        $paging = '';
        if (self::$current != 1 && $arrows) {
            if (self::$current != 2) {
                $paging .= $this->ups_eu_woo_build_link('', '&laquo;');
            }
            $paging .= $this->ups_eu_woo_build_link((self::$current - 1), '&lt;');
        }
        return $paging;
    }

    /**
     * Returns the next arrows as long as arrows is set to true and the page is not the last page
     * @param boolean $arrows If you want to display next arrows set to true else set to false
     * @return string Any next link arrows will be returned as a string
     */
    protected function ups_eu_woo_post_links($arrows = true)
    {
        $paging = '';
        if (self::$current != self::$totalPages && $arrows) {
            $paging .= $this->ups_eu_woo_build_link((self::$current + 1), '&gt;');
            if (self::$current != (self::$totalPages - 1)) {
                $paging .= $this->ups_eu_woo_build_link(self::$totalPages, '&raquo;');
            }
        }
        return $paging;
    }
}
