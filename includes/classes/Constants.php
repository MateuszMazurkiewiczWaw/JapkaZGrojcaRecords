<?php
    class Constants {
        //Bledy rejestracji
        public static $passwordsDoNotMatch = "Nieprawidlowa wartosc - wprowadzone hasla musza byc takie same";
        public static $passwordNotAlphanum = "Nieprawidlowa wartosc - haslo powinno zawierac jedynie litery i liczby";
        public static $passwordsChars = "Nieprawidlowa wartosc - haslo musi zawierac minimum 2, maksimum 25 znakow";
        public static $emailInvalidFormat = "Nieprawidlowa wartosc - nieprawidlowy format adresu email";
        public static $emailsDoNotMatch = "Nieprawidlowa wartosc - adresy email musza byc takie same";
        public static $emailTaken = "Podany email jest juz zajety - sproboj ponownie";
        public static $lastNameChars = "Nieprawidlowa wartosc - nazwisko uzytkownika musi zawierac minimum 2, maksimum 25 znakow";
        public static $firstNameChars = "Nieprawidlowa wartosc - imie uzytkownika musi zawierac minimum 2, maksimum 25 znakow";
        public static $userNameChars = "Nieprawidlowa nazwa uzytkownika - login musi zawierac minimum 5, maksimum 25 znakow";
        public static $userNameTaken = "Podany login jest juz zajety - sproboj ponownie";
        //Bledy logowania
        public static $loginFailed = "Twoj login lub haslo byly niepoprawne";
    }
?>

