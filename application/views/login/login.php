<?php include('themes/templates/header.php'); ?>
	<div class="container-fluid">

		<div class="row-fluid" >
			<div class="span5 offset1" >
				<header class="jumbotron" >
					<h1>RVL Movers </h1>
					<h3></h3>
					<p class="lead">Integrated Delivery Receipt System</p>
				</header>

				<div class="container-fluid">
					<div class="row-fluid"><h3>Efficient Delivery Receipt Encoding</h3></div>
						<i>
							<div class="row-fluid">
								<div class="span5"><span class="pull-right"><h3>Plan Creation</h3></span></div>
								<div class="span7"><h3><small>Systematic DR Processing</small></h3></div>
							</div>
							
							<div class="row-fluid">
								<div class="span5"><span class="pull-right"><h3>Inform</h3></span></div>
								<div class="span7"><h3><small>the availability of Drivers</small></h3></div>
							</div>
							<div class="row-fluid">
								<div class="span5"><span class="pull-right"><h3>Fast & Easy</h3></span></div>
								<div class="span7"><h3><small>Queuing of Approval</small></h3></div>
							</div>
					    </i>
					</div>
				</div>

				<div class="span4" style="padding-top:150px;">
					<form class="form-horizontal" action="<?php echo url('login/authenticate_account'); ?>" method="POST">
						<div class="page-header"><h2>Log in </h2></div>
						<?php echo $error_message; ?>
						<div class="control-group">
							<label for="txtUsername" class="control-label">Username</label>
							<div class="controls">
								<input type ="text" name ="username" size ="50" placeholder="Username"/>
							</div>
						</div>
						<div class="control-group">
							<label for="txtUsername" class="control-label">Password</label>
							<div class="controls">
								<input type ="password" name ="password" size ="50" placeholder="Password" />
							</div>
						</div>	
						<div class="control-group error">
							<div class="controls">
								<button class="btn" type ="submit" name="btnLogin" id="btnLogin" >Log in</button>
							</div>
							<div class="controls error">
								<span class="help-inline" ></span>
							</div>
						</div>	   
					</form>
				</div>

			</div>
		</div>
</div>