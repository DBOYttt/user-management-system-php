<?php
include('../class/User.php');
$user = new User();
if(!empty($_POST['action']) && $_POST['action'] == 'listUser') {
	$user->getUserList();
}
if(!empty($_POST['action']) && $_POST['action'] == 'userDelete') {
	$user->deleteUser();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getUser') {
	$user->getUser();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addUser') {
	$user->addUser();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateUser') {
	$user->updateUser();
}
?>