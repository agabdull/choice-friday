<?php

if(isset($_POST['loginButton'])){
    //Login button pressed
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    $result = $account->login($email, $password);

    if($result){
        $_SESSION['userLoggedIn'] = $email;

        $userGrade = intval(($pdo->query("SELECT grade FROM users WHERE email='$email';"))['grade']);
        $_SESSION['userGrade'] = $userGrade;
        header("Location: index.php");
    }
}

?>