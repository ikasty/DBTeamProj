$('document').ready(function() {
	$('a.ajax_load').each(function() {
		$(this).on("click", function() {
			$.blockUI({
				css: {backgroundColor: 'transparent', border: 0},
				message: $('#throbber')
			});
			$.ajax({
				url: '/ajax.php',
				type: 'POST',
				dataType: 'html',
				data: {TARGET: $(this).attr('data-link'), AJAXKEY: ajaxkey}
			}).done(function(data) {
				if (data != '-1')
					$('#contents').html(data);
				console.log(data);
				$.unblockUI();
			});
		});
	});
});