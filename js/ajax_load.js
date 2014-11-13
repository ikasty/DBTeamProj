$('document').ready(function() {
	$('a.ajax_load[data-link]').each(function() {
		var clickfunc = function() {console.log(this);
			$(this).off("click", clickfunc);
			$.blockUI({
				css: {backgroundColor: 'transparent', border: 0},
				message: $('#throbber')
			});
			$.ajax({
				url: '/ajax.php',
				type: 'POST',
				dataType: 'html',
				data: {TARGET: 'view/' . $(this).attr('data-link'), AJAXKEY: ajaxkey}
			}).done(function(data) {
				if (data != '-1')
					$('#contents').html(data);
				$.unblockUI();
				$(this).on("click", clickfunc);
			});
		});
		$(this).on("click", clickfunc);
	});
	$('a.ajax_load[data-func]').each(function() {
		var clickfunc = function() {console.log(this);
			$(this).off("click", clickfunc);
			$.ajax({
				url: '/ajax.php',
				type: 'POST',
				dataType: 'ajax',
				data: {TARGET: 'func/' . $(this).attr('data-func'), AJAXKEY: ajaxkey, ARGS: $(this).attr('data-func-arg')}
			}).done(function(data) {
				[$(this).attr('data-func-end')](this, data);
				$(this).on("click", clickfunc);
			});
		});
		$(this).on("click", clickfunc);
	});
});