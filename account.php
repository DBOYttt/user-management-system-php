<?php
/**
 * Plik account.php jest odpowiedzialny za wyświetlanie szczegółów konta użytkownika.
 *
 * Plik ten zawiera kod PHP, który pobiera szczegóły konta użytkownika za pomocą klasy User,
 * a następnie wyświetla te szczegóły w tabeli na stronie. Użytkownik ma również możliwość
 * edycji swojego konta, klikając na odpowiedni link.
 *
 * @package UserManagementSystem
 */
?>
<?php 
include('class/User.php');
$user = new User();
$user->loginStatus();
$userDetail = $user->userDetails();
include('include/header.php');
?>
<title>pdoadmin</title>
<div class="container contact">	
	<h2>pdoadmin</h2>	
	<?php include('menu.php');?>
	<div class="table-responsive">		
		<div><span style="font-size:20px;">User Account Details:</span><div class="pull-right"><a href="edit_account.php">Edit Account</a></div>
		<table class="table table-boredered">		
			<tr>
				<th>Name</th>
				<td><?php echo $userDetail['first_name']." ".$userDetail['last_name']; ?></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><?php echo $userDetail['email']; ?></td>
			</tr>
			<tr>
				<th>Password</th>
				<td>**********</td>
			</tr>
			<tr>
				<th>Gender</th>
				<td><?php echo $userDetail['gender']; ?></td>
			</tr>
			<tr>
				<th>Mobile</th>
				<td><?php echo $userDetail['mobile']; ?></td>
			</tr>
			<tr>
				<th>Designation</th>
				<td><?php echo $userDetail['designation']; ?></td>
			</tr>		
		</table>
	</div>	
</div>	
<?php include('include/footer.php');?>