
function show_topleft_loader() {
	$('#default_module_loader_wrapper').removeClass("hidden");
	$('#default_module_loader_wrapper').html(topright_ajax_loader);
}

function end_topleft_loader() {
	$('#default_module_loader_wrapper').addClass("hidden");
	$('#default_module_loader_wrapper').html("");
}

$(".add_user_btn").live('click', function() {
	//$('#add_new_delivery').addClass('hidden');
	//$('#delivery_status_dd_wrapper').addClass('hidden');
	//$('#back_delivery_list').removeClass('hidden');
	show_topleft_loader();
	$.post(base_url + 'user_management/add_user_form',{},function(o) {
		end_topleft_loader();
		$('#user_management_main_wrapper').html(o);
	});
});