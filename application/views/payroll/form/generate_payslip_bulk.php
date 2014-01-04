<script>
$(function() {
	$('#from_date_dtp').datetimepicker({
      pickTime: false,
    });

    $('#to_date_dtp').datetimepicker({
      pickTime: false,
    });
});

function download_payslips() {
	var from_date 	= $('#from_date').val();
	var to_date 	= $('#to_date').val();

	window.location.href = base_url + "payroll/generate_payslip_bulk?from_date="+from_date+"&to_date="+to_date;

}
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Generate Payslip (Bulk)</h4>
</div>
<div class="modal-body">
	<form id="generate_payslip_bulk_form" name="generate_payslip_bulk_form" method="post" action="<?php echo url('payroll/generate_payslip_bulk'); ?>">
		<div class="control-group">
			<label class="control-label">Date Coverage : </label>
			<div class="controls">
				<div id="from_date_dtp" class="input-append">
					<input type="text" id="from_date" name="from_date" class="" data-format="yyyy-MM-dd" readonly="true" value="<?php echo $start_date; ?>"></input>
					<span class="add-on">
					  <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
					</span>
				</div>

				<div id="to_date_dtp" class="input-append">
					<input type="text" id="to_date" name="to_date" class="" data-format="yyyy-MM-dd" readonly="true" value="<?php echo $end_date; ?>"></input>
					<span class="add-on">
					  <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
					</span>
				</div>

				<a href="javascript:void(0);" onclick="javascript:download_payslips();" target="_blank" class="btn btn-primary" style="margin-bottom:10px;">Generate and Download</a>
			</div>
		</div>

	</form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
