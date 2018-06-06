<?php
session_start();

$_SESSION['id'] = "";

header("location: login.php");
exit();

