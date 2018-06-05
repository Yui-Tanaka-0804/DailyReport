<?php
require_once("Nippou/Report.php");
session_start();

if(!isset($_SESSION['id']) || $_SESSION['id'] == ""){
	echo "";
}else {
	$num = htmlspecialchars($_POST['num']);

	echo Report::getReport($num);
}
