<?php
    class Account{

        private $con;
        private $errorArray;

        public function __construct($con) {
            $this->con = $con;
            $this->errorArray = array(); //pusta tablica
        }

        public function register($uNameToVal, $fNameToVal, $lNameToVal, $eMailToVal1, $eMailToVal2, $passToVal1, $passToVal2){
            $this->validateUserName($uNameToVal);
            $this->validateFirstName($fNameToVal);
            $this->validateLastName($lNameToVal);
            $this->validateEmails($eMailToVal1, $eMailToVal2);
            $this->validatePaswords($passToVal1, $passToVal2);

            if(empty($this->errorArray) == true){
                //wprowadz do bazy danych
                return $this->insertUserDetails($uNameToVal, $fNameToVal, $lNameToVal, $eMailToVal1, $passToVal1);
            }
            else {
                return false;
            }
        }

        public function login($userName, $passw){
            $passw = md5($passw); // kodowanie hasla

            $query = mysqli_query($this->con, "SELECT * FROM users WHERE username = '$userName' AND password = '$passw'");

            if(mysqli_num_rows($query) == 1) {
                return true;
            }
            else {
                array_push($this->errorArray, Constants::$loginFailed);
                return false;
            }
        }

        public function getError($error) {
            if(!in_array($error, $this->errorArray)){
                $error = "";
            }
            return "<span class='errorMessage'>$error</span>";
        }

        private function insertUserDetails($userName, $fName, $lName, $eMail, $passw){
            $encryptedPw = md5($passw); // kodowanie hasla
            $profilePic = "assets/images/profile-pics/head_emerald.png";
            $date = date("Y-m-d");

            $result = mysqli_query($this->con,
                "INSERT INTO users (id, username, firstName, lastName, email, password, signUpDate, profilePic)
                    VALUES ('', '$userName', '$fName', '$lName', '$eMail', '$encryptedPw', '$date', '$profilePic')");
            return $result;
        }

        private function validateUserName($uNameToVal){
            if (strlen($uNameToVal) > 25 || strlen($uNameToVal) < 5 ){
                array_push($this->errorArray, Constants::$userNameChars);
                return;
            }

            $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username = '$uNameToVal'");
            if(mysqli_num_rows($checkUsernameQuery) != 0){
                array_push($this->errorArray, Constants::$userNameTaken);
                return;
            }
        }

        private function validateFirstName($fNameToVal){
            if (strlen($fNameToVal) > 25|| strlen($fNameToVal) < 2 ){
                array_push($this->errorArray, Constants::$firstNameChars);
                return;
            }
        }

        private function validateLastName($lNameToVal){
            if (strlen($lNameToVal) > 35 || strlen($lNameToVal) < 2 ){
                array_push($this->errorArray,  Constants::$lastNameChars);
                return;
            }
        }

        private function validateEmails($eMailToVal1, $eMailToVal2){
            if($eMailToVal1 != $eMailToVal2){
                array_push($this->errorArray, Constants::$emailsDoNotMatch);
                return;
            }

            if(!filter_var($eMailToVal1, FILTER_VALIDATE_EMAIL)){
                array_push($this->errorArray, Constants::$emailInvalidFormat);
                return;
            }

            $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email = '$eMailToVal1'");
            if(mysqli_num_rows($checkEmailQuery) != 0){
                array_push($this->errorArray, Constants::$emailTaken);
                return;
            }

        }

        private function validatePaswords($passToVal1, $passToVal2){
            if($passToVal1 != $passToVal2){
                array_push($this->errorArray, Constants::$passwordsDoNotMatch);
                return;
            }

            if(preg_match('/[^A-Za-z0-9]/',$passToVal1)){
                array_push($this->errorArray, Constants::$passwordNotAlphanum);
                return;
            }

            if (strlen($passToVal1) > 30|| strlen($passToVal1) < 5 ){
                array_push($this->errorArray, Constants::$passwordsChars);
                return;
            }

        }


    }
?>