<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://webnus.biz
 * @since      1.0.0
 *
 * @package    Webnus Currency
 * @subpackage Webnus Currency/admin
 */

/**
 * The admin-specific functionality of the plugin.
 */
class Wncu_Admin {

	/**
	 * The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, WNCU_DIR . 'admin/assets/css/plugin-name-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, WNCU_DIR . 'admin/assets/js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );

	}

}
