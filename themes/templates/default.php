<?php include('themes/templates/header.php'); ?>
<?php 
	$session = $_SESSION['rvl']['login']; 
	$ac 	 = $session['account_type'];
?>

<div class="sb">
	<div class="sb-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12"><br/>
				  <center><a href="<?php echo url('user_gateway'); ?>"><img src="<?php echo BASE_FOLDER; ?>themes/images/rvllogo.png" /></a></center>
				</div>
			</div>
		</div>
		<hr>
		<ul class="nav nav-list ga-navlist">
			<li class="nav-header"><small>Welcome <?php echo $session['firstname'] . " (".$session['account_type'] . ")"; ?></small></li>
			
			<?php if($ac == SUPER_ADMIN || $ac == COORDINATOR || $ac == CENTRAL_DISPATCHER || $ac == GUARD) { ?>
			<li class="nav-header"><a class="ga-nav-header"  data-target="#delivery-management" data-toggle="collapse" > <i class="fa fa-truck fa-2x"></i> Delivery Management <!--span class="badge pull-right">1</span--></a>
				<ul class="nav nav-list collapse <?php echo ($delivery_management ? "in" : ""); ?> subnav-group1" id="delivery-management">
					<?php if($ac != GUARD) { ?>
						<li class="<?php echo $delivery_plans; ?>"><a href="<?php echo url('delivery_management'); ?>"> <i class="fa fa-calendar fa-lg"></i> Delivery Plans</a></li>
					<?php } ?>
					<?php if($ac == SUPER_ADMIN || $ac == GUARD) { ?>
						<li class="<?php echo $scan_receipt_form; ?>"><a href="<?php echo url('delivery_management/scan_delivery_plan'); ?>"><i class="fa fa-barcode fa-lg"></i> Scan Reciept</a></li>
					<?php } ?>
					<?php if($ac == SUPER_ADMIN || $ac == CENTRAL_DISPATCHER) { ?>
						<li class="<?php echo $clear_dr; ?>"><a href="<?php echo url('delivery_management/clear_delivery_plans'); ?>"><i class="fa fa-check-square fa-lg"></i> Clear DR</a></li>
					<?php } ?>
					<li class="<?php echo $search_all_dr; ?>"><a href="<?php echo url('delivery_management/search'); ?>"><i class="fa fa-search fa-lg"></i> Search</a></li>
				</ul>
			</li>
			<?php } ?>

			<?php if($ac == SUPER_ADMIN || $ac == BILLING) { ?>
				<li class="nav-header <?php echo $billing_management; ?>"> <a class="ga-nav-header" data-target="#billing-management" data-toggle="collapse"  href="<?php echo url('billing_management'); ?>" ><i class="fa fa-money fa-2x"></i> Billing Management</a></li>
			<?php } ?>

			<?php if($ac == SUPER_ADMIN || $ac == PAYROLL) { ?>
				<li class="nav-header"><a class="ga-nav-header"  data-target="#payroll-management" data-toggle="collapse" > <i class="fa fa-list-alt fa-2x"></i> Payroll Management <!--span class="badge pull-right">1</span--></a>
					<ul class="nav nav-list collapse <?php echo ($payroll_management ? "in" : ""); ?> subnav-group1" id="payroll-management">
						<li class="<?php echo $computation_settings; ?>"><a href="<?php echo url('payroll/computation_settings'); ?>"><i class="fa fa-cogs fa-lg"></i> Computation Settings</a></li>
						<li class="<?php echo $payroll_register; ?>"><a href="<?php echo url('payroll'); ?>"> <i class="fa fa-list-ul fa-lg"></i> Payroll Register</a></li>
					</ul>
				</li>
			<?php } ?>

		  	<!--<li class="nav-header <?php echo $payroll; ?>"> <a class="ga-nav-header" href="<?php echo url('payroll'); ?>" ><i class="fa fa-money fa-2x"></i> Payroll</a></li>-->
		  	<?php if($ac == SUPER_ADMIN) { ?>
		  		<li class="nav-header <?php echo $employee_management; ?>"> <a class="ga-nav-header"  data-target="#employee-management" data-toggle="collapse" href="<?php echo url('employee_management'); ?>" ><i class="fa fa-group fa-2x"></i> Employee Management</a></li>
		  	<?php } ?>
		  	<!--<li class="nav-header <?php echo $user_management; ?>"> <a class="ga-nav-header" href="<?php echo url('user_management'); ?>" ><i class="fa fa-money fa-2x"></i> User Management</a></li>-->
		  
		 	<li><a href="<?php echo url('logout'); ?>"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li> 

		  
		</ul> 
	</div>
</div>

<div class="cb">
	<div style="position: absolute;" class="navbar navbar-inverse navbar-fixed-top">
		<div class="tb">
			<div class="row-fluid">
				<div class="span5">
					<ul class="breadcrumb" style="display:none;">
					  <li class="active"><a href="">Home</a> &raquo; </li>
					  <li><a href="#">Delivery Receipt</a> &raquo; </li>
					  <li>Test</li>
					</ul>
					<div id="default_module_loader_wrapper" class="pull-left default_loader_topleft"></div>
				</div>
				
				<?php if($delivery_management) { ?>
					<div class="span3 pull-right">
						<div class="btn-toolbar pull-right" style="margin: 0;">
							<?php if($ac == SUPER_ADMIN || $ac == COORDINATOR) { ?>
						  		<button type="button" id="add_new_delivery" class="btn btn-small btn-primary add_new_delivery">Upload Invoice</button>
						  	<?php } ?>
							<button type="button" id="back_delivery_list" class="btn btn-small btn-primary back_delivery_list hidden">Back</button>
							<!--<button type="button" id="scan_receipt" class="btn btn-small scan_receipt btn-success">Scan Receipt</button>-->
						</div>
					</div>
				<?php } ?>

				<?php if($billing_management) { ?>
					<script>	
						function back_to_billing() {
							window.location.href = base_url + "billing_management";
						}
					</script>
					<div class="span3 pull-right">
						<div class="btn-toolbar pull-right" style="margin: 0;">
							<button type="button" id="back_delivery_plans_dm" class="btn btn-small btn-primary back_delivery_plans_dm hidden"  onclick="javascript:back_to_billing();">Back</button>
						</div>
					</div>
				<?php } ?>

				<?php if($employee_management) { ?>
					<div class="span3 pull-right">
						<div class="btn-toolbar pull-right" style="margin: 0;">
						  	<button type="button" id="add_new_employee_btn" class="btn btn-small btn-primary add_new_employee_btn"><b><i class="icon-plus icon-white"></i></b> Add Employee</button>
							<button type="button" id="back_employee_list_btn" class="btn btn-small btn-primary back_employee_list_btn hidden">Back</button>
						</div>
					</div>
				<?php } ?>

				<?php if($user_management) { ?>
					<div class="span3 pull-right">
						<div class="btn-toolbar pull-right" style="margin: 0;">
						  	<button type="button" id="add_user_btn" class="btn btn-small btn-primary add_user_btn"><b><i class="icon-plus icon-white"></i></b> Add User</button>
				
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>

	<div class="cb-content">
		<div class="container-fluid">

		<!-- Main Content -->
		
	<br/>
	<div class="alert_confirmation_wrapper"></div>