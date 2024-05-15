<?php 
include('class/User.php');
$user = new User();
$errorMessage = '';
if(!empty($_POST['resetpassword']) && $_POST['resetpassword']) {
	$errorMessage =  $user->savePassword();
}
include('include/header.php');
?>
<title>pdo_admin</title>
<div class="container contact">	
	<h2>pdo_admin</h2>	
	<div class="col-md-6">                    
		<div class="panel panel-info" >
			<div class="panel-heading">
				<div class="panel-title">Reset Password</div>                        
			</div> 
			<div style="padding-top:30px" class="panel-body" >
				<?php if ($errorMessage != '') { ?>
					<div id="login-alert" class="alert alert-danger col-sm-12"><?php echo $errorMessage; ?></div>                            
				<?php } ?>
				<?php if(!empty($_GET['authtoken']) && $_GET['authtoken']) { ?>
					<form id="loginform" class="form-horizontal" role="form" method="POST" action="">                                    
						<div style="margin-bottom: 25px" class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input type="password" class="form-control" id="password" name="password"  placeholder="New password..." required>			
						</div>
						<div style="margin-bottom: 25px" class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input type="password" class="form-control" id="cpassword" name="cpassword"  placeholder="Confirm password..." required>              
						</div>	
						<div style="margin-top:10px" class="form-group">                               
							<div class="col-sm-12 controls">
								<input type="hidden" name="authtoken"  value="<?php echo $_GET['authtoken']; ?>" />
								<input type="submit" name="resetpassword" value="Save" class="btn btn-info">						  
							</div>						
						</div>					 
						</div>  	
					</form>
				<?php } else { ?>
					Invalid password reset request.
				<?php } ?>
			</div>                     
		</div>  
	</div>
</div>	
<?php include('include/footer.php');?>