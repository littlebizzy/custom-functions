jQuery(document).ready(function($) {



	$('.custom-functions-template').submit(function() {
		return false;
	});



	$('#custom-functions-template-button').click(function() {

		if (wp.themePluginEditor.lastSaveNoticeCode) {
			wp.themePluginEditor.removeNotice(wp.themePluginEditor.lastSaveNoticeCode);
		}

		var $button = $(this);
		$button.closest('.submit').find('.spinner').css('visibility', 'visible');
		$button.attr('disabled', true)

		var code = wp.themePluginEditor.instance.codemirror.getValue();

		var data = {
			code: code,
			action: 'cstmfn_save',
			nonce: cstmfn_data['nonce']
		};

		$.post(ajaxurl + '?_=' + new Date().getTime(), data, function(e) {

			if ('undefined' == typeof e.status) {

				wp.themePluginEditor.lastSaveNoticeCode = 'unknown_error';
				wp.themePluginEditor.addNotice({
					code: 'unknown_error',
					type: 'error',
					message: 'Unknown error. Please try again after a few moments.',
					dismissible: true
				});

			} else if ('error' == e.status) {

				var notice = $.extend({
					code: 'save_error',
					message: wp.themePluginEditor.l10n.saveError
				}, e.data, {
					type: 'error',
					dismissible: true,
					data: e.data,
					message: e.data.message
				});

				wp.themePluginEditor.lastSaveNoticeCode = notice.code;
				wp.themePluginEditor.addNotice(notice);

			} else if ('ok' == e.status) {

				wp.themePluginEditor.lastSaveNoticeCode = 'file_saved';
				wp.themePluginEditor.addNotice({
					code: wp.themePluginEditor.lastSaveNoticeCode,
					type: 'success',
					message: e.reason,
					dismissible: true
				});

				wp.themePluginEditor.dirty = false;
			}

		}).fail(function() {

			wp.themePluginEditor.lastSaveNoticeCode = 'server_error';
			wp.themePluginEditor.addNotice({
				code: 'server_error',
				type: 'error',
				message: 'Server communication error. Please try again after a few moments.',
				dismissible: true
			});

		}).always(function() {

			wp.themePluginEditor.spinner.removeClass('is-active');
			wp.themePluginEditor.isSaving = false;

			wp.themePluginEditor.textarea.prop( 'readonly', false );
			if (wp.themePluginEditor.instance) {
				wp.themePluginEditor.instance.codemirror.setOption('readOnly', false);
			}

			$button.closest('.submit').find('.spinner').css('visibility', 'hidden');
			$button.attr('disabled', false);
		});

		return false;
	});



});