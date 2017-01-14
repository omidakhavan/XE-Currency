<?php

/**
 * @link              http://Webnus.net
 * @since             1.0.0
 * @package           webnus currencies
 */


/**
* Wncu_Main_Excute
*/
class Wncu_Main_Excute {
	
	public $havale_usd = '';


	function __construct(){
		

		// Add new corn job time
		add_filter( 'cron_schedules',      array ( $this, 'wncu_my_cron_schedules' ) );
		add_action( 'admin_init',          array ( $this, 'wncu_define_cornhourly' ) );
		// add_action( 'init',                array ( $this, 'get_havale_usd' ) );
		add_action( 'wp_ajax_wncuupdate',  array ( $this, 'wncu_update_now'        ) );

		add_action( 'wncu_corns_five',     array ( $this, 'wncu_corns_five'        ) );
		add_action( 'wncu_corns_ten',      array ( $this, 'wncu_corns_ten'         ) );
		add_action( 'wncu_corns_fifteen',  array ( $this, 'wncu_corns_fifteen'     ) );
		add_action( 'wncu_corns_thrtee',   array ( $this, 'wncu_corns_thrtee'      ) );
		add_action( 'wncu_corns_hourly',   array ( $this, 'wncu_do_this_hourly'    ) );

		// add_action('wp_head', array ( $this, 'test') );

	}

	/**
	 * Set havle
	 */
	public function set_havale( $set_havale ) {
		$this->havale_usd = $set_havale;
	}

	/**
	 * Get havale
	 */
	public function get_havale() {
		return $this->havale_usd ;
	}

	public function get_havale_usd() {

		$estekhraj  = wncu_get_option( 'wncu_fetchhavale', 'general_tab' );

		if ( $estekhraj == 'on' ) {

			$opts = array(
				'http'=>array(
					'method'=>"POST",
					'header'=>"Mozilla/5.0"
				)
			);
			$context = stream_context_create($opts);
			$getfile = @file_get_contents('http://www.sarafiparsi.com/wp-content/plugins/t-rate/trate.html',NULL,$context,100,300);
			$converttoarray = explode(' ',trim( $getfile ) );
			$numi = trim( intval(preg_replace('/[^0-9]+/', '', $converttoarray[74]), 10) );

			if ( $numi !== '0' && !empty( $numi ) && isset( $numi ) &&  NULL !== $numi  ) {
				$this->set_havale( $numi );			
			}
		}

		if ( $estekhraj != 'on' ) {
			$havale_usd_opt = wncu_get_option( 'wncu_usd_havale', 'general_tab' );
			$this->set_havale( $havale_usd_opt );
		}
	}

	/**
	 *  Update Now!
	 */
	public function wncu_update_now() {
		// renew rate of usd
		$this->get_havale_usd();
		$havale_usd = $this->get_havale();
		$usd = wncu_get_option( 'wncu_usd_time', 'currencies' );
			$curr_usd   = wncu_get_option( 'wncu_usd', 'currencies' );
			$sood_usd   = wncu_get_option( 'wncu_usd_sood', 'currencies' );
			$crate_usd  = $this->wb_currency( $curr_usd );
			$ragham_usd = ceil( $crate_usd * $havale_usd );
			$darsad_usd = ceil( ( $sood_usd / 100 ) * $ragham_usd);
			$result_usd = $ragham_usd + $darsad_usd;
			$this->wncu_crud( $curr_usd , 'دلار آمریکا', $result_usd );

		$cad = wncu_get_option( 'wncu_cad_time', 'currencies' );	
			$curr_cad   = wncu_get_option( 'wncu_cad', 'currencies' );
			$sood_cad   = wncu_get_option( 'wncu_cad_sood', 'currencies' );
			$crate_cad  = $this->wb_currency( $curr_cad );
			$ragham_cad = ceil( $crate_cad * $havale_usd );
			$darsad_cad = ceil( ( $sood_cad / 100 ) * $ragham_cad);
			$result_cad = $ragham_cad + $darsad_cad;
			$this->wncu_crud( $curr_cad , 'دلار کانادا', $result_cad );	
		
		$eur = wncu_get_option( 'wncu_eur_time', 'currencies' );
			$curr_eur   = wncu_get_option( 'wncu_eur', 'currencies' );
			$sood_eur   = wncu_get_option( 'wncu_eur_sood', 'currencies' );
			$crate_eur  = $this->wb_currency( $curr_eur );
			$ragham_eur = ceil( $crate_eur * $havale_usd );
			$darsad_eur = ceil( ( $sood_eur / 100 ) * $ragham_eur);
			$result_eur = $ragham_eur + $darsad_eur;
			$this->wncu_crud( $curr_eur , 'یورو', $result_eur );
		
		$gbp = wncu_get_option( 'wncu_gbp_time', 'currencies' );
			$curr_gbp   = wncu_get_option( 'wncu_gbp', 'currencies' );
			$sood_gbp   = wncu_get_option( 'wncu_gbp_sood', 'currencies' );
			$crate_gbp  = $this->wb_currency( $curr_gbp );
			$ragham_gbp = ceil( $crate_gbp * $havale_usd );
			$darsad_gbp = ceil( ( $sood_gbp / 100 ) * $ragham_gbp);
			$result_gbp = $ragham_gbp + $darsad_gbp;
			$this->wncu_crud( $curr_gbp , 'پوند انگلیس', $result_gbp );
		
		$aud = wncu_get_option( 'wncu_aud_time', 'currencies' );
			$curr_aud   = wncu_get_option( 'wncu_aud', 'currencies' );
			$sood_aud   = wncu_get_option( 'wncu_aud_sood', 'currencies' );
			$crate_aud  = $this->wb_currency( $curr_aud );
			$ragham_aud = ceil( $crate_aud * $havale_usd );
			$darsad_aud = ceil( ( $sood_aud / 100 ) * $ragham_aud);
			$result_aud = $ragham_aud + $darsad_aud;
			$this->wncu_crud( $curr_aud , 'دلار استرالیا', $result_aud );
		
		$cny = wncu_get_option( 'wncu_cny_time', 'currencies' );
			$curr_cny   = wncu_get_option( 'wncu_cny', 'currencies' );
			$sood_cny   = wncu_get_option( 'wncu_cny_sood', 'currencies' );
			$crate_cny  = $this->wb_currency( $curr_cny );
			$ragham_cny = ceil( $crate_cny * $havale_usd );
			$darsad_cny = ceil( ( $sood_cny / 100 ) * $ragham_cny);
			$result_cny = $ragham_cny + $darsad_cny;
			$this->wncu_crud( $curr_cny , 'یوان', $result_cny );
		
		$aed = wncu_get_option( 'wncu_aed_time', 'currencies' );
			$curr_aed   = wncu_get_option( 'wncu_aed', 'currencies' );
			$sood_aed   = wncu_get_option( 'wncu_aed_sood', 'currencies' );
			$crate_aed  = $this->wb_currency( $curr_aed );
			$ragham_aed = ceil( $crate_aed * $havale_usd );
			$darsad_aed = ceil( ( $sood_aed / 100 ) * $ragham_aed);
			$result_aed = $ragham_aed + $darsad_aed;
			$this->wncu_crud( $curr_aed , 'درهم امارات', $result_aed );
		
		$hkd = wncu_get_option( 'wncu_hkd_time', 'currencies' );
			$curr_hkd   = wncu_get_option( 'wncu_hkd', 'currencies' );
			$sood_hkd   = wncu_get_option( 'wncu_hkd_sood', 'currencies' );
			$crate_hkd  = $this->wb_currency( $curr_hkd );
			$ragham_hkd = ceil( $crate_hkd * $havale_usd );
			$darsad_hkd = ceil( ( $sood_hkd / 100 ) * $ragham_hkd);
			$result_hkd = $ragham_hkd + $darsad_hkd;
			$this->wncu_crud( $curr_hkd , 'دلار هنگ کنگ', $result_hkd );
		
		$chf = wncu_get_option( 'wncu_chf_time', 'currencies' );
			$curr_chf   = wncu_get_option( 'wncu_chf', 'currencies' );
			$sood_chf   = wncu_get_option( 'wncu_chf_sood', 'currencies' );
			$crate_chf  = $this->wb_currency( $curr_chf );
			$ragham_chf = ceil( $crate_chf * $havale_usd );
			$darsad_chf = ceil( ( $sood_chf / 100 ) * $ragham_chf);
			$result_chf = $ragham_chf + $darsad_chf;
			$this->wncu_crud( $curr_chf , 'فرانک سوییس', $result_chf );
		
		$dkk = wncu_get_option( 'wncu_dkk_time', 'currencies' );
			$curr_dkk   = wncu_get_option( 'wncu_dkk', 'currencies' );
			$sood_dkk   = wncu_get_option( 'wncu_dkk_sood', 'currencies' );
			$crate_dkk  = $this->wb_currency( $curr_dkk );
			$ragham_dkk = ceil( $crate_dkk * $havale_usd );
			$darsad_dkk = ceil( ( $sood_dkk / 100 ) * $ragham_dkk);
			$result_dkk = $ragham_dkk + $darsad_dkk;
			$this->wncu_crud( $curr_dkk , 'کرون دانمارک', $result_dkk );

		$sek = wncu_get_option( 'wncu_sek_time', 'currencies' );		
			$curr_sek   = wncu_get_option( 'wncu_sek', 'currencies' );
			$sood_sek   = wncu_get_option( 'wncu_sek_sood', 'currencies' );
			$crate_sek  = $this->wb_currency( $curr_sek );
			$ragham_sek = ceil( $crate_sek * $havale_usd );
			$darsad_sek = ceil( ( $sood_sek / 100 ) * $ragham_sek);
			$result_sek = $ragham_sek + $darsad_sek;
			$this->wncu_crud( $curr_sek , 'کرون سوئد', $result_sek );

		$sgd = wncu_get_option( 'wncu_sgd_time', 'currencies' );		
			$curr_sgd   = wncu_get_option( 'wncu_sgd', 'currencies' );
			$sood_sgd   = wncu_get_option( 'wncu_sgd_sood', 'currencies' );
			$crate_sgd  = $this->wb_currency( $curr_sgd );
			$ragham_sgd = ceil( $crate_sgd * $havale_usd );
			$darsad_sgd = ceil( ( $sood_sgd / 100 ) * $ragham_sgd);
			$result_sgd = $ragham_sgd + $darsad_sgd;
			$this->wncu_crud( $curr_sgd , 'دلار سنگاپور', $result_sgd );

		$nzd = wncu_get_option( 'wncu_nzd_time', 'currencies' );			
			$curr_nzd   = wncu_get_option( 'wncu_nzd', 'currencies' );
			$sood_nzd   = wncu_get_option( 'wncu_nzd_sood', 'currencies' );
			$crate_nzd  = $this->wb_currency( $curr_nzd );
			$ragham_nzd = ceil( $crate_nzd * $havale_usd );
			$darsad_nzd = ceil( ( $sood_nzd / 100 ) * $ragham_nzd);
			$result_nzd = $ragham_nzd + $darsad_nzd;
			$this->wncu_crud( $curr_nzd , 'دلار نیوزلند', $result_nzd );

		$zar = wncu_get_option( 'wncu_zar_time', 'currencies' );	
			$curr_zar   = wncu_get_option( 'wncu_zar', 'currencies' );
			$sood_zar   = wncu_get_option( 'wncu_zar_sood', 'currencies' );
			$crate_zar  = $this->wb_currency( $curr_zar );
			$ragham_zar = ceil( $crate_zar * $havale_usd );
			$darsad_zar = ceil( ( $sood_zar / 100 ) * $ragham_zar);
			$result_zar = $ragham_zar + $darsad_zar;
			$this->wncu_crud( $curr_zar , 'راند', $result_zar );
	}
	/**
	 * Define new corns
	 */
	public function wncu_my_cron_schedules($schedules){
	    if(!isset($schedules["5min"])){
	        $schedules["5min"] = array(
	            'interval' => 5*60,
	            'display' => __('Once every 5 minutes'));
	    }
	    if(!isset($schedules["10min"])){
	        $schedules["10min"] = array(
	            'interval' => 10*60,
	            'display' => __('Once every 10 minutes'));
	    }	    
	    if(!isset($schedules["15min"])){
	        $schedules["15min"] = array(
	            'interval' => 15*60,
	            'display' => __('Once every 15 minutes'));
	    }	    
	    if(!isset($schedules["30min"])){
	        $schedules["30min"] = array(
	            'interval' => 30*60,
	            'display' => __('Once every 30 minutes'));
	    }
	    return $schedules;
	}

