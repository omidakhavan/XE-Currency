<?php

/**
 * @link              http://Webnus.net
 * @since             1.0.0
 * @package           webnus currencies
 */

/**
 * Shortcode class
 */
class Wncu_Shortcodes {

	function __construct() {

		add_shortcode('wncu', array( $this, 'wncu_shortcode' ) );

		add_action( 'vc_before_init', array( $this, 'wncu_vc_shortcode' ) );
				
	}

	public function wncu_shortcode($atts, $content){

		global $wpdb;

		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wncu", ARRAY_A  );

		$tableone   = intval( wncu_get_option( 'wncu_tableone', 'general_tab' ) );
		// $tabletwo   = intval( wncu_get_option( 'wncu_tableone', 'general_tab' ) );

		$out = '';
		$count = 0 ;

			$out .= '
			<table class="wncu-curr-tone wncu-curr-t">
				<tr class="wncu-curr-hone wncu-curr-h">
					<th>نماد</th>
					<th>ارز</th> 
					<th>نرخ (تومان)</th>
				</tr>';

				foreach ( $results as $key => $value) {
					$count++;
					$out .= '<tr>';
					$out .=	'<td class="wncu-curr-abbv"> '.$value['namad'].'</td>';
					$out .=	'<td class="wncu-curr-curr"> '.$value['arz'].'</td>';
					$out .=	'<td class="wncu-curr-rate"> '.$value['nerkh'].'</td>';
					$out .= '</tr>';

					if ( $count > $tableone ) {
						break;
					}
				}	

				$out .= '
			</table>';

			// table two

			$out .= '
			<table class="wncu-curr-ttwo wncu-curr-t">
				<tr class="wncu-curr-htow wncu-curr-h">
					<th>نماد</th>
					<th>ارز</th> 
					<th>نرخ (تومان)</th>
				</tr>';

				foreach ( array_slice( $results, 7 ) as $key2 => $value2) {

					$out .= '<tr>';
					$out .=	'<td class="wncu-curr-abbv"> '.$value2['namad'].'</td>';
					$out .=	'<td class="wncu-curr-curr"> '.$value2['arz'].'</td>';
					$out .=	'<td class="wncu-curr-rate"> '.$value2['nerkh'].'</td>';
					$out .= '</tr>';

				}	

				$out .= '
			</table>';
		

		return $out;
	}

	public function wncu_vc_shortcode() {
	   vc_map( array(
	      "name" => __( "جدول ارز وبنوس", "wncu" ),
	      "base" => "wncu",
	      "class" => "",
	      "category" => __( "Webnus Shortcodes", "wncu"),
	      "params" => array(
	      	array(
	      		'type' => 'textfield',
	      		'heading' => __( 'جدول ارز وبنوس', 'wncu' ),
	      		'param_name' => 'wncu',
	      		'value' => '[wncu]',
	      		),

	      	)
	   ) );
	}

}