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
	public function test() {
		$condition         = get_option( 'wncucalc_from' );

		// filter condtions
		$condition['karmozd'] = array_values( array_diff( $condition['karmozd']  , array( '' ) ) );
		$karmozd = $condition['karmozd'];

		// get expersion value
		foreach( $condition['karmozd'] as $key => $value ) if( $key&1 ) unset( $condition['karmozd'][$key] );
		$splited_exp =  array_values ( $condition['karmozd'] );

		// get karmozd value
		foreach( $karmozd as $key0 => $value0 ) if( !($key0&1) ) unset( $karmozd[$key0] );
		$splited_karmozd = array_values( $karmozd );

		// sorting values from lower to up
		sort( $splited_exp );
		rsort( $splited_karmozd );


		?>
		<pre>
		<?php var_dump($splited_exp); var_dump($splited_karmozd);  ?>
		</pre>
		<?php
	}

	public function wncu_calc_ajax () {

		global $wpdb;

		// get values
		$from = trim( $_REQUEST['from'] );

		$to   = trim( $_REQUEST['to'] );

		$type = trim( $_REQUEST['type'] );

		$amont= trim( $_REQUEST['amont'] );

		if ( $amont == '' || !isset( $amont ) ) {
			echo 'لطفا مبلغ را وارد نمایید';
			exit();
		}

		$wncu_warning      = wncu_get_option( 'wncu_warning', 'general_tab' );
		$defult_karmozd    = wncu_get_option( 'wncu_karmozd', 'calculation' );
		$condition         = get_option( 'wncucalc_from' );

		// filter condtions
		$condition['karmozd'] = array_values( array_diff( $condition['karmozd']  , array( '' ) ) );
		$karmozd = $condition['karmozd'];

		// get expersion value
		foreach( $condition['karmozd'] as $key => $value ) if( $key&1 ) unset( $condition['karmozd'][$key] );
		$splited_exp =  array_values ( $condition['karmozd'] );

		// get karmozd value
		foreach( $karmozd as $key0 => $value0 ) if( !($key0&1) ) unset( $karmozd[$key0] );
		$splited_karmozd = array_values( $karmozd );

		// sorting values from lower to up
		sort( $splited_exp );
		rsort( $splited_karmozd );

		// get rate of from 
		$resfrom = $wpdb->get_col( $wpdb->prepare( "SELECT nerkh FROM {$wpdb->prefix}wncu WHERE namad = %s" , $from ) );

		// gate rate of to
		$resto = $wpdb->get_col( $wpdb->prepare( "SELECT nerkh FROM {$wpdb->prefix}wncu WHERE namad = %s" , $to ) );

		// get usd
		$resusd = $wpdb->get_col( $wpdb->prepare( "SELECT nerkh FROM {$wpdb->prefix}wncu WHERE namad = 'USD'" ) );

		// if warning set to on skip and die
		if ( $wncu_warning == 'on' ) { 
			echo 'ارایه قیمت مقدور نمی باشد لطفا تماس بگیرید.'; 
			exit(); 
		}

		// if warning set to on skip and die
		if ( $amont <= wncu_get_option( 'wncu_kaf_havale', 'general_tab' ) || $from == 'RIAL' && $amont <= wncu_get_option( 'wncu_kaf_havale_rial', 'general_tab' ) ) {
				if ( $from != 'RIAL' ) echo 'مقدار حواله قابل ارسال نمیتواند پایینتر از ' . wncu_get_option( 'wncu_kaf_havale', 'general_tab' ) . ' برای ارزهای خارجی باشد'; 
				else 
					echo 'مقدار حواله قابل ارسال نمیتواند پایینتر از ' . wncu_get_option( 'wncu_kaf_havale_rial', 'general_tab' ) . ' تومان باشد'; 
			exit(); 
		} 

		// when currency dont have value exit
		if ( !isset( $resfrom['0'] ) && empty( $resfrom['0'] ) && $from !== 'RIAL' || !isset( $resto['0'] ) && empty( $resto['0'] ) &&  $to !== 'RIAL' ) {
			echo 'برای اطلاع از ارز درخواستی لطفا تماس بگیرید.'; 
			exit();
		}


		$resultc = ( $to == 'RIAL') ? $resfrom['0'] : $resto['0'] ;
		if ( $resultc == 0 ) {
		  	echo 'ارز مورد نظر قابل ارایه نمی باشد.';
			exit();
		}

		// get limitation check
		if ( $to == 'USD' ) {
			$a_calc = isset( $condition['karmozd'] ) ? ceil ( ( $amont / $resultc ) - min($splited_karmozd) ) : ceil ( ( $amont / $resultc ) - $defult_karmozd );
		}elseif ( $to == 'RIAL' ) {
			$a_calc = $amont;
		}else{
			$a_calc = isset( $condition['karmozd'] ) ? ceil ( ( $amont / $resusd ) - min($splited_karmozd) ) : ceil ( ( $amont / $resusd ) - $defult_karmozd );

			// $a_calc = isset( $condition['karmozd'] ) ? ceil ( ( $amont / $resultc ) - min($splited_karmozd) ) : ceil ( ( $amont / $resultc ) - $defult_karmozd );

		}
		// calculation amount for id upper than $10000 exit
		if ( $from != 'CAD' && $to != 'CAD' && $type == 'شخصی' && $a_calc >= '10000' ) { 
			echo 'حواله شخصی بالاتر از 10 هزار واحد به علت رعایت  قوانین مبارزه با پولشویی امکان پذیر نمیباشد. (بجز دلار کانادا).';
			exit();
		}

		// calculate currency with conidtions from rial to any
		if ( $to !== 'CAD' && $from !== 'CAD' && $type == 'شخصی' && $to !== 'RIAL' ) {
			$count = count( $splited_exp );
			for ( $i=0; $i < $count ; $i++ ) { 
				if ( $splited_exp[$i] > $a_calc ) {
					$result =  number_format ( ( $amont / $resultc ) - ( $splited_karmozd[$i] ) );
					echo  $to . ' ' .  $result ;
					break;				
				}
			}
		}

		// calculate currency for cad
		if ( $to == 'CAD' && ( $type == 'شخصی' || $type == 'شرکتی'  ) ) {
			if ( $a_calc >= '100000' ) {
				echo 'حواله شخصی بالاتر از 100 هزار واحد به علت رعایت  قوانین مبارزه با پولشویی امکان پذیر نمیباشد.';
				exit();
			} else {
				$result =  number_format ( ( $amont / $resultc ) + 30 );
				echo $to . ' ' . $result ;
				exit();
			}
		}

		// sherkati 
		if ( $type == 'شرکتی' && $to !== 'RIAL' ) {
			$result = number_format ( ( $amont / $resultc ) - 50 );
			echo $to . ' ' .  $result ;
			exit();
		}

		// any currency to rial 
		if ( $to == 'RIAL' && $type == 'شخصی' ) {
			$count = count( $splited_exp );
			for ( $i=0; $i < $count ; $i++ ) { 
				if ( $splited_exp[$i] > $a_calc ) {
					$result =  number_format ( ( $amont * $resultc ) - ( $splited_karmozd[$i] . '000' ) );
					echo $result  . ' تومان'  ;
					break;				
				}
			}
		}

		exit();
	}

	protected function compare( $resultc, $a_calc ){

	}

}