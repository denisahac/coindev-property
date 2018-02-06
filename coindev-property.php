<?php
/**
 * @package CoinDev_Property
 * @since 1.0
 * @author Den Isahac <den.isahac@gmail.com>
 */
/*
Plugin Name: Coin Development Property
Plugin URI: http://coindevelopment.com/
Description: Property listing that you can avail for loans.
Version: 1.0
Author: Den Isahac
Author URI: http://denisahac.xyz/
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: coindev_property
Domain Path: /languages
*/

// If this file is called directly, abort.
if(!defined('WPINC'))
	die;

require_once plugin_dir_path(__FILE__) . 'functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-coindev-property-loader.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-coindev-property-scripts.php';

// Enqueue plugin scripts.
new CoinDev_Property_Scripts();

/**
 * Plugin activation hook.
 *
 * @since 1.0
 */
function coindev_property_activation_hook() {
	coindev_property_flush_rules();
}
register_activation_hook(__FILE__, 'coindev_property_activation_hook');

/**
 * Plugins loaded action.
 *
 * @since 1.0
 */
function coindev_property_plugins_loaded() {
	new CoinDev_Property_Loader();
}
add_action('plugins_loaded', 'coindev_property_plugins_loaded');