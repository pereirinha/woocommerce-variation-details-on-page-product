jQuery(document).ready(function($) {
    if(typeof keys != 'undefined'){
        $('#'+eval(keys)).change(function () {
            var str = "";
            $('#'+eval(keys) + " option:selected").each(function () {
                count = 0;
                for (value in dimensionalValues) {
                    if (searchStringInArray(eval(keys[0]), $(this).text()) >= 0 && eval(dimensionalValues[value])[searchStringInArray(eval(keys[0]), $(this).text())] > 0 && value != 3){
                        str += eval(dimensionalValues[value])[searchStringInArray(eval(keys[0]), $(this).text())] + ' x ';
                    }
                    if (count == 2) {
                        str = str.substring(0, str.length-3);
                        if (str.length > 0) str += dimensionalUnit + '<br>';
                    }
                    if (searchStringInArray(eval(keys[0]), $(this).text()) >= 0 && eval(dimensionalValues[value])[searchStringInArray(eval(keys[0]), $(this).text())] > 0 && value == 3){
                        str += eval(dimensionalValues[value])[searchStringInArray(eval(keys[0]), $(this).text())] + weightUnit;
                    }
                    count ++;
                }
            });
    
            $(".product_details").remove();
            $(".product_meta").append("<div class='product_details'>"+str+"</div>");
        });
    }
    
    // Check selected
    function searchStringInArray (stringArray, searchString) {
        for (var i=0; i<stringArray.length; i++) {
            if (stringArray[i].valueOf()==(searchString).valueOf()){
                return i;
            }
        }
        return -1;
    }
});