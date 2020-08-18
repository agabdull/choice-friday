<?php
    class Account {
        private $pdo;
        private $errorArray;

        public function __construct($pdo){
            $this->pdo = $pdo;
            $this->errorArray = array();
        }

        public function login($un, $pw){
            $pw = md5($pw);
            $query = $this->pdo->query("SELECT * FROM users WHERE username='$un' AND password='$pw'");

            if($query->rowCount() == 1){
                return true;
            } else {
                array_push($this->errorArray, Constants::$loginError);
                return false;
            }
        }

        public function register($un, $fn, $ln, $em, $em2, $pw, $pw2){
            $this->validateUsername($un);
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validateEmails($em, $em2);
            $this->validatePasswords($pw, $pw2);

            if(empty($this->errorArray)){
                // Insert into db
                return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
            } else {
                return false;
            }
        }

        public function getError($error){
            if(!in_array($error, $this->errorArray)){
                $error = "";
            }
            return "<span class='errorMessage'> $error </span>";
        }

        private function insertUserDetails($un, $fn, $ln, $em, $pw){
            $encryptedPw = md5($pw);
            $profilePic = "assets/images/profile-pics/dr_renert.png";
            $date = date("Y-m-d");

            $result = $this->pdo->query("INSERT INTO users VALUES ('', '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')");
            return $result;
        }

        

        private function validateUsername($un){
            if (strlen($un) > 20 || strlen($un) < 3){
                array_push($this->errorArray, Constants::$unLengthError);
                return;
            }

            $checkUsernameQuery = $this->pdo->query("SELECT username FROM users WHERE username='$un'");
        
            if ($checkUsernameQuery->rowCount() != 0){
                array_push($this->errorArray, Constants::$unTakenError);
                return;
            }
        }
        
        private function validateFirstName($fn){
            if (strlen($fn) > 20 || strlen($fn) < 2){
                array_push($this->errorArray, Constants::$fnLengthError);
                return;
            }
            
        }
        
        private function validateLastName($ln){
            if (strlen($ln) > 20 || strlen($ln) < 2){
                array_push($this->errorArray, Constants::$lnLengthError);
                return;
            }
        }
        
        private function validateEmails($em, $em2){
            if ($em != $em2){
                array_push($this->errorArray, Constants::$emMatchError);
                return;
            }

            if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
                array_push($this->errorArray, Constants::$emInvalidError);
                return;
            }

            $checkEmailQuery = $this->pdo->query("SELECT email FROM users WHERE email='$em'");
        
            if ($checkEmailQuery->rowCount() != 0){
                array_push($this->errorArray, Constants::$emTakenError);
                return;
            }
            
        }
        
        private function validatePasswords($pw, $pw2){
            
            if($pw != $pw2){
                array_push($this->errorArray, Constants::$pwMatchError);
                return;
            }

            if(preg_match('/[^A-Za-z0-9]/', $pw)) {
                array_push($this->errorArray, Constants::$pwAlphanumError);
                return;
            }

            if (strlen($pw) > 30 || strlen($pw) < 8){
                array_push($this->errorArray, Constants::$pwLengthError);
                return;
            }

        }

    }
?>