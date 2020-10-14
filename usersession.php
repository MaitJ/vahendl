<?php
session_start();

//Logime v2lja
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: page.php");
    exit();
}

if (!isset($_SESSION["userid"])) {
    header("Location: page.php");
    exit();
}