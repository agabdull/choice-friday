<?php

function sanitize($inputText) {
    return str_replace(" ", "", strip_tags($inputText));
}


if(isset($_POST['registerButton'])){
    //Register button pressed
    $username = sanitize($_POST['username']);
    $firstName = ucfirst(strtolower(sanitize($_POST['firstName'])));
    $lastName = ucfirst(strtolower(sanitize($_POST['lastName'])));
    $email = sanitize($_POST['email']);
    $email2 = sanitize($_POST['email2']);
    $password = strip_tags($_POST['password']);
    $password2 = strip_tags($_POST['password2']);

    $wasSuccessful = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2);

    if($wasSuccessful){
        $_SESSION['userLoggedIn'] = $username;
        header("Location: index.php");
    } else {
        // Registration failed
    }
}

?>