<?php

/**
 * @link              http://Webnus.net
 * @since             1.0.0
 * @package           webnus currencies
 */

/**
 * The public-facing functionality of the plugin.
 */
class Wncu_Public {
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
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, WNCU_URL . '/public/assets/css/wncu-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, WNCU_URL . '/public/assets/js/wncu-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name , 'adminurl', array(
			'wncu' => admin_url( 'admin-ajax.php' ), 
		));

	}

}
