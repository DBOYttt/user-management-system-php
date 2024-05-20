<?php
/**
 * Plik index.php jest głównym plikiem aplikacji User Management System PHP.
 * Zawiera on kod odpowiedzialny za logikę logowania użytkownika, wyświetlanie nagłówka, treści strony oraz stopki.
 */
 
include('class/User.php');
$user = new User();
$user->loginStatus();
include('include/header.php');
?>
<title>pdoadmin</title>
<div class="container contact">	
	<h2>PdoAdmin</h2>	
	<?php include('menu.php');?>
	<div class="table-responsive">	
	</div>
</div>	
<?php include('include/footer.php');?>