	/**
	 * define event according to corns
	 */
	public function wncu_define_cornhourly() {
	    if ( ! wp_next_scheduled ( 'wncu_corns_hourly' ) ) {
			wp_schedule_event( time(), 'hourly', 'wncu_corns_hourly');
	    }
	    if ( ! wp_next_scheduled ( 'wncu_corns_five' ) ) {
			wp_schedule_event( time(), '5min', 'wncu_corns_five');
	    }
	    if ( ! wp_next_scheduled ( 'wncu_corns_ten' ) ) {
			wp_schedule_event( time(), '10min', 'wncu_corns_ten');
	    }
	    if ( ! wp_next_scheduled ( 'wncu_corns_fifteen' ) ) {
			wp_schedule_event( time(), '15min', 'wncu_corns_fifteen');
	    }
	    if ( ! wp_next_scheduled ( 'wncu_corns_thrtee' ) ) {
			wp_schedule_event( time(), '30min', 'wncu_corns_thrtee');
	    }

	}

		

	/**
	 * Do this 5 min
	 */
	public function wncu_corns_five() {
		// renew rate of usd
		$this->get_havale_usd();
		$havale_usd = $this->get_havale();
		$usd = wncu_get_option( 'wncu_usd_time', 'currencies' );
		if ( $usd == '5' ) {
			$curr_usd   = wncu_get_option( 'wncu_usd', 'currencies' );
			$sood_usd   = wncu_get_option( 'wncu_usd_sood', 'currencies' );
			$crate_usd  = $this->wb_currency( $curr_usd );
			$ragham_usd = ceil( $crate_usd * $havale_usd );
			$darsad_usd = ceil( ( $sood_usd / 100 ) * $ragham_usd);
			$result_usd = $ragham_usd + $darsad_usd;
			$this->wncu_crud( $curr_usd , 'دلار آمریکا', $result_usd );
		}	

		$cad = wncu_get_option( 'wncu_cad_time', 'currencies' );	
		if ( $cad == '5' ) {
			$curr_cad   = wncu_get_option( 'wncu_cad', 'currencies' );
			$sood_cad   = wncu_get_option( 'wncu_cad_sood', 'currencies' );
			$crate_cad  = $this->wb_currency( $curr_cad );
			$ragham_cad = ceil( $crate_cad * $havale_usd );
			$darsad_cad = ceil( ( $sood_cad / 100 ) * $ragham_cad);
			$result_cad = $ragham_cad + $darsad_cad;
			$this->wncu_crud( $curr_cad , 'دلار کانادا', $result_cad );	
		}
		
		$eur = wncu_get_option( 'wncu_eur_time', 'currencies' );
		if ( $eur == '5' ) {
			$curr_eur   = wncu_get_option( 'wncu_eur', 'currencies' );
			$sood_eur   = wncu_get_option( 'wncu_eur_sood', 'currencies' );
			$crate_eur  = $this->wb_currency( $curr_eur );
			$ragham_eur = ceil( $crate_eur * $havale_usd );
			$darsad_eur = ceil( ( $sood_eur / 100 ) * $ragham_eur);
			$result_eur = $ragham_eur + $darsad_eur;
			$this->wncu_crud( $curr_eur , 'یورو', $result_eur );
		}
		
		$gbp = wncu_get_option( 'wncu_gbp_time', 'currencies' );
		if ( $gbp == '5' ) {
			$curr_gbp   = wncu_get_option( 'wncu_gbp', 'currencies' );
			$sood_gbp   = wncu_get_option( 'wncu_gbp_sood', 'currencies' );
			$crate_gbp  = $this->wb_currency( $curr_gbp );
			$ragham_gbp = ceil( $crate_gbp * $havale_usd );
			$darsad_gbp = ceil( ( $sood_gbp / 100 ) * $ragham_gbp);
			$result_gbp = $ragham_gbp + $darsad_gbp;
			$this->wncu_crud( $curr_gbp , 'پوند انگلیس', $result_gbp );
		}		
		
		$aud = wncu_get_option( 'wncu_aud_time', 'currencies' );
		if ( $aud == '5' ) {
			$curr_aud   = wncu_get_option( 'wncu_aud', 'currencies' );
			$sood_aud   = wncu_get_option( 'wncu_aud_sood', 'currencies' );
			$crate_aud  = $this->wb_currency( $curr_aud );
			$ragham_aud = ceil( $crate_aud * $havale_usd );
			$darsad_aud = ceil( ( $sood_aud / 100 ) * $ragham_aud);
			$result_aud = $ragham_aud + $darsad_aud;
			$this->wncu_crud( $curr_aud , 'دلار استرالیا', $result_aud );
		}		
		
		$cny = wncu_get_option( 'wncu_cny_time', 'currencies' );
		if ( $cny == '5' ) {
			$curr_cny   = wncu_get_option( 'wncu_cny', 'currencies' );
			$sood_cny   = wncu_get_option( 'wncu_cny_sood', 'currencies' );
			$crate_cny  = $this->wb_currency( $curr_cny );
			$ragham_cny = ceil( $crate_cny * $havale_usd );
			$darsad_cny = ceil( ( $sood_cny / 100 ) * $ragham_cny);
			$result_cny = $ragham_cny + $darsad_cny;
			$this->wncu_crud( $curr_cny , 'یوان', $result_cny );
		}		
		
		$aed = wncu_get_option( 'wncu_aed_time', 'currencies' );
		if ( $aed == '5' ) {
			$curr_aed   = wncu_get_option( 'wncu_aed', 'currencies' );
			$sood_aed   = wncu_get_option( 'wncu_aed_sood', 'currencies' );
			$crate_aed  = $this->wb_currency( $curr_aed );
			$ragham_aed = ceil( $crate_aed * $havale_usd );
			$darsad_aed = ceil( ( $sood_aed / 100 ) * $ragham_aed);
			$result_aed = $ragham_aed + $darsad_aed;
			$this->wncu_crud( $curr_aed , 'درهم امارات', $result_aed );
		}		
		
		$hkd = wncu_get_option( 'wncu_hkd_time', 'currencies' );
		if ( $hkd == '5' ) {
			$curr_hkd   = wncu_get_option( 'wncu_hkd', 'currencies' );
			$sood_hkd   = wncu_get_option( 'wncu_hkd_sood', 'currencies' );
			$crate_hkd  = $this->wb_currency( $curr_hkd );
			$ragham_hkd = ceil( $crate_hkd * $havale_usd );
			$darsad_hkd = ceil( ( $sood_hkd / 100 ) * $ragham_hkd);
			$result_hkd = $ragham_hkd + $darsad_hkd;
			$this->wncu_crud( $curr_hkd , 'دلار هنگ کنگ', $result_hkd );
		}		
		
		$chf = wncu_get_option( 'wncu_chf_time', 'currencies' );
		if ( $chf == '5' ) {
			$curr_chf   = wncu_get_option( 'wncu_chf', 'currencies' );
			$sood_chf   = wncu_get_option( 'wncu_chf_sood', 'currencies' );
			$crate_chf  = $this->wb_currency( $curr_chf );
			$ragham_chf = ceil( $crate_chf * $havale_usd );
			$darsad_chf = ceil( ( $sood_chf / 100 ) * $ragham_chf);
			$result_chf = $ragham_chf + $darsad_chf;
			$this->wncu_crud( $curr_chf , 'فرانک سوییس', $result_chf );
		}		
		
		$dkk = wncu_get_option( 'wncu_dkk_time', 'currencies' );
		if ( $dkk == '5' ) {
			$curr_dkk   = wncu_get_option( 'wncu_dkk', 'currencies' );
			$sood_dkk   = wncu_get_option( 'wncu_dkk_sood', 'currencies' );
			$crate_dkk  = $this->wb_currency( $curr_dkk );
			$ragham_dkk = ceil( $crate_dkk * $havale_usd );
			$darsad_dkk = ceil( ( $sood_dkk / 100 ) * $ragham_dkk);
			$result_dkk = $ragham_dkk + $darsad_dkk;
			$this->wncu_crud( $curr_dkk , 'کرون دانمارک', $result_dkk );
		}

		$sek = wncu_get_option( 'wncu_sek_time', 'currencies' );		
		if ( $sek == '5' ) {
			$curr_sek   = wncu_get_option( 'wncu_sek', 'currencies' );
			$sood_sek   = wncu_get_option( 'wncu_sek_sood', 'currencies' );
			$crate_sek  = $this->wb_currency( $curr_sek );
			$ragham_sek = ceil( $crate_sek * $havale_usd );
			$darsad_sek = ceil( ( $sood_sek / 100 ) * $ragham_sek);
			$result_sek = $ragham_sek + $darsad_sek;
			$this->wncu_crud( $curr_sek , 'کرون سوئد', $result_sek );
		}	

		$sgd = wncu_get_option( 'wncu_sgd_time', 'currencies' );		
		if ( $sgd == '5' ) {
			$curr_sgd   = wncu_get_option( 'wncu_sgd', 'currencies' );
			$sood_sgd   = wncu_get_option( 'wncu_sgd_sood', 'currencies' );
			$crate_sgd  = $this->wb_currency( $curr_sgd );
			$ragham_sgd = ceil( $crate_sgd * $havale_usd );
			$darsad_sgd = ceil( ( $sood_sgd / 100 ) * $ragham_sgd);
			$result_sgd = $ragham_sgd + $darsad_sgd;
			$this->wncu_crud( $curr_sgd , 'دلار سنگاپور', $result_sgd );
		}

		$nzd = wncu_get_option( 'wncu_nzd_time', 'currencies' );			
		if ( $nzd == '5' ) {
			$curr_nzd   = wncu_get_option( 'wncu_nzd', 'currencies' );
			$sood_nzd   = wncu_get_option( 'wncu_nzd_sood', 'currencies' );
			$crate_nzd  = $this->wb_currency( $curr_nzd );
			$ragham_nzd = ceil( $crate_nzd * $havale_usd );
			$darsad_nzd = ceil( ( $sood_nzd / 100 ) * $ragham_nzd);
			$result_nzd = $ragham_nzd + $darsad_nzd;
			$this->wncu_crud( $curr_nzd , 'دلار نیوزلند', $result_nzd );
		}	

		$zar = wncu_get_option( 'wncu_zar_time', 'currencies' );	
		if ( $zar == '5' ) {
			$curr_zar   = wncu_get_option( 'wncu_zar', 'currencies' );
			$sood_zar   = wncu_get_option( 'wncu_zar_sood', 'currencies' );
			$crate_zar  = $this->wb_currency( $curr_zar );
			$ragham_zar = ceil( $crate_zar * $havale_usd );
			$darsad_zar = ceil( ( $sood_zar / 100 ) * $ragham_zar);
			$result_zar = $ragham_zar + $darsad_zar;
			$this->wncu_crud( $curr_zar , 'راند', $result_zar );
		}		

	}

