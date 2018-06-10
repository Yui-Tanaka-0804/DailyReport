<?php
require_once("../web/Nippou/Report.php");
require_once("../web/Nippou/Login.php");

function h($s){
	return htmlspecialchars($s);
}

$id = h($_POST['id']);
$pass = h($_POST['password']);
$num = h($_POST['num']);
$main = h($_POST['main']);

$l = new Login($id, $pass);

if($l->login()){
	if(Report::rewriteReport($num, $id, $main)){
		echo "true";
	}else {
		echo "false";
	}
}else {
	echo "false";
}

