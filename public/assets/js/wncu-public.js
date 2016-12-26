// start ajax add product wishlist
(function( $ ) {
	'use strict';
	$(document).ready(function($) {
		$( '.wncu-calculationfield').on('click', function(event) {
			event.preventDefault();

			$('.wncu-calculationresult').text('در حال محاسبه ...');
			
			console.log('ssss');
			// get product id 
			var from  =  $('#wncuaddfrom').val();
			var to    =  $('#wncutofrom').val();
			var type  =  $('#wncutype').val();
			var amont =  $('#wncu-calculationfield').val();

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

					}, 500);
				}
			});
		});
	});
})( jQuery );	