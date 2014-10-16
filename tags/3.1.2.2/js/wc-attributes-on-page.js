if( ! window.console ){
	var console = { log: function(){} };
}

jQuery(document).ready(function($) {

	var variationsRaw = window.Variations,
		$selector = $(variationsRaw.att_dom_sel),
		$hook = $(variationsRaw.att_data_hook),
		type_data_selector,
		selectedSelectors,
		error = false;

	/*
	 * Control existence of DOM objects
	 */
	if( 0 === $selector.length ){
		console.log('It seems that we can\'t find the DOM object were actions are hooked.');
		error = true;
	}
	if( 0 === $hook.length ){
		console.log('It seems that we can\'t find the DOM object were data will be hooked.');
		error = true;
	}

	function toogleData(){
		var selection = {},
			result = null;
		$.each( $selector, function() {
			var $this = $(this);
			selection[ $this.attr( 'name' ) ] = $this.val();
		});

		selectedSelectors = 0;
		$.each( $selector, function(){
			if( $(this).val().length > 0 ) {
				selectedSelectors++;
			}
		});

		if ( selectedSelectors === numVariations ){
			for( var i in variations ) {
				var variables = variations[i].variables;

				for( var variable in variables ) {
					var value = variables[variable];
					if ( value.length > 0 ) {
						if( selection[variable] === value ) {
							result = i;
						} else {
							result = null;
							break;
						}
					}
				}
				if( result ){
					break;
				}
			}

			var product_details = variations[ result ].dimensions + '<br>' + variations[ result ].weight;
			$(placeholder).remove();
			$hook.append('<div '+type_data_selector+'="'+data_selector+'">'+product_details+'</div>');

		} else {
			$(placeholder).remove();
		}
	}

	if(typeof variationsRaw.variations !== 'undefined'){
		var variations = variationsRaw.variations.replace(/&quot;/g, '"'),
			placeholder = variationsRaw.att_data_sel,
			numVariations =+ variationsRaw.num_variations;

		variations = jQuery.parseJSON(variations);

		if (placeholder.charAt(0) === '.') {
			type_data_selector = 'class';
		} else if (placeholder.charAt(0) === '#') {
			type_data_selector = 'id';
		} else {
			console.log('Misconfiguration on Data Selector. Please, verify first char.');
			error = true;
		}

		if( error ){
			return;
		}

		var data_selector = placeholder.substring(1);

		if( $( '.mp_wc_vdopp_variations' ).length > 0 ) {
			$hook = $( '.mp_wc_vdopp_variations' );
		}

		toogleData();

		$selector.on('change', function(){
			toogleData();
		});

		// Cleanup data
		$('.reset_variations').on('click', function(){
			$(placeholder).remove();
		});
	}
});