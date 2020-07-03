<?php
include("../../config.php");

if(!isset($_POST['username'])) {
    echo "Blad: nie mozna ustawic nazwy uzytkownika (username)";
    exit();
}

if(isset($_POST['email']) && $_POST['email'] != "") {

    $username = $_POST['username'];
    $email = $_POST['email'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adres email jest niepoprawny";
        exit();
    }

    $emailCheck = mysqli_query($con, "SELECT email FROM users WHERE email = '$email' AND username != '$username'");
    if (mysqli_num_rows($emailCheck) > 0) {
        echo "Adres email jest juz uzywany";
        exit();
    }

    $updateQuery = mysqli_query($con, "UPDATE users SET email = '$email' WHERE username = '$username'");
    echo "Zmiana adresu email powiodla sie!";
}
else {
    echo "Blad: musisz wprowadzic adres email";
}

?>













