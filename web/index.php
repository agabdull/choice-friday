<?php

include("includes/config.php");

// manual logout
// session_destroy();

if(isset($_SESSION['userLoggedIn'])){
    $userLoggedIn = $_SESSION['userLoggedIn'];

    $query = $pdo->query("SELECT grade FROM users WHERE email='$userLoggedIn'");
    if (!$query){
        echo "query failed";
    } else {
        echo "query success";
    }
    
    $row = $query->fetch(PDO::FETCH_ASSOC);

    if (!$row){
        echo "fetch failed";
    } else {
        echo "fetch success";
    }

    $grade = $row['grade'];

    echo $grade;

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

    <p>Hello, <?php echo $userLoggedIn?>.  </p>
</body>
</html>