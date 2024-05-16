<?php
include('class/User.php');
$user = new User();

if (isset($_POST['message'])) {
    $user->sendMessage($_POST['message']);
}