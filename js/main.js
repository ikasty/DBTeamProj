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