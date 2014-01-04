<?php include('themes/templates/default.php'); ?>

<script>
	$(function() {
		$('#delivery_no').focus();
		$('#add_new_delivery').hide();
	});

	$("#btn_delivery").live('click', function() {
		verify_delivery_plan();
	});
</script>

<legend>Scan Delivery Plan</legend>
<div class="input-append">
  <input type="text" id="delivery_no" name="delivery_no" class="span3" placeholder="Delivery No.">
  <button type="button" id="btn_delivery" class="btn">Search</button>
</div>

<div id="delivery_details_wrapper"></div>