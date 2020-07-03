<?php
include("includes/config.php");
include("includes/classes/User.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");
include("includes/classes/Playlist.php");

//session_destroy(); //tymczasowe wylogowywanie

if(isset($_SESSION['userLoggedIn'])){
    $userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
    $userName = $userLoggedIn->getUsername();

    echo "<script>userLoggedIn = '$userName';</script>";
}
else {
    header("Location: register.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Witaj w serwisie Japka z Grojca Records!</title>
    <link rel="stylesheet" type="text/css" href="assets/css/index.css">
    <!-- sciagniete z https://developers.google.com/speed/libraries-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="assets/js/script.js"></script>
</head>
<body>

    <!--
    <script>
        var audioElement = new Audio();
        audioElement.setTrack("assets/music/DanceAtTheMoonlight.mp3");
        audioElement.audio.play();
    </script>
    -->

    <div id="mainContainer">
        <div id="topContainer">
        <?php include("includes/navBarContainer.php"); ?>

            <div id="mainViewContainer">

                <div id="mainContent">