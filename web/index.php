<?php

include("includes/config.php");

// manual logout
// session_destroy();

if(isset($_SESSION['userLoggedIn'])){
    $userLoggedIn = $_SESSION['userLoggedIn'];
} else {
    header("Location: register.php");
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choice Friday</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="assets/js/scripts.js"></script>
</head>
<body>
    <button class="button" onclick="logout()">LOG OUT</button>

    <p>Hello, <?php echo $userLoggedIn?>.  I am Dr. Moshe Renert, Founder of the Renert School and Creator of the Choice Friday System.  
    Welcome to paradise. </p>
</body>
</html>