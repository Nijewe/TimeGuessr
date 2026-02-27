<?php


    session start();

    require_once("../src/home.php");

    $paths = [
        'answer' => '../src/answer.php',
        'end'=> '',
    ]


    session_destroy();


?>