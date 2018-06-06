<?php
require_once("Nippou/App.php");

session_start();

if(!isset($_SESSION['id']) || $_SESSION['id'] == ""){
	header("location: login.php");
	exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/css.css" type="text/css">
	<title><?php echo App::APP_NAME; ?></title>
</head>
<body>

<div id="header">
	<div id="appname">
		<?php echo App::APP_NAME; ?>
	</div>

  <div id="userid">
  <?php
  echo $_SESSION['id'];
  ?>
  </div>
  <div id="logout" onclick="logout();">
    logout
  </div>
  <div id="newReportButton" onclick="newReport()">
    ＋ New Report
  </div>
  <div id="newTeamButton">
    ＋ New Team
  </div>

</div>

<div id="main">
	<div id="calendar">

	</div>

	<div id="list">
	</div>

	<div id="report">
	</div>

	<div id="newreport">
    <select id="">
      <option>Personal</option>
    </select>
    <div id="writer" style="display: inline;"></div>
		<div id="newreport_main" contenteditable="true" placeholder="write here"></div>
    <input id="newreportsubmit" type="button" value="submit">
	</div>
</div>

<script src="js/jquery.min.js"></script>
<script>

let date = new Date();
let today = new Date().getDate();

const id = "<?php echo $_SESSION['id']; ?>";

const showCalendar = function(){
	const cal = document.getElementById("calendar");
  const week = ["日", "月", "火", "水", "木", "金", "土"];
	let d = new Date(date.getFullYear(), date.getMonth() + 1, 0);
	let sd = new Date(date.getFullYear(), date.getMonth(), 1);
	const day = sd.getDay();
  $.post("getReportNum.php", {"date": date.getFullYear() + "-" + (date.getMonth() + 1)}, function(r){
      const numList = JSON.parse(r);


  	cal.innerHTML = "<div id='calendar_title'><button onclick='prevMonth()'>&lt;</button>" + (date.getMonth() + 1) + "月<button onclick='nextMonth()'>&gt;</button></div>";
    for(let i = 0; i < week.length; i++){
      cal.innerHTML += "<div class='header'>" + week[i] + "</div>";
    }
  	for(let i = 0; i < day; i++){
  		cal.innerHTML += "<div class='li'></div>";
  	}

  	for(let i = 0; i < d.getDate(); i++, sd.setDate(sd.getDate() + 1)){
      let s = "<div ";
      if(today == sd.getDate()){
      s += "style='height: 33px; border-bottom: 4px solid #63ff44'";
      }
      r = numList[i];
      if(r == 0) r = "";
      s += " class='li' onclick='changeDate(" + (i + 1) + ")'>" + (i + 1) + "<br>" + r + "</div>";
      cal.innerHTML += s;
      if(sd.getDay() % 7 == 0) cal.innerHTML += "<br>";
  	}
  });
}

const nextMonth = function(){
  date.setMonth(date.getMonth() + 1);
  today = date.getDate();
  showCalendar();
  getReportList();
}

const prevMonth = function(){
  date.setMonth(date.getMonth() - 1);
  today = date.getDate();
  showCalendar();
  getReportList();
}

const changeDate = function(n){
  date.setDate(n);
  today = n;
  showCalendar();
  getReportList();
}

const getReportList = function(){
	let d = new Date(date.getFullYear(), date.getMonth() + 1, 0);
	const dt = date.getFullYear() + "-" + (date.getMonth()+1) + "-" +date.getDate();

	$.post("getReportList.php", {'date': dt}, function(r){
    let list = JSON.parse(r);
    let s = "";

		s += "<ul>";

		for(let i = 0; i < list.length; i++){
			let num = list[i]['num'];
			let writer = list[i]['userId'];
			let team = list[i]['teamName'];
			if(team == "") team = "Personal";
			if(num == undefined || writer == undefined || team == undefined) continue;
			s += "<a href='#' onclick='showReport(" + num + ")'><li>[" + team + "] " + writer + "</li></a>";
		}
		s += "</ul>";
		document.getElementById("list").innerHTML = s;
	});
}

const showReport = function(n){
	$.post("getReport.php", {"num": n}, function(r){
		// const rep = r.split(',');
		// const writer = rep[0];
		// const team = rep[1];
		// const main = rep[2];
		// const datetime = rep[3];
		// const latest = rep[4];
    const rep = JSON.parse(r);
    const writer = rep['id'];
    const team = rep['team'];
    const main = rep['main'];
    const datetime = rep['date'];
    const latest = rep['latest'];

		let area = document.getElementById("report");
    let s = ";";

		s = "<div id='report_title'>[" + team + "] " + writer + "</div>";
    if(id == writer){
      s += "<div id='report_command'>"
          +"<input type='button' value='編集' onclick='rewrite(" + n + ")'>"
          +"<input type='button' value='削除' onclick='deleteReport(" + n + ")'>"
          +"</div>";
    }
		s += "<div id='report_dates'>"
                    +     "<div id='report_make_date'>作成　　　:" + datetime + "</div>"
                    +   "<div id='report_latest_date'>最終更新日:" + latest + "</div>"
                    + "</div>"
		                + "<div id='report_main'>" + main + "</div>";
    area.innerHTML = s;
    $("#newreport").hide();
    $("#report").show();
	});
}

const newReport = function(){
  $("#writer").html(" <?php echo $_SESSION['id']; ?>");
	$("#newreport").show();
	$("#report").hide();
}

const resetNewReport = function(){
  document.getElementById("newreport_main").innerHTML = "";
}

document.getElementById("newreportsubmit").onclick = function(){
  const writer = id;
  const team = "";
  const main = document.getElementById("newreport_main").innerHTML;
  $.post("newReport.php", {"writer": writer, "team": team, "main": main}, function(r){
    if(r >= 0){
      alert("完了しました");
      resetNewReport();
      getReportList();
      showReport(r);
    }else {
      alert("失敗しました");
    }
  });
}

const rewrite_stop = function(n){
  const f = confirm("終了しますか?");
  if(f){
    document.getElementById("report_main").contentEditable = false;
    showReport(n);
  }
}

const rewrite_save = function(n){
  const writer = id;
  const main = document.getElementById("report_main").innerHTML;
  $.post("rewriteReport.php", {"num": n, "main": main}, function(r){
    if(r == "true"){
      alert("完了しました");
    }else {
      alert("失敗しました");
    }
    showReport(n);
  })
}

const rewrite = function(n){
  const rc = document.getElementById("report_command");
  rc.innerHTML = "<input type='button' value='保存' onclick='rewrite_save(" + n + ")'>"
                +"<input type='button' value='キャンセル' onclick='rewrite_stop(" + n + ")'>";
  document.getElementById("report_main").contentEditable = true;
}

const deleteReport = function(n){
  const f = confirm("削除しますか?");
  if(f){
    $.post("deleteReport.php", {"num": n}, function(r){
      if(r == "true"){
        alert("削除しました");
        resetNewReport();
        getReportList();
        document.getElementById("report").innerHTML = "";
      }else {
        alert("削除に失敗しました");
      }
    });
  }
}

const logout = function(){
  location.href = "logout.php";
}

showCalendar();
getReportList();
</script>
</body>
</html>
