<?php 
include('../class/User.php');
$user = new User();
$user->adminLoginStatus();
$message  = '';
if(!empty($_POST['password_change']) && $_POST['password_change']) {
	$message = $user->saveAdminPassword();
}
include('include/header.php');
?>
<title>pdoadmin</title>
<link rel="stylesheet" href="css/style.css">
<div class="container contact">	
	<h2>pdo_admin</h2>	
	<?php include 'menus.php'; ?>
	<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">   
		<a href="#"><strong><span class="fa fa-dashboard"></span> Change Password</strong></a>
		<hr>
		<div class="col-sm-6"> 
			<?php if ($message != '') { ?>
				<div id="login-alert" class="alert alert-danger col-sm-12"><?php echo $message; ?></div>                            
			<?php } ?>
			<form class="form-horizontal" role="form" method="POST" action="">                                    
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
						<input type="submit" name="password_change" value="Change Password" class="btn btn-info">						  
					</div>						
				</div>				
			</form>
		</div>  	
	</div>
</div>	
<?php include('include/footer.php');?>