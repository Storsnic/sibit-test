$("#investform-mult").click(function(e){
	e.stopPropagation();
	$(".mult-slider").show();
});

$("body").click(function(){
	$(".mult-slider").hide();
});


/* Slider */

$(".settingsRange").on("input", function(){
	$("#investform-mult").val($(this).val());
	var factInv = parseInt($("#investform-suminv").val()) * parseInt($("#investform-mult").val());
	$(".factInv").text('= $ ' + factInv);
});

$("#investform-mult").change(function(){
	var mult = parseInt($("#investform-mult").val());
	var factInv = parseInt($("#investform-suminv").val()) * mult;
	$(".factInv").text('= $ ' + factInv);
	$(".settingsRange").val(mult);
});
$("#investform-suminv").change(function(){
	var mult = parseInt($("#investform-mult").val());
	var factInv = parseInt($("#investform-suminv").val()) * mult;
	$(".factInv").text('= $ ' + factInv);
	$(".settingsRange").val(mult);
});


/* Bottom block */

$(".bottom-title").click(function(e){
	if ( $('.bottom-block').css('visibility') == 'hidden' ) {
		$('.bottom-block').css('visibility','visible');
		$(".bottom-title").text("˅ Ограничить прибыль и убыток");
	}
	  else {
		$('.bottom-block').css('visibility','hidden');
		$(".bottom-title").text("˃ Ограничить прибыль и убыток");
	  }
});

$('input:radio[name="InvestForm[restriction]"]').change(function(e){
	$(".income-input").toggleClass("radiocheck");
	$(".outcome-input").toggleClass("radiocheck");
});

$('input:checkbox[name="InvestForm[income]"]').change(function(e){
	$(".income-field-input").toggleClass("input-disabled");
});
$('input:checkbox[name="InvestForm[outcome]"]').change(function(e){
	$(".outcome-field-input").toggleClass("input-disabled");
});


/* sumInv/mult fields */

$("#investform-suminv").bind('keydown', function(e){
	var targetValue = String.fromCharCode(e.which);
	var inputValue = $("#investform-suminv").val();
	
	if(e.which ===8 || e.which === 13 || e.which === 37 || e.which === 39 || e.which === 46 || inputValue == "") {
		return;
	}
	if($.isNumeric(targetValue)) {
		return;
	}
	e.preventDefault();
});
$("#investform-suminv").bind('keyup', function(e){
	var targetValue = String.fromCharCode(e.which);
	var inputValue = $("#investform-suminv").val();

	if($.isNumeric(targetValue)) {
		if(parseInt(inputValue) > 200000)
			$("#investform-suminv").val("200000");
	}
	if(inputValue == "") {
		$("#investform-suminv").val("0");
	}
});

$("#investform-mult").bind('keydown', function(e){
	var targetValue = String.fromCharCode(e.which);
	var inputValue = $("#investform-mult").val();
		if(e.which ===8 || e.which === 13 || e.which === 37 || e.which === 39 || e.which === 46 || inputValue == "") {
			return;
	}
	if($.isNumeric(targetValue)) {
		if(inputValue.length < 2)
			return;
	}
	e.preventDefault();
});
$("#investform-mult").bind('keyup', function(e){
	var targetValue = String.fromCharCode(e.which);
	var inputValue = $("#investform-mult").val();

	if(inputValue == "") {
		$("#investform-mult").val("1");
	}
});


/* Custom validation error messages*/

var suminv_observer = new MutationObserver( function(mutations) {
		if($("div.field-investform-suminv > p").text() !== "")
			$("div.field-investform-suminv > p").addClass("suminv-error");
		else 
			$("div.field-investform-suminv > p").removeClass("suminv-error");
	}.bind());
suminv_observer.observe($("div.field-investform-suminv > p").get(0), {characterData: true, childList: true});

var mult_observer = new MutationObserver( function(mutations) {
		if($("div.field-investform-mult > p").text() !== "")
			$("div.field-investform-mult > p").addClass("mult-error");
		else 
			$("div.field-investform-mult > p").removeClass("mult-error");
	}.bind());
mult_observer.observe($("div.field-investform-mult > p").get(0), {characterData: true, childList: true});

var takeincome_observer = new MutationObserver( function(mutations) {
		if($("div.field-investform-takeincome > p").text() !== "")
			$("div.field-investform-takeincome > p").addClass("takeincome-error");
		else 
			$("div.field-investform-takeincome > p").removeClass("takeincome-error");
	}.bind());
takeincome_observer.observe($("div.field-investform-takeincome > p").get(0), {characterData: true, childList: true});

var takeoutcome_observer = new MutationObserver( function(mutations) {
		if($("div.field-investform-takeoutcome > p").text() !== "")
			$("div.field-investform-takeoutcome > p").addClass("takeoutcome-error");
		else 
			$("div.field-investform-takeoutcome > p").removeClass("takeoutcome-error");
	}.bind());
takeoutcome_observer.observe($("div.field-investform-takeoutcome > p").get(0), {characterData: true, childList: true});


$('.invest-btn').on('click', function() {
     $(this).addClass("clicked");
});


/* Ajax submit request */

$(document).on("beforeSubmit", "#login-form", function (e) {
    var form = $(this);
	if(!$(".outcome-field-input").hasClass("input-disabled")){
		$("#investform-takeoutcome").focus();
		$("#investform-takeoutcome").focus();
	}
	
	if (form.find('.has-error').length) {
		return false;
	}
	var sumInv = $("#investform-suminv").val();
	var mult = $("#investform-mult").val();
	
	if($('#investform-income').is(':checked') && $("#investform-takeincome").val() != "") {
		if($('#radiobutton1').is(':checked')) {
			var takeProfit = $("#investform-takeincome").val();
		}
		else {
			takeProfit = parseInt($("#investform-takeincome").val()) / 100 * parseInt(sumInv);
		}
	}
	
	if($('#investform-outcome').is(':checked') && $("#investform-takeoutcome").val() != "") {
		if($('#radiobutton1').is(':checked')) {
			var stopLoss = $("#investform-takeoutcome").val();
		}
		else {
			stopLoss = parseInt($("#investform-takeoutcome").val()) / 100 * parseInt(sumInv);
		}
	}
	
	
    var direction = $(".invest-btn.clicked").val();
	
    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: {sumInv: sumInv, mult: mult, takeProfit: takeProfit, stopLoss: stopLoss, direction: direction},
        success: function (msg) {
            console.log(msg)
			$(".invest-btn.clicked").removeClass("clicked");
        },
        error: function () {
            // действие на случай ошибки
        }
    });

}).on('submit', function(e){
    e.preventDefault();
});











