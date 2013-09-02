jQuery(document).ready(function($) {

	if(typeof Variations.siblings != "undefined"){
		var siblings  		= Variations.siblings.replace(/&quot;/g, '"');
		var variations		= jQuery.parseJSON(siblings);
		var attributes		= new Array();
		if (Variations.att_data_sel.charAt(0) == '.') {
			var type_data_selector = 'class';
		} else if (Variations.att_data_sel.charAt(0) == '#') {
			var type_data_selector = 'id';
		} else {
			console.log('Misconfiguration on Data Selector. Please, verify first char.');
		}
		var data_selector = Variations.att_data_sel.substring(1);
		$(Variations.att_dom_sel).on("change", function(e){

		    if ( ! ($(this).val()) ) return '';
			
			attributes[$(this).attr('name')] = $(this).val();
			
			if (variations != ''){
				// Count number of variations
				var no_variations = 0;
				var no_attributes = 0;
				for ( variation in variations[0]['variation_data'] ) {
					if(variations[0]['variation_data'].hasOwnProperty(variation)) {
						no_variations++;
					}
				}

				for ( atribute in attributes ) {
					if(attributes.hasOwnProperty(atribute)) {
						no_attributes++;
					}
				}

				if (no_variations == no_attributes && no_variations > 0 ){
					var keys = [];
					for (var i=0; i < variations.length; i++) {
						keys[i] = i;
					}
					searchVariation(variations, keys, attributes);
					var variation_details = variations[keys];

					if (variation_details) {
						var product_details = '';
						if (variation_details.width) product_details += variation_details.width + 'x';
						if (variation_details.height) product_details += variation_details.height + 'x';
						if (variation_details.length) {
							product_details += variation_details.length;
						} else {
							product_details = product_details.slice(0, -1);
						}
						if (product_details) product_details += Variations.att_dim_unit;
						if (product_details && variation_details.weight) product_details += '<br>';
						if (variation_details.weight) product_details += variation_details.weight + Variations.att_wei_unit;

						// Cleanup data
						$(Variations.att_data_sel).remove();
						$(Variations.att_data_hook).append("<div "+type_data_selector+"='"+data_selector+"'>"+product_details+"</div>");

						// Cleanup data	
						variation_id = $("select")[0].selectedIndex-1;
						if (variation_id == -1) $(Variations.att_data_sel).remove();
					}
				}
			}
		});

		// Cleanup data
		$(".reset_variations").on("click", function(e){
			attributes = new Array();
			$(Variations.att_data_sel).remove();
		});
	}

	function searchVariation(objects, key_values, attributes){
		if (typeof(attributes) == 'undefined') attributes = new Array();
		for (atribute in attributes) {
			many_keys = key_values.length;
			for (var i = 0; i < many_keys; i++){
				key = i;
				if (objects[key]['variation_data'][atribute] != attributes[atribute]) key_values.splice(key_values.indexOf(key), 1);
			}
			if (key_values.length == 1)	return key_values;
		};

		searchVariation(objects, key_values, attributes);
	}
});