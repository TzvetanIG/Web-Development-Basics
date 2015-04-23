<?php
if(isset($_POST['username']) && $_POST['username'] != ''){
    $_SESSION['username'] = $_POST['username'];
}

if(!isset($_SESSION['username'])){
    header('Location: index.php');
    die;
}