	/**
	 * Do this 10 min
	 */
	public function wncu_corns_ten() {
		// renew rate of usd
		$this->get_havale_usd();
		$havale_usd = $this->get_havale();
		$usd = wncu_get_option( 'wncu_usd_time', 'currencies' );
		if ( $usd == '10' ) {
			$curr_usd   = wncu_get_option( 'wncu_usd', 'currencies' );
			$sood_usd   = wncu_get_option( 'wncu_usd_sood', 'currencies' );
			$crate_usd  = $this->wb_currency( $curr_usd );
			$ragham_usd = ceil( $crate_usd * $havale_usd );
			$darsad_usd = ceil( ( $sood_usd / 100 ) * $ragham_usd);
			$result_usd = $ragham_usd + $darsad_usd;
			$this->wncu_crud( $curr_usd , 'دلار آمریکا', $result_usd );
		}	

		$cad = wncu_get_option( 'wncu_cad_time', 'currencies' );	
		if ( $cad == '10' ) {
			$curr_cad   = wncu_get_option( 'wncu_cad', 'currencies' );
			$sood_cad   = wncu_get_option( 'wncu_cad_sood', 'currencies' );
			$crate_cad  = $this->wb_currency( $curr_cad );
			$ragham_cad = ceil( $crate_cad * $havale_usd );
			$darsad_cad = ceil( ( $sood_cad / 100 ) * $ragham_cad);
			$result_cad = $ragham_cad + $darsad_cad;
			$this->wncu_crud( $curr_cad , 'دلار کانادا', $result_cad );	
		}
		
		$eur = wncu_get_option( 'wncu_eur_time', 'currencies' );
		if ( $eur == '10' ) {
			$curr_eur   = wncu_get_option( 'wncu_eur', 'currencies' );
			$sood_eur   = wncu_get_option( 'wncu_eur_sood', 'currencies' );
			$crate_eur  = $this->wb_currency( $curr_eur );
			$ragham_eur = ceil( $crate_eur * $havale_usd );
			$darsad_eur = ceil( ( $sood_eur / 100 ) * $ragham_eur);
			$result_eur = $ragham_eur + $darsad_eur;
			$this->wncu_crud( $curr_eur , 'یورو', $result_eur );
		}
		
		$gbp = wncu_get_option( 'wncu_gbp_time', 'currencies' );
		if ( $gbp == '10' ) {
			$curr_gbp   = wncu_get_option( 'wncu_gbp', 'currencies' );
			$sood_gbp   = wncu_get_option( 'wncu_gbp_sood', 'currencies' );
			$crate_gbp  = $this->wb_currency( $curr_gbp );
			$ragham_gbp = ceil( $crate_gbp * $havale_usd );
			$darsad_gbp = ceil( ( $sood_gbp / 100 ) * $ragham_gbp);
			$result_gbp = $ragham_gbp + $darsad_gbp;
			$this->wncu_crud( $curr_gbp , 'پوند انگلیس', $result_gbp );
		}		
		
		$aud = wncu_get_option( 'wncu_aud_time', 'currencies' );
		if ( $aud == '10' ) {
			$curr_aud   = wncu_get_option( 'wncu_aud', 'currencies' );
			$sood_aud   = wncu_get_option( 'wncu_aud_sood', 'currencies' );
			$crate_aud  = $this->wb_currency( $curr_aud );
			$ragham_aud = ceil( $crate_aud * $havale_usd );
			$darsad_aud = ceil( ( $sood_aud / 100 ) * $ragham_aud);
			$result_aud = $ragham_aud + $darsad_aud;
			$this->wncu_crud( $curr_aud , 'دلار استرالیا', $result_aud );
		}		
		
		$cny = wncu_get_option( 'wncu_cny_time', 'currencies' );
		if ( $cny == '10' ) {
			$curr_cny   = wncu_get_option( 'wncu_cny', 'currencies' );
			$sood_cny   = wncu_get_option( 'wncu_cny_sood', 'currencies' );
			$crate_cny  = $this->wb_currency( $curr_cny );
			$ragham_cny = ceil( $crate_cny * $havale_usd );
			$darsad_cny = ceil( ( $sood_cny / 100 ) * $ragham_cny);
			$result_cny = $ragham_cny + $darsad_cny;
			$this->wncu_crud( $curr_cny , 'یوان', $result_cny );
		}		
		
		$aed = wncu_get_option( 'wncu_aed_time', 'currencies' );
		if ( $aed == '10' ) {
			$curr_aed   = wncu_get_option( 'wncu_aed', 'currencies' );
			$sood_aed   = wncu_get_option( 'wncu_aed_sood', 'currencies' );
			$crate_aed  = $this->wb_currency( $curr_aed );
			$ragham_aed = ceil( $crate_aed * $havale_usd );
			$darsad_aed = ceil( ( $sood_aed / 100 ) * $ragham_aed);
			$result_aed = $ragham_aed + $darsad_aed;
			$this->wncu_crud( $curr_aed , 'درهم امارات', $result_aed );
		}		
		
		$hkd = wncu_get_option( 'wncu_hkd_time', 'currencies' );
		if ( $hkd == '10' ) {
			$curr_hkd   = wncu_get_option( 'wncu_hkd', 'currencies' );
			$sood_hkd   = wncu_get_option( 'wncu_hkd_sood', 'currencies' );
			$crate_hkd  = $this->wb_currency( $curr_hkd );
			$ragham_hkd = ceil( $crate_hkd * $havale_usd );
			$darsad_hkd = ceil( ( $sood_hkd / 100 ) * $ragham_hkd);
			$result_hkd = $ragham_hkd + $darsad_hkd;
			$this->wncu_crud( $curr_hkd , 'دلار هنگ کنگ', $result_hkd );
		}		
		
		$chf = wncu_get_option( 'wncu_chf_time', 'currencies' );
		if ( $chf == '10' ) {
			$curr_chf   = wncu_get_option( 'wncu_chf', 'currencies' );
			$sood_chf   = wncu_get_option( 'wncu_chf_sood', 'currencies' );
			$crate_chf  = $this->wb_currency( $curr_chf );
			$ragham_chf = ceil( $crate_chf * $havale_usd );
			$darsad_chf = ceil( ( $sood_chf / 100 ) * $ragham_chf);
			$result_chf = $ragham_chf + $darsad_chf;
			$this->wncu_crud( $curr_chf , 'فرانک سوییس', $result_chf );
		}		
		
		$dkk = wncu_get_option( 'wncu_dkk_time', 'currencies' );
		if ( $dkk == '10' ) {
			$curr_dkk   = wncu_get_option( 'wncu_dkk', 'currencies' );
			$sood_dkk   = wncu_get_option( 'wncu_dkk_sood', 'currencies' );
			$crate_dkk  = $this->wb_currency( $curr_dkk );
			$ragham_dkk = ceil( $crate_dkk * $havale_usd );
			$darsad_dkk = ceil( ( $sood_dkk / 100 ) * $ragham_dkk);
			$result_dkk = $ragham_dkk + $darsad_dkk;
			$this->wncu_crud( $curr_dkk , 'کرون دانمارک', $result_dkk );
		}

		$sek = wncu_get_option( 'wncu_sek_time', 'currencies' );		
		if ( $sek == '10' ) {
			$curr_sek   = wncu_get_option( 'wncu_sek', 'currencies' );
			$sood_sek   = wncu_get_option( 'wncu_sek_sood', 'currencies' );
			$crate_sek  = $this->wb_currency( $curr_sek );
			$ragham_sek = ceil( $crate_sek * $havale_usd );
			$darsad_sek = ceil( ( $sood_sek / 100 ) * $ragham_sek);
			$result_sek = $ragham_sek + $darsad_sek;
			$this->wncu_crud( $curr_sek , 'کرون سوئد', $result_sek );
		}	

		$sgd = wncu_get_option( 'wncu_sgd_time', 'currencies' );		
		if ( $sgd == '10' ) {
			$curr_sgd   = wncu_get_option( 'wncu_sgd', 'currencies' );
			$sood_sgd   = wncu_get_option( 'wncu_sgd_sood', 'currencies' );
			$crate_sgd  = $this->wb_currency( $curr_sgd );
			$ragham_sgd = ceil( $crate_sgd * $havale_usd );
			$darsad_sgd = ceil( ( $sood_sgd / 100 ) * $ragham_sgd);
			$result_sgd = $ragham_sgd + $darsad_sgd;
			$this->wncu_crud( $curr_sgd , 'دلار سنگاپور', $result_sgd );
		}

		$nzd = wncu_get_option( 'wncu_nzd_time', 'currencies' );			
		if ( $nzd == '10' ) {
			$curr_nzd   = wncu_get_option( 'wncu_nzd', 'currencies' );
			$sood_nzd   = wncu_get_option( 'wncu_nzd_sood', 'currencies' );
			$crate_nzd  = $this->wb_currency( $curr_nzd );
			$ragham_nzd = ceil( $crate_nzd * $havale_usd );
			$darsad_nzd = ceil( ( $sood_nzd / 100 ) * $ragham_nzd);
			$result_nzd = $ragham_nzd + $darsad_nzd;
			$this->wncu_crud( $curr_nzd , 'دلار نیوزلند', $result_nzd );
		}	

		$zar = wncu_get_option( 'wncu_zar_time', 'currencies' );	
		if ( $zar == '10' ) {
			$curr_zar   = wncu_get_option( 'wncu_zar', 'currencies' );
			$sood_zar   = wncu_get_option( 'wncu_zar_sood', 'currencies' );
			$crate_zar  = $this->wb_currency( $curr_zar );
			$ragham_zar = ceil( $crate_zar * $havale_usd );
			$darsad_zar = ceil( ( $sood_zar / 100 ) * $ragham_zar);
			$result_zar = $ragham_zar + $darsad_zar;
			$this->wncu_crud( $curr_zar , 'راند', $result_zar );
		}			
	}

