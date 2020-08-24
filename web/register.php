<?php
    include("includes/config.php");
    include("includes/classes/Constants.php");
    include("includes/classes/Account.php");

    $account = new Account($pdo);

    include("includes/handlers/register-handler.php");
    include("includes/handlers/login-handler.php");


    // Use the below fuction to remember user inputted values in the form
    function getInputValue($name){
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    
    <script src="assets/js/loginScript.js"></script>
    <link rel="stylesheet" href="assets/css/register.css">
    <title>Choice Friday - Login or Sign up!</title>
</head>



<body>

    <?php

    if(isset($_POST['registerButton'])){
        echo '<script>
                $(document).ready(function(){
                    $("#loginForm").hide();
                    $("#registerForm").show();
                })

            </script>';
    } else {
        echo '<script>
                $(document).ready(function(){
                    $("#loginForm").show();
                    $("#registerForm").hide();
                })

            </script>';
    }
    
    ?>

    
    <div class="container">

        <header class="text-center text-light my-4">
          <h1 class="mb-4">Choice Friday Scheduler</h1>
        </header>    


        <form class="text-center my-4" id="loginForm" action="register.php" method="POST">
            <p>
            <p class='errormsg'> <?php echo $account->getError(Constants::$loginError);?> </p>
                <input class="form-control m-auto" id="loginEmail" name="loginEmail" type="email" 
                value="<?php echo getInputValue('loginEmail');?>" placeholder="Email" required>
            </p>

            <p>
                <input class="form-control m-auto" id="loginPassword" name="loginPassword" type="password" 
                placeholder="Password" required>
            </p>
            <button type="submit" name="loginButton" class="submitter">Log in</button>

            <p class="text-light text-center"><a class="createAccount" role="button"> 
                <span id="hideLogin"> <br>Create an account </span>    
            </a></p>

        </form>


        <form class="text-center my-4" id="registerForm" action="register.php" method="POST">
                <p>
                    <p class='errormsg'> <?php echo $account->getError(Constants::$emMatchError);?> </p>
                    <p class='errormsg'> <?php echo $account->getError(Constants::$emInvalidError);?> </p>
                    <p class='errormsg'> <?php echo $account->getError(Constants::$emTakenError);?> </p>
                    <input class="form-control m-auto" id="email" name="email" type="email" 
                    value="<?php echo getInputValue('email');?>" placeholder="Email" required>
                </p>

                <p>
                    <input class="form-control m-auto" id="email2" name="email2" type="email" 
                    value="<?php echo getInputValue('email2');?>" placeholder="Confirm email" required>
                </p>

                <p>
                    <p class='errormsg'> <?php echo $account->getError(Constants::$gradeError);?> </p>
                    <input class="form-control m-auto" id="type" name="type" type="text"
                     value="<?php echo getInputValue('type');?>" placeholder="Grade (Number between 1-12)"required>
                </p>


                <p>
                    <p class='errormsg'> <?php echo $account->getError(Constants::$fnLengthError);?> </p>
                    <input class="form-control m-auto" id="firstName" name="firstName" type="text" 
                    value="<?php echo getInputValue('firstName');?>" placeholder="First name" required>
                </p>

                <p>
                    <p class='errormsg'> <?php echo $account->getError(Constants::$lnLengthError);?> </p>
                    <input class="form-control m-auto" id="lastName" name="lastName" type="text" 
                    value="<?php echo getInputValue('lastName');?>" placeholder="Last name"required>
                </p>


                <p>
                    <p class='errormsg'> <?php echo $account->getError(Constants::$pwMatchError);?> </p>
                    <p class='errormsg'> <?php echo $account->getError(Constants::$pwLengthError);?> </p>
                    <input class="form-control m-auto" id="password" name="password" type="password"
                     placeholder="Password" required>
                </p>

                <p>
                    <input class="form-control m-auto" id="password2" name="password2" type="password" 
                    placeholder="Confirm password"required>
                </p>

            <button type="submit" name="registerButton" class="submitter">Sign up</button>

            <p class="text-light text-center"><a class="logIntoAccount" role="button"> 
                <span id="hideRegister"> <br>Log in</span>    
            </a></p>

            </form>
    
      </div>
</body>
</html>