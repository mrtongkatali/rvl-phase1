<script>
	$(function() {
		var opts=$("#truck_source").html(), opts2="<option></option>"+opts;
	    $("#truck_plate_no").each(function() { var e=$(this); e.html(e.hasClass("placeholder")?opts2:opts); });
	    $("#truck_plate_no").select2({allowClear: true});
	    

		var opts=$("#driver_source").html(), opts2="<option></option>"+opts;
		$("#driver").each(function() { var e=$(this); e.html(e.hasClass("placeholder")?opts2:opts); });
		$("#driver").select2({allowClear: true});
		$("#driver").select2("data", {id: "", text: ""} );
		$("#driver").on("change", function(e) { 
			$(".driver2").select2("data", {id: "", text: ""} ); 
		});
		

	    $(".driver2").select2({
	        placeholder: "",
	        minimumInputLength: 1,
	        ajax: {
	            url       : "delivery_management/get_available_porter",
	            dataType  : "json",
	            type      : "POST",
	            allowClear: true,
	            data: function (term, page) {
	              var driver = $('#driver').val();
	                return {
	                    q: term, // search term
	                    page_limit: 10,
	                    driver: driver,
	                };
	            },
	            multiple: true,
	            allowClear: true,
	            results: function (data, page) {
	                return {results: data};
	            }
	        },
	    });
	    $(".driver2").select2("data", {id: "<?php echo $dr['other_driver_id']; ?>", text: "<?php echo $dr['other_driver_name']; ?>"} );
	   
	    $('#delivery_date_dtp').datetimepicker({
	      pickTime: false,
	    });

		$("#update_dr_form").ajaxForm({
			success: function(o) {
			  
			  if(o.is_successful) {
			    $('.update_dr_form_wrapper').modal('hide');
			    delivery_receipt_list();
			  } else {
			    
			  }
			 
			},
			beforeSubmit: function(o) {
			 	var driver = $('#driver').val();
			 	var driver2 = $('#driver2').val();

			 	if(driver != "" && driver2 != 0) {
			 		return true;
			 	} else {
			 		alert("Oops! Please select driver 2");
			 		return false;
			 	}
			 	
			 	
			},
			dataType: 'json'
		});

		var opts=$("#address_source").html(), opts2="<option></option>"+opts;
	    $("#delivery_address").each(function() { var e=$(this); e.html(e.hasClass("placeholder")?opts2:opts); });
	    $("#delivery_address").select2({allowClear: true});

	    var opts=$("#address_source").html(), opts2="<option></option>"+opts;
	    $("#pickup_point").each(function() { var e=$(this); e.html(e.hasClass("placeholder")?opts2:opts); });
	    $("#pickup_point").select2({allowClear: true});
	});

	<?php if($dr['status'] != PENDING && $dr['status'] != REJECTED) { ?>
		disabled_select();
	<?php } ?>

	function disabled_select() {
		$(".driver2").select2("enable",false);
		$("#driver").select2("enable",false);
		$("#truck_plate_no").select2("enable",false);
	}

