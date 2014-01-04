<?php include('themes/templates/default.php'); ?>

<script>
	$(function() {
		driver_list();
	});


</script>

<div id="bulk_import_wrapper" class="pull-right">
	<button type="button" class="btn btn-success" onclick="javascript:generate_payslip_bulk();">Generate Payslip (Bulk)</button>
</div>
<div class="clear"></div>
<br>
<div id="payroll_main_wrapper"></div>

<div class="invoice_cleared_dr_form_wrapper modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:50%;"></div>
<div class="generate_payslip_bulk_form_wrapper modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:55%;left:45%;"></div>

<?php include('footer/default.php'); ?>
