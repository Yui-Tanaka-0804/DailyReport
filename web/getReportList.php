<?php
require_once("Nippou/App.php");
require_once("Nippou/Report.php");
session_start();

if(isset($_SESSION['id']) && $_SESSION['id'] != ""){
	$r = new Report();
	$d = htmlspecialchars($_POST['date']);
	echo $r->getReportList($d);
}
