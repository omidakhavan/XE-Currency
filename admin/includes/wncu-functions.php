<?php

/**
 * @link              http://Webnus.net
 * @since             1.0.0
 * @package           webnus currencies
 */ 


/**
 * [wncu_get_option get webnus options]
 */
function wncu_get_option( $option, $section, $default = '' ) {
	if ( empty( $option ) )
		return;
    $options = get_option( $section );
    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }
    return $default;
}

add_action( 'wsa_form_top_calculation', 'wncu_calculation_form' );
/**
 * Add custom code to setting page calculation
 */
function wncu_calculation_form() {

	global $wpdb;
	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wncu", ARRAY_A  );
	$from = !empty( get_option( 'wncucalc_from' ) ) ? get_option( 'wncucalc_from' ) :'';
	?>
<!-- 	<script>
	(function( $ ) {
	'use strict';

		jQuery(document).ready(function($) {
		    jQuery('#mec_add_ticket_button').on('click', function()
		    {
		    	console.log('h');
		        var key = jQuery('#mec_new_ticket_key').val();
		        var html = jQuery('#mec_new_ticket_raw').html().replace(/:i:/g, key);
		        
		        jQuery('#mec_tickets').append(html);
		        jQuery('#mec_new_ticket_key').val(parseInt(key)+1);
		    });
		});
		    function mec_ticket_remove(i) {
			    jQuery("#mec_ticket_row"+i).remove();
			}

	</script> -->
	<!-- From -->
		<div class="wncu-calccontainer">
			<a href="#" class="wncuaddfrombtn">"از"</a>
			<select name="wncuaddfrom" id="wncuaddfrom">
			<option value="RLS">ریال</option>
			<?php foreach ( $results as $key => $value ) : ?>
				<option value="<?php echo $value['namad']; ?>"><?php echo $value['arz']; ?></option>
			<?php endforeach; ?>		
			</select>
			<div class="wncu-ul-container">
				<ul class="wncufromfield" name="wncufromfield" id="wncufromfield">
					<?php 
					if ( isset( $from['from'] ) ) :
					foreach ( $from['from'] as $key => $value) : ?>
						<span class="wncuremove"> <li value="<?php echo $value; ?>" ><?php echo $value; ?></li> X</span>
					<?php endforeach; endif; ?>	
				</ul>
			</div>
		</div>

	<!-- To -->
		<div class="wncu-calccontainer">
			<a href="#" class="wncutofrombtn">"به"</a>
			<select name="wncutofrom" id="wncutofrom">
			<option value="RLS">ریال</option>
			<?php foreach ( $results as $key => $value ) : ?>
				<option value="<?php echo $value['namad']; ?>"><?php echo $value['arz']; ?></option>
			<?php endforeach; ?>		
			</select>
			<div class="wncu-ul-container">
				<ul class="wncutofield" name="wncutofield" id="wncutofield">
					<?php if ( isset( $from['to'] ) ) :  
					foreach ( $from['to'] as $key0 => $value0 ) : ?>
						<span class="wncuremove"> <li value="<?php echo $value0; ?>" ><?php echo $value0; ?></li> X</span>
					<?php endforeach; endif; ?>	
				</ul>
			</div>
		</div>		

<!-- 		<div class="wncu-calccontainer">
			<a href="#" class="wncutypebtn">"کارمزد"</a>
			<input class="wncu-type-havale" name="wncu-type-havale" type="text">
			<div class="wncu-ul-container">
				<ul class="wncutypefield" name="wncutypefield" id="wncutypefield">
					<?php// if ( isset( $from['type'] ) ):  
					//foreach ( $from['type'] as $key0 => $value0 ) : ?>
						<!-- <span class="wncuremove"> <li value="<?php echo $value0; ?>" ><?php echo $value0; ?></li> X</span> -->
					<?php //endforeach; endif; ?>	
<!-- 				</ul>
			</div>
		</div>
  -->
		

		<div class="wncu-repeat">
	    <table class="wncu-wrapper" width="100%">
	        <thead>
	            <tr>
	                <td style="padding-top:20px; padding-bottom: 20px;" ><span class="wncu-add wncutypebtn">کارمزد</span></td>
	            </tr>
	        </thead>
	        <tbody class="wncu-container">
	        <tr class="wncu-karmozd wncu-template wncu-row">
	            <td width="10%"><span class="wncu-move">مرتب کردن</span></td>

	            <td width="10%">درخواست کمتر از</td>
				
	            <td width="30%">
	                <input type="text" class="wncu-karmozd-input" name="an-input-field[{{row-count-placeholder}}]" />
	            </td>	            

	            <td width="10%">نرخ درصد کارمزد</td>

	            <td width="300%">
	                <input type="text" class="wncu-karmozd-input" name="an-input-field[{{row-count-placeholder}}]" />
	            </td>

	            <td width="10%"><span class="wncu-remove">حذف</span></td>
	        </tr>
	        </tbody>
	    </table>
	</div>

	<div class="wncu-repeat">
	   	<table class="wncu-wrapper" width="100%">
	        <thead>
	            <tr>
	            </tr>
	        </thead>
	        <tbody class="wncu-container">
	            <?php
	            $from['karmozd'] = array_diff( $from['karmozd'] , array( '' ) ); 
	            $from['karmozd'] = array_values( $from['karmozd'] );
	            $count = count( $from['karmozd'] );
	            for ( $i=0; $i < $count ; $i++) : ?>
	        <tr class="wncu-karmozd">
	            <td width="10%"><span class="wncu-move">مرتب کردن</span></td>

	            <td width="10%">درخواست کمتر از</td>
				
	            <td width="30%">
	                <input type="text" class="wncu-karmozd-input" name="an-input-field[{{row-count-placeholder}}]" value="<?php echo $from['karmozd'][$i++]; ?>"  />
	            </td>	            

	            <td width="10%">نرخ درصد کارمزد</td>

	            <td width="300%">
	                <input class="wncu-karmozd-input" type="text" name="an-input-field[{{row-count-placeholder}}]" value="<?php echo $from['karmozd'][$i]; ?>" />
	            </td>

	            <td width="10%"><span class="wncu-remove">حذف</span></td>
	        </tr>
	            <?php endfor;?>    
	        </tbody>
	    </table>
	</div>
        <?php
}

/**
 * Get data from calculation page
 */
add_action( 'wp_ajax_wncucalc', 'wncu_save_calc' );
function wncu_save_calc() {
	// Check
	check_ajax_referer( 'ajax_wncucalc_nounce', 'security', false );

    // Save final options
    update_option( 'wncucalc_from', $_REQUEST );
}
	
/**
 * Inline ajax for saving window
 */
add_action( 'in_admin_footer', 'ajax_activate_js' );
function ajax_activate_js() {
	$ajaxurl = admin_url( 'admin-ajax.php' );
	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery(function() {
			    jQuery('.wncu-repeat').each(function() {
			        jQuery(this).repeatable_fields();
			    });
			});
						
			jQuery("#calculation .button").on('click', function()
			{
				// Add loading Class to the button	
				var from = jQuery("#wncufromfield li").map(function() { return jQuery(this).text() }).get();

				var to = jQuery("#wncutofield li").map(function() { return jQuery(this).text() }).get();

				var karmozd = jQuery(".wncu-karmozd-input").map(function() { return jQuery(this).val() }).get();

			    jQuery.ajax(
			    {
			        type: "POST",
			        url: "<?php echo $ajaxurl; ?>",
			        data: {
			        	action : 'wncucalc',
			        	from : from,
			        	to : to,
			        	karmozd : karmozd

			        	 },
			        success: function(data)
			        {
			            // Remove the loading Class to the button
			            setTimeout(function(){

			            }, 1000);
			            location.reload( true );
			        },
			        error: function(jqXHR, textStatus, errorThrown)
			        {
			            // Remove the loading Class to the button
			            setTimeout(function(){
			            }, 1000);
			        }
			    });
			});
		});	
	</script>
<?php
}
