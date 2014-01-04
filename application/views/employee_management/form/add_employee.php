<script>

  var IS_EMAIL_DUPLICATE = true;
  var IS_USERNAME_DUPLICATE = true;

  $(function() {
    $("#add_employee_form").validationEngine({scroll:false});
    $("#add_employee_form").ajaxForm({
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

    $('#email_address').live("blur",function() {
      $('#verify_email_address_wrapper').addClass('fa fa-spinner fa-spin');
      var email_address = this.value;
      $.post(base_url + "validate_duplicate_email",{email_address:email_address},function(o) {
        $('#verify_email_address_wrapper').removeClass('fa fa-spinner fa-spin');
        if(o.is_duplicate) {
          $('#email_address').validationEngine('showPrompt', 'Email is not available', 'error', '', true);
        } else {
          $('#email_address').validationEngine('hide');
        }

        IS_EMAIL_DUPLICATE = o.is_duplicate;

      },'json');
    });

    $('#username').live("blur",function() {
      $('#verify_username_wrapper').addClass('fa fa-spinner fa-spin');
      var username = this.value;
      $.post(base_url + "validate_duplicate_username",{username:username},function(o) {
        $('#verify_username_wrapper').removeClass('fa fa-spinner fa-spin');
        if(o.is_duplicate) {
          $('#username').validationEngine('showPrompt', 'Username is not available', 'error', '', true);
        } else {
          $('#username').validationEngine('hide');
        }

        IS_USERNAME_DUPLICATE = o.is_duplicate;

      },'json');
    });

    //
  });

</script>

<form id="add_employee_form" name="add_employee_form" method="post" action="<?php echo url('employee_management/save_employee'); ?>">

  <div class="form-horizontal">
  	<legend>Add Employee</legend>
    <div class="control-group">
      <label class="control-label">Employee Code</label>
      <div class="controls">
        <input type="text" id="employee_code" name="employee_code" class="validate[required]">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Firstname</label>
      <div class="controls">
        <input type="text" id="firstname" name="firstname" class="validate[required]">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Middlename</label>
      <div class="controls">
        <input type="text" id="middlename" name="middlename" class="validate[required]">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Lastname</label>
      <div class="controls">
        <input type="text" id="lastname" name="lastname" class="validate[required]">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Suffix</label>
      <div class="controls">
        <input type="text" id="suffix" name="suffix">
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
          <input type="text" id="birthdate" name="birthdate" data-format="yyyy-MM-dd" class="validate[required]" value="<?php echo date('1980-m-d'); ?>"></input>
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
        <input type="text" id="email_address" name="email_address" class="validate[required,custom[email]]">
        <span id="verify_email_address_wrapper"></span>
      </div>
    </div>

    <br/>
    <legend>Account Details</legend>
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

    <script>
      function change_account_type() {
        var account_type = $('#account_type').val();
        (account_type == "Guard" ? $('#client_name_wrapper').removeClass('hidden') : $('#client_name_wrapper').addClass('hidden'));

        if(account_type == "Driver") {
          $('#truck_list_wrapper').removeClass('hidden');
          $('#driver_type_wrapper').removeClass('hidden');
          $('#driver_license_wrapper').removeClass('hidden');
        } else {
          $('#truck_list_wrapper').addClass('hidden');
          $('#driver_type_wrapper').addClass('hidden');
          $('#driver_license_wrapper').addClass('hidden');
        }
      }
    </script>

    <div class="control-group">
      <label class="control-label">User Roles</label>
      <div class="controls">
        <select id="account_type" name="account_type" onchange="javascript:change_account_type();">
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

    <div id="client_name_wrapper" class="control-group hidden">
      <label class="control-label">Client Name</label>
      <div class="controls">
        <select id="client_id" name="client_id" style="width:auto;">
        <?php foreach($clients as $key=>$value): ?>
          <option value="<?php echo $value['id']; ?>"><?php echo $value['client_name']; ?></option>
        <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div id="truck_list_wrapper" class="control-group hidden">
      <label class="control-label">Assigned Truck</label>
      <div class="controls">
        <select id="truck_id" name="truck_id" style="width:220px;">
        <?php foreach($truck_list as $key=>$value): ?>
          <option value="<?php echo $value['id']; ?>"><?php echo $value['truck_model'] . " - " . $value['plate_number']; ?></option>
        <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div id="driver_type_wrapper" class="control-group hidden">
      <label class="control-label">Type</label>
      <div class="controls">
        <select id="assigned_type" name="assigned_type" style="width:220px;">
          <option value="<?php echo PORTER; ?>"><?php echo PORTER; ?></option>
          <option value="<?php echo JOCKEY; ?>"><?php echo JOCKEY; ?></option>
        </select>
      </div>
    </div>

    <div id="driver_license_wrapper" class="control-group hidden">
      <label class="control-label">Driver's License</label>
      <div class="controls">
        <input type="text" id="driver_license" name="driver_license">
      </div>
    </div>

    <div class="control-group">
      <div class="controls">
        <button type="submit" class="btn btn-primary" onclick="$('add_employee_form').submit();">Save</button>
      </div>
    </div>

  </div>
</form>