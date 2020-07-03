<?php

if(isset($_POST['loginButton'])) {
    //nacisnieto button login
    $username = $_POST['loginUsername'];
    $password = $_POST['loginPassword'];

    $result = $account->login($username, $password );
    if (result == true){
        $_SESSION['userLoggedIn'] = $username;
        header("Location: index.php");
    }

}

?>