<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://webnus.biz
 * @since      1.0.0
 *
 * @package    Webnus Currency
 * @subpackage Webnus Currency/includes
 */

/**
 * Define the internationalization functionality.
 */
class Wncu_i18n {


	/**
	 * Load the plugin text domain for translation.
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wncu',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
