
function show_topleft_loader() {
	$('#default_module_loader_wrapper').removeClass("hidden");
	$('#default_module_loader_wrapper').html(topright_ajax_loader);
}

function end_topleft_loader() {
	$('#default_module_loader_wrapper').addClass("hidden");
	$('#default_module_loader_wrapper').html("");
}


function driver_list() {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}
	show_topleft_loader();
	$.post(base_url + 'payroll/driver_list',{},function(o) {
		end_topleft_loader();
		$('#payroll_main_wrapper').html(o);
	});
}

function generate_invoice(dr_id) {
	var dr_id = parseInt(dr_id);

	$.post(base_url + 'delivery_management/update_delivery_plan_form',{dr_id:dr_id},function(o) {
		$('.update_dr_form_wrapper').html(o);
		$('.update_dr_form_wrapper').appendTo("body").modal('show');
		
		$('.update_dr_form_wrapper').on('hidden', function () {
		  $("#update_dr_form").validationEngine('hide');
		  $('.update_dr_form_wrapper').html("");
		});
	});
}

function show_client_dr_list(client_id) {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}
	show_topleft_loader();
	$.post(base_url + 'billing_management/show_cleared_dr_list',{client_id:client_id},function(o) {
		end_topleft_loader();
		$('#payroll_main_wrapper').html(o);
	});
}

function invoice_cleared_dr_from(id) {
	$.post(base_url + 'billing_management/invoice_cleared_dr_form',{id:id},function(o) {
		$('.invoice_cleared_dr_form_wrapper').html(o);
		$('.invoice_cleared_dr_form_wrapper').appendTo("body").modal('show');
		
		$('.invoice_cleared_dr_form_wrapper').on('hidden', function () {
		  $('#invoice_cleared_dr_form').html("");
		});
	});
}

function generate_payslip_bulk() {
	$.post(base_url + 'payroll/generate_payslip_bulk_form',{},function(o) {
		$('.generate_payslip_bulk_form_wrapper').html(o);
		$('.generate_payslip_bulk_form_wrapper').appendTo("body").modal('show');
	});
}