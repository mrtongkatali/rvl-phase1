<script>
	$(function() {
		$('#example').dataTable({
			"bJQueryUI": true,
	        "sPaginationType": "full_numbers",
	        "bPaginate": true,
	        "bLengthChange": false,
	        "bFilter": true,
	        "bInfo": false,     
	        "bScrollCollapse": false,
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": base_url + "delivery_management/get_delivery_receipt_list",
			"fnDrawCallback": function( oSettings ) {
				$('.edit_user').tipsy({gravity: 's'});
				$('.delete_user').tipsy({gravity: 's'});
				$('.print_receipt').tipsy({gravity: 's'});
				$('.approve_user').tipsy({gravity: 's'});
		    }
		});
	});
</script>


<table id="example" class="datatable">
    <thead>
	<tr>
		<th align="center" valign="top" width="3%"></th>
		<th align="left" valign="top" width="5%">Delivery #</th>
		<th align="left" valign="top" width="20%">Client</th>
		<th align="left" valign="top" width="5%">Plate #</th>
		<th align="left" valign="top" width="10%">Driver 1</th>
		<th align="left" valign="top" width="10%">Driver 2</th>
		<th align="left" valign="top" width="10%">Date of Delivery</th>
	</tr>
    </thead>
    <tbody>
    </tbody>	
</table>