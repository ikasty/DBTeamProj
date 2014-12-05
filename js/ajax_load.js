function load_view(target, done_func, args) {
	menu_reload = args.menu_reload;

	$.ajax({
		url: '/ajax.php',
		type: 'POST',
		dataType: 'html',
		data: {TARGET: 'view/' + target, AJAXKEY: ajaxkey, ARGS: args}
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
			
			var args = {};
			if (typeof item.attr('data-args') !== 'undefined')
				item.attr('data-args').split(",").map(function(data) {
					value = data.split(":");
					args[value[0].trim()] = value[1];
				});
			args.menu_reload = menu_reload;

			// load view
			load_view(item.attr('data-link'), function(data) {
				view_change_finish();
				item.on("click", clickfunc);
			}, args);
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
				dataType: 'json',
				data: {TARGET: 'func/' + item.attr('data-func'), AJAXKEY: ajaxkey, ARGS: args}
			}).done(function(data) {
				//console.log("ajax_load.js func data: ", data);
				//data = JSON.parse(data);

				if (typeof data['debug-message'] !== "undefined")
					console.log(data['debug-message']);

				if (typeof data['noti-message'] !== "undefined") {
					$("#notice-message").html(data['noti-message']);
					get_notice();
				}
				if (typeof data['orig-return'] !== "undefined")
					data = data['orig-return'];

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

// view change effects
function view_change_start() {
	$.blockUI({
		css: {backgroundColor: 'transparent', border: 0},
		message: $('#throbber')
	});
}
function view_change_finish() {
	$.unblockUI();
	get_notice();
}