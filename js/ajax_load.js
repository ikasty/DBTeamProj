function load_view(target, done_func, menu_reload) {
	var args = {TARGET: 'view/' + target, AJAXKEY: ajaxkey};
	if (typeof menu_reload === 'undefined') menu_reload = 'false';
	args.menu_reload = menu_reload;

	$.ajax({
		url: '/ajax.php',
		type: 'POST',
		dataType: 'html',
		data: args
	}).done(function(data) {
		// replace view
		if (menu_reload === 'true')	target = $('#container');
		else						target = $('#contents');

		if (data != '-1') target.html(data);
		done_func(data);
		setajax();
	});
}

function setajax() {
	$('a.ajax_load[data-link]').each(function() {
		var clickfunc = function() {
			var item = $(this);
			item.off("click", clickfunc);

			// view change
			view_change_start();

			var menu_reload = 'false';
			if (typeof item.attr('data-reload') !== 'undefined')
				menu_reload = 'true';

			// load view
			load_view(item.attr('data-link'), function(data) {
				view_change_finish();
				item.on("click", clickfunc);
			}, menu_reload);
		};
		$(this).on("click", clickfunc);
	});

	$('a.ajax_load[data-func]').each(function() {
		var clickfunc = function() {
			var item = $(this);
			item.off("click", clickfunc);

			// get args
			var args = {};
			var option = {'success': true};
			item.trigger('start', [args, option]);
			if (!option.success) {
				item.on("click", clickfunc);
				return ;
			}

			$.ajax({
				url: '/ajax.php',
				type: 'POST',
				dataType: 'html',
				data: {TARGET: 'func/' + item.attr('data-func'), AJAXKEY: ajaxkey, ARGS: args}
			}).done(function(data) {
				console.log(data);data = JSON.parse(data);
				// trigger finish func
				item.trigger('finish', [item, data]);
			}).fail(function(jqHXR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}).complete(function(jqHXR, textStatus) {
				item.on("click", clickfunc);
			});
		};
		$(this).on("click", clickfunc);
	});
}

$('document').ready(setajax);