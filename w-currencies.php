<?php

/**
 * @link              http://Webnus.net
 * @since             1.0.0
 * @package           webnus currencies
 *
 * @wordpress-plugin
 * Plugin Name:       webnus currencies 
 * Description:       Webnus currencies integreated with XE.
 * Version:           1.0.0
 * Author:            Webnus
 * Author URI:        http://Webnus.net
 * License:           GPL-2.0+
 * Text Domain:       wncu
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Define Some Var
 */
define( 'WNCU_VER', '1.0.0' );
define( 'WNCU_DIR', plugin_dir_path(  __FILE__  ));
define( 'WNCU_URL', plugins_url( '' , __FILE__ ));

/**
 * The code that runs during plugin activation.
 */
function activate_wncu() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/wncu-activator.php';
	Wncu_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_wncu() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/wncu-deactivator.php';
	Wncu_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wncu' );
register_deactivation_hook( __FILE__, 'deactivate_wncu' );

/**
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/wncu-core.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_wncu_core() {

	$wn_run = new Wncu_Core();
	$wn_run->run();

}
run_wncu_core();
