<?php
    class Account {
        private $pdo;
        private $errorArray;

        public function __construct($pdo){
            $this->pdo = $pdo;
            $this->errorArray = array();
        }

        public function login($em, $pw){
            $pw = md5($pw);
            $query = $this->pdo->query("SELECT * FROM users WHERE email='$em' AND password='$pw'");

            if($query->rowCount() == 1){
                return true;
            } else {
                array_push($this->errorArray, Constants::$loginError);
                return false;
            }
        }

        public function register($em, $em2, $tp, $fn, $ln, $pw, $pw2){
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validateEmails($em, $em2);
            $this->validatePasswords($pw, $pw2);
            $this->validateGrade($tp);

            if(empty($this->errorArray)){
                // Insert into db
                return $this->insertUserDetails($em, $tp, $fn, $ln, $pw);
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

        private function insertUserDetails($em, $tp, $fn, $ln, $pw){
            $encryptedPw = md5($pw);
            if($tp != 0){
                $this->pdo->query("INSERT INTO userchoices(email, choices) VALUES ('$em', ARRAY ['', '', '', '', '', '', '', ''])");
            }
            $result = $this->pdo->query("INSERT INTO users(email, grade, fName, lName, password) VALUES('$em', '$tp', '$fn', '$ln', '$encryptedPw')");
            return $result;
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

            /*if(preg_match('/[^A-Za-z0-9]/', $pw)) {
                array_push($this->errorArray, Constants::$pwAlphanumError);
                return;
            }*/

            if (strlen($pw) > 30 || strlen($pw) < 6){
                array_push($this->errorArray, Constants::$pwLengthError);
                return;
            }

        }

        private function validateGrade($tp){
            $gradeLevels = array('1','2','3','4','5','6','7','8','9','10','11','12');
            if (!in_array($tp, $gradeLevels)){
                array_push($this->errorArray, Constants::$gradeError);
                return;
            }
        }

    }
?>