	/**
	 * Do this 15 min
	 */
	public function wncu_corns_fifteen() {
		// renew rate of usd
		$this->get_havale_usd();
		$havale_usd = $this->get_havale();
		$usd = wncu_get_option( 'wncu_usd_time', 'currencies' );
		if ( $usd == '15' ) {
			$curr_usd   = wncu_get_option( 'wncu_usd', 'currencies' );
			$sood_usd   = wncu_get_option( 'wncu_usd_sood', 'currencies' );
			$crate_usd  = $this->wb_currency( $curr_usd );
			$ragham_usd = ceil( $crate_usd * $havale_usd );
			$darsad_usd = ceil( ( $sood_usd / 100 ) * $ragham_usd);
			$result_usd = $ragham_usd + $darsad_usd;
			$this->wncu_crud( $curr_usd , 'دلار آمریکا', $result_usd );
		}	

		$cad = wncu_get_option( 'wncu_cad_time', 'currencies' );	
		if ( $cad == '15' ) {
			$curr_cad   = wncu_get_option( 'wncu_cad', 'currencies' );
			$sood_cad   = wncu_get_option( 'wncu_cad_sood', 'currencies' );
			$crate_cad  = $this->wb_currency( $curr_cad );
			$ragham_cad = ceil( $crate_cad * $havale_usd );
			$darsad_cad = ceil( ( $sood_cad / 100 ) * $ragham_cad);
			$result_cad = $ragham_cad + $darsad_cad;
			$this->wncu_crud( $curr_cad , 'دلار کانادا', $result_cad );	
		}
		
		$eur = wncu_get_option( 'wncu_eur_time', 'currencies' );
		if ( $eur == '15' ) {
			$curr_eur   = wncu_get_option( 'wncu_eur', 'currencies' );
			$sood_eur   = wncu_get_option( 'wncu_eur_sood', 'currencies' );
			$crate_eur  = $this->wb_currency( $curr_eur );
			$ragham_eur = ceil( $crate_eur * $havale_usd );
			$darsad_eur = ceil( ( $sood_eur / 100 ) * $ragham_eur);
			$result_eur = $ragham_eur + $darsad_eur;
			$this->wncu_crud( $curr_eur , 'یورو', $result_eur );
		}
		
		$gbp = wncu_get_option( 'wncu_gbp_time', 'currencies' );
		if ( $gbp == '15' ) {
			$curr_gbp   = wncu_get_option( 'wncu_gbp', 'currencies' );
			$sood_gbp   = wncu_get_option( 'wncu_gbp_sood', 'currencies' );
			$crate_gbp  = $this->wb_currency( $curr_gbp );
			$ragham_gbp = ceil( $crate_gbp * $havale_usd );
			$darsad_gbp = ceil( ( $sood_gbp / 100 ) * $ragham_gbp);
			$result_gbp = $ragham_gbp + $darsad_gbp;
			$this->wncu_crud( $curr_gbp , 'پوند انگلیس', $result_gbp );
		}		
		
		$aud = wncu_get_option( 'wncu_aud_time', 'currencies' );
		if ( $aud == '15' ) {
			$curr_aud   = wncu_get_option( 'wncu_aud', 'currencies' );
			$sood_aud   = wncu_get_option( 'wncu_aud_sood', 'currencies' );
			$crate_aud  = $this->wb_currency( $curr_aud );
			$ragham_aud = ceil( $crate_aud * $havale_usd );
			$darsad_aud = ceil( ( $sood_aud / 100 ) * $ragham_aud);
			$result_aud = $ragham_aud + $darsad_aud;
			$this->wncu_crud( $curr_aud , 'دلار استرالیا', $result_aud );
		}		
		
		$cny = wncu_get_option( 'wncu_cny_time', 'currencies' );
		if ( $cny == '15' ) {
			$curr_cny   = wncu_get_option( 'wncu_cny', 'currencies' );
			$sood_cny   = wncu_get_option( 'wncu_cny_sood', 'currencies' );
			$crate_cny  = $this->wb_currency( $curr_cny );
			$ragham_cny = ceil( $crate_cny * $havale_usd );
			$darsad_cny = ceil( ( $sood_cny / 100 ) * $ragham_cny);
			$result_cny = $ragham_cny + $darsad_cny;
			$this->wncu_crud( $curr_cny , 'یوان', $result_cny );
		}		
		
		$aed = wncu_get_option( 'wncu_aed_time', 'currencies' );
		if ( $aed == '15' ) {
			$curr_aed   = wncu_get_option( 'wncu_aed', 'currencies' );
			$sood_aed   = wncu_get_option( 'wncu_aed_sood', 'currencies' );
			$crate_aed  = $this->wb_currency( $curr_aed );
			$ragham_aed = ceil( $crate_aed * $havale_usd );
			$darsad_aed = ceil( ( $sood_aed / 100 ) * $ragham_aed);
			$result_aed = $ragham_aed + $darsad_aed;
			$this->wncu_crud( $curr_aed , 'درهم امارات', $result_aed );
		}		
		
		$hkd = wncu_get_option( 'wncu_hkd_time', 'currencies' );
		if ( $hkd == '15' ) {
			$curr_hkd   = wncu_get_option( 'wncu_hkd', 'currencies' );
			$sood_hkd   = wncu_get_option( 'wncu_hkd_sood', 'currencies' );
			$crate_hkd  = $this->wb_currency( $curr_hkd );
			$ragham_hkd = ceil( $crate_hkd * $havale_usd );
			$darsad_hkd = ceil( ( $sood_hkd / 100 ) * $ragham_hkd);
			$result_hkd = $ragham_hkd + $darsad_hkd;
			$this->wncu_crud( $curr_hkd , 'دلار هنگ کنگ', $result_hkd );
		}		
		
		$chf = wncu_get_option( 'wncu_chf_time', 'currencies' );
		if ( $chf == '15' ) {
			$curr_chf   = wncu_get_option( 'wncu_chf', 'currencies' );
			$sood_chf   = wncu_get_option( 'wncu_chf_sood', 'currencies' );
			$crate_chf  = $this->wb_currency( $curr_chf );
			$ragham_chf = ceil( $crate_chf * $havale_usd );
			$darsad_chf = ceil( ( $sood_chf / 100 ) * $ragham_chf);
			$result_chf = $ragham_chf + $darsad_chf;
			$this->wncu_crud( $curr_chf , 'فرانک سوییس', $result_chf );
		}		
		
		$dkk = wncu_get_option( 'wncu_dkk_time', 'currencies' );
		if ( $dkk == '15' ) {
			$curr_dkk   = wncu_get_option( 'wncu_dkk', 'currencies' );
			$sood_dkk   = wncu_get_option( 'wncu_dkk_sood', 'currencies' );
			$crate_dkk  = $this->wb_currency( $curr_dkk );
			$ragham_dkk = ceil( $crate_dkk * $havale_usd );
			$darsad_dkk = ceil( ( $sood_dkk / 100 ) * $ragham_dkk);
			$result_dkk = $ragham_dkk + $darsad_dkk;
			$this->wncu_crud( $curr_dkk , 'کرون دانمارک', $result_dkk );
		}

		$sek = wncu_get_option( 'wncu_sek_time', 'currencies' );		
		if ( $sek == '15' ) {
			$curr_sek   = wncu_get_option( 'wncu_sek', 'currencies' );
			$sood_sek   = wncu_get_option( 'wncu_sek_sood', 'currencies' );
			$crate_sek  = $this->wb_currency( $curr_sek );
			$ragham_sek = ceil( $crate_sek * $havale_usd );
			$darsad_sek = ceil( ( $sood_sek / 100 ) * $ragham_sek);
			$result_sek = $ragham_sek + $darsad_sek;
			$this->wncu_crud( $curr_sek , 'کرون سوئد', $result_sek );
		}	

		$sgd = wncu_get_option( 'wncu_sgd_time', 'currencies' );		
		if ( $sgd == '15' ) {
			$curr_sgd   = wncu_get_option( 'wncu_sgd', 'currencies' );
			$sood_sgd   = wncu_get_option( 'wncu_sgd_sood', 'currencies' );
			$crate_sgd  = $this->wb_currency( $curr_sgd );
			$ragham_sgd = ceil( $crate_sgd * $havale_usd );
			$darsad_sgd = ceil( ( $sood_sgd / 100 ) * $ragham_sgd);
			$result_sgd = $ragham_sgd + $darsad_sgd;
			$this->wncu_crud( $curr_sgd , 'دلار سنگاپور', $result_sgd );
		}

		$nzd = wncu_get_option( 'wncu_nzd_time', 'currencies' );			
		if ( $nzd == '15' ) {
			$curr_nzd   = wncu_get_option( 'wncu_nzd', 'currencies' );
			$sood_nzd   = wncu_get_option( 'wncu_nzd_sood', 'currencies' );
			$crate_nzd  = $this->wb_currency( $curr_nzd );
			$ragham_nzd = ceil( $crate_nzd * $havale_usd );
			$darsad_nzd = ceil( ( $sood_nzd / 100 ) * $ragham_nzd);
			$result_nzd = $ragham_nzd + $darsad_nzd;
			$this->wncu_crud( $curr_nzd , 'دلار نیوزلند', $result_nzd );
		}	

		$zar = wncu_get_option( 'wncu_zar_time', 'currencies' );	
		if ( $zar == '15' ) {
			$curr_zar   = wncu_get_option( 'wncu_zar', 'currencies' );
			$sood_zar   = wncu_get_option( 'wncu_zar_sood', 'currencies' );
			$crate_zar  = $this->wb_currency( $curr_zar );
			$ragham_zar = ceil( $crate_zar * $havale_usd );
			$darsad_zar = ceil( ( $sood_zar / 100 ) * $ragham_zar);
			$result_zar = $ragham_zar + $darsad_zar;
			$this->wncu_crud( $curr_zar , 'راند', $result_zar );
		}				
	}
	

