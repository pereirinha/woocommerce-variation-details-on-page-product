if ( 'object' !== typeof console ) {
	var console = { log: function(){} };
}

(function($){
	'use strict';

	var prop,
		filterData = function filterDataF( obj ) {
			return selectedVal[prop] === obj[prop];
		},
		toogleData = function toogleDataF( e ){
			var attribute = e.target.name;

			if ( 'variation_id' === attribute ) {
				return;
			}

			if( -1 === $.inArray( attribute, attributes ) ) {
				attributes.push( attribute );
			}

			$.each( $selector, function() {
				var $this = $(this),
					thisAttribute = 'attribute_' + $this.attr('id'),
					value;

				switch( selectorType ) {
					case 'SELECT':
						 value = $this.find( 'option:selected' ).val();
						if( '' !== value ) {
							selectedVal[thisAttribute] = value;
						} else {
							delete selectedVal[thisAttribute];
						}
						break;

					case 'INPUT':
						value = $this.closest( ':checked' ).val();
						if( undefined !== value ) {
							selectedVal[thisAttribute] = value;
						}
						break;
				}
			});

			// Wait until all selection are made
			if ( Object.keys(selectedVal).length !== numSelectors ) {
				$(placeholder).remove();
				return;
			}

			var result = variations;

			for ( prop in selectedVal ) {
				if ( selectedVal. hasOwnProperty( prop ) ) {
					result = result.filter( filterData );
				}
			}

			if ( result.length > 0 ) {
				var product_details = result[0].dimensions + '<br>' + result[0].weight;
				$(placeholder).remove();
				$hook.append('<div '+type_data_selector+'="'+data_selector+'">'+product_details+'</div>');
			}
		};

	var variationsRaw = window.mp_wc_variations;

	if ( typeof variationsRaw !== 'undefined' ) {
		var $selector     = $( variationsRaw.att_dom_sel ),
			$hook         = $( variationsRaw.att_data_hook ),
			selectorType  = $selector[0].tagName,
			variations    = variationsRaw.variations.replace(/&quot;/g, '"'),
			placeholder   = variationsRaw.att_data_sel,
			numSelectors  = +variationsRaw.num_variations, // Cast integer
			selectedVal   = {},
			attributes    = [],
			type_data_selector;

		/*
		 * Control existence of DOM objects
		 */
		if ( -1 === [ 'SELECT', 'INPUT' ].indexOf( selectorType ) ) {
			console.log( 'This plugin is intended to work only with dropdown lists and radio buttons as variations selectors.' );
			return false;
		}

		if ( 0 === $selector.length ) {
			console.log( 'It seems that we can\'t find the DOM object were actions are hooked.' );
			return false;
		}
		if ( 0 === $hook.length ) {
			console.log( 'It seems that we can\'t find the DOM object were data will be hooked.' );
			return false;
		}

		variations = jQuery.parseJSON( variations );

		if ( '.' === placeholder.charAt(0) ) {
			type_data_selector = 'class';
		} else if ( '#' === placeholder.charAt(0) ) {
			type_data_selector = 'id';
		} else {
			console.log( 'Misconfiguration on Data Selector. Please, verify first char.' );
			return false;
		}

		var data_selector = placeholder.substring(1);

		if( $( '.mp_wc_vdopp_variations' ).length > 0 ) {
			$hook = $( '.mp_wc_vdopp_variations' );
		}

		$(document).on( 'change select', $selector, toogleData );
	}
}(jQuery));