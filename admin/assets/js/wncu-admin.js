(function(e){var t,n=e();e.fn.sortable=function(r){var i=String(r);r=e.extend({connectWith:false},r);return this.each(function(){if(/^enable|disable|destroy$/.test(i)){var s=e(this).children(e(this).data("items")).attr("draggable",i=="enable");if(i=="destroy"){s.add(this).removeData("connectWith items").off("dragstart.h5s dragend.h5s selectstart.h5s dragover.h5s dragenter.h5s drop.h5s")}return}var o,u,s=e(this).children(r.items);var a=e("<"+(/^ul|ol$/i.test(this.tagName)?"li":"div")+' class="sortable-placeholder">');s.find(r.handle).mousedown(function(){o=true}).mouseup(function(){o=false});e(this).data("items",r.items);n=n.add(a);if(r.connectWith){e(r.connectWith).add(this).data("connectWith",r.connectWith)}s.attr("draggable","true").on("dragstart.h5s",function(n){if(r.handle&&!o){return false}o=false;var i=n.originalEvent.dataTransfer;i.effectAllowed="move";i.setData("Text","dummy");u=(t=e(this)).addClass("sortable-dragging").index()}).on("dragend.h5s",function(){if(!t){return}t.removeClass("sortable-dragging").show();n.detach();if(u!=t.index()){t.parent().trigger("sortupdate",{item:t})}t=null}).not("a[href], img").on("selectstart.h5s",function(){this.dragDrop&&this.dragDrop();return false}).end().add([this,a]).on("dragover.h5s dragenter.h5s drop.h5s",function(i){if(!s.is(t)&&r.connectWith!==e(t).parent().data("connectWith")){return true}if(i.type=="drop"){i.stopPropagation();n.filter(":visible").after(t);t.trigger("dragend.h5s");return false}i.preventDefault();i.originalEvent.dataTransfer.dropEffect="move";if(s.is(this)){if(r.forcePlaceholderSize){a.height(t.outerHeight())}t.hide();e(this)[a.index()<e(this).index()?"after":"before"](a);n.not(a).detach()}else if(!n.is(this)&&!e(this).children(r.items).length){n.detach();e(this).append(a)}return false})})}})(jQuery);
(function( $ ) {
	'use strict';

	$(document).ready(function($) {
		// add from
		$('.wncuaddfrombtn').on( 'click', function(e) {
			e.preventDefault();
			var $value = $( '#wncuaddfrom' ).val();
			$( '#wncufromfield' ).append('<span class="wncuremove"><li value="'+$value+'">'+$value+'</li> X</span>');
			remove();
		});
		// add to
		$('.wncutofrombtn').on( 'click', function(e) {
			e.preventDefault();
			var $value = $( '#wncutofrom' ).val();
			$( '#wncutofield' ).append('<span class="wncuremove"><li value="'+$value+'">'+$value+'</li> X</span>');
			remove();
		});
		// remove function 
		function remove() { 
			// remove from
			$('.wncuremove').on( 'click', function() {

				$(this).remove();

			});
		}
		// sortable
		$('#wncufromfield').sortable();
		$('#wncutofield').sortable();

		// remove on dom ready 
		$('.wncuremove').on( 'click', function() {

			$(this).remove();

		});			

		// remove on dom ready 
		$('.wncu-remove').on( 'click', function() {

			$(this).closest('tr').remove();

		});

		// update nwo ajax

		$(".wncu-update-curr").on('click', function() {
			// Add loading Class to the button
			$('.wncu-succ').fadeIn('slow');

		    $.ajax( {
		        type: "POST",
		        url: wncu.adminajax,
		        data: {
		        	action : 'wncuupdate',
		        	},
		        success: function(data) {
		            // Remove the loading Class to the button
		            $('.wncu-succ').fadeOut('slow');
		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		            // Remove the loading Class to the button
		            $('.wncu-succ').fadeOut('slow');
		            alert('ارتباط با سرور قطع شد دوباره تلاش نمایید.')
		            
		        }
		    });
		});

	});

})( jQuery );


(function($) {
	$.fn.repeatable_fields = function(custom_settings) {
		var default_settings = {
			wrapper: '.wncu-wrapper',
			container: '.wncu-container',
			row: '.wncu-row',
			add: '.wncu-add',
			remove: '.wncu-remove',
			move: '.wncu-move',
			template: '.wncu-template',
			is_sortable: true,
			before_add: null,
			after_add: after_add,
			before_remove: null,
			after_remove: null,
			sortable_options: null,
			row_count_placeholder: '{{row-count-placeholder}}',
		}

		var settings = $.extend({}, default_settings, custom_settings);

		// Initialize all repeatable field wrappers
		initialize(this);

		function initialize(parent) {
			$(settings.wrapper, parent).each(function(index, element) {
				var wrapper = this;

				var container = $(wrapper).children(settings.container);

				// Disable all form elements inside the row template
				$(container).children(settings.template).hide().find(':input').each(function() {
					$(this).prop('disabled', true);
				});

				var row_count = $(container).children(settings.row).filter(function() {
					return !$(this).hasClass(settings.template.replace('.', ''));
				}).length;

				$(container).attr('data-rf-row-count', row_count);

				$(wrapper).on('click', settings.add, function(event) {
					event.stopImmediatePropagation();

					var row_template = $($(container).children(settings.template).clone().removeClass(settings.template.replace('.', ''))[0].outerHTML);

					// Enable all form elements inside the row template
					$(row_template).find(':input').each(function() {
						$(this).prop('disabled', false);
					});

					if(typeof settings.before_add === 'function') {
						settings.before_add(container);
					}

					var new_row = $(row_template).show().appendTo(container);

					if(typeof settings.after_add === 'function') {
						settings.after_add(container, new_row, after_add);
					}

					// The new row might have it's own repeatable field wrappers so initialize them too
					initialize(new_row);
				});

				$(wrapper).on('click', settings.remove, function(event) {
					event.stopImmediatePropagation();

					var row = $(this).parents(settings.row).first();

					if(typeof settings.before_remove === 'function') {
						settings.before_remove(container, row);
					}

					row.remove();

					if(typeof settings.after_remove === 'function') {
						settings.after_remove(container);
					}
				});

				if(settings.is_sortable === true && typeof $.ui !== 'undefined' && typeof $.ui.sortable !== 'undefined') {
					var sortable_options = settings.sortable_options !== null ? settings.sortable_options : {};

					sortable_options.handle = settings.move;

					$(wrapper).find(settings.container).sortable(sortable_options);
				}
			});
		}

		function after_add(container, new_row) {
			var row_count = $(container).attr('data-rf-row-count');

			row_count++;

			$('*', new_row).each(function() {
				$.each(this.attributes, function(index, element) {
					this.value = this.value.replace(settings.row_count_placeholder, row_count - 1);
				});
			});

			$(container).attr('data-rf-row-count', row_count);
		}
	}
})(jQuery);
