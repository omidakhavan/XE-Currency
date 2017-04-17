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

		wp_enqueue_style( $this->plugin_name, WNCU_URL . '/admin/assets/css/wncu-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		if ( isset( $_GET['page'] ) && $_GET['page'] == 'wncu-xe' ) {
			wp_enqueue_script( $this->plugin_name, WNCU_URL . '/admin/assets/js/wncu-admin.js', array( 'jquery' ), $this->version, false );
			wp_localize_script( $this->plugin_name, 'wncu', array(
				'adminajax' => admin_url( 'admin-ajax.php' )
			));
		}

	}

}
