<?php
session_start();
include_once 'authorization.php';
include_once 'templates/header.html';

if(!isset($_SESSION['number']) ||
    (isset($_POST['submit']) && $_POST['submit'] == 'Play Again')){
    $_SESSION['number'] = rand(1, 100);
    $_SESSION['count'] = 1;
 }

$number = $_SESSION['number'];
$userNumber = isset($_POST['userNumber']) ? (int)$_POST['userNumber'] : null;
$username = $_SESSION['username'];

if($userNumber === null){
    include_once 'templates/play-form.html';
    include_once 'templates/footer.html';
    die;
}

if($userNumber != $number){
    $_SESSION['count']++;
    if($userNumber < $number){
        $message = "Up\n";
    } else {
        $message = "Down\n";
    }

    echo "$message <br/><br/>";
    include_once 'templates/play-form.html';
} else {
    echo "Congratulation, $username!<br/>
         You guess number with {$_SESSION['count']} turns<br/><br/>\n";
    include_once 'templates/congratulations.html';
}

include_once 'templates/footer.html';