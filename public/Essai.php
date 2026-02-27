<?php
        session_start();

        require_once('../src/home.php');

        $cookieFin = time() + 60*60*2;          // Pour une durée de vie de 2 heures

        setcookie('login', 'David', $cookieFin);

        echo $_COOKIE['login'];
        session_destroy();

?>