<?php

include("includes/config.php");

// manual logout
// session_destroy();

if(isset($_SESSION['userLoggedIn'])){
    $userLoggedIn = $_SESSION['userLoggedIn'];
    $test = $_SESSION['session_var'];
    $userGrade = $_SESSION['userGrade'];
    //$all = $_SESSION['all'];
} else {
    header("Location: register.php");
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choice Friday - Home</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="assets/js/scripts.js"></script>
</head>
<body>
    <button class="button" onclick="logout()">LOG OUT</button>

    <p>Hello, <?php echo $userLoggedIn?>.  I am Dr. Moshe Renert, Founder of the Renert School and Creator of the Choice Friday System.  
    Welcome to paradise.  You are in grade <?php print_r($userGrade)?>.  Heres: <?php //echo $all?>. queries back in, 
    i am a frustration.  Here's our message from before: <?php echo $test?>.  Now we're trying to use fetch in order to set
    our desired session variable to something sensical.  Oh shizzz it didn't crash, so now let's uncomment the lines where we try to
    display our session variable value! try array</p>
</body>
</html>