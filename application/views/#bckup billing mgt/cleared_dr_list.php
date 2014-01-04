<script>
	$(function() {
		$('#back_delivery_plans_dm').show();
		var client_id = "<?php echo $client_id; ?>";
		$('#dr_list_dt').dataTable({
			"bJQueryUI": true,
	        "sPaginationType": "full_numbers",
	        "bPaginate": true,
	        "bLengthChange": false,
	        "bFilter": true,
	        "bInfo": false,     
	        "bScrollCollapse": false,
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": base_url + "billing_management/get_cleared_list_dt?client_id="+client_id,
			"fnDrawCallback": function( oSettings ) {
				$('.view_details').tipsy({gravity: 's'});
				$('.print_receipt').tipsy({gravity: 's'});
				$('.approve').tipsy({gravity: 's'});
				$('.reject').tipsy({gravity: 's'});
				$('.cleared').tipsy({gravity: 's'});
		    }
		});
	});
</script>

<h3>Delivery Plans</h3>
<br/>
<table id="dr_list_dt" class="datatable">
    <thead>
	<tr>
		<th align="center" valign="top" width="3%"></th>
		<th align="left" valign="top" width="10%">Delivery #</th>
		<th align="left" valign="top" width="20%">Client</th>
		<th align="left" valign="top" width="5%">Plate #</th>
		<th align="left" valign="top" width="10%">Driver 1</th>
		<th align="left" valign="top" width="10%">Driver 2</th>
		<th align="left" valign="top" width="10%">Date of Delivery</th>
		<th align="left" valign="top" width="7%">Status</th>
	</tr>
    </thead>
    <tbody>
    </tbody>
</table>

<style>
table.datatable td, th {padding-left:5px;}
table.datatable tr.success {background-color:#DEF0D8;}
table.datatable tr.error {background-color:#F2DEE0;}
table.datatable tr.warning {background-color:#FDF8E4;}

</style>