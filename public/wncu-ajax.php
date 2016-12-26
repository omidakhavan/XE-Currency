<?php

/**
 * @link              http://Webnus.net
 * @since             1.0.0
 * @package           webnus currencies
 */

/**
*  Online calculation class
*/
class Wncu_Ajax {
	
	function __construct() {
		// public ajax defination
		add_action( 'wp_ajax_calculation_action', array( $this, 'wncu_calc_ajax' ) );
		add_action( 'wp_ajax_nopriv_calculation_action', array ( $this,  'wncu_calc_ajax' ) );

		// add_action( 'init', array ( $this, 'test' ) );
				
	}
	public function test(){
		?>
		<pre>
		<?php var_dump( get_option( 'wncu_ajax' ) ); ?>
		</pre>
		<?php
	}

	public function wncu_calc_ajax () {

		global $wpdb;

		// if ( !isset( $_REQUEST['amont'] ) ) die('amount not set.');
		
		$from = trim( $_REQUEST['from'] );

		$to   = trim( $_REQUEST['to'] );

		$type = trim( $_REQUEST['type'] );

		$amont= trim( $_REQUEST['amont'] );

		$resfrom = $wpdb->get_col( $wpdb->prepare( "SELECT nerkh FROM {$wpdb->prefix}wncu WHERE namad = %s" , $from ) );
		$a = $amont * $resfrom['0'];
		echo 'قیمت برای شما '.$a;

		// update_option( 'wncu_ajax', $resfrom);
		// $need_calc = $_REQUEST ;
		// $need_calc['from'];



	}

}