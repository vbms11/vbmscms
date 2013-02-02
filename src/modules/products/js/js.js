
function validateProductsForm (id) {
    var ret = false;
    $('#'+id+' input').each(function (obj) { 
        //alert("Bitte gebe");
        if (trim($(obj).val()) == "")
            ret = true;
    });
    if (ret == false) {
        alert("Bitte geben sie einen Wert ein!");
    }
    return ret;
}

