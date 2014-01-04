<?php include('themes/templates/header.php'); ?>

<form >
<div class="form-horizontal">
	<legend>Delivery Receipt Creation</legend>
  <div class="control-group">
    <label class="control-label" >Client</label>
    <div class="controls">
      <input type="text" placeholder="">
	  <span class="help-inline">[Client Long Name]</span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" >From</label>
    <div class="controls">
      <input type="text" placeholder="">
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" >Truck Plate No.</label>
    <div class="controls">
      <input type="text" placeholder="">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" >Delivered By:</label>
    <div class="controls">
      <input type="text" placeholder="">
    </div>
  </div>
</div>
<legend>Items</legend>
<small>
<table class="table table-condensed table-bordered table-hover" style="width: auto;">
              <thead>
                <tr>
                  <th>VIN No.</th>
                  <th>Conduction Sticker No.</th>
                  <th>Model</th>
				  <th>Color</th>
				  <th>Quantity</th>
				  <th>Settings</th>
                </tr>
              </thead>
              <tbody>
			  <!--tr>
                  <td>1</td>
                  <td>1</td>
                  <td>1</td>
                  <td>1</td>
                  <td>1</td>
                  <td>1
				  <span class="pull-right">
				  <div class="btn-group ">
						<a class="btn btn-mini" id="removeitem"><i class="icon-minus"></i> Remove</a>
				  </div>
				  </span>
				  </td>                  
                </tr-->
                <tr id="adder">
                  <td><input class="input-small" type="text" placeholder="VIN No." id="txtVINNO" style="margin-bottom: 0px;"></td>
                  <td><input class="input-small" type="text" placeholder="CS No." id="txtVINNO" style="margin-bottom: 0px;"></td>
                  <td><input class="input-small" type="text" placeholder="Model" style="margin-bottom: 0px;"></td>
				  <td><input class="input-medium" type="text" placeholder="Color" style="margin-bottom: 0px;"></td>
				  <td><input class="input-mini" type="text" placeholder="Qty" style="margin-bottom: 0px;"></td>
				  <td><input class="input-large" type="text" placeholder=".input-medium" style="margin-bottom: 0px;">
				  
					<div class="btn-group ">
						<a class="btn btn-mini" id="additem"><i class="icon-plus"></i> Add</a>
				  </div>
				  </td>
                </tr>
              </tbody>
            </table>
</small>
  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn">Submit</button>
    </div>
  </div>
  
</form>