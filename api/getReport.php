<?php
require_once("../web/Nippou/Report.php");
require_once("../web/Nippou/Login.php");

function h($s){
	return htmlspecialchars($s);
}

$id = h($_POST['id']);
$pass = h($_POST['password']);
$num = h($_POST['num']);

$l = new Login($id, $pass);

if($l->login()){
	echo Report::getReport($num);
}

