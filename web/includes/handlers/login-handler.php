<?php

if(isset($_POST['loginButton'])){
    //Login button pressed
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    $result = $account->login($email, $password);

    if($result){
        $_SESSION['userLoggedIn'] = $email;
        header("Location: index.php");
    }
}

?>