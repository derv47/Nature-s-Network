<?php 
session_start();
$_SESSION['username'] = null;
$_SESSION['coins'] = null;
header('location: main.php');
?>