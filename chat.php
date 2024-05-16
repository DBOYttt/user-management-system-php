<?php

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}

include('include/header.php');
?>
<title>Chat</title>
<div class="container">
    <h2>Chat</h2>
    <div id="chat-box">
        <!-- Messages will be loaded here dynamically -->
    </div>
    <form id="chat-form" method="POST" action="">
        <input type="text" id="message" name="message" placeholder="Type your message here" required>
        <input type="submit" name="send" value="Send">
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    function loadMessages(){
        $.get('get_messages.php', function(data){
            $('#chat-box').html(data);
        });
    }

    loadMessages(); // Load messages on page load

    // Reload messages every 1 second
    setInterval(function(){
        loadMessages();
    }, 1000);

    // Send new message
    $('#chat-form').on('submit', function(e){
        e.preventDefault();
        var message = $('#message').val();
        $.post('send_message.php', {message: message}, function(){
            $('#message').val('');
            loadMessages();
        });
    });
});
</script>
<?php include('include/footer.php');?>