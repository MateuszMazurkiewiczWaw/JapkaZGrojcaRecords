<?php

?>

<div id="navBarContainer">
    <nav class="navBar">
        <span role="link" tabindex="0" onclick="openPage('index.php')" class="logo"> <!--a href="index.php" -->
            <img src="assets/images/icons/kuba1.png">
        </span>

        <div class="group">
            <div class="navItem">
                <span role='link' tabindex='0' onclick='openPage("search.php")' class="navItemLink">
                    Szukaj<img src="assets/images/icons/search.png" class="icon" alt="Szukaj">
                </span>
            </div>
        </div>

        <div class="group">
            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink">Przegladaj</span>
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink">Twoja muza</span>
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('profile.php')" class="navItemLink"><?php echo $userLoggedIn->getFirstAndLastName(); ?></span>
            </div>
        </div>

    </nav>
</div>
