<?php
require_once("App.php");

class Password{
	private $password;

	function __construct($password){
		$this->password = htmlspecialchars($password);
	}

	function getPassHash(){
		return hash(
			"sha256", 
			App::$PASS_B_SALT . $this->password . App::$PASS_A_SALT);
	}
}
