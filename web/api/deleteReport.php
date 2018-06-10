<?php
require_once("../Nippou/Report.php");
require_once("../Nippou/Login.php");

function h($s){
	return htmlspecialchars($s);
}

$id = h($_POST['id']);
$pass = h($_POST['password']);
$num = h($_POST['num']);

$l = new Login($id, $pass);

if($l->login()){
	if(Report::deleteReport($num, $id)){
		echo "true";
	}else {
		echo "false";
	}
}else {
	echo "false";
}

