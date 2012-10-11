jQuery(document).ready(function($) {    
    $('#'+eval(keys)).change(function () {
        var str = "";
        var weight = "";
        $('#'+eval(keys) + " option:selected").each(function () {
            for (value in dimensionalValues) {
                if (searchStringInArray(eval(keys[0]), $(this).text()) >= 0 && eval(dimensionalValues[value])[searchStringInArray(eval(keys[0]), $(this).text())] > 0 ){
                    str += eval(dimensionalValues[value])[searchStringInArray(eval(keys[0]), $(this).text())] + ' x ';
                    weight = eval(weightValues)[searchStringInArray(eval(keys[0]), $(this).text())];
                }
            }
            
            if (str.length > 0) {
                str = str.substring(0, str.length-3);
                str += dimensionalUnit;
            }
            
            if (weight.length > 0) {
                str += '<br>'+weight+weightUnit;
            }
        });

        $(".product_details").remove();
        $(".product_meta").append("<div class='product_details'>"+str+"</div>");
    });
    
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