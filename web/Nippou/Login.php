<?php
require_once("App.php");
require_once("Password.php");

class Login{
	private $id;
	private $pass;

	private static function h($s){
		return htmlspecialchars($s);
	}

	function __construct($id, $pass){
		$p = new Password($pass);
		$this->id = $this->h($id);
		$this->pass = $p->getPassHash();
	}

	function getId(){
		return $this->id;
	}

	function login(){
		try{
			$pdo = App::DB();
			$res = $pdo->prepare("select count(*) from user where id=:id and password=:pass");
			$res->bindParam(":id", $this->id);
			$res->bindParam(":pass", $this->pass);
			$res->execute();

			$row = $res->fetch(PDO::FETCH_NUM)[0];

			if($row == 1){
				return true;
			}else {
				return false;
			}
			$res = null;
			$pdo = null;
			return true;
		}catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}

	}

	function redirect(){
		header("location:index.php");
		exit();
	}
}
