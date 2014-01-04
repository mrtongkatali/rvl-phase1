<?php ob_start();?>
<?php 
    date_default_timezone_set('Asia/Manila');
    
    $failed_entries = $_SESSION['failed_entries'];
    $filename       = "FAILED_ENTRY_LOG-".date("Y-m-d").'.xls';
?>
<style type="text/css">
.font-size {
	font-size: x-small;
}
</style>
<?php 
    $delivery_address   = $import_error['delivery_address']; 
    $delivery_point     = $import_error['delivery_point']; 
?>
<table width="100%" border="1">
<thead>
    <th>Delivery Address</th>
    <th>Delivery Point</th>
</thead>
    <tr>
        <td><?php echo $delivery_address; ?></td>
        <td><?php echo $delivery_point;  ?></td>
    </tr>
    <tr></tr>
</table>

<table width="100%" border="1">
<thead>
    <th>vin_no</th>
    <th>conduction_sticker_no</th>
    <th>model</th>
    <th>color</th>
    <th>qty</th>
    <th>settings</th>
    <th>delivery_type</th>
    <th>error</th>
</thead>
<?php foreach($import_error['vn'] as $f): ?>
  <tr>
    <td><?php echo $f['vin_no']; ?></td>
    <td><?php echo $f['conduction_sticker_no'];  ?></td>
    <td><?php echo $f['model'];  ?></td>
    <td><?php echo $f['color']; ?></td>
    <td><?php echo $f['qty'];  ?></td>
    <td><?php echo $f['settings'];  ?></td>
    <td><?php echo $f['delivery_type'];  ?></td>
    <td><?php echo $f['message'];  ?></td>
  </tr>
<?php endforeach; ?>
</table>


<?php
header("Content-type: application/x-msexcel;charset=UTF-8"); //tried adding  charset='utf-8' into header
header("Content-Disposition: attachment; filename=$filename");
header("Content-Disposition: attachment;filename=$filename");
Header("Pragma: no-cache");
header("Expires: 0");
?>