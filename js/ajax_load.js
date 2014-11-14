function load_view(target, done_func, menu_reload) {
	var args = {TARGET: 'view/' + target, AJAXKEY: ajaxkey};
	if (typeof menu_reload !== 'undefined') args.menu_reload = menu_reload;

	$.ajax({
		url: '/ajax.php',
		type: 'POST',
		dataType: 'html',
		data: args
	}).done(function(data) {
		// replace view
		if (menu_reload)	target = $('#container');
		else				target = $('#contents');

		if (data != '-1') target.html(data);
		done_func(data);
	});
}

$('document').ready(function() {
	$('a.ajax_load[data-link]').each(function() {
		var clickfunc = function() {
			var item = $(this);
			item.off("click", clickfunc);

			// view change
			view_change_start();

			// load view
			load_view(item.attr('data-link'), function(data) {
				view_change_finish();
				item.on("click", clickfunc);
			});		
		};
		$(this).on("click", clickfunc);
	});

	$('a.ajax_load[data-func]').each(function() {
		var clickfunc = function() {
			var item = $(this);
			item.off("click", clickfunc);

			// get args
			var args = {};
			item.trigger('start', args);

			$.ajax({
				url: '/ajax.php',
				type: 'POST',
				dataType: 'json',
				data: {TARGET: 'func/' + item.attr('data-func'), AJAXKEY: ajaxkey, ARGS: args}
			}).done(function(data) {
				// trigger finish func
				item.trigger('finish', [item, data]);
				item.on("click", clickfunc);
			});
		};
		$(this).on("click", clickfunc);
	});
});