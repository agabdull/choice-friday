<?php

if(isset($_POST['loginButton'])){
    //Login button pressed
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    $result = $account->login($email, $password);

    if($result){
        $_SESSION['userEmail'] = $email;

        $query = $pdo->query("SELECT grade, fname FROM users WHERE email='$userEmail'");
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $_SESSION['userGrade'] = $row['grade'];
        $_SESSION['userFirstName'] = $row['fname'];
        header("Location: index.php");
    }
}

?>