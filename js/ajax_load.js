$('document').ready(function() {
	$('a.ajax_load[data-link]').each(function() {
		var clickfunc = function() {
			var item = $(this);
			item.off("click", clickfunc);
			$.blockUI({
				css: {backgroundColor: 'transparent', border: 0},
				message: $('#throbber')
			});
			$.ajax({
				url: '/ajax.php',
				type: 'POST',
				dataType: 'html',
				data: {TARGET: 'view/' + item.attr('data-link'), AJAXKEY: ajaxkey}
			}).done(function(data) {console.log("test!2", data)
				if (data != '-1')
					$('#contents').html(data);
				$.unblockUI();
				item.on("click", clickfunc);
			});
		};
		$(this).on("click", clickfunc);
	});
	$('a.ajax_load[data-func]').each(function() {
		var clickfunc = function() {
			var item = $(this);
			item.off("click", clickfunc);
			var args = {};
			item.trigger('args', args);
			$.ajax({
				url: '/ajax.php',
				type: 'POST',
				dataType: 'html',
				data: {TARGET: 'func/' + item.attr('data-func'), AJAXKEY: ajaxkey, ARGS: args}
			}).done(function(data) {
				item.trigger('finish', [item, JSON.parse(data)]);
				item.on("click", clickfunc);
			});
		};
		$(this).on("click", clickfunc);
	});
});