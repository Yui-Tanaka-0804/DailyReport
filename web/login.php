<?php
require_once("Nippou/App.php");
require_once("Nippou/Login.php");
session_start();


if(isset($_POST['id']) && $_POST['id'] != "" &&
	 isset($_POST['pass']) && $_POST['pass'] != ""){

	$login = new Login($_POST['id'], $_POST['pass']);

	if($login->login()){
		$_SESSION['id'] = $login->getId();

		$login->redirect();
	}
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/login.css" type="text/css">
	<title>login</title>
</head>
<body>

<div id="header">
	login
</div>

<div id="main">
	<form action="login.php" method="POST">
		<input type="text" name="id" placeholder="id"><br>
		<input type="password" name="pass" placeholder="password"><br>
		<input type="submit" value="login">
	</form>
	<a href="register.php">登録する</a>
</div>
</body>
</html>
