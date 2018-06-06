<?php
require_once("../web/Nippou/Register.php");

function h($s){
	return htmlspecialchars($s);
}

$id   = h($_POST['id']);
$name = h($_POST['name']);
$pass = h($_POST['password']);

$r = new Register($id, $name, $pass);

if($r->register()){
	echo "true";
}else {
	echo "false";
}

