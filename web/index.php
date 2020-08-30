<?php

include("includes/config.php");

// manual logout
// session_destroy();

if(isset($_SESSION['userEmail'])){
    $userEmail = $_SESSION['userEmail'];

    $query = $pdo->query("SELECT id, grade, fname FROM users WHERE email='$userEmail'");
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $_SESSION['userId'] = $row['id'];
    $_SESSION['userGrade'] = $row['grade'];
    $_SESSION['userFirstName'] = $row['fname'];

    $id = $_SESSION['userId'];
    $userGrade = $_SESSION['userGrade'];
    $userFirstName = $_SESSION['userFirstName'];

    if ($userGrade == 0){
        // did we just make a successful submit?  If so, set this session variable to true
        // if we know we just came from a successful submit, then we can clear the form
        $_SESSION['submitSuccess'] = false;
       header("Location: instructor.php");
    }

} else {
    header("Location: register.php");
}


$query = $pdo->query("SELECT p1, p2, p3, p4, p5, p6, p7, p8 FROM user$id"); 
if ($query){
    if ($query->rowCount() != 0){
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $prevChoices = [$row['p1'], $row['p2'], $row['p3'], $row['p4'], $row['p5'], $row['p6'], $row['p7'], $row['p8']];
    } else {
        $prevChoices = [];
    }
    
} else {
    echo "FAILURE: Query for prevChoices failed";
}


// if prevChoices are valid, then we want to automatically select the boxes
// corresponding to the choices




if(isset($_POST['chooseButton'])){
    $choiceArr = [$_POST['choicePeriod1'],  $_POST['choicePeriod2'], $_POST['choicePeriod3'], $_POST['choicePeriod4'], 
    $_POST['choicePeriod5'],  $_POST['choicePeriod6'], $_POST['choicePeriod7'], $_POST['choicePeriod8']];


    // remove the user from his old choices
    if($prevChoices !== []){  // if no previous choices selected by user, then skip this
        for($i=1; $i<=8; $i++){
            $prevChoice = $prevChoices[$i-1]; // $prevChoice is an INTEGER
            $pdo->query("DELETE FROM choice$prevChoice WHERE userid='$id'");
        }
    }


    // we want to update $prevChoices ASAP so that the page refreshes with the new choices auto-selected
    $prevChoices = $choiceArr;



    // update userchoices
    $pdo->query("DELETE FROM user$id"); // gets rid of previous choices
    for($i=1;$i<=8;$i++){
        $c1 = $choiceArr[0]; // these are all INTEGERS (userids)
        $c2 = $choiceArr[1];
        $c3 = $choiceArr[2];
        $c4 = $choiceArr[3];
        $c5 = $choiceArr[4];
        $c6 = $choiceArr[5];
        $c7 = $choiceArr[6];
        $c8 = $choiceArr[7];
        $pdo->query("INSERT INTO user$id (p1, p2, p3, p4, p5, p6, p7, p8) VALUES ($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8)");
    }
    


    // add the user to each individual choice
    for($i=1; $i<=8; $i++){
        $newChoice = $choiceArr[$i-1];
        $pdo->query("INSERT INTO choice$newChoice (userid) VALUES ($id)");
    }
}


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/student.css">
    <title>Choice Friday - Home</title>
</head>
<body>
<div style="width: 100%; align: right;">
    <button id="logoutButton" class="button submitter" onclick="logout()">Log out</button>
</div>

    <!--<p>Hello, <?php echo $userFirstName?>.  You are in grade <?php echo $userGrade . ", and your email address is " . $userEmail?></p>-->


    <div class="container">

    <header class="text-center text-light my-4">
        <h1 class="mb-4">Choose Your Choices!</h1>
    </header>


        <form class="text-center my-4" id="chooseForm" action="index.php" method="POST">

        <?php
        for($i=1; $i<=8; $i++){
            echo " <div class='choicePeriod text-light text-left'>
            <hr> 
            <h3 class='text-center'>Period " . $i . "</h3> ";
            
            $query = $pdo->query("SELECT id, title, description FROM choices WHERE period='$i'");
            $row = $query->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($row as $val){ 
                $choiceId = $val['id'];
                $choiceReference = "choice" . $choiceId; // unique
                $title = $val['title'];

                // The value of the input type should be the ID of the choice

                $description = $val['description'];
                echo "<input type='radio' id='". $choiceReference . "' name='choicePeriod". $i . "' value='" . $choiceId ."' required>
                    <label for='" . $choiceReference . "'> <b> " . $title . ": </b> <i> " . $description . "</i> </label>";
                
            }   
            echo "</div>"; 
        }
        ?>

        <hr style="max-width: 30em;">
        <button type="submit" name="chooseButton" class="submitter">Submit</button>

        </form>

    </div>
</body>

<script> 
    // we got the user's previous choices via an SQL query
    // now, we pass that php array into a short JS script
    // which automatically checks the user's previous choices
    const previousChoices = <?php echo json_encode($prevChoices)?>;
    if (previousChoices[0] !== ""){
        for(i=1; i<=8;i++){
            console.log(previousChoices[i-1] + i.toString());
            document.getElementById("choice" + previousChoices[i-1]).checked = true;
        }
    }
</script>

</html>