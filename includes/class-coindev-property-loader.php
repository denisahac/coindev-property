<?php
require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-coindev-property-investment.php';

/**
 * Fired when plugin is loaded.
 *
 * @package CoinDev_Property
 * @subpackage CoinDev_Property/includes
 * @since 1.0
 * @author Den Isahac <den.isahac@gmail.com>
 */
class CoinDev_Property_Loader {

	/**
	 * CoinDev_Property_Investment access field variable.
	 *
	 * @since 1.0
	 * @access private
	 */
	private $investment;

	/**
	 * Class instantiation method.
	 *
	 * @since 1.0
	 */
	function __construct() {
		$this->investment = new CoinDev_Property_Investment();
	}

}