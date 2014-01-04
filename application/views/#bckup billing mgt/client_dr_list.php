<?php include('themes/templates/default.php'); ?>

<br/>

<script>
	$(function() {
		$('#back_delivery_plans_dm').show();
		$('#from_date_dtp').datetimepicker({
	      pickTime: false,
	    });

	    $('#to_date_dtp').datetimepicker({
	      pickTime: false,
	    });

	    $("#search_dr_plan_form").ajaxForm({
			success: function(o) {
				$('#delivery_plan_wrapper').html(o);
			},
			beforeSubmit: function(o) {
			 
			},
		});
	});
</script>

<h4><?php echo $client['client_name']; ?></h4>

<br/>
<form id="search_dr_plan_form" name="search_dr_plan_form" method="post" action="<?php echo url('billing_management/search_client_dr_plan_form'); ?>">
<input type="hidden" id="client_id" name="client_id" value="<?php echo $client['id']; ?>">
	<div class="control-group">
		<label class="control-label">Date Coverage : </label>
		<div class="controls">
			<div id="from_date_dtp" class="input-append">
				<input type="text" id="from_date" name="from_date" class="" data-format="yyyy-MM-dd" value="<?php echo ($dr['delivery_date'] ? date('Y-m-d',strtotime($dr['delivery_date'])) : date('Y-m-d') ); ?>"></input>
				<span class="add-on">
				  <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
				</span>
			</div>

			<div id="to_date_dtp" class="input-append">
				<input type="text" id="to_date" name="to_date" class="" data-format="yyyy-MM-dd" value="<?php echo ($dr['delivery_date'] ? date('Y-m-d',strtotime($dr['delivery_date'])) : date('Y-m-d') ); ?>"></input>
				<span class="add-on">
				  <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
				</span>
			</div>

			<a href="javascript:void(0);" onclick="$('#search_dr_plan_form').submit();" class="btn btn-primary">Filter</a>
		</div>
	</div>
</form>

<hr />

<div id="delivery_plan_wrapper"></div>



<?php include('footer/default.php'); ?>