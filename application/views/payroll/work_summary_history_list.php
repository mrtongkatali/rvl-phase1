<br/>
<?php if($payslip) { ?>


<h4>Pay Period : <?php echo $pay_period; ?></h4>

<a href="<?php echo url("payroll/download_payslip"); ?>" class="btn btn-success pull-right" target="_blank" >Download Payslip</a> <br/><br/>
<br/>
<table class="datatable table-bordered table-condensed table">
    <thead>
		<th align="left" valign="top" width="10%">Delivery #</th>
		<th align="left" valign="top" width="20%">Client</th>
		<th align="left" valign="top" width="20%">Delivery Address</th>
		<th align="left" valign="top" width="20%">Pickup Point</th>
		<th align="left" valign="top" width="10%">Delivery Date</th>
    </thead>
    <tbody>
    <?php foreach($payslip as $key=>$value): ?>
    <?php 
    	$dr = Delivery_Receipt::findById($value['delivery_receipt_id']);

        $gross_pay += $value['basic_pay'];
    ?>
    	<tr>
    		<td><?php echo $dr['delivery_no']; ?></td>
    		<td><?php echo $dr['client_name']; ?></td>
    		<td><?php echo $dr['delivery_address']; ?></td>
    		<td><?php echo $dr['pickup_point']; ?></td>
    		<td><?php echo date("M d, Y", strtotime($dr['delivery_date'])); ?></td>
    	</tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php
    $tax        = Settings_Rate::findActiveRate();

    $witholding = $gross_pay * ($tax['witholding_tax'] / 100);
    $philhealth = $gross_pay * ($tax['philhealth'] / 100);
    $pagibig    = $gross_pay * ($tax['pagibig'] / 100);
    $net_pay    = $gross_pay - ($witholding + $philhealth + $pagibig);
?>

<table class="datatable" style="width:100%;">
    <thead>
    <tbody>
    	<tr>
    		<td width="30%">Basic Salary</td>
    		<td width="70%"> <?php echo number_format($gross_pay,2,'.',','); ?> </td>
    	</tr>
    	<tr>
    		<td>Witholding Tax / BIR</td>
    		<td width="70%"> <?php echo number_format($witholding,2,'.',','); ?> </td>
    	</tr>
    	<tr>
    		<td>Philhealth</td>
    		<td width="70%"> <?php echo number_format($philhealth,2,'.',','); ?> </td>
    	</tr>
        <tr>
            <td>Pag-Ibig / SSS</td>
            <td width="70%"> <?php echo number_format($pagibig,2,'.',','); ?> </td>
        </tr>
    	<tr>
    		<td>Overtime</td>
    		<td>0.00</td>
    	</tr>
        <tr>
            <td>Net Pay</td>
            <td width="70%"> <?php echo number_format($net_pay,2,'.',','); ?> </td>
        </tr>
    </tbody>
</table>
<?php } else { ?>
	<center><b>No results found</b></center>
<?php } ?>

<br/>
<br/>