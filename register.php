<?php
include("includes/config.php");
include("includes/classes/Account.php");
include("includes/classes/Constants.php");

$account = new Account($con);
//$account->register();

include("includes/handlers/register-handler.php");
include("includes/handlers/login-handler.php");

function getInputValue($name)
{
    if (isset($_POST[$name])) {
        echo $_POST[$name];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Witamy w serwisie strumieniowania muzyki JapkaZGrojca</title>
    <link rel="stylesheet" type="text/css" href="assets/css/register.css">
    <!-- sciagniete z https://developers.google.com/speed/libraries-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>
<body>
    <?php
        if(isset($_POST['registerButton'])) {
            echo '<script>
                    $(document).ready(function() {
                        $("#loginForm").hide();
                        $("#registerForm").show();
                    });
                 </script>';
        }
        else {
            echo '<script>
                    $(document).ready(function() {
                        $("#loginForm").show();
                        $("#registerForm").hide();
                    });
                 </script>';
        }
    ?>

    <div id="background">
    <div id="loginContainer">
        <div id="inputContainer">
            <form id="loginForm" action="register.php" method="POST">
                <h2>Zaloguj sie na swoje konto</h2>
                <p>
                    <?php echo $account->getError(Constants::$loginFailed); ?>
                    <label for="loginUsername">Nazwa uzytkownika</label>
                    <input id="loginUsername" name="loginUsername" type="text" placeholder="wpisz swoj login"
                           value="<?php getInputValue('loginUsername'); ?>" required>
                </p>
                <p>
                    <label for="loginPassword">Haslo</label>
                    <input id="loginPassword" name="loginPassword" type="password" placeholder="Twoje haslo" required>
                </p>

                <button type="submit" name="loginButton">Zaloguj</button>

                <div class="hasAccountText">
                    <span id="hideLogin">Nie masz jeszcze konta? Zapisz sie tutaj.</span>
                </div>

            </form>


            <form id="registerForm" action="register.php" method="POST">
                <h2>Zaloz darmowe konto</h2>
                <p>
                    <?php echo $account->getError(Constants::$userNameChars); ?>
                    <?php echo $account->getError(Constants::$userNameTaken); ?>
                    <label for="username">Nazwa uzytkownika</label>
                    <input id="username" name="username" type="text" placeholder="wpisz swoj login"
                           value="<?php getInputValue('username'); ?>" required>
                </p>

                <p>
                    <?php echo $account->getError(Constants::$firstNameChars); ?>
                    <label for="firstName">Imie</label>
                    <input id="firstName" name="firstName" type="text" placeholder="wpisz swoje imie"
                           value="<?php getInputValue('firstName'); ?>" required>
                </p>

                <p>
                    <?php echo $account->getError(Constants::$lastNameChars); ?>
                    <label for="lastName">Nazwisko</label>
                    <input id="lastName" name="lastName" type="text" placeholder="wpisz swoje nazwisko"
                           value="<?php getInputValue('lastName'); ?>" required>
                </p>

                <p>
                    <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                    <?php echo $account->getError(Constants::$emailInvalidFormat); ?>
                    <?php echo $account->getError(Constants::$emailTaken); ?>
                    <label for="email">Adres email</label>
                    <input id="email" name="email" type="email" placeholder="wpisz swoj adres email"
                           value="<?php getInputValue('email'); ?>" required>
                </p>

                <p>
                    <label for="email2">Potwierdz email</label>
                    <input id="email2" name="email2" type="email" placeholder="potwierdz swoj adres email"
                           value="<?php getInputValue('email2'); ?>" required>
                </p>

                <p>
                    <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                    <?php echo $account->getError(Constants::$passwordNotAlphanum); ?>
                    <?php echo $account->getError(Constants::$passwordsChars); ?>
                    <label for="password">Haslo</label>
                    <input id="password" name="password" type="password" placeholder="Twoje haslo" required>
                </p>

                <p>
                    <label for="password2">Potwierdz haslo</label>
                    <input id="password2" name="password2" type="password" placeholder="Twoje haslo" required>
                </p>

                <button type="submit" name="registerButton">Zarejestruj</button>

                <div class="hasAccountText">
                    <span id="hideRegister">Masz juz konto? Zaloguj sie tutaj.</span>
                </div>

            </form>
        </div>

        <div id="loginText">
            <h1>Najlepsze Disco Polo, od reki!</h1>
            <h2>Posluchaj najlepszych przebojow JapekZGrojca za darmo!</h2>
            <ul>
                <li>Odkryj najlepsze, sadownicze przeboje w ktorych sie zakochasz</li>
                <li>Tworz wlasne playlisty</li>
                <li>Badz na czasie z przebojami Gangsty</li>
            </ul>

        </div>

    </div>
</div>
</body>
</html>