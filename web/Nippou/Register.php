<?php
require_once("App.php");
require_once("Password.php");
require_once("User.php");
require_once("Team.php");

class Register{
	private $id;
	private $name;
	private $passhash;

	private function h($s){
		return htmlspecialchars($s);
	}

	public function __construct($id, $name, $password){
		$p = new Password($password);
		$this->id = $this->h($id);
		$this->name = $this->h($name);
		$this->passhash = $p->getPassHash();
	}

	public function register(){
		try{

			if(!User::userExists($this->id)){
				$pdo = App::DB();
				$res = $pdo->prepare("insert into user(id, name, password) values(:id, :name, :password)");
				$res->bindParam(":id", $this->id);
				$res->bindParam(":name", $this->name);
				$res->bindParam(":password", $this->passhash);
				$res->execute();

				$res = null;
				$pdo = null;
				return true;
			}

		}catch(PDOException $e){
      echo "Error";
			return false;
		}
		return false;
	}
}
