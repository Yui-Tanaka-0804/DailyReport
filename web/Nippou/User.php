<?php
require_once("App.php");

class User{

  // userNumからIdを取得
	public static function getId($num){
		try{
			$pdo = App::DB();
			$res = $pdo->prepare("select id from user where num=:num");
			$res->bindParam(":num", $num);
			$res->execute();
			$id = $res->fetch(PDO::FETCH_NUM)[0];
			$res = null;
			$pdo = null;
			return $id;
		}catch(PDOException $e){
			return "";
		}
	}

  // IdからuserNumを取得
	public static function getNum($id){
		try{
			$pdo = App::DB();
			$res = $pdo->prepare("select num from user where id=:id");
			$res->bindParam(":id", $id);
			$res->execute();
			$num = $res->fetch(PDO::FETCH_NUM)[0];
			$res = null;
			$pdo = null;
			return $num;
		}catch(PDOException $e){
			return "";
		}
	}

  // 引数で渡されたユーザーが存在するか
	public static function userExists($id){
		try{
			$pdo = App::DB();
			$res = $pdo->prepare("select count(*) from user where id=:id");
			$res->bindParam(":id", $id);
			$res->execute();

			$n = $res->fetch(PDO::FETCH_NUM)[0];

			if($n == 0) return false;
			else return true;
		}catch(PDOException $e){
			return false;
		}
	}
}
