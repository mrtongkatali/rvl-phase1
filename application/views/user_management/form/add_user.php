<script>
 $(function() {
    $("#add_delivery_form").ajaxForm({
      success: function(o) {
        
        if(o.is_successful) {
          $('#add_new_delivery').removeClass('hidden');
          $('#back_delivery_list').addClass('hidden');
          delivery_receipt_list();
        } else {
          
        }
       
      },
      beforeSubmit: function(o) {
       
      },
      dataType: 'json'

    });

 });

</script>

<br/>
<h3>Add User</h3>
<br/>
<div class="form-horizontal">
  <form id="add_delivery_form" name="add_delivery_form" method="post" action="<?php echo url('delivery_management/save_delivery_plan'); ?>">

    <div class="control-group">
      <label class="control-label">Firstname</label>
      <div class="controls">
        <input type="text" id="firstname" name="firstname">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Lastname</label>
      <div class="controls">
        <input type="text" id="lastname" name="lastname">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Lastname</label>
      <div class="controls">
        <input type="text" id="lastname" name="lastname">
      </div>
    </div>

  </form>
</div>