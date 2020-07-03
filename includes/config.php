<?php
    ob_start();
    //zmienne sesyjne
    session_start();

    $timezone = date_default_timezone_set("Europe/Warsaw");

    $con = mysqli_connect("localhost", "root", "", "japka_z_grojca_records");

    if(mysqli_connect_errno()){
        echo "Blad polaczenia z baza danych: ". mysqli_connect_errno();
    }

?>