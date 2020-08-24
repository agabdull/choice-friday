<?php

function sanitize($inputText) {
    return str_replace(" ", "", strip_tags($inputText));
}


if(isset($_POST['registerButton'])){
    //Register button pressed
    $email = sanitize($_POST['email']);
    $email2 = sanitize($_POST['email2']);
    $type = $_POST['type'];
    $firstName = ucfirst(strtolower(sanitize($_POST['firstName'])));
    $lastName = ucfirst(strtolower(sanitize($_POST['lastName'])));
    $password = strip_tags($_POST['password']);
    $password2 = strip_tags($_POST['password2']);

    $wasSuccessful = $account->register($email, $email2, $type, $firstName, $lastName, $password, $password2);

    if($wasSuccessful){
        $_SESSION['userLoggedIn'] = $email;
        header("Location: index.php");
    } else {
        // Registration failed
        // echo "REGISTRATION FAILED.  LIFE IS FULL OF DISSAPOINTMENTS.";
    }
}

?>