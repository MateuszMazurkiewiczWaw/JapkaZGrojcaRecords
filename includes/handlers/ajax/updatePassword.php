<?php
include("../../config.php");

if (!isset($_POST['username'])) {
    echo "Blad: nie mozna ustawic nazwy uzytkownika (username)";
    exit();
}

if (!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])) {
    echo "Nie ustawiono wszystkich wartosci dla hasel";
    exit();
}

if ($_POST['oldPassword'] == "" || $_POST['newPassword1'] == "" || $_POST['newPassword2'] == "") {
    echo "Prosze uzupelnic wszystkie wartosci dla hasel";
    exit();
}

$username = $_POST['username'];
$oldPassword = $_POST['oldPassword'];
$newPassword1 = $_POST['newPassword1'];
$newPassword2 = $_POST['newPassword2'];

$oldMd5 = md5($oldPassword);

$passwordCheck = mysqli_query($con, "SELECT * FROM users WHERE username = '$username' AND password = '$oldMd5'");
if (mysqli_num_rows($passwordCheck) != 1) {
    echo "Nie poprawne haslo";
    exit();
}

if ($newPassword1 != $newPassword2) {
    echo "Oba hasla musza byc takie same";
    exit();
}

if (preg_match('/[^A-Za-z0-9]/', $newPassword1)) {
    echo "Twoje haslo musi zawierac jedynie litery i cyfry";
    exit();
}

if (strlen($newPassword1) > 30 || strlen($newPassword1) < 5) {
    echo "Twoje haslo musi zawierac od 5 do 30 znakow";
    exit();
}

$newMd5 = md5($newPassword1);

$query = mysqli_query($con, "UPDATE users SET password = '$newMd5' WHERE username = '$username'");
echo "Haslo zostalo poprawnie zaktualizowane";


?>













