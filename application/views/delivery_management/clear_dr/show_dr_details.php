<script>
	$(function() {
		$("#confirm_delivery_plan").ajaxForm({
	      success: function(o) {
	   		default_success_confirmation({message : "Delivery Plan has been cleared!", alert_type: "alert-success"});
	   		verify_delivery_plan();
	      },
	      beforeSubmit: function(o) {
	       
	      },
	      dataType: 'json'

	    });
	});
</script>
<legend>Delivery Details</legend>

<?php if($dr) { ?>
<form id="confirm_delivery_plan" name="confirm_delivery_plan" method="POST" action="<?php echo url('delivery_management/verify_delivery_plan'); ?>">
<div class="row-fluid">
	<div class="span6">
		<dl class="dl-horizontal">
		  <dt>Client:</dt>
		  <dd><?php echo $dr['client_name']; ?></dd>
		  <dt>Client Address:</dt>
		  <dd><?php echo $dr['delivery_address']; ?></dd>
		  <dt>Pick Up Point:</dt>
		  <dd><?php echo $dr['pickup_point']; ?></dd>
		  <dt></dt>
		  <dd>&nbsp;</dd>
		  <dt>Delivered By:</dt>
		  <dd><?php echo $dr['driver_name']; ?> <br/>  <?php echo $dr['other_driver_name']; ?></dd>
		  <dt>Plate Number:</dt>
		  <dd><?php echo strtoupper($dr['plate_no']); ?></dd>
		  <dt>Date Created:</dt>
		  <dd><?php echo date("M d, Y",strtotime($dr['date_created'])); ?></dd>
		</dl>
	</div>
	<div class="span6">
		<dl class="dl-horizontal">
		  <dt><span class="pull-left">Warehouse</span></dt>
		  <dd>&nbsp;</dd>
		  <dt>Departure:</dt>
		  <dd><?php echo ($dr['warehouse_datetime_in'] == "" ? '' : date("M d, Y h:i:s a",strtotime($dr['warehouse_datetime_in'])) ); ?></dd>
		  <dt>Arrival:</dt>
		  <dd><?php echo ($dr['warehouse_datetime_out'] == "" ? '' : date("M d, Y h:i:s a",strtotime($dr['warehouse_datetime_out'])) ); ?></dd>
		  
		  <dt>&nbsp;</dt>
		  <dd>&nbsp;</dd>
		  <dt><span class="pull-left">Dealer</span></dt>
		  <dd>&nbsp;</dd>
		  <dt>Departure:</dt>
		  <dd><?php echo ($dr['dealer_datetime_in'] == "" ? '' : date("M d, Y h:i:s a",strtotime($dr['dealer_datetime_in'])) ); ?></dd>
		  <dt>Arrival:</dt>
		  <dd><?php echo ($dr['dealer_datetime_out'] == "" ? '' : date("M d, Y h:i:s a",strtotime($dr['dealer_datetime_out'])) ); ?></dd>
		</dl>
	</div>
</div>
<legend>Items</legend>
<small>
<table class="table table-condensed table-bordered table-hover" >
  <thead>
    <tr>
      <th>VIN No.</th>
      <th>Conduction Sticker No.</th>
      <th>Model</th>
	  <th>Color</th>
	  <th>Quantity</th>
	  <th>Settings</th>
	  <th>Remarks</th>
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
			<!--<input type="text" id="settings_<?php echo $value['id']; ?>" name="settings[<?php echo $value['id']; ?>]" value="<?php echo $value['settings']; ?>" style="width:70px;">-->
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
		</td>
		<td><?php echo $value['remarks']; ?></td>
		<?php $total_quantity += $value['qty']; ?>			  
	</tr>
  <?php endforeach; ?>
  
	<tr>
      <td colspan="7"><b>Total Unit: </b> <?php echo $total_quantity; ?> </td>                 
    </tr>
  </tbody>
</table>
</small>
		<input type="hidden" id="dr_id" name="dr_id" value="<?php echo $dr['id']; ?>">
		<input type="hidden" id="client_id" name="client_id" value="<?php echo $dr['client_id']; ?>">
		<div class="control-group">
			<div class="controls">
			  <button id="confirmation" type="button" class="btn btn-primary" onclick="$('#confirm_delivery_plan').submit();">Clear Plan</button>
			</div>
		</div>
</form>
<?php #} ?>
<?php } else { ?>
	<strong>No records found!</strong>
<?php } ?>