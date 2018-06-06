<?php
require_once("Nippou/App.php");
require_once("Nippou/Report.php");
session_start();

if(isset($_SESSION['id']) && $_SESSION['id'] != ""){
	if(Report::deleteReport($_POST['num'], $_SESSION['id']))
    echo "true";
  else
    echo "false";
}