	/**
	 * Do this 30 min
	 */
	public function wncu_corns_thrtee() {
		// renew rate of usd
		$this->get_havale_usd();
		$havale_usd = $this->get_havale();
		$usd = wncu_get_option( 'wncu_usd_time', 'currencies' );
		if ( $usd == '30' ) {
			$curr_usd   = wncu_get_option( 'wncu_usd', 'currencies' );
			$sood_usd   = wncu_get_option( 'wncu_usd_sood', 'currencies' );
			$crate_usd  = $this->wb_currency( $curr_usd );
			$ragham_usd = ceil( $crate_usd * $havale_usd );
			$darsad_usd = ceil( ( $sood_usd / 100 ) * $ragham_usd);
			$result_usd = $ragham_usd + $darsad_usd;
			$this->wncu_crud( $curr_usd , 'دلار آمریکا', $result_usd );
		}	

		$cad = wncu_get_option( 'wncu_cad_time', 'currencies' );	
		if ( $cad == '30' ) {
			$curr_cad   = wncu_get_option( 'wncu_cad', 'currencies' );
			$sood_cad   = wncu_get_option( 'wncu_cad_sood', 'currencies' );
			$crate_cad  = $this->wb_currency( $curr_cad );
			$ragham_cad = ceil( $crate_cad * $havale_usd );
			$darsad_cad = ceil( ( $sood_cad / 100 ) * $ragham_cad);
			$result_cad = $ragham_cad + $darsad_cad;
			$this->wncu_crud( $curr_cad , 'دلار کانادا', $result_cad );	
		}
		
		$eur = wncu_get_option( 'wncu_eur_time', 'currencies' );
		if ( $eur == '30' ) {
			$curr_eur   = wncu_get_option( 'wncu_eur', 'currencies' );
			$sood_eur   = wncu_get_option( 'wncu_eur_sood', 'currencies' );
			$crate_eur  = $this->wb_currency( $curr_eur );
			$ragham_eur = ceil( $crate_eur * $havale_usd );
			$darsad_eur = ceil( ( $sood_eur / 100 ) * $ragham_eur);
			$result_eur = $ragham_eur + $darsad_eur;
			$this->wncu_crud( $curr_eur , 'یورو', $result_eur );
		}
		
		$gbp = wncu_get_option( 'wncu_gbp_time', 'currencies' );
		if ( $gbp == '30' ) {
			$curr_gbp   = wncu_get_option( 'wncu_gbp', 'currencies' );
			$sood_gbp   = wncu_get_option( 'wncu_gbp_sood', 'currencies' );
			$crate_gbp  = $this->wb_currency( $curr_gbp );
			$ragham_gbp = ceil( $crate_gbp * $havale_usd );
			$darsad_gbp = ceil( ( $sood_gbp / 100 ) * $ragham_gbp);
			$result_gbp = $ragham_gbp + $darsad_gbp;
			$this->wncu_crud( $curr_gbp , 'پوند انگلیس', $result_gbp );
		}		
		
		$aud = wncu_get_option( 'wncu_aud_time', 'currencies' );
		if ( $aud == '30' ) {
			$curr_aud   = wncu_get_option( 'wncu_aud', 'currencies' );
			$sood_aud   = wncu_get_option( 'wncu_aud_sood', 'currencies' );
			$crate_aud  = $this->wb_currency( $curr_aud );
			$ragham_aud = ceil( $crate_aud * $havale_usd );
			$darsad_aud = ceil( ( $sood_aud / 100 ) * $ragham_aud);
			$result_aud = $ragham_aud + $darsad_aud;
			$this->wncu_crud( $curr_aud , 'دلار استرالیا', $result_aud );
		}		
		
		$cny = wncu_get_option( 'wncu_cny_time', 'currencies' );
		if ( $cny == '30' ) {
			$curr_cny   = wncu_get_option( 'wncu_cny', 'currencies' );
			$sood_cny   = wncu_get_option( 'wncu_cny_sood', 'currencies' );
			$crate_cny  = $this->wb_currency( $curr_cny );
			$ragham_cny = ceil( $crate_cny * $havale_usd );
			$darsad_cny = ceil( ( $sood_cny / 100 ) * $ragham_cny);
			$result_cny = $ragham_cny + $darsad_cny;
			$this->wncu_crud( $curr_cny , 'یوان', $result_cny );
		}		
		
		$aed = wncu_get_option( 'wncu_aed_time', 'currencies' );
		if ( $aed == '30' ) {
			$curr_aed   = wncu_get_option( 'wncu_aed', 'currencies' );
			$sood_aed   = wncu_get_option( 'wncu_aed_sood', 'currencies' );
			$crate_aed  = $this->wb_currency( $curr_aed );
			$ragham_aed = ceil( $crate_aed * $havale_usd );
			$darsad_aed = ceil( ( $sood_aed / 100 ) * $ragham_aed);
			$result_aed = $ragham_aed + $darsad_aed;
			$this->wncu_crud( $curr_aed , 'درهم امارات', $result_aed );
		}		
		
		$hkd = wncu_get_option( 'wncu_hkd_time', 'currencies' );
		if ( $hkd == '30' ) {
			$curr_hkd   = wncu_get_option( 'wncu_hkd', 'currencies' );
			$sood_hkd   = wncu_get_option( 'wncu_hkd_sood', 'currencies' );
			$crate_hkd  = $this->wb_currency( $curr_hkd );
			$ragham_hkd = ceil( $crate_hkd * $havale_usd );
			$darsad_hkd = ceil( ( $sood_hkd / 100 ) * $ragham_hkd);
			$result_hkd = $ragham_hkd + $darsad_hkd;
			$this->wncu_crud( $curr_hkd , 'دلار هنگ کنگ', $result_hkd );
		}		
		
		$chf = wncu_get_option( 'wncu_chf_time', 'currencies' );
		if ( $chf == '30' ) {
			$curr_chf   = wncu_get_option( 'wncu_chf', 'currencies' );
			$sood_chf   = wncu_get_option( 'wncu_chf_sood', 'currencies' );
			$crate_chf  = $this->wb_currency( $curr_chf );
			$ragham_chf = ceil( $crate_chf * $havale_usd );
			$darsad_chf = ceil( ( $sood_chf / 100 ) * $ragham_chf);
			$result_chf = $ragham_chf + $darsad_chf;
			$this->wncu_crud( $curr_chf , 'فرانک سوییس', $result_chf );
		}		
		
		$dkk = wncu_get_option( 'wncu_dkk_time', 'currencies' );
		if ( $dkk == '30' ) {
			$curr_dkk   = wncu_get_option( 'wncu_dkk', 'currencies' );
			$sood_dkk   = wncu_get_option( 'wncu_dkk_sood', 'currencies' );
			$crate_dkk  = $this->wb_currency( $curr_dkk );
			$ragham_dkk = ceil( $crate_dkk * $havale_usd );
			$darsad_dkk = ceil( ( $sood_dkk / 100 ) * $ragham_dkk);
			$result_dkk = $ragham_dkk + $darsad_dkk;
			$this->wncu_crud( $curr_dkk , 'کرون دانمارک', $result_dkk );
		}

		$sek = wncu_get_option( 'wncu_sek_time', 'currencies' );		
		if ( $sek == '30' ) {
			$curr_sek   = wncu_get_option( 'wncu_sek', 'currencies' );
			$sood_sek   = wncu_get_option( 'wncu_sek_sood', 'currencies' );
			$crate_sek  = $this->wb_currency( $curr_sek );
			$ragham_sek = ceil( $crate_sek * $havale_usd );
			$darsad_sek = ceil( ( $sood_sek / 100 ) * $ragham_sek);
			$result_sek = $ragham_sek + $darsad_sek;
			$this->wncu_crud( $curr_sek , 'کرون سوئد', $result_sek );
		}	

		$sgd = wncu_get_option( 'wncu_sgd_time', 'currencies' );		
		if ( $sgd == '30' ) {
			$curr_sgd   = wncu_get_option( 'wncu_sgd', 'currencies' );
			$sood_sgd   = wncu_get_option( 'wncu_sgd_sood', 'currencies' );
			$crate_sgd  = $this->wb_currency( $curr_sgd );
			$ragham_sgd = ceil( $crate_sgd * $havale_usd );
			$darsad_sgd = ceil( ( $sood_sgd / 100 ) * $ragham_sgd);
			$result_sgd = $ragham_sgd + $darsad_sgd;
			$this->wncu_crud( $curr_sgd , 'دلار سنگاپور', $result_sgd );
		}

		$nzd = wncu_get_option( 'wncu_nzd_time', 'currencies' );			
		if ( $nzd == '30' ) {
			$curr_nzd   = wncu_get_option( 'wncu_nzd', 'currencies' );
			$sood_nzd   = wncu_get_option( 'wncu_nzd_sood', 'currencies' );
			$crate_nzd  = $this->wb_currency( $curr_nzd );
			$ragham_nzd = ceil( $crate_nzd * $havale_usd );
			$darsad_nzd = ceil( ( $sood_nzd / 100 ) * $ragham_nzd);
			$result_nzd = $ragham_nzd + $darsad_nzd;
			$this->wncu_crud( $curr_nzd , 'دلار نیوزلند', $result_nzd );
		}	

		$zar = wncu_get_option( 'wncu_zar_time', 'currencies' );	
		if ( $zar == '30' ) {
			$curr_zar   = wncu_get_option( 'wncu_zar', 'currencies' );
			$sood_zar   = wncu_get_option( 'wncu_zar_sood', 'currencies' );
			$crate_zar  = $this->wb_currency( $curr_zar );
			$ragham_zar = ceil( $crate_zar * $havale_usd );
			$darsad_zar = ceil( ( $sood_zar / 100 ) * $ragham_zar);
			$result_zar = $ragham_zar + $darsad_zar;
			$this->wncu_crud( $curr_zar , 'راند', $result_zar );
		}			
	}


