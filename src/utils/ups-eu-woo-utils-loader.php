<?php namespace UpsEuWoocommerce\utils;

/**
 * _USER_TECHNICAL_AGREEMENT
 *
 * @category    ups-shipping-for-woocommerce
 * @package     UPS Shipping and UPS Access Point™ : Official Plugin For WooCommerce
 * @author      United Parcel Service of America, Inc. <noreply@ups.com>
 * @copyright   (c) 2019, United Parcel Service of America, Inc., all rights reserved
 * @link        https://www.ups.com/us/en/help-center/technology-support/ready-program/e-commerce.page
 *
 * _LICENSE_TAG
 *
 * ups-eu-woo-utils-loader.php - The core plugin class.
 *
 * Register all actions and filters for the plugin.
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 */

class Ups_Eu_Woo_Utils_Loader
{

    /**
     * The array of actions registered with WordPress.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
     */
    protected $actions;

    /**
     * The array of filters registered with WordPress.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
     */
    protected $filters;
    private $hook = 'hook';
    private $component = 'component';
    private $callback = 'callback';
    private $priority = 'priority';
    private $accepted_args = 'accepted_args';

    /**
     * Initialize the collections used to maintain the actions and filters.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->actions = [];
        $this->filters = [];
    }

    /**
     * Add a new action to the collection to be registered with WordPress.
     *
     * @since    1.0.0
     * @param      string               $hook             The name of the WordPress action that is being registered.
     * @param      object               $component        A reference to the instance of the object on which the action
     * is defined.
     * @param      string               $callback         The name of the function definition on the $component.
     * @param      int      Optional    $priority         The priority at which the function should be fired.
     * @param      int      Optional    $accepted_args    The number of arguments that should be passed to
     * the $callback.
     */
    public function ups_eu_woo_loader_add_action($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->actions = $this->ups_eu_woo_loader_add($this->actions, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * @since    1.0.0
     * @param      string               $hook             The name of the WordPress filter that is being registered.
     * @param      object               $component        A reference to the instance of the object on which the filter
     * is defined.
     * @param      string               $callback         The name of the function definition on the $component.
     * @param      int      Optional    $priority         The priority at which the function should be fired.
     * @param      int      Optional    $accepted_args    The number of arguments that should be passed to
     * the $callback.
     */
    public function ups_eu_woo_loader_add_filter($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->filters = $this->ups_eu_woo_loader_add($this->filters, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * A utility function that is used to register the actions and hooks into a single
     * collection.
     *
     * @since    1.0.0
     * @access   private
     * @param      array                $hooks            The collection of hooks that is being registered
     * (that is, actions or filters).
     * @param      string               $hook             The name of the WordPress filter that is being registered.
     * @param      object               $component        A reference to the instance of the object on which
     * the filter is defined.
     * @param      string               $callback         The name of the function definition on the $component.
     * @param      int      Optional    $priority         The priority at which the function should be fired.
     * @param      int      Optional    $accepted_args    The number of arguments that should be passed to
     * the $callback.
     * @return   type                                   The collection of actions and filters registered with WordPress.
     */
    private function ups_eu_woo_loader_add($hooks, $hook, $component, $callback, $priority, $accepted_args)
    {
        $hooks[] = [
            $this->hook => $hook,
            $this->component => $component,
            $this->callback => $callback,
            $this->priority => $priority,
            $this->accepted_args => $accepted_args
        ];

        return $hooks;
    }

    /**
     * Register the filters and actions with WordPress.
     *
     * @since    1.0.0
     */
    public function ups_eu_woo_loader_run()
    {
        foreach ($this->filters as $hook) {
            add_filter(
                $hook[$this->hook],
                [$hook[$this->component], $hook[$this->callback]],
                $hook[$this->priority],
                $hook[$this->accepted_args]
            );
        }

        foreach ($this->actions as $hook) {
            add_action(
                $hook[$this->hook],
                [$hook[$this->component], $hook[$this->callback]],
                $hook[$this->priority],
                $hook[$this->accepted_args]
            );
        }

        add_filter('woocommerce_cart_shipping_method_full_label', function ($label, $method) {
            if ($method->cost <= 0) {
                $label = $method->get_label();
            }
            return $label;
        }, 10, 2);
    }
}
