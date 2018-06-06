<?php
require_once("Nippou/App.php");
require_once("Nippou/Report.php");
session_start();

if(!isset($_SESSION['id']) || $_SESSION['id'] == ""){
  header("location: login.php");
  exit();
}

echo (Report::newReport($_POST['writer'], $_POST['team'], $_POST['main']) + 1);
