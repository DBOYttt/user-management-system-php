<?php
/**
 * Plik get_messages.php odpowiedzialny jest za pobieranie i wyświetlanie wiadomości czatu.
 */

include('class/User.php');
$user = new User();

$messages = $user->getChatMessages();

foreach ($messages as $message) {
    $first_name = $message['first_name'];
    $last_name = $message['last_name'];
    $username = $first_name . ' ' . $last_name;
    echo '<p><strong>' . $username . ':</strong> ' . $message['message'] . '</p>';
}