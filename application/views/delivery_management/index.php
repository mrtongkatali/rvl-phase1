<?php include('themes/templates/default.php'); ?>

<script>
	$(function() {
		delivery_receipt_list();
	});


	$("#delivery_status_dd").live('change', function() {
		delivery_receipt_list();
	});

</script>

<br/>

<?php if($ac == SUPER_ADMIN) { ?>
<div id="delivery_status_dd_wrapper" class="pull-right">
	<span>Filter</span> &nbsp;
	<select id="delivery_status_dd" name="delivery_status_dd" style="vertical-align:inherit;">
		<option value="all">All</option>
		<option value="<?php echo PENDING; ?>">Pending</option>
		<option value="<?php echo APPROVED; ?>">Approved</option>
		<option value="<?php echo REJECTED; ?>">Rejected</option>
		<option value="<?php echo PRINTED; ?>">Printed</option>
	</select>
</div>
<br/><br/>
<?php } ?>

<br/>

<div id="delivery_management_main_wrapper"></div>

<div id="test" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Modal header</h3>
  </div>
  <div class="modal-body">
    <p>One fine body…</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Save changes</a>
  </div>
</div>

<?php include('footer/default.php'); ?>

<div class="update_dr_form_wrapper modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:70%; left:35%;"></div>