<?php include('themes/templates/default.php'); ?>

<br/>
<h3>Computation Settings</h3>
<br/>

<script>
	$(function() {
		
		$("#computation_settings_form").ajaxForm({
			success: function(o) {
				if(o.is_successful) {
					default_success_confirmation({message : o.message, alert_type: "alert-success"});
				}
			},
			beforeSubmit: function(o) {
			 
			},
			dataType: 'json'
		});

	});
</script>
<div id="computation_settings_main_wrapper">
	<form id="computation_settings_form" name="computation_settings_form" method="post" action="<?php echo url('payroll/update_tax_computation'); ?>">
	<input type="hidden" id="id" name="id" value="<?php echo $rate['id']; ?>">
	<div class="form-horizontal">
		<div class="control-group">
	      <label class="control-label">Witholding Tax</label>
	      <div class="controls">
	        <input type="text" id="witholding_tax" name="witholding_tax" value="<?php echo $rate['witholding_tax']; ?>" maxlength="3" style="width:40px;"> %
	      </div>
	    </div>

	    <div class="control-group">
	      <label class="control-label">Philhealth</label>
	      <div class="controls">
	        <input type="text" id="philhealth" name="philhealth" value="<?php echo $rate['philhealth']; ?>" maxlength="3" style="width:40px;"> %
	      </div>
	    </div>

	    <div class="control-group">
	      <label class="control-label">SSS</label>
	      <div class="controls">
	        <input type="text" id="sss" name="sss" value="<?php echo $rate['sss']; ?>" maxlength="3" style="width:40px;"> %
	      </div>
	    </div>

	    <div class="control-group">
	      <div class="controls">
	        <button type="submit" class="btn btn-primary" onclick="javascript:void(0);">Save</button>
	      </div>
	    </div>
	</div>
	</form>

</div>


<?php include('footer/default.php'); ?>
