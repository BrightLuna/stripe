
jQuery(function($) {
	//Disable Enter key
	$("input"). keydown(function(e) {
		if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
			return false;
		}else{
			return true;
		}
	})

	//Amount Validation
	$("#crwsjp_data_amount").each(function(){
		$(this).bind('keydown keyup keypress change', hoge(this))
	})
		function hoge(elm){
		var v, old = elm.value
		return function(){
			if(old != (v=elm.value)){
				old = v
				str = $(this).val()
				if(str.match(/^([1-9]\d*|0)$/)){
					$("#amount-validation").addClass("validation_set");
					$("#amount-validation").removeClass("crwsjp-text-error");
					$("#crwsjp_data_amount").removeClass("crwsjp-form-error");
				}else{
					$("#amount-validation").removeClass("validation_set");
					$("#amount-validation").addClass("crwsjp-text-error");
					$("#crwsjp_data_amount").addClass("crwsjp-form-error");
				}
			}
		}
	}

	//Tax Validation
	$("#crwsjp_data_taxrate").each(function(){
		$(this).bind('keydown keyup keypress change', hoge2(this))
	})
		function hoge2(elm){
		var v, old = elm.value
		return function(){
			if(old != (v=elm.value)){
				old = v
				str = $(this).val()
				if(str.match(/^([1-9]\d*|1)$/)){
					$("#tax-validation").addClass("validation_set");
					$("#tax-validation").removeClass("crwsjp-text-error");
					$("#crwsjp_data_taxrate").removeClass("crwsjp-form-error");
				}else{
					$("#tax-validation").removeClass("validation_set");
					$("#tax-validation").addClass("crwsjp-text-error");
					$("#crwsjp_data_taxrate").addClass("crwsjp-form-error");
				}
			}
		}
	}

	//Stock Validation
	$("#crwsjp_data_stocknumber").each(function(){
		$(this).bind('keydown keyup keypress change', hoge3(this))
	})
		function hoge3(elm){
		var v, old = elm.value
		return function(){
			if(old != (v=elm.value)){
				old = v
				str = $(this).val()
				if(str.match(/^([0-9]\d*|0)$/)){
					$("#stock-validation").addClass("validation_set");
					$("#stock-validation").removeClass("crwsjp-text-error");
					$("#crwsjp_data_stocknumber").removeClass("crwsjp-form-error");
				}else{
					$("#stock-validation").removeClass("validation_set");
					$("#stock-validation").addClass("crwsjp-text-error");
					$("#crwsjp_data_stocknumber").addClass("crwsjp-form-error");
				}
			}
		}
	}

	//Description Count
	var inputCountMax = 16;
	$('#crwsjp_data_description').bind('keydown keyup keypress change',function(){
	var thisValueLength = $(this).val().length;
	var countDown = (inputCountMax)-(thisValueLength);
	$("#description-validation").text(countDown)
	if(countDown < 0){
		$('#description-validation').css({color:'#E30101'});
		$('#crwsjp_data_description').addClass("crwsjp-form-error");
	} else {
		$('#description-validation').css({color:'#000000'});
		$('#crwsjp_data_description').removeClass("crwsjp-form-error");
	}
	})
	$("#description-validation").text(inputCountMax)

})