<?php

include("includes/config.php");

// manual logout
// session_destroy();

if(isset($_SESSION['userEmail'])){
    $userEmail = $_SESSION['userEmail'];

    $query = $pdo->query("SELECT grade, fname FROM users WHERE email='$userEmail'");
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $_SESSION['userGrade'] = $row['grade'];
    $_SESSION['userFirstName'] = $row['fname'];

    $userGrade = $_SESSION['userGrade'];
    $userFirstName = $_SESSION['userFirstName'];

    if ($userGrade == 0){
       header("Location: instructor.php");
    }

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

    <p>Hello, <?php echo $userFirstName?>.  You are in grade <?php echo $userGrade . ", and your email address is " . $userEmail?></p>
</body>
</html>