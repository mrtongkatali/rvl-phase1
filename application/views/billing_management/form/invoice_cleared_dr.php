<script>
	$(function() {
		
		$("#invoice_cleared_dr_form").ajaxForm({
			success: function(o) {
			  
			  if(o.is_successful) {
			    $('.invoice_cleared_dr_form_wrapper').modal('hide');
			    show_client_dr_list(<?php echo $dr['client_id']; ?>);
			  } else {
			    
			  }
			 
			},
			beforeSubmit: function(o) {
			 
			},
			dataType: 'json'
		});

	});
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Delivery Plan :: <?php echo str_pad($dr['delivery_no'], 11, "0", STR_PAD_LEFT); ?> / <?php echo $dr['client_name']; ?></h4>
</div>
<div class="modal-body">
	<form id="invoice_cleared_dr_form" name="invoice_cleared_dr_form" method="post" action="<?php echo url('billing_management/invoice_cleared_dr'); ?>">
	<input type="hidden" id="id" name="id" value="<?php echo $dr['id']; ?>">

		<div class="form-horizontal">
			<div class="control-group">
				<label class="control-label">Truck Plate No.</label>
				<span style="float:left; margin-top: 4px; padding-left:3%;"><b><?php echo strtoupper($dr['plate_no']); ?></b></span>
			</div>

			<div class="control-group">
				<label class="control-label">Driver 1</label>
				<span style="float:left; margin-top: 5px; padding-left:3%;"><b><?php echo strtoupper($dr['driver_name']); ?></b></span>
			</div>

			<div class="control-group">
				<label class="control-label">Driver 2</label>
				<span style="float:left; margin-top: 5px; padding-left:3%;"><b><?php echo strtoupper($dr['other_driver_name']); ?></b></span>
			</div>

			<div class="control-group">
				<label class="control-label">Pick Up Address</label>
				<span style="float:left; margin-top: 5px; padding-left:3%;"><b><?php echo strtoupper($dr['pickup_point']); ?></b></span>
			</div>

			<?php $status = ($dr['delivery_type'] == STANDARD ? 'hidden' : ''); ?>
			<div class="control-group <?php echo $status; ?>">
				<label class="control-label">Delivery Address</label>
				<span style="float:left; margin-top: 5px; padding-left:3%;"><b><?php echo strtoupper($dr['delivery_address']); ?></b></span>
			</div>

			<div class="control-group">
				<label class="control-label">Date of Delivery</label>
				<div class="controls">
					<span style="float:left; margin-top: 5px;"><b><?php echo date("M d, Y",strtotime($dr['delivery_date'])); ?></b></span>
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
			    	</tr>
			    	<?php endforeach; ?>
			    </tbody>
			</table>
		</div>
	</form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  <a href="javascript:void(0);" onclick="$('#invoice_cleared_dr_form').submit();" class="btn btn-success">Invoice</a>
</div>