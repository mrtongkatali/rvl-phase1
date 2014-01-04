<?php include('themes/templates/default.php'); ?>

<script>
	$(function() {
		$('#back_payroll_dl').show();
		$('#from_date_dtp').datetimepicker({
	      pickTime: false,
	    });

	    $('#to_date_dtp').datetimepicker({
	      pickTime: false,
	    });

	    $("#filter_payroll_register_form").ajaxForm({
			success: function(o) {
				$('#payroll_register_wrapper').html(o);
			},
			beforeSubmit: function(o) {
			 
			},
		});
	});
</script>
<br/>
<h3>Generate Payslip</h3>

<br/>

<table class="datatable">
    <thead>
	<tr>
		<th align="left" valign="top" width="10%">Name</th>
		<th align="left" valign="top" width="20%">Driver's License</th>
		<th align="left" valign="top" width="5%">Type</th>
		<th align="left" valign="top" width="5%">Status</th>
	</tr>
    </thead>
    <tbody>
    	<tr>
    		<td><?php echo $driver['full_name']; ?></td>
    		<td><?php echo $driver['driver_license']; ?></td>
    		<td><?php echo $driver['assigned_type']; ?></td>
    		<td><?php echo $driver['status']; ?></td>
    	</tr>
    </tbody>
</table>

<br/><br/>
<form id="filter_payroll_register_form" name="filter_payroll_register_form" method="post" action="<?php echo url('payroll/filter_payroll_register'); ?>">
<input type="hidden" id="driver_id" name="driver_id" value="<?php echo $driver['id']; ?>">
	<div class="control-group">
		<label class="control-label">Date Coverage : </label>
		<div class="controls">
			<div id="from_date_dtp" class="input-append">
				<input type="text" id="from_date" name="from_date" class="" data-format="yyyy-MM-dd" value="<?php echo $start_date; ?>"></input>
				<span class="add-on">
				  <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
				</span>
			</div>

			<div id="to_date_dtp" class="input-append">
				<input type="text" id="to_date" name="to_date" class="" data-format="yyyy-MM-dd" value="<?php echo $end_date; ?>"></input>
				<span class="add-on">
				  <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
				</span>
			</div>

			<a href="javascript:void(0);" onclick="$('#filter_payroll_register_form').submit();" class="btn btn-primary">Filter</a>
		</div>
	</div>
</form>

<hr />

<div id="payroll_register_wrapper"></div>



<?php include('footer/default.php'); ?>
