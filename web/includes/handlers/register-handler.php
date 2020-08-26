<?php

function sanitize($inputText) {
    return str_replace(" ", "", strip_tags($inputText));
}


if(isset($_POST['registerButton'])){
    //Register button pressed
    $email = sanitize($_POST['email']);
    $email2 = sanitize($_POST['email2']);
    $grade = $_POST['grade'];
    $firstName = ucfirst(strtolower(sanitize($_POST['firstName'])));
    $lastName = ucfirst(strtolower(sanitize($_POST['lastName'])));
    $password = strip_tags($_POST['password']);
    $password2 = strip_tags($_POST['password2']);

    $wasSuccessful = $account->register($email, $email2, $grade, $firstName, $lastName, $password, $password2);

    if($wasSuccessful){
        $_SESSION['userEmail'] = $email;
        $_SESSION['userGrade'] = $grade;
        $_SESSION['userFirstName'] = $firstName;
        header("Location: index.php");
    } else {
        // Registration failed
        // echo "REGISTRATION FAILED.  LIFE IS FULL OF DISSAPOINTMENTS.";
    }
}

?>