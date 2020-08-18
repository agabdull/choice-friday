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
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Vollkorn">
    <link rel="stylesheet" href="assets/css/register.css">
</head>
<body>
    <div id="background">
        <div id="loginContainer">
            <div id = "inputContainer">
                <form id="loginForm" action="register.php" method="POST">
                <h2>Login to your account</h2>
                <p>
                <?php echo $account->getError(Constants::$loginError);?>
                    <label for="loginUsername">Username: </label>
                    <input id="loginUsername" name="loginUsername" type="text" value="<?php echo getInputValue('loginUsername');?>" required>
                </p>

                <p>
                    <label for="loginPassword">Password:  </label>
                    <input id="loginPassword" name="loginPassword" type="password" required>
                </p>
                <button type="submit" name="loginButton">LOG IN</button>
                </form>




                <!-- REGISTRATION-->



                <form id="registerForm" action="register.php" method="POST">
                <h2>Create an account:</h2>
                <p>
                    <?php echo $account->getError(Constants::$unLengthError);?>
                    <?php echo $account->getError(Constants::$unTakenError);?>
                    <label for="username">Username: </label>
                    <input id="username" name="username" type="text" value="<?php echo getInputValue('username');?>" required>
                </p>

                <p>
                    <?php echo $account->getError(Constants::$fnLengthError);?>
                    <label for="firstName">First Name: </label>
                    <input id="firstName" name="firstName" type="text" value="<?php echo getInputValue('firstName');?>" required>
                </p>

                <p>
                    <?php echo $account->getError(Constants::$lnLengthError);?>
                    <label for="lastName">Last Name: </label>
                    <input id="lastName" name="lastName" type="text" value="<?php echo getInputValue('lastName');?>" required>
                </p>

                <p>
                    <?php echo $account->getError(Constants::$emMatchError);?>
                    <?php echo $account->getError(Constants::$emInvalidError);?>
                    <?php echo $account->getError(Constants::$emTakenError);?>
                    <label for="email">Email: </label>
                    <input id="email" name="email" type="email" value="<?php echo getInputValue('email');?>" required>
                </p>

                <p>
                    <label for="email2">Confirm email: </label>
                    <input id="email2" name="email2" type="email" value="<?php echo getInputValue('email2');?>" required>
                </p>

                <p>
                    <?php echo $account->getError(Constants::$pwMatchError);?>
                    <?php echo $account->getError(Constants::$pwAlphanumError);?>
                    <?php echo $account->getError(Constants::$pwLengthError);?>
                    <label for="password">Password:  </label>
                    <input id="password" name="password" type="password" required>
                </p>

                <p>
                    <label for="password2">Confirm password:  </label>
                    <input id="password2" name="password2" type="password" required>
                </p>

                <button type="submit" name="registerButton">SIGN UP</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>