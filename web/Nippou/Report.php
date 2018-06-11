<?php
require_once("App.php");
require_once("User.php");
require_once("Team.php");

class Report{

  // 日報リストの取得(JSON)
	public static function getReportList($d){
    $d1 = $d." 00:00:00";
    $d2 = $d." 23:59:59";
		try{
			$pdo = App::DB();
			$res = $pdo->prepare("select * from report where date between :date1 and :date2 ");
			$res->bindParam(":date1", $d1);
			$res->bindParam(":date2", $d2);
			$res->execute();
			// $csv = "";
			// while($row = $res->fetch(PDO::FETCH_ASSOC)){
			// 	$csv .= $row['num'].",";
			// 	$csv .= User::getId($row['userNum']).",";
			// 	$csv .= Team::getName($row['teamNum'])."\n";
			// }

      $arry = array();
      $i = 0;
      while($row = $res->fetch(PDO::FETCH_ASSOC)){
        $a = array("num"=>$row['num'],
                   "userId"=>User::getId($row['userNum']),
                   "teamName"=>Team::getName($row['teamNum']));
        array_push($arry, $a);
      }

			$res = null;
			$pdo = null;
      return json_encode($arry);
		}catch(PDOException $e){
			$e->getMessage();
		}
	}

  // 引数で渡された日報番号の日報を取得(JSON)
	public static function getReport($num){
		try{
			$pdo = App::DB();
			$res = $pdo->prepare("select * from report where num=:num");
			$res->bindParam(":num", $num);
			$res->execute();

			$rep = $res->fetch(PDO::FETCH_ASSOC);
      $arry = array("id"=>User::getId($rep['userNum']),
                    "team"=>Team::getName($rep['teamNum']),
                    "main"=>$rep['main'],
                    "date"=>$rep['date'],
                    "latest"=>$rep['latest']);
      $res = null;
      $pdo = null;
			return json_encode($arry);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}

  // １日の日報の数を１ヶ月分取得
  public static function getReportNumAll($ym){
    $arry = array();
    for($i = 1; $i <= 31; $i++){
      $a = Report::getReportNum($ym."-".$i);
      array_push($arry, $a);
    }

    return json_encode($arry);
  }

  // 引数で渡された日付の日報の数を取得
  public static function getReportNum($d){
    $num = 0;
    $d1 = $d." 00:00:00";
    $d2 = $d." 23:59:59";

    try{
      $pdo = App::DB();
      $res = $pdo->prepare("select count(*) from report where date between :date1 and :date2 ");
      $res->bindParam(":date1", $d1);
      $res->bindParam(":date2", $d2);
      $res->execute();
      $num = $res->fetch(PDO::FETCH_NUM)[0];

      $res = null;
      $pdo = null;
    }catch(PDOException $e){
      $e->getMessage();
    }
    return $num;
  }

  // 日報を作成する
  // 作成に成功した場合 日報番号
  //      失敗した場合 -1
	public static function newReport($writer, $team, $main){
		$userNum = User::getNum($writer);
		$teamNum = Team::getNum($team);
    $num = -2;

		try{
			$pdo = App::DB();
      $res = $pdo->prepare("select max(num) from report");
      $res->execute();
      $num = $res->fetch(PDO::FETCH_NUM)[0];
			$res = $pdo->prepare(
				"insert into report (userNum, teamNum, main, date, latest) values (:userNum, :teamNum, :main, now(), now())"
			);

			$res->bindParam(":userNum", $userNum);
			$res->bindParam(":teamNum", $teamNum);
			$res->bindParam(":main", $main);
			$res->execute();

			$res = null;
			$pdo = null;
		}catch(PDOException $e){
			return $num;
		}
		return $num;
	}

  // 日報を削除する
  // 削除が成功した場合true
  //      失敗した場合false
  public static function deleteReport($num, $writer){
    $userNum = User::getNum($writer);
    try{
      $pdo = App::DB();
      $res = $pdo->prepare("select count(*) from report where num=:num and userNum=:userNum");
      $res->bindParam(":num", $num);
      $res->bindParam(":userNum", $userNum);
      $res->execute();

      $cnt = $res->fetch(PDO::FETCH_NUM)[0];

      // 日報が存在する場合削除する
      if($cnt == 1){
        $res = $pdo->prepare("delete from report where num=:num and usernum=:userNum");
        $res->bindParam(":num", $num);
        $res->bindParam(":userNum", $userNum);
        $res->execute();
      }else {
        return false;
      }
      $res = null;
      $pdo = null;
    }catch(PDOException $e){
      return false;
    }
    return true;
  }

  // 日報を更新する
  // 更新が成功した場合true
  //      失敗した場合false
  public static function rewriteReport($num, $writer, $main){
    $userNum = User::getNum($writer);

    try{
      $pdo = App::DB();

      $res = $pdo->prepare("select count(*) from report where num=:num and userNum=:userNum");
      $res->bindParam(":num", $num);
      $res->bindParam(":userNum", $userNum);
      $res->execute();
      $cnt = $res->fetch(PDO::FETCH_NUM)[0];

      // 日報がある場合メインの内容とlatestの日付を最新に更新する
      if($cnt == 1){
        $res = $pdo->prepare("update report set main=:main, latest=now() where num=:num and userNum=:userNum");
        $res->bindParam(":main", $main);
        $res->bindParam(":num", $num);
        $res->bindParam(":userNum", $userNum);
        $res->execute();
      }else {
        return false;
      }
      $res = null;
      $pdo = null;
    }catch(PDOException $e){
      echo $e->getMessage();
      return false;
    }
    return true;
  }
}
