jQuery(document).ready(function($) {



	$('.custom-functions-template').submit(function() {
		return false;
	});



	$('#custom-functions-template-button').click(function() {
		$(this).closest('.submit').find('.spinner').css('visibility', 'visible');
		$(this).attr('disabled', true)
		return false;
	});



});