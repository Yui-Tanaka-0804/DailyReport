<?php
require_once("../web/Nippou/Login.php");

function h($s){
	return htmlspecialchars($s);
}

$id = h($_POST['id']);
$pass = h($_POST['password']);
$l = new Login($id, $pass);

if($l->login()){
	echo "true";
}else {
	echo "false";
}
