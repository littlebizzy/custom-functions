jQuery(document).ready(function($) {



	$('.custom-functions-template').submit(function() {
		return false;
	});



	$('#custom-functions-template-button').click(function() {

		var $button = $(this);
		$button.closest('.submit').find('.spinner').css('visibility', 'visible');
		$button.attr('disabled', true)


		var data = {
			nonce: cstmfn_data['nonce'],
			action: 'cstmfn_save',
			code: $('#newcontent').val()
		};

		$.post(ajaxurl + '?_=' + new Date().getTime(), data, function(e) {

			if ('undefined' == typeof e.status) {
				alert('Unknown error');

			} else if ('error' == e.status) {
				alert(e.reason);

			} else if ('ok' == e.status) {
				alert('ok');
			}

		}).fail(function() {
			alert('Server communication error.' + "\n" + 'Please try again after few moments.');

		}).always(function() {
			$button.closest('.submit').find('.spinner').css('visibility', 'hidden');
			$button.attr('disabled', false);
		});

		return false;
	});



});