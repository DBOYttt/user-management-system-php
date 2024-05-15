<?php 
include('class/User.php');
$user = new User();
$errorMessage = '';
if(!empty($_POST['forgetpassword']) && $_POST['forgetpassword']) {
	$errorMessage =  $user->resetPassword();
}
include('include/header.php');
?>
<title>pdo-admin</title>
<div class="container contact">	
	<h2>pdo-admin</h2>	
	<div class="col-md-6">                    
		<div class="panel panel-info" >
			<div class="panel-heading">
				<div class="panel-title">Forget Password</div>                        
			</div> 
			<div style="padding-top:30px" class="panel-body" >
				<?php if ($errorMessage != '') { ?>
					<div id="login-alert" class="alert alert-danger col-sm-12"><?php echo $errorMessage; ?></div>                            
				<?php } ?>
				<form id="loginform" class="form-horizontal" role="form" method="POST" action="">                                    
					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input type="email" class="form-control" id="email" name="email"  placeholder="email" required>                                        
					</div>				
					<div style="margin-top:10px" class="form-group">                               
						<div class="col-sm-12 controls">
						  <input type="submit" name="forgetpassword" value="Submit" class="btn btn-info">						  
						</div>						
					</div>
					<div class="form-group">
						<div class="col-md-12 control">
							<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
								If You've already an account! 
							<a href="login.php">
								Log In 
							</a>Here
							</div>
						</div>
					</div>  	
				</form>   
			</div>                     
		</div>  
	</div>
</div>	
<?php include('include/footer.php');?>