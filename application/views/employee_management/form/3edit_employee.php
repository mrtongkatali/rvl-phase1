<script>
 $(function() {

    $("#edit_employee_form").ajaxForm({
      success: function(o) {
        if(o.is_successful) {
          $('#add_new_employee_btn').removeClass('hidden');
          $('#back_employee_list_btn').addClass('hidden');
          employee_list();
        } else {
          
        }
       
      },
      beforeSubmit: function(o) {
       
      },
      dataType: 'json'

    });

    $('#birthdate_dtp').datetimepicker({
      pickTime: false,
    });
 });

</script>

<form id="edit_employee_form" name="edit_employee_form" method="post" action="<?php echo url('employee_management/save_employee'); ?>">
  <div class="form-horizontal">
  	<legend>Edit Employee</legend>

    <div class="control-group">
      <label class="control-label">Employee Code</label>
      <div class="controls">
        <input type="text" id="employee_code" name="employee_code" value="<?php echo $e['employee_code'] ?>">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Firstname</label>
      <div class="controls">
        <input type="text" id="firstname" name="firstname" value="<?php echo $e['employee_code'] ?>">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Middlename</label>
      <div class="controls">
        <input type="text" id="middlename" name="middlename" value="<?php echo $e['middlename'] ?>">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Lastname</label>
      <div class="controls">
        <input type="text" id="lastname" name="lastname" value="<?php echo $e['lastname'] ?>">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Suffix</label>
      <div class="controls">
        <input type="text" id="suffix" name="suffix" value="<?php echo $e['suffix'] ?>">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Gender</label>
      <div class="controls">
        <select id="gender" name="gender">
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Birthdate</label>
      <div class="controls">
        <div id="birthdate_dtp" class="input-append">
          <input type="text" id="birthdate" name="birthdate" data-format="yyyy-MM-dd"  value="<?php echo $e['birthdate'] ?>"></input>
          <span class="add-on">
            <i data-time-icon="icon-time" data-date-icon="icon-calendar">
            </i>
          </span>
        </div>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Email Address</label>
      <div class="controls">
        <input type="text" id="email_address" name="email_address" value="<?php echo $e['email_address'] ?>">
      </div>
    </div>

    <div class="control-group">
      <div class="controls">
        <button type="submit" class="btn btn-primary" onclick="$('edit_employee_form').submit();">Save</button>
      </div>
    </div>

  </div>
</form>