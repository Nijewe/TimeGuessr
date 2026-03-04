<?php
session_start();

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

$pages = [
    'home'   => '../src/home.php',
    'quiz'   => '../src/quiz.php',
    'answer' => '../src/answer.php',
    'end'    => '../src/end.php',
];

if (array_key_exists($page, $pages)) {
    require_once $pages[$page];
} else {
    require_once '../src/home.php';
}
