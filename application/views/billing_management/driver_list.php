<script>
	$(function() {
		$('#billing_list_dt').dataTable({
			"bJQueryUI": true,
	        "sPaginationType": "full_numbers",
	        "bPaginate": true,
	        "bLengthChange": false,
	        "bFilter": true,
	        "bInfo": false,     
	        "bScrollCollapse": false,
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": base_url + "billing_management/get_client_list",
			"fnDrawCallback": function( oSettings ) {
				$('.generate_invoice').tipsy({gravity: 's'});
				$('.view_dr_plans').tipsy({gravity: 's'});
		    }
		});
	});
</script>

<h3>Billing Management</h3>

<table id="billing_list_dt" class="datatable">
    <thead>
	<tr>
		<th align="center" valign="top" width="2%"></th>
		<th align="left" valign="top" width="20%">Client Name</th>
		<th align="left" valign="top" width="10%"><small>Cleared<small></th>
		<th align="left" valign="top" width="3%">Status</th>
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

