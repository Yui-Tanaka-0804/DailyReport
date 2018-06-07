<?php
require_once("../web/Nippou/Report.php");
require_once("../web/Nippou/Login.php");

function h($s){
	return htmlspecialchars($s);
}

$id = h($_POST['id']);
$pass = h($_POST['password']);
$team = h($_POST['team']);
$main = h($_POST['main']);

$l = new Login($id, $pass);

if($l->login()){
	echo (Report::newReport($id, $team, $main) + 1);
}else {
	echo "-1";
}

