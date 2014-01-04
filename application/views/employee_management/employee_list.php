<script>
	$(function() {
		$('#employee_list_dt').dataTable({
			"bJQueryUI": true,
	        "sPaginationType": "full_numbers",
	        "bPaginate": true,
	        "bLengthChange": false,
	        "bFilter": true,
	        "bInfo": false,     
	        "bScrollCollapse": false,
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": base_url + "employee_management/get_employee_list",
			"fnDrawCallback": function( oSettings ) {
				$('.edit_employee').tipsy({gravity: 's'});
				$('.print_receipt').tipsy({gravity: 's'});
				$('.approve').tipsy({gravity: 's'});
				$('.reject').tipsy({gravity: 's'});
		    }
		});
	});
</script>

<table id="employee_list_dt" class="datatable">
    <thead>
	<tr>
		<th align="center" valign="top" width="1%"></th>
		<th align="left" valign="top" width="10%">Employee Code</th>
		<th align="left" valign="top" width="20%">Name</th>
		<th align="left" valign="top" width="5%">Gender</th>
		<th align="left" valign="top" width="10%">Status</th>
	</tr>
    </thead>
    <tbody>
    </tbody>
</table>

<style>
table.datatable td, th {padding-left:5px;}
</style>

