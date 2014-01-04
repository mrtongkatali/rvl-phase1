<script>

  var IS_EMAIL_DUPLICATE = false;
  var IS_USERNAME_DUPLICATE = false;

  $(function() {
    $("#edit_employee_form").validationEngine({scroll:false});
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
        if(IS_EMAIL_DUPLICATE && IS_USERNAME_DUPLICATE) {
          return false;
        }
      },
      dataType: 'json'

    });

    $('#birthdate_dtp').datetimepicker({
      pickTime: false,
    });

    $('#email_address').live("change",function() {
      $('#verify_email_address_wrapper').addClass('fa fa-spinner fa-spin');
      var email_address = this.value;
      var user_id = $('#id').val();
      $.post(base_url + "validate_duplicate_email",{email_address:email_address, user_id:user_id},function(o) {
        $('#verify_email_address_wrapper').removeClass('fa fa-spinner fa-spin');
        if(o.is_duplicate) {
          $('#email_address').validationEngine('showPrompt', 'Email is not available', 'error', '', true);
        } else {
          $('#email_address').validationEngine('hide');
        }

        IS_EMAIL_DUPLICATE = o.is_duplicate;

      },'json');
    });

    //
  });

</script>

<form id="edit_employee_form" name="edit_employee_form" method="post" action="<?php echo url('employee_management/save_employee'); ?>">
<input type="hidden" id="id" name="id" value="<?php echo $e['id']; ?>">
<input type="hidden" id="employee_id" name="employee_id" value="<?php echo $e['id']; ?>">
  <div class="form-horizontal">
  	<legend>Edit Employee</legend>
    <div class="control-group">
      <label class="control-label">Employee Code</label>
      <div class="controls">
        <input type="text" id="employee_code" name="employee_code" class="validate[required]" value="<?php echo $e['employee_code']; ?>">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Firstname</label>
      <div class="controls">
        <input type="text" id="firstname" name="firstname" class="validate[required]" value="<?php echo $e['firstname']; ?>">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Middlename</label>
      <div class="controls">
        <input type="text" id="middlename" name="middlename" class="validate[required]" value="<?php echo $e['middlename']; ?>">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Lastname</label>
      <div class="controls">
        <input type="text" id="lastname" name="lastname" class="validate[required]" value="<?php echo $e['lastname']; ?>">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Suffix</label>
      <div class="controls">
        <input type="text" id="suffix" name="suffix" value="<?php echo $e['suffix']; ?>">
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
          <input type="text" id="birthdate" name="birthdate" data-format="yyyy-MM-dd" class="validate[required]"  value="<?php echo $e['birthdate']; ?>"></input>
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
        <input type="text" id="email_address" name="email_address" class="validate[required,custom[email]]"  value="<?php echo $e['email_address']; ?>">
        <span id="verify_email_address_wrapper"></span>
      </div>
    </div>


    <br/>
    
    <legend>Account Details</legend>

    <!--
    <div class="control-group">
      <label class="control-label">Username</label>
      <div class="controls">
        <input type="text" id="username" name="username" class="validate[required]">
        <span id="verify_username_wrapper"></span>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Password</label>
      <div class="controls">
        <input type="password" id="password" name="password" class="validate[required]">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Confirm Password</label>
      <div class="controls">
        <input type="password" id="confirm_password" name="confirm_password" class="validate[required,minSize[6],equals[password]]">
        <span id="verify_username_wrapper"></span>
      </div>
    </div>
    -->

    <script>
      $(function() {
        $('#account_type_edit').val("<?php echo $user['account_type']; ?>");
      });

      function change_account_type() {
        var account_type = $('#account_type_edit').val();
        (account_type == "Guard" ? $('#client_name_edit_wrapper').removeClass('hidden') : $('#client_name_edit_wrapper').addClass('hidden'));

        if(account_type == "Driver") {
          $('#truck_list_edit_wrapper').removeClass('hidden');
          $('#driver_type_edit_wrapper').removeClass('hidden');
          $('#driver_license_edit_wrapper').removeClass('hidden');
        } else {
          $('#truck_list_edit_wrapper').addClass('hidden');
          $('#driver_type_edit_wrapper').addClass('hidden');
          $('#driver_license_edit_wrapper').addClass('hidden');
        }
      }
    </script>
    <div class="control-group">
      <label class="control-label">User Roles</label>
      <div class="controls">
        <select id="account_type_edit" name="account_type" onchange="javascript:change_account_type();">
          <option value="<?php echo SUPER_ADMIN; ?>"><?php echo SUPER_ADMIN; ?></option>
          <option value="<?php echo USER_ADMIN; ?>"><?php echo USER_ADMIN; ?></option>
          <option value="<?php echo SYSTEM_ADMIN; ?>"><?php echo SYSTEM_ADMIN; ?></option>
          <option value="<?php echo COORDINATOR; ?>"><?php echo COORDINATOR; ?></option>
          <option value="<?php echo CENTRAL_DISPATCHER; ?>"><?php echo CENTRAL_DISPATCHER; ?></option>
          <option value="<?php echo GUARD; ?>"><?php echo GUARD; ?></option>
          <option value="<?php echo DRIVER; ?>"><?php echo DRIVER; ?></option>
          <option value="<?php echo TRUCK_MAINTENANCE; ?>"><?php echo TRUCK_MAINTENANCE; ?></option>
          <option value="<?php echo PREDEP_INSPECTOR; ?>"><?php echo PREDEP_INSPECTOR; ?></option>
          <option value="<?php echo BILLING; ?>"><?php echo BILLING; ?></option>
          <option value="<?php echo PAYROLL; ?>"><?php echo PAYROLL; ?></option>
          <option value="<?php echo CLIENT_INTERFACE; ?>"><?php echo CLIENT_INTERFACE; ?></option>
          <option value="<?php echo PETTY_CASH_CUSTODIAN; ?>"><?php echo PETTY_CASH_CUSTODIAN; ?></option>
          <option value="<?php echo EXECUTIVE; ?>"><?php echo EXECUTIVE; ?></option>
        </select>
      </div>
    </div>


    <script>
      $(function() {
        $('#client_id_edit').val("<?php echo $e['client_id']; ?>");
      });
    </script>

    <div id="client_name_edit_wrapper" class="control-group <?php echo ($user['account_type'] == GUARD ? '' : 'hidden'); ?>">
      <label class="control-label">Client Name</label>
      <div class="controls">
        <select id="client_id_edit" name="client_id" style="width:auto;">
        <?php foreach($clients as $key=>$value): ?>
          <option value="<?php echo $value['id']; ?>"><?php echo $value['client_name']; ?></option>
        <?php endforeach; ?>
        </select>
      </div>
    </div>

    <script>
      $(function() {
        $('#assigned_type').val("<?php echo $driver['assigned_type']; ?>");
        $('#truck_id').val("<?php echo $driver['assigned_truck_id']; ?>");
      });
    </script>
    <div id="truck_list_edit_wrapper" class="control-group <?php echo ($user['account_type'] == DRIVER ? '' : 'hidden'); ?>">
      <label class="control-label">Assigned Truck</label>
      <div class="controls">
        <select id="truck_id" name="truck_id" style="width:220px;">
        <?php foreach($truck_list as $key=>$value): ?>
          <option value="<?php echo $value['id']; ?>"><?php echo $value['truck_model'] . " - " . $value['plate_number']; ?></option>
        <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div id="driver_type_edit_wrapper" class="control-group <?php echo ($user['account_type'] == DRIVER ? '' : 'hidden'); ?>">
      <label class="control-label">Type</label>
      <div class="controls">
        <select id="assigned_type" name="assigned_type" style="width:220px;">
          <option value="<?php echo PORTER; ?>"><?php echo PORTER; ?></option>
          <option value="<?php echo JOCKEY; ?>"><?php echo JOCKEY; ?></option>
        </select>
      </div>
    </div>

    <div id="driver_license_edit_wrapper" class="control-group <?php echo ($user['account_type'] == DRIVER ? '' : 'hidden'); ?>">
      <label class="control-label">Driver's License</label>
      <div class="controls">
        <input type="text" id="driver_license" name="driver_license" value="<?php echo $driver['driver_license']; ?>">
      </div>
    </div>

    <div class="control-group">
      <div class="controls">
        <button type="submit" class="btn btn-primary" onclick="$('edit_employee_form').submit();">Save</button>
      </div>
    </div>

  </div>
</form>