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
        // did we just make a successful submit?  If so, set this session variable to true
        // if we know we just came from a successful submit, then we can clear the form
        $_SESSION['submitSuccess'] = false;
       header("Location: instructor.php");
    }

} else {
    header("Location: register.php");
}




$query = $pdo->query("SELECT choices FROM userchoices WHERE email='$userEmail'"); 
$row = $query->fetch(PDO::FETCH_ASSOC);
$prevChoices = $row['choices'];
print_r($prevChoices);

// if prevChoices are valid, then we want to automatically select the boxes
// corresponding to the choices



if(isset($_POST['chooseButton'])){
    $choiceArr = [$_POST['choice1'],  $_POST['choice2'], $_POST['choice3'], $_POST['choice4'], 
    $_POST['choice5'],  $_POST['choice6'], $_POST['choice7'], $_POST['choice8']];

    print_r($choiceArr);

    /*
    // remove the user from his old choices
    $query = $pdo->query("SELECT choices FROM userchoices WHERE email='$userEmail'"); 
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $oldChoices = $row['choices'];
    if($oldChoices[0] != ""){ // if no previous choices selected by user, then skip this
        for($i=1; $i<8; $i++){
            $oldChoice = pg_escape_string($oldChoices[$i-1]);
            $query = $pdo->query("SELECT students FROM choices WHERE title='$oldChoice'");
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $arr = $row['students'];
            $key = array_search($userEmail, $arr);
            array_splice($arr, 1, $key);

            
            $pdo->query("UPDATE choices SET students='$arr' WHERE title='$oldChoice'");
        }
    }*/


    // update userchoices
    $query = $pdo->query("UPDATE userchoices SET choices = 'ARRAY $choiceArr' WHERE email='$userEmail'"); 
    if ($query){
        echo "Query to update userchoices successful";
    } else {
        echo "Query to update userchoices unsuccessful";
    }
    
    /*
    // add the user to each individual choice
    for($i=1; $i<=8; $i++){
        $newChoice = $choiceArr[$i-1];
        $query = $pdo->query("SELECT students FROM choices WHERE title='$newChoice'");
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $arr = $row['students'];
        array_push($arr, $userEmail);

        $pdo->query("UPDATE choices SET students='$arr' WHERE title='$newChoice'");
    }*/

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

    <p>Hello, <?php echo $userFirstName?>.  You are in grade <?php echo $userGrade . ", and your email address is " . $userEmail?></p>


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
            
            $query = $pdo->query("SELECT title, description FROM choices WHERE period='$i'");
            $row = $query->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($row as $val){ 
                $title = $val['title'];
                $description = $val['description'];
                echo "<input type='radio' id='". $title . $i . "' name='choice". $i . "' value='" . $title ."' required>
                    <label for='" . $title . $i . "'> <b> " . $title . ": </b> <i> " . $description . "</i> </label>";
                
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
            document.getElementById(previousChoices[i-1] + i.toString()).checked = true;
        }
    }
</script>

</html>