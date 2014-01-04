<script>
	$(function() {
		$('#driver_list_dt').dataTable({
			"bJQueryUI": true,
	        "sPaginationType": "full_numbers",
	        "bPaginate": true,
	        "bLengthChange": false,
	        "bFilter": true,
	        "bInfo": false,     
	        "bScrollCollapse": false,
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": base_url + "payroll/get_driver_list",
			"fnDrawCallback": function( oSettings ) {
				$('.generate_payslip').tipsy({gravity: 's'});
		    }
		});
	});
</script>

<h3>Payroll</h3>

<table id="driver_list_dt" class="datatable">
    <thead>
	<tr>
		<th align="center" valign="top" width="1%"></th>
		<th align="left" valign="top" width="20%">Name</th>
		<th align="left" valign="top" width="10%">Driver's License</th>
		<th align="left" valign="top" width="10%">Total Trips</th>
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

