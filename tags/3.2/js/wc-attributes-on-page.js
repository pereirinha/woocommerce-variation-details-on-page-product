if ( 'object' !== typeof console ) {
	var console = { log: function(){} };
}

(function($){
	'use strict';

	var toogleData = function toogleDataF( e ){
		var attribute = e.target.name;

		switch( selectorType ) {
			case 'SELECT':
				selectedVal = $selector.find( 'option:selected' ).val();
				break;
			case 'INPUT':
				selectedVal = $selector.closest( ':checked' ).val();
				break;
		}

		var result = variations.filter( function( obj ) {
			return selectedVal === obj[attribute];
		});

		if ( result.length > 0 ) {
			var product_details = result[0].dimensions + '<br>' + result[0].weight;
			$(placeholder).remove();
			$hook.append('<div '+type_data_selector+'="'+data_selector+'">'+product_details+'</div>');
		} else {
			$(placeholder).remove();
		}
	};

	var variationsRaw = window.mp_wc_variations;

	if ( typeof variationsRaw !== 'undefined' ) {
		var $selector     = $( variationsRaw.att_dom_sel ),
			$hook         = $( variationsRaw.att_data_hook ),
			selectorType  = $selector[0].tagName,
			variations    = variationsRaw.variations.replace(/&quot;/g, '"'),
			placeholder   = variationsRaw.att_data_sel,
			type_data_selector,
			selectedVal;

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