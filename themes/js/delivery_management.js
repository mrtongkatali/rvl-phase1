
function show_topleft_loader() {
	$('#default_module_loader_wrapper').removeClass("hidden");
	$('#default_module_loader_wrapper').html(topright_ajax_loader);
}

function end_topleft_loader() {
	$('#default_module_loader_wrapper').addClass("hidden");
	$('#default_module_loader_wrapper').html("");
}

$(".add_new_delivery").live('click', function() {
	$('#add_new_delivery').addClass('hidden');
	$('#delivery_status_dd_wrapper').addClass('hidden');
	$('#back_delivery_list').removeClass('hidden');
	show_topleft_loader();
	$.post(base_url + 'delivery_management/add_delivery_form',{},function(o) {
		end_topleft_loader();
		$('#delivery_management_main_wrapper').html(o);
	});
});

$(".back_delivery_list").live('click', function() {
	$('#add_new_delivery').removeClass('hidden');
	$('#delivery_status_dd_wrapper').removeClass('hidden');
	$('#back_delivery_list').addClass('hidden');
	$('#delivery_management_main_wrapper').html("");

	delivery_receipt_list();
});

function delivery_receipt_list() {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}
	show_topleft_loader();
	$.post(base_url + 'delivery_management/delivery_receipt_list',{},function(o) {
		end_topleft_loader();
		$('#delivery_management_main_wrapper').html(o);
	});
}

function print_pdf(id) {
	var id = parseInt(id);
	
	show_topleft_loader();
	$.post(base_url + 'delivery_management/print_pdf',{id:id},function(o) {
		end_topleft_loader();
		$('#delivery_management_main_wrapper').html(o);
	});
	
}

function approve_receipt(id) {
	var id = parseInt(id);
	$.post(base_url + 'delivery_management/approve_receipt',{id:id},function(o) {
		if(o.is_successful) {
			delivery_receipt_list();
		}
	},'json');
}

function reject_receipt(id) {
	var id = parseInt(id);
	$.post(base_url + 'delivery_management/reject_receipt',{id:id},function(o) {
		if(o.is_successful) {
			delivery_receipt_list();
		}
	},'json');
}

function set_default_driver() {
	var truck_id = $('#truck_plate_no').val();
	$.post(base_url + 'delivery_management/get_default_driver',{truck_id:truck_id},function(o) {
		$('#driver').select2('enable',true);
		$('#driver').select2('val', [o.driver1]);

		$('.driver2').select2('enable',true);
	    $(".driver2").select2("data", {id: o.driver2, text: o.driver2_name});

		
	},'json');

}

$(".scan_receipt").live('click', function() {
	//$('#back_delivery_list').removeClass('hidden');
	//$('#add_new_delivery').removeClass('hidden');
	//$('#scan_receipt').addClass('hidden');
	$('#delivery_status_dd_wrapper').addClass('hidden');
	scan_receipt_form();
});

function scan_receipt_form() {
	if($('.tipsy-inner')) {
		$('.tipsy-inner').remove();
	}
	show_topleft_loader();
	$.post(base_url + 'delivery_management/scan_receipt_form',{},function(o) {
		end_topleft_loader();
		$('#delivery_management_main_wrapper').html(o);
	});
}

function show_dr_details() {
	var delivery_no = $("#delivery_no").val();
	if(delivery_no !== "") {
		show_topleft_loader();
		$.post(base_url + "delivery_management/show_dr_details",{delivery_no:delivery_no}, function(o) {
			end_topleft_loader();
			$('#delivery_details_wrapper').html(o);
		});
	}
}

function update_dr_form(dr_id) {
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

function cleared_receipt(id) {
	var id = parseInt(id);
	$.post(base_url + 'delivery_management/cleared_receipt',{id:id},function(o) {
		if(o.is_successful) {
			delivery_receipt_list();
		}
	},'json');
}

function print_delivery_plan(id) {
	$.post(base_url + 'delivery_management/set_print',{id:id},function(o) {
		if(o.is_successful) {
			setTimeout(function() {
				delivery_receipt_list();
			},1000);
		}
	},'json');
	
	/*
	$.post(base_url + 'delivery_management/set_print',{id:id},function(o) {
		if(o.is_successful) {
			
		}
	},'json');
	*/
}

function verify_delivery_plan() {
	var delivery_no = $("#delivery_no").val();
	if(delivery_no !== "") {
		show_topleft_loader();
		$.post(base_url + "delivery_management/show_printed_delivery_plan",{delivery_no:delivery_no}, function(o) {
			end_topleft_loader();
			$('#delivery_details_wrapper').html(o);
		});
	}
}

function search_all_dr() {
	var delivery_no = $("#delivery_no").val();
	if(delivery_no !== "") {
		show_topleft_loader();
		$.post(base_url + "delivery_management/show_all_dr",{delivery_no:delivery_no}, function(o) {
			end_topleft_loader();
			$('#delivery_details_wrapper').html(o);
		});
	}
}