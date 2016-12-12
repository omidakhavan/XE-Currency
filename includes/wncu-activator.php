<?php

/**
 *
 * @link       http://webnus.biz
 * @since      1.0.0
 *
 * @package    Webnus Currency
 * @subpackage Webnus Currency/includes
 */

/**
 * Fired during plugin activation.
 */
class Wncu_Activator {

	public static function activate() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'wncu';

	$sql = "CREATE TABLE $table_name (
		namad CHAR(3) NOT NULL DEFAULT '',
		arz CHAR(120) NOT NULL,
		nerkh CHAR(20) NOT NULL,
		PRIMARY KEY (namad),
		UNIQUE KEY  namad (namad)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	}

}
