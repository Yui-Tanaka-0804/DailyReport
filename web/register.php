<?php
require_once("Nippou/Register.php");
session_start();
if(isset($_POST['id']) && $_POST['id'] != ""
	&& isset($_POST['name']) && $_POST['name'] != ""
	&& isset($_POST['pass']) && $_POST['pass'] != ""){

	$r = new Register($_POST['id'], $_POST['name'], $_POST['pass']);

	$ret = $r->register();
	if($ret){
		echo "登録完了";
		$_SESSION['id'] = htmlspecialchars($_POST['id']);
		header("location: index.php");
		exit();
	}else {
		echo $ret;
	}
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/login.css" type="text/css">
	<title>register</title>
</head>
<body>

<form action="register.php" method="POST">
	<input type="text" name="id" placeholder="id"><br>
	<input type="text" name="name" placeholder="name"><br>
	<input type="password" name="pass" placeholder="password"><br>
	<input type="submit" value="register">
</form>
</body>
</html>
