<?php
/**
 * Enqueue plugin javascripts and stylesheets.
 * 
 * @package CoinDev_Property
 * @subpackage CoinDev_Property/includes
 * @since 1.0
 * @author Den Isahac <den.isahac@gmail.com>
 */
class CoinDev_Property_Scripts {

	/**
	 * Class instantiation method.
	 *
	 * @since 1.0
	 */
	function __construct() {
		add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
		add_action('wp_enqueue_scripts', [$this, 'wp_enqueue_scripts']);
	}	

	/**
	 * Enqueue scripts on the admin section.
	 *
	 * @since 1.0
	 */
	function admin_enqueue_scripts() {
		// App
		wp_enqueue_style('app',  plugin_dir_url(__DIR__) . 'admin/css/app.css', array(), '1.0', 'screen');
	}

	/**
	 * Enqueue scripts on the frontend.
	 *
	 * @since 1.0
	 */
	function wp_enqueue_scripts() {
		if(!is_admin()) {
			// jQuery
			wp_enqueue_script('jquery');
			// App
			wp_enqueue_style('app', plugin_dir_url(__DIR__) . 'assets/css/app.css', array(), '1.0', 'screen');
			wp_enqueue_script('app', plugin_dir_url(__DIR__) . 'assets/js/app.js', array('jquery'), '1.0', true);
		}
	}
}
