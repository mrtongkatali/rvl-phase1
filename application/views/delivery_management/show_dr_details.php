<script>
	$(function() {
		$("#confirm_delivery_plan").ajaxForm({
	      success: function(o) {
	   		show_dr_details();
	      },
	      beforeSubmit: function(o) {
	       
	      },
	      dataType: 'json'

	    });
	});
</script>
<legend>Delivery Details</legend>

<?php if($dr) { ?>
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
		<td><?php echo $value['settings']; ?></td>
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

<?php #if(!$dpt) { ?>
	<form id="confirm_delivery_plan" name="confirm_delivery_plan" method="POST" action="<?php echo url('delivery_management/received_delivery_plan'); ?>">
		<input type="hidden" id="dr_id" name="dr_id" value="<?php echo $dr['id']; ?>">
		<input type="hidden" id="client_id" name="client_id" value="<?php echo $dr['client_id']; ?>">
		<div class="control-group">
			<div class="controls">
			  <button id="confirmation" type="button" class="btn btn-primary" onclick="$('#confirm_delivery_plan').submit();">Confirm</button>
			</div>
		</div>
	</form>
<?php #} ?>
<?php } else { ?>
	<strong>No records found!</strong>
<?php } ?>