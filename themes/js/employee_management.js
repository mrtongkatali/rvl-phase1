$(".add_new_employee_btn").live('click', function() {
	$('#add_new_employee_btn').addClass('hidden');
	$('#back_employee_list_btn').removeClass('hidden');
	show_topleft_loader();
	$.post(base_url + 'employee_management/add_employee_form',{},function(o) {
		end_topleft_loader();
		$('#employee_management_main_wrapper').html(o);
	});
});

$(".back_employee_list_btn").live('click', function() {
	$('#add_new_employee_btn').removeClass('hidden');
	$('#back_employee_list_btn').addClass('hidden');
	$('#employee_management_main_wrapper').html("");

	employee_list();
});

function employee_list() {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}
	show_topleft_loader();
	$.post(base_url + 'employee_management/employee_list',{},function(o) {
		end_topleft_loader();
		$('#employee_management_main_wrapper').html(o);
	});
}

function show_topleft_loader() {
	$('#default_module_loader_wrapper').removeClass("hidden");
	$('#default_module_loader_wrapper').html(topright_ajax_loader);
}

function end_topleft_loader() {
	$('#default_module_loader_wrapper').addClass("hidden");
	$('#default_module_loader_wrapper').html("");
}

function edit_employee_form(id) {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}

	$('#add_new_employee_btn').addClass('hidden');
	$('#back_employee_list_btn').removeClass('hidden');

	var id = parseInt(id);
	show_topleft_loader();
	$.post(base_url + 'employee_management/edit_employee_form',{id:id},function(o) {
		end_topleft_loader();
		$('#employee_management_main_wrapper').html(o);
	});
}
