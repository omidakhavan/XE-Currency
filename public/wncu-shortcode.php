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
		add_shortcode('wncu-calc', array( $this, 'wncu_calc_shortcode' ) );

		add_action( 'vc_before_init', array( $this, 'wncu_vc_shortcode' ) );
		add_action( 'vc_before_init', array( $this, 'wncu_cal_vc_shortcode' ) );				
				
	}

	/**
	 *  Shortcode for currency table
	 */
	public function wncu_shortcode( $atts, $content ){

		global $wpdb;

		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wncu", ARRAY_A  );

		$tableone     = intval( wncu_get_option( 'wncu_tableone', 'general_tab' ) );
		$wncu_warning = wncu_get_option( 'wncu_warning', 'general_tab' );
		// $tabletwo   = intval( wncu_get_option( 'wncu_tableone', 'general_tab' ) );

		$out = '';

		// warning message
		if ( $wncu_warning == 'on' ) {
			$wncu_msg = wncu_get_option( 'wncu_msg', 'general_tab' );
			$out .= '<span class="wncu-warning-msg">'. $wncu_msg .'</span>';
		}	

		$count = 0 ;

			$out .= '
			<table class="wncu-curr-tone wncu-curr-t">
				<tr class="wncu-curr-hone wncu-curr-h">
					<th>نماد</th>
					<th>ارز</th> 
					<th>نرخ (تومان)</th>
				</tr>';
			if ( $wncu_warning != 'on' ) {
				foreach ( $results as $key => $value ) {
					$count++;
					$out .= '<tr>';
					$out .=	'<td class="wncu-curr-abbv"> '.$value['namad'].'</td>';
					$out .=	'<td class="wncu-curr-curr"> '.$value['arz'].'</td>';
					$out .=	'<td class="wncu-curr-rate"> '. $this->numberfarsi( $value['nerkh'] ) .'</td>';
					$out .= '</tr>';

					if ( $count > $tableone ) {
						break;
					}
				}
			} else {
				foreach ( $results as $key => $value) {
					$count++;
					$out .= '<tr>';
					$out .=	'<td class="wncu-curr-abbv">'.$value['namad'].'</td>';
					$out .=	'<td class="wncu-curr-curr">'.$value['arz'].'</td>';
					$out .=	'<td class="wncu-curr-rate"> لطفا تماس بگیرید.</td>';
					$out .= '</tr>';
					if ( $count > $tableone ) {
						break;
					}
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
			if ( $wncu_warning != 'on' ) {

				foreach ( array_slice( $results, 7 ) as $key2 => $value2) {

					$out .= '<tr>';
					$out .=	'<td class="wncu-curr-abbv"> '.$value2['namad'].'</td>';
					$out .=	'<td class="wncu-curr-curr"> '.$value2['arz'].'</td>';
					$out .=	'<td class="wncu-curr-rate"> '.  $this->numberfarsi( $value2['nerkh'] ).'</td>';
					$out .= '</tr>';

				}	
			} else {
				foreach ( array_slice( $results, 7 ) as $key2 => $value2) {
					$out .= '<tr>';
					$out .=	'<td class="wncu-curr-abbv">'.$value2['namad'].'</td>';
					$out .=	'<td class="wncu-curr-curr">'.$value2['arz'].'</td>';
					$out .=	'<td class="wncu-curr-rate"> لطفا تماس بگیرید.</td>';
					$out .= '</tr>';
				}	
			}	

				$out .= '
			</table>';
		

		return $out;
	}

	/**
	 *  Shortcode for calculation 
	 */
	public function wncu_calc_shortcode( $atts, $content ) {

		$result = !empty( get_option( 'wncucalc_from' ) ) ? get_option( 'wncucalc_from' ) : '' ;

		$out = '';
		// from select box
		$out .='
			<div class="wncu-calculator-container col-md-12">
				<div  class="col-md-3">
					<label for="wncuaddfrom">از</label>
					<select name="wncuaddfrom" id="wncuaddfrom" class="wncu-calc-select">
					<option value="RIAL">تومان</option>';
			foreach ( $result['from'] as $key => $value ) : 
		$out .='		
						<option value=" '. $value .' "> '. $this->wncu_convert_to_persian ( $value ) .' </option>';
			endforeach;
		$out .='	
					</select>
				</div>
			<div  class="col-md-3">
				<label for="wncutofrom">به</label>
					<select name="wncutofrom" id="wncutofrom" class="wncu-calc-select">
					<option value="RIAL">تومان</option>';
		// to select box		
			foreach ( $result['to'] as $key0 => $value0 ) : 
		$out .='		
					<option value=" '. $value0 .' "> '.  $this->wncu_convert_to_persian ( $value0 ).' </option>';
			 endforeach;
		$out .='	 		
				</select>
			</div>';

		// type 
		$out .='
		<div  class="col-md-3">
			<label for="wncutype">نوع حواله</label>
			<select name="wncutype" id="wncutype">
				<option value="شرکتی"> شرکتی </option>
				<option value="شخصی"> شخصی </option>
			</select>
		</div>';

		//field for calculation
		$out .='
			<div class="col-md-2">
				<label for="wncu-calculationfield">مقدار ارز برای حواله*</label>
				<input type="number" name="wncu-calculationfield" id="wncu-calculationfield" >
			</div>
			<div class="col-md-1">
				<a href="#" class="wncu-calculationfield gform_button button">محاسبه</a>
			</div>
			<span class="wncu-calculationresult" ></span>
		</div>
		';
			
		return $out;
	}

	/**
	 * Shortcode for currency table
	 */
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

	/**
	 * Shortcode for calculation
	 */
	public function wncu_cal_vc_shortcode() {
	   vc_map( array(
	      "name" => __( "محاسبه گر ارز وبنوس", "wncu" ),
	      "base" => "wncu-calc",
	      "class" => "",
	      "category" => __( "Webnus Shortcodes", "wncu"),
	      "params" => array(
	      	array(
	      		'type' => 'textfield',
	      		'heading' => __( 'محاسبه گر وبنوس', 'wncu' ),
	      		'param_name' => 'wncu-calc',
	      		'value' => '[wncu-calc]',
	      		),

	      	)
	   ) );
	}

	/**
	 *  Convert abbrv to complete currency name 
	 */
	public function wncu_convert_to_persian( $val ) {

		switch ( $val ) {
			case 'USD':
			return 'دلار آمریکا';	

			case 'AUD':
			return 'دلار استرالیا';	

			case 'CAD':
			return 'دلار کانادا';	

			case 'AED':
			return 'درهم امارات';	

			case 'EUR':
			return 'یورو';	

			case 'GBP':
			return 'پوند انگلیس';	

			case 'CNY':
			return 'یوان';	

			case 'HKD':
			return 'دلار هنگ کنگ';	

			case 'CHF':
			return 'فرانک سوییس';			

			case 'DKK':
			return 'کرون دانمارک';

			case 'SEK':
			return 'کرون سوئد';	

			case 'SGD':
			return 'دلار سنگاپور';	

			case 'NZD':
			return 'دلار نیوزیلند';	

			case 'ZAR':
			return 'راند';	

			case 'CZK':
			return 'کرون چک';		

			case 'HUF':
			return 'فورینت';	

			case 'NOK':
			return 'کرون نروژ';	

			case 'PLN':
			return 'زلوتی لهستان';					

			case 'RLS':
			return 'ریال';			

		}
	}

	public function numberfarsi( $string ) {

		$result = '';

		for( $i = 0 ; $i < strlen($string) ; $i++ ){

			switch( $string[$i] ){

				case 0:
				$result .= '٠';
				break;

				case 1:
				$result .= '١';
				break;

				case 2:
				$result .= '٢';
				break;

				case 3:
				$result .= '٣';
				break;

				case 4:
				$result .= '٤';
				break;

				case 5:
				$result .= '٥';
				break;

				case 6:
				$result .= '٦';
				break;

				case 7:
				$result .= '٧';
				break;

				case 8:
				$result .= '٨';
				break;

				case 9:
				$result .= '٩';
				break;
			}

		}

		return $result;
		unset($result);

	} 

}