	/**
	 * Do this hourly
	 */
	public function wncu_do_this_hourly() {
		// renew rate of usd
		$this->get_havale_usd();
		$havale_usd = $this->get_havale();
		$usd = wncu_get_option( 'wncu_usd_time', 'currencies' );
		if ( $usd == 'hourly' ) {
			$curr_usd   = wncu_get_option( 'wncu_usd', 'currencies' );
			$sood_usd   = wncu_get_option( 'wncu_usd_sood', 'currencies' );
			$crate_usd  = $this->wb_currency( $curr_usd );
			$ragham_usd = ceil( $crate_usd * $havale_usd );
			$darsad_usd = ceil( ( $sood_usd / 100 ) * $ragham_usd);
			$result_usd = $ragham_usd + $darsad_usd;
			$this->wncu_crud( $curr_usd , 'دلار آمریکا', $result_usd );
		}	

		$cad = wncu_get_option( 'wncu_cad_time', 'currencies' );	
		if ( $cad == 'hourly' ) {
			$curr_cad   = wncu_get_option( 'wncu_cad', 'currencies' );
			$sood_cad   = wncu_get_option( 'wncu_cad_sood', 'currencies' );
			$crate_cad  = $this->wb_currency( $curr_cad );
			$ragham_cad = ceil( $crate_cad * $havale_usd );
			$darsad_cad = ceil( ( $sood_cad / 100 ) * $ragham_cad);
			$result_cad = $ragham_cad + $darsad_cad;
			$this->wncu_crud( $curr_cad , 'دلار کانادا', $result_cad );	
		}
		
		$eur = wncu_get_option( 'wncu_eur_time', 'currencies' );
		if ( $eur == 'hourly' ) {
			$curr_eur   = wncu_get_option( 'wncu_eur', 'currencies' );
			$sood_eur   = wncu_get_option( 'wncu_eur_sood', 'currencies' );
			$crate_eur  = $this->wb_currency( $curr_eur );
			$ragham_eur = ceil( $crate_eur * $havale_usd );
			$darsad_eur = ceil( ( $sood_eur / 100 ) * $ragham_eur);
			$result_eur = $ragham_eur + $darsad_eur;
			$this->wncu_crud( $curr_eur , 'یورو', $result_eur );
		}
		
		$gbp = wncu_get_option( 'wncu_gbp_time', 'currencies' );
		if ( $gbp == 'hourly' ) {
			$curr_gbp   = wncu_get_option( 'wncu_gbp', 'currencies' );
			$sood_gbp   = wncu_get_option( 'wncu_gbp_sood', 'currencies' );
			$crate_gbp  = $this->wb_currency( $curr_gbp );
			$ragham_gbp = ceil( $crate_gbp * $havale_usd );
			$darsad_gbp = ceil( ( $sood_gbp / 100 ) * $ragham_gbp);
			$result_gbp = $ragham_gbp + $darsad_gbp;
			$this->wncu_crud( $curr_gbp , 'پوند انگلیس', $result_gbp );
		}		
		
		$aud = wncu_get_option( 'wncu_aud_time', 'currencies' );
		if ( $aud == 'hourly' ) {
			$curr_aud   = wncu_get_option( 'wncu_aud', 'currencies' );
			$sood_aud   = wncu_get_option( 'wncu_aud_sood', 'currencies' );
			$crate_aud  = $this->wb_currency( $curr_aud );
			$ragham_aud = ceil( $crate_aud * $havale_usd );
			$darsad_aud = ceil( ( $sood_aud / 100 ) * $ragham_aud);
			$result_aud = $ragham_aud + $darsad_aud;
			$this->wncu_crud( $curr_aud , 'دلار استرالیا', $result_aud );
		}		
		
		$cny = wncu_get_option( 'wncu_cny_time', 'currencies' );
		if ( $cny == 'hourly' ) {
			$curr_cny   = wncu_get_option( 'wncu_cny', 'currencies' );
			$sood_cny   = wncu_get_option( 'wncu_cny_sood', 'currencies' );
			$crate_cny  = $this->wb_currency( $curr_cny );
			$ragham_cny = ceil( $crate_cny * $havale_usd );
			$darsad_cny = ceil( ( $sood_cny / 100 ) * $ragham_cny);
			$result_cny = $ragham_cny + $darsad_cny;
			$this->wncu_crud( $curr_cny , 'یوان', $result_cny );
		}		
		
		$aed = wncu_get_option( 'wncu_aed_time', 'currencies' );
		if ( $aed == 'hourly' ) {
			$curr_aed   = wncu_get_option( 'wncu_aed', 'currencies' );
			$sood_aed   = wncu_get_option( 'wncu_aed_sood', 'currencies' );
			$crate_aed  = $this->wb_currency( $curr_aed );
			$ragham_aed = ceil( $crate_aed * $havale_usd );
			$darsad_aed = ceil( ( $sood_aed / 100 ) * $ragham_aed);
			$result_aed = $ragham_aed + $darsad_aed;
			$this->wncu_crud( $curr_aed , 'درهم امارات', $result_aed );
		}		
		
		$hkd = wncu_get_option( 'wncu_hkd_time', 'currencies' );
		if ( $hkd == 'hourly' ) {
			$curr_hkd   = wncu_get_option( 'wncu_hkd', 'currencies' );
			$sood_hkd   = wncu_get_option( 'wncu_hkd_sood', 'currencies' );
			$crate_hkd  = $this->wb_currency( $curr_hkd );
			$ragham_hkd = ceil( $crate_hkd * $havale_usd );
			$darsad_hkd = ceil( ( $sood_hkd / 100 ) * $ragham_hkd);
			$result_hkd = $ragham_hkd + $darsad_hkd;
			$this->wncu_crud( $curr_hkd , 'دلار هنگ کنگ', $result_hkd );
		}		
		
		$chf = wncu_get_option( 'wncu_chf_time', 'currencies' );
		if ( $chf == 'hourly' ) {
			$curr_chf   = wncu_get_option( 'wncu_chf', 'currencies' );
			$sood_chf   = wncu_get_option( 'wncu_chf_sood', 'currencies' );
			$crate_chf  = $this->wb_currency( $curr_chf );
			$ragham_chf = ceil( $crate_chf * $havale_usd );
			$darsad_chf = ceil( ( $sood_chf / 100 ) * $ragham_chf);
			$result_chf = $ragham_chf + $darsad_chf;
			$this->wncu_crud( $curr_chf , 'فرانک سوییس', $result_chf );
		}		
		
		$dkk = wncu_get_option( 'wncu_dkk_time', 'currencies' );
		if ( $dkk == 'hourly' ) {
			$curr_dkk   = wncu_get_option( 'wncu_dkk', 'currencies' );
			$sood_dkk   = wncu_get_option( 'wncu_dkk_sood', 'currencies' );
			$crate_dkk  = $this->wb_currency( $curr_dkk );
			$ragham_dkk = ceil( $crate_dkk * $havale_usd );
			$darsad_dkk = ceil( ( $sood_dkk / 100 ) * $ragham_dkk);
			$result_dkk = $ragham_dkk + $darsad_dkk;
			$this->wncu_crud( $curr_dkk , 'کرون دانمارک', $result_dkk );
		}

		$sek = wncu_get_option( 'wncu_sek_time', 'currencies' );		
		if ( $sek == 'hourly' ) {
			$curr_sek   = wncu_get_option( 'wncu_sek', 'currencies' );
			$sood_sek   = wncu_get_option( 'wncu_sek_sood', 'currencies' );
			$crate_sek  = $this->wb_currency( $curr_sek );
			$ragham_sek = ceil( $crate_sek * $havale_usd );
			$darsad_sek = ceil( ( $sood_sek / 100 ) * $ragham_sek);
			$result_sek = $ragham_sek + $darsad_sek;
			$this->wncu_crud( $curr_sek , 'کرون سوئد', $result_sek );
		}	

		$sgd = wncu_get_option( 'wncu_sgd_time', 'currencies' );		
		if ( $sgd == 'hourly' ) {
			$curr_sgd   = wncu_get_option( 'wncu_sgd', 'currencies' );
			$sood_sgd   = wncu_get_option( 'wncu_sgd_sood', 'currencies' );
			$crate_sgd  = $this->wb_currency( $curr_sgd );
			$ragham_sgd = ceil( $crate_sgd * $havale_usd );
			$darsad_sgd = ceil( ( $sood_sgd / 100 ) * $ragham_sgd);
			$result_sgd = $ragham_sgd + $darsad_sgd;
			$this->wncu_crud( $curr_sgd , 'دلار سنگاپور', $result_sgd );
		}

		$nzd = wncu_get_option( 'wncu_nzd_time', 'currencies' );			
		if ( $nzd == 'hourly' ) {
			$curr_nzd   = wncu_get_option( 'wncu_nzd', 'currencies' );
			$sood_nzd   = wncu_get_option( 'wncu_nzd_sood', 'currencies' );
			$crate_nzd  = $this->wb_currency( $curr_nzd );
			$ragham_nzd = ceil( $crate_nzd * $havale_usd );
			$darsad_nzd = ceil( ( $sood_nzd / 100 ) * $ragham_nzd);
			$result_nzd = $ragham_nzd + $darsad_nzd;
			$this->wncu_crud( $curr_nzd , 'دلار نیوزلند', $result_nzd );
		}	

		$zar = wncu_get_option( 'wncu_zar_time', 'currencies' );	
		if ( $zar == 'hourly' ) {
			$curr_zar   = wncu_get_option( 'wncu_zar', 'currencies' );
			$sood_zar   = wncu_get_option( 'wncu_zar_sood', 'currencies' );
			$crate_zar  = $this->wb_currency( $curr_zar );
			$ragham_zar = ceil( $crate_zar * $havale_usd );
			$darsad_zar = ceil( ( $sood_zar / 100 ) * $ragham_zar);
			$result_zar = $ragham_zar + $darsad_zar;
			$this->wncu_crud( $curr_zar , 'راند', $result_zar );
		}		

	}

