
$(function () {
	textPlaceholder
	$("textarea").each(function(index,object)){
		$(object).focus(function(){
			if ($(object).val() == textPlaceholder) {
				$(object).val("");
			}
		}).blur(function(){
			if ($(object).val().trim().length == 0) {
				$(object).val(textPlaceholder);
			}
		});
	}
	
})

