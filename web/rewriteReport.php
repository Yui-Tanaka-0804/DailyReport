<?php
require_once("Nippou/App.php");
require_once("Nippou/Report.php");
session_start();

if(isset($_SESSION['id']) && $_SESSION['id'] != ""){
	if(Report::rewriteReport($_POST['num'], $_SESSION['id'], $_POST['main']))
    echo "true";
  else
    echo "false";
}
