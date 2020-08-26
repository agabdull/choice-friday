<?php

include("includes/config.php");

if(isset($_SESSION['userEmail']) && isset($_SESSION['userGrade']) && isset($_SESSION['userFirstName'])){
    if($_SESSION['userGrade'] != 0){  // Kid is trying to gain admin privileges unlawfully
        header("Location: index.php");
    } else {
        $userEmail = $_SESSION['userEmail'];
        $userFirstName = $_SESSION['userFirstName'];
    }
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

    <p>Hello, <?php echo $userFirstName?>. You are an instructor! Your email address is <?php echo $userEmail?> </p>
</body>
</html>