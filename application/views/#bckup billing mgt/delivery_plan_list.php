<br/>
<?php if($dr) { ?>
<a href="<?php echo url("generate_invoice_receipt"); ?>" class="btn btn-success pull-right" target="_blank" >Generate</a> <br/><br/>
<?php foreach($dr as $key=>$value): ?>
	<hr/><br/>
	<div id="dr_plan_item_<?php echo $value['id']; ?>">
		<table class="datatable table-bordered table-condensed table">
		    <thead>
				<th align="left" valign="top" width="10%">Delivery #</th>
				<th align="left" valign="top" width="20%">Client</th>
				<th align="left" valign="top" width="5%">Plate #</th>
				<th align="left" valign="top" width="10%">Driver 1</th>
				<th align="left" valign="top" width="10%">Driver 2</th>
				<th align="left" valign="top" width="10%">Delivery Date</th>
		    </thead>
		    <tbody>
		    	<tr>
		    		<td><?php echo $value['delivery_no']; ?></td>
		    		<td><?php echo $value['client_name']; ?></td>
		    		<td><?php echo $value['plate_no']; ?></td>
		    		<td><?php echo $value['driver_name']; ?></td>
		    		<td><?php echo $value['other_driver_name']; ?></td>
		    		<td><?php echo $value['delivery_date']; ?></td>
		    	</tr>
		    </tbody>
		</table>

		<br/>

		<?php $vn_list = Vn_List::findAllByDeliveryReceipt($value['id']); ?>
		<table class="datatable table-bordered table-condensed table">
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
		    	<?php foreach($vn_list as $key2=>$value2): ?>
		    	<tr>
		    		<td><?php echo $value2['vin_no']; ?></td>
		    		<td><?php echo $value2['conduction_sticker_no']; ?></td>
		    		<td><?php echo $value2['model']; ?></td>
		    		<td><?php echo $value2['color']; ?></td>
		    		<td><?php echo $value2['qty']; ?></td>
		    	</tr>
		    	<?php endforeach; ?>
		    </tbody>
		</table>
	</div>
	<br/>
<?php endforeach; ?>
<?php } else { ?>
	<center><b>No results found</b></center>
<?php } ?>