	/**
	 * Fetch currency
	 */
	public function wb_currency( $curr ) {

		$username = wncu_get_option( 'wncu_user', 'general_tab');
		$password = wncu_get_option( 'wncu_pass', 'general_tab' );		

		$URL="https://xecdapi.xe.com/v1/convert_from.json/?from=$curr&to=USD&amount=1";

		$ch_verify = curl_init( $URL );
        curl_setopt($ch_verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch_verify, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_verify, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0');
        curl_setopt($ch_verify, CURLOPT_USERPWD, "$username:$password");

        $cinit_verify_data = curl_exec($ch_verify);
        curl_close($ch_verify);
        $converttoarray = json_decode( $cinit_verify_data, true  ); 

		$result = $this->wncu_found_value( 'mid', $converttoarray);

		return $result;
	}

	/**
	 * found value
	 */
	public function wncu_found_value($key, array $arr){
        if ( !isset( $arr ) || empty( $arr ) || is_null( $arr ) ) {
          return;
        }
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val){
            if($k == $key) array_push($val, $v);
        });
        return count($val) > 1 ? $val : array_pop($val);
    }

    public function wncu_crud( $abb , $curr , $rate ){

		global $wpdb;

		$namad = $abb;
		$arz = $curr;
		$nerkh = $rate;
		$results = $wpdb->get_results( "SELECT namad FROM {$wpdb->prefix}wncu ", ARRAY_A  );
		foreach ( $results as $key => $value) {
			if ( $namad == $value['namad'] ) {
				$flag = '1';
			}
		}

		if ( $flag == 1 ) {
			// $sql = "UPDATE {$wpdb->prefix}wncu SET nerkh.nerkh = $nerkh WHERE namad.namad = $namad";
			// $wpdb->query( $wpdb->prepare( $sql, $namad, $arz, $nerkh) );
			 $wpdb->update( $wpdb->prefix.'wncu',  array( 'nerkh' => $nerkh ),array( 'namad' => $namad ), array( '%s' )  ); 

		}else {
			$sql = "INSERT INTO {$wpdb->prefix}wncu ( namad,arz,nerkh ) VALUES ( %s,%s,%d )";

			$wpdb->query( $wpdb->prepare( $sql, $namad, $arz, $nerkh) );
		}

		// var_dump($results);
	}
	public function test(){
			$curr_cad   = wncu_get_option( 'wncu_cad', 'currencies' );
			$havale_cad = wncu_get_option( 'wncu_cad_havale', 'currencies' );
			$sood_cad   = wncu_get_option( 'wncu_cad_sood', 'currencies' );
			$crate_cad  = $this->wb_currency( $curr_cad );
			$result_cad = ceil( ($crate_cad * $havale_cad ) * ( $sood_cad / 100 ) ) ;
			$this->wncu_crud( $curr_cad , 'دلار کانادا', $result_cad );	
		$ragham = ceil ( $crate_cad * $havale_cad );
		$darsad = ceil( ($sood_cad / 100) * $ragham );
		
		?>
		<pre>
		<?php	print_r($ragham + $darsad); ?>
		</pre>
		<?php
	}
}


