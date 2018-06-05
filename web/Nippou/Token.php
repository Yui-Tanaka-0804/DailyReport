<?php
require_once("App.php");

class Token{
	private $id;
	private $token;

	function __construct($id){
		$this->id = $id;
	}

	function makeToken(){
		$this->token = bin2hex(openssl_random_pseudo_bytes(App::TOKEN_LEN));
	}

	// トークンをサーバに登録する
	function setToken(){
		try{
			$pdo = new PDO(
						 "mysql:host=".App::DB_HOST
						.";dbname=".App::DB_NAME,
						App::DB_USER,
						App::DB_PASS);
			
			$res = $pdo->prepare("insert into token(id, token) values(:id, :token)");
			$res->bindParam(":id", $this->id);
			$res->bindParam(":token", $this->token);
			$res->execute();

			$res = null;
			$pdo = null;
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}

	function getToken(){
		return $this->token;
	}

	function checkToken($token){
		try{
			$pdo = new PDO(
						"mysql:host=".App::DB_HOST,
						";dbname=".App::DB_NAME,
						App::DB_USER,
						App::DB_PASS);
			
			$res = $pdo->prepare("select token from token where id=:id");
			$res->bindParam(":id", $this->id);
			$res->execute();

			while($row = $res->fetch(PDO::FETCH_ASSOC)){
				if($row['token'] == $token) return true;
			}
			$res = null;
			$pdo = null;
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		return false;
	}

}