</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Update Delivery Plan :: <?php echo str_pad($dr['delivery_no'], 11, "0", STR_PAD_LEFT); ?> / <?php echo $dr['client_name']; ?></h4>
</div>
<div class="modal-body">
	<form id="update_dr_form" name="update_dr_form" method="post" action="<?php echo url('delivery_management/update_delivery_plan'); ?>">
	<input type="hidden" id="id" name="id" value="<?php echo $dr['id']; ?>">

		<div class="form-horizontal">
			<div class="control-group">
				<label class="control-label">Truck Plate No.</label>
				<?php if($dr['status'] == PENDING || $dr['status'] == REJECTED) { ?>
					<div class="controls">
					  <select id="truck_plate_no" name="truck_plate_no" class="populate" style="width:400px;" onchange="javascript:set_default_driver();"></select>
					  <section class="clear"></section>
					</div>
				<?php } else { ?>
					<span style="float:left; margin-top: 4px; padding-left:3%;"><b><?php echo strtoupper($dr['plate_no']); ?></b></span>
				<?php } ?>
			</div>

			<div class="control-group">
				<label class="control-label">Driver 1</label>
				<?php if($dr['status'] == PENDING || $dr['status'] == REJECTED) { ?>
					<div class="controls">
					  <select id="driver" name="driver" class="populate validate[required]" style="width:400px;"></select>
					  <section class="clear"></section>
					</div>
				<?php } else { ?>
					<span style="float:left; margin-top: 5px; padding-left:3%;"><b><?php echo strtoupper($dr['driver_name']); ?></b></span>
				<?php } ?>
			</div>

			<div class="control-group">
				<label class="control-label">Driver 2</label>
				<?php if($dr['status'] == PENDING || $dr['status'] == REJECTED) { ?>
					<div class="controls">
					  <input type="hidden" id="driver2" name="driver2" class="bigdrop driver2" style="width:400px;" />
					  <section class="clear"></section>
					</div>
				<?php } else { ?>
					<span style="float:left; margin-top: 5px; padding-left:3%;"><b><?php echo strtoupper($dr['other_driver_name']); ?></b></span>
				<?php } ?>
			</div>

			<div class="control-group">
				<label class="control-label">Pick Up Address</label>
				<?php if($dr['status'] == PENDING || $dr['status'] == REJECTED) { ?>
					<div class="controls">
					  <select id="pickup_point" name="pickup_point" class="populate" style="width:400px;"></select>
					  <section class="clear"></section>
					</div>
				<?php } else { ?>
					<span style="float:left; margin-top: 5px; padding-left:3%;"><b><?php echo strtoupper($dr['pickup_point']); ?></b></span>
				<?php } ?>
			</div>

			<?php $status = ($dr['delivery_type'] == STANDARD ? 'hidden' : ''); ?>
			<div class="control-group <?php echo $status; ?>">
				<label class="control-label">Delivery Address</label>
				<?php if($dr['status'] == PENDING || $dr['status'] == REJECTED) { ?>
					<div class="controls">
					  <select id="delivery_address" name="delivery_address" class="populate" style="width:400px;"></select>
					  <section class="clear"></section>
					</div>
				<?php } else { ?>
					<span style="float:left; margin-top: 5px; padding-left:3%;"><b><?php echo strtoupper($dr['delivery_address']); ?></b></span>
				<?php } ?>
			</div>

			<div class="control-group">
				<label class="control-label">Date of Delivery</label>
				<div class="controls">
					<?php if($dr['status'] == PENDING || $dr['status'] == REJECTED) { ?>
					  <div id="delivery_date_dtp" class="input-append">
					    <input type="text" id="delivery_date" name="delivery_date" class="validate[required]" data-format="yyyy-MM-dd" value="<?php echo ($dr['delivery_date'] ? date('Y-m-d',strtotime($dr['delivery_date'])) : date('Y-m-d') ); ?>"></input>
					    <span class="add-on">
					      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
					      </i>
					    </span>
					  </div>
					<?php } else { ?>
						<span style="float:left; margin-top: 5px;"><b><?php echo date("M d, Y",strtotime($dr['delivery_date'])); ?></b></span>
					<?php } ?>
				</div>
			</div>

			<table id="dr_list_dt" class="datatable">
			    <thead>
				<tr>
					<th align="left" valign="top" width="10%">VIN #</th>
					<th align="left" valign="top" width="20%">Conduction Sticker #</th>
					<th align="left" valign="top" width="5%">Model</th>
					<th align="left" valign="top" width="10%">Color</th>
					<th align="left" valign="top" width="10%">Qty</th>
					<!--<th align="left" valign="top" width="10%">Settings</th>-->
				</tr>
			    </thead>
			    <tbody>
			    	<?php foreach($vn_list as $key=>$value): ?>
			    	<tr>
			    		<td><?php echo $value['vin_no']; ?></td>
			    		<td><?php echo $value['conduction_sticker_no']; ?></td>
			    		<td><?php echo $value['model']; ?></td>
			    		<td><?php echo $value['color']; ?></td>
			    		<td><?php echo $value['qty']; ?></td>
			    		<td>
			    		<?php if($dr['status'] == PENDING || $dr['status'] == REJECTED) { ?>
			    			<!--
			    			<select id="settings_<?php echo $value['id']; ?>" name="settings[<?php echo $value['id']; ?>]" style="width:auto;">
			    				<option <?php echo ($value['settings'] == "R1" ? 'selected="selected"' : ''); ?> value="R1">R1</option>
			    				<option <?php echo ($value['settings'] == "R2" ? 'selected="selected"' : ''); ?> value="R2">R2</option>
			    				<option <?php echo ($value['settings'] == "R3" ? 'selected="selected"' : ''); ?> value="R3">R3</option>
			    				<option <?php echo ($value['settings'] == "R4" ? 'selected="selected"' : ''); ?> value="R4">R4</option>
			    				<option <?php echo ($value['settings'] == "R5" ? 'selected="selected"' : ''); ?> value="R5">R5</option>
			    				<option <?php echo ($value['settings'] == "R6" ? 'selected="selected"' : ''); ?> value="R6">R6</option>
			    				<option <?php echo ($value['settings'] == "R7" ? 'selected="selected"' : ''); ?> value="R7">R7</option>
								<option <?php echo ($value['settings'] == "F1" ? 'selected="selected"' : ''); ?> value="F1">F1</option>
			    				<option <?php echo ($value['settings'] == "F2" ? 'selected="selected"' : ''); ?> value="F2">F2</option>
			    				<option <?php echo ($value['settings'] == "F3" ? 'selected="selected"' : ''); ?> value="F3">F3</option>
			    				<option <?php echo ($value['settings'] == "F4" ? 'selected="selected"' : ''); ?> value="F4">F4</option>
			    				<option <?php echo ($value['settings'] == "F5" ? 'selected="selected"' : ''); ?> value="F5">F5</option>
			    				<option <?php echo ($value['settings'] == "F6" ? 'selected="selected"' : ''); ?> value="F6">F6</option>
			    				<option <?php echo ($value['settings'] == "F7" ? 'selected="selected"' : ''); ?> value="F7">F7</option>
			    			</select>
			    			-->
			    		<?php } else { echo $value['settings']; } ?>
			    		</td>
			    	</tr>
			    	<?php endforeach; ?>
			    </tbody>
			</table>
		</div>
	</form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  <?php if($dr['status'] == PENDING || $dr['status'] === REJECTED) { ?>
  	<a href="javascript:void(0);" onclick="$('#update_dr_form').submit();" class="btn btn-primary">Update</a>
  <?php } ?>
</div>

<select id="driver_source" style="display:none">
  <?php foreach($driver_list as $key=>$value): ?>
  <?php $name = $value['firstname'] . " " . $value['lastname']; ?>
    <option value="<?php echo $value['id']; ?>"><?php echo $name; ?></option>
  <?php endforeach; ?>
</select>

<select id="truck_source" style="display:none">
  <?php foreach($truck_list as $key=>$value): ?>
  	<?php
  		$reserve 	= 0;
  		$reserve 	= $value['capacity'] - $value['remaining'];
  		$avail 		= " ({$reserve}/" . $value['capacity'] . ")";
  	?>
    <option value="<?php echo $value['id']; ?>"><?php echo strtoupper($value['plate_number']) . $avail; ?></option>
  <?php endforeach; ?>
</select>

<select id="address_source" style="display:none">
  <?php foreach($address_list as $key=>$value): ?>
    <option value="<?php echo $value['id']; ?>"><?php echo strtoupper($value['address_code']); ?> - <?php echo $value['address']; ?></option>
  <?php endforeach; ?>
</select>