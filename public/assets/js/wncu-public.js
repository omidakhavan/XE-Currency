// start ajax add product wishlist

(function( $ ) {
	'use strict';
	$(document).ready(function($) {
		$( '.wncu-calculationfield').on('click', function(event) {
			event.preventDefault();
			$(this).attr('clicked', 'yes');

			$('.wncu-calculationresult').text('در حال محاسبه ...');
			
			// get product id 
			var from  =  $('#wncuaddfrom').val();
			var to    =  $('#wncutofrom').val();
			var type  =  $('#wncutype').val();
			var amont =  findAndReplace( $('#wncu-calculationfield').val(), ',' , '' );

			$.ajax( {
				type: 'POST',
				url: adminurl.wncu, //get ajax url from loclized script
				data: {
					'action' : 'calculation_action', // wp ajax function action
					'from'	 : from,
					'to'	 : to,
					'type'	 : type,
					'amont'	 : amont

				},
				success: function(data) {
					setTimeout(function() {
						console.log(data);
						$('.wncu-calculationresult').text(data);
						$('.wncu-calculationresult').addClass('wncu-calc-result-feild');

					}, 500);
				}
			});
		});

		// validate calculation from 
		if ( $('#wncuaddfrom').val() == 'RIAL' ) { 
			$('#wncutofrom option').each(function() {
				if ( $(this).val() == 'RIAL') { $(this).remove(); }
			});
		}
		var el = [];
		var arr;
		$('#wncuaddfrom').change(function() {
			var $this = $(this);
			if ( $this.val() == 'RIAL' ) { 
				$('#wncutofrom').find('option[value="RIAL"]').remove();
				for ( arr in el ){
					console.log(arr);
					$('#wncutofrom').prepend(el[arr]); 
					
				}
			}
			if ( $this.val() != 'RIAL' ) {
				var flag = '';
				$('#wncutofrom option').each(function() {
					if ( $(this).val() == 'RIAL') { flag = 1 ; }
				});
				if ( flag != 1 ) {$('#wncutofrom').prepend('<option value="RIAL">تومان</option>');}
				$('#wncutofrom option').each(function() {
					$this = $(this);
					if ( $this.val() != 'RIAL') {  el.push( $this.detach() ); }
				});
			}
		});


		$('#wncu-calculationfield').keypress(function(event){

			if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
				event.preventDefault(); 
			}
		});

		$('#wncu-calculationfield').keyup(function(event) {

		// skip for arrow keys
		if(event.which >= 37 && event.which <= 40) return;

			// format number
			$(this).val(function(index, value) {
				return value
				.replace(/\D/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
				;
			});
		});


	});

})( jQuery );

function findAndReplace(string, target, replacement) {

	var i = 0, length = string.length;

	for (i; i < length; i++) {
		string = string.replace(target, replacement);
	}
	
	return string;
}

