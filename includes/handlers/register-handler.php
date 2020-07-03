<?php

function cleanFormUsername($inputText) {
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ","", $inputText);
    return $inputText;
}

function cleanFormString($inputText) {
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ","", $inputText);
    $inputText = ucfirst(strtolower($inputText));
    return $inputText;
}

function cleanFormPassword($inputText) {
    $inputText = strip_tags($inputText);
    return $inputText;
}

if(isset($_POST['registerButton'])) {
    //nacisnieto button rejestracji
    $username = cleanFormUsername($_POST['username']);
    $firstName = cleanFormString($_POST['firstName']);
    $lastName = cleanFormString($_POST['lastName']);
    $email = cleanFormString($_POST['email']);
    $email2 = cleanFormString($_POST['email2']);
    $password = cleanFormPassword($_POST['password']);
    $password2 = cleanFormPassword($_POST['password2']);

    $successfulRegister = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2);

    if($successfulRegister == true){
        $_SESSION['userLoggedIn'] = $username;
        header("Location: index.php");
    }
}

?>