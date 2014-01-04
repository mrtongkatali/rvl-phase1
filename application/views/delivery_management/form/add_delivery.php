<script>
 $(function() {

    var opts=$("#client_source").html(), opts2="<option></option>"+opts;
    $("#client_name").each(function() { var e=$(this); e.html(e.hasClass("placeholder")?opts2:opts); });
    $("#client_name").select2({});
    $("#add_delivery_form").ajaxForm({
      success: function(o) {
        
        if(o.is_successful) {
          $('#add_new_delivery').removeClass('hidden');
          $('#delivery_status_dd_wrapper').removeClass('hidden');
          $('#back_delivery_list').addClass('hidden');
          $.unblockUI();

          delivery_receipt_list();
        } else {
          
        }
       
      },
      beforeSubmit: function(o) {
        $.blockUI({ message: '<h4>Uploading...</h4>' });       
      },
      dataType: 'json'

    });

    $('#delivery_date_dtp').datetimepicker({
      pickTime: false,
    });
 });

</script>

<form id="add_delivery_form" name="add_delivery_form" method="post" action="<?php echo url('delivery_management/save_delivery_plan'); ?>"  enctype="multipart/form-data">
<div class="form-horizontal">
	<legend>Upload Invoice</legend>
  <div class="control-group">
    <label class="control-label">Client</label>
    <div class="controls">
      <select  id="client_name" name="client_name" class="populate" style="width:580px"></select>
      <section class="clear"></section>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label">Upload</label>
    <div class="controls">
      <input type="file" id="vn_excel" name="vn_excel">
      <section class="clear"></section>
    </div>
  </div>

  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn btn-primary" onclick="$('add_delivery_form').submit();">Save</button>
    </div>
  </div>

</div>

</form>

<select id="client_source" style="display:none">
  <?php foreach($client_list as $key=>$value): ?>
    <option value="<?php echo $value['id']; ?>"><?php echo $value['client_name']; ?></option>
  <?php endforeach; ?>
</select>