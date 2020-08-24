<?php

if(isset($_POST['loginButton'])){
    //Login button pressed
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    $result = $account->login($email, $password);

    if($result){
        $_SESSION['userLoggedIn'] = $email;

        //$userGrade = intval(($pdo->query("SELECT grade FROM users WHERE email='$email';"))->fetchAll()['grade']);

        $userGrade = $account->$pdo->query("SELECT fName FROM users WHERE email='$email'");
        $all = $account->$pdo->query("SELECT * FROM users WHERE email='$email'");
        //$_SESSION['all'] = $all;
        $_SESSION['userGrade'] = $userGrade;
        $_SESSION['session_var'] = "this is sample text for our session variable";
        header("Location: index.php");
    }
}

?>