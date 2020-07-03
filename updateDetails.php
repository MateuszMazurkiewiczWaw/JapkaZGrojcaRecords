<?php
include("includes/includedFiles.php");
?>

<div class="userDetails">

    <div class="container borderBottom">
        <h2>Adres email</h2>
        <input type="text" class="email" name="email" placeholder="Adres email..." value="<?php echo $userLoggedIn->getEmail(); ?>">
        <span class="message"></span>
        <button class="button" onclick="updateEmail('email')">ZAPISZ</button>
    </div>

    <div class="container">
        <h2>Haslo</h2>
        <input type="password" class="oldPassword" name="oldPassword" placeholder="Aktualne haslo">
        <input type="password" class="newPassword1" name="newPassword1" placeholder="Nowe haslo">
        <input type="password" class="newPassword2" name="newPassword2" placeholder="Potwierdz haslo">
        <span class="message"></span>
        <button class="button" onclick="updatePassword('oldPassword','newPassword1','newPassword2')">ZAPISZ</button>
    </div>

</div>

