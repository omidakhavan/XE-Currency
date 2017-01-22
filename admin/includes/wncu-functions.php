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
	$from =  get_option( 'wncucalc_from' );
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

	            <td width="10%">کمتر از</td>
				
	            <td width="30%">
	                <input type="text" class="wncu-karmozd-input" name="an-input-field[{{row-count-placeholder}}]" />
	            </td>	            

	            <td width="10%">واجد کارمزد</td>

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

	            <td width="10%">کمتر از</td>
				
	            <td width="30%">
	                <input type="text" class="wncu-karmozd-input" name="an-input-field[{{row-count-placeholder}}]" value="<?php echo $from['karmozd'][$i++]; ?>"  />
	            </td>	            

	            <td width="10%">واحد کارمزد</td>

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
 * Get data from account page
 */
add_action( 'wp_ajax_wncucalc', 'wncu_save_calc' );
function wncu_save_calc() {
	// Save final options
	update_option( 'wncucalc_from', $_REQUEST );
}

/**
 * 	Update button
 */
add_action( 'wsa_form_bottom_general_tab', 'wncu_general_form' );
function wncu_general_form() {
 echo '
 		<div class="wncu-update-container">
 			<a href="#" class="wncu-update-curr">بروزرسانی فوری تابلو</a>
 			<p> اگر میخواهید تابلو ارز همین حالا با تنظیمات جدید بروزرسانی شود این دکمه را بفشارید در غیر اینصورت تابلو طبق برنامه بروز خواهد شد. </p> 
 		</div>
 		<div class="wncu-succ"></div>';
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


/**
 * Inline ajax for saving calculate pages
 */
add_action( 'in_admin_footer', 'ajax_wncu_account' );
function ajax_wncu_account() {
	$ajaxurl = admin_url( 'admin-ajax.php' );
	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
						
			jQuery(".wncu_save_option").on('click', function(e)
			{
			e.preventDefault();

		// Add loading Class to the button	
				var page = jQuery("#wncu_select_page").val();
			    jQuery.ajax(
			    {
			        type: "POST",
			        url: "<?php echo $ajaxurl; ?>",
			        data: {
			        	action : 'wncu_account',
			        	page : page
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

/**
 * Add custom code to setting page account
 */
add_action( 'wsa_form_bottom_accounts', 'wncu_account_form' );
function wncu_account_form() {

	$list = new Wp_Query( array( 'post_type' => 'page' ) );
	$selected = get_option( 'wncu_account');

	if ( $list->have_posts() ) {
		echo '<select id="wncu_select_page">';
		while ( $list->have_posts() ) {
			$list->the_post();
			if ($selected['page'] == get_the_title()) {
				echo '<option value="' . get_the_id() . '" selected>' . get_the_title() . '</option>';
			}else{
				echo '<option value="' . get_the_id() . '" >' . get_the_title() . '</option>';
			}
		}
		echo '</select>';
	}

	echo '<div><a style="margin-top: 50px;" href="#" class="wncu_save_option button button-primary" />ذخیره ی تغیرات</a></div>';
}


/**
 * Get data from calculation page
 */
add_action( 'wp_ajax_wncu_account', 'wncu_save_wncu_account' );
function wncu_save_wncu_account() {
	// Save final options
	update_option( 'wncu_account', $_REQUEST );
}

//add_action( 'wp_head', 'wncu_account_restriction' );
function wncu_account_restriction() {

	$selected = get_option( 'wncu_account');
	if ( !is_user_logged_in() ) {
		if ( get_the_ID() == $selected['page'] ) {
			wp_redirect( wp_login_url() );
		}
	}

}