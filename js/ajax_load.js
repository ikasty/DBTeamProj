//$.blockUI.defaults.css = {border: 0, textAlign: 'center'};
$('document').ready(function() {
	$('a.ajax_load').each(function(index, item) {
		$(item).on("click", function() {
			$.blockUI({
				css: {backgroundColor: 'transparent', border: 0},
				message: $('#throbber')
			});
			$.ajax({
				url: '/ajax.php',
				type: 'POST',
				dataType: 'html',
				data: {TARGET: 'view/main', AJAXKEY: 'test'}
			}).done(function(data) {
				$('#contents').html(data);
				$.unblockUI();
			});
		});
	});
});