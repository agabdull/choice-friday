<?php

include("includes/config.php");

if(isset($_SESSION['userEmail']) && isset($_SESSION['userGrade']) && isset($_SESSION['userFirstName'])){
    if($_SESSION['userGrade'] != 0){  // Kid is trying to gain admin privileges unlawfully
        header("Location: index.php");
    } else {
        $userEmail = $_SESSION['userEmail'];
        $userFirstName = $_SESSION['userFirstName'];
    }
} else {
    header("Location: register.php");
}




$submitMessage = "";
    
function getInputValue($name){
    if(isset($_POST[$name])){
        echo $_POST[$name];
    }
}


if(isset($_POST['addButton'])){
    echo "form submitted";
    $title = strip_tags($_POST['addTitle'] . " with " . $_POST['addInstructors']);
    $admin = $userEmail;
    $description = strip_tags($_POST['addDescription']);
    $period = $_POST['addPeriod'];
    $minGrade = $_POST['minGrade'];
    $maxGrade = $_POST['maxGrade'];

    echo $description;

    if($minGrade > $maxGrade){
        $submitMessage = "FAILURE: Invalid grade range";
    } else {
        $result = $pdo->query("INSERT INTO choices(title, admin, description, period, mingrade, maxgrade, students) VALUES
        ('$title', '$admin', '$description', '$period', '$minGrade', '$maxGrade', ARRAY[]::text[])");

        //echo $title . $admin . $description . $period . $minGrade . $maxGrade;

        if($result){
            $submitMessage = "SUCCESS!";
        } else {
            $submitMessage = "FAILURE: Insertion into database could not be completed";
        }
    }

}
    

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choice Friday - Instructor</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/instructor.css">
    <script src="assets/js/scripts.js"></script>
</head>
<body>
    <button class="button" onclick="logout()">LOG OUT</button>

    <p>Hello, <?php echo $userFirstName?>. You are an instructor! Your email address is <?php echo $userEmail?> </p>

    <div class="container">

        <header class="text-center text-light my-4">
          <h1 class="mb-4">Submit a New Choice!</h1>
        </header>    

        


        <form class="text-center my-4" id="addChoiceForm" action="register.php" method="POST">

        <div class="choiceBox">
            <p>
                <input class="form-control m-auto" id="addTitle" name="addTitle" type="text" 
                value="<?php echo getInputValue('addTitle');?>" placeholder="Title" required>
                <label for="addInstructors">with</label>
                <input class="form-control m-auto" id="addInstructors" name="addInstructors" type="text" 
                value="<?php echo getInputValue('addInstructors');?>" placeholder="Instructor Name(s)" required>
            </p>

            <p>
                <input class="form-control m-auto" id="addDescription" name="addDescription" type="text" 
                value="<?php echo getInputValue('addDescription');?>" placeholder="Description" required>
            </p>
        </div>



            <div class="extras">
            <p> <br>
            <label for="addPeriod"> Period: </label>
            <select name="addPeriod" id="addPeriod">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select>
            </p>

            <p>
                <div class="form-group" id="addGradeRange">
                <label for="addGradeRange"> Grade Range: </label>
                        <select name="minGrade" id="minGrade">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                        to
                        <select name="maxGrade" id="maxGrade">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                </div>
            </p>
            </div>



            <button type="submit" name="addButton" class="submitter">Submit</button>

            <?php echo "<p>". $submitMessage ."</p>"?>

        </form>
    
      </div>
</body>
</html>