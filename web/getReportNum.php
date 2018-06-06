<?php
require_once("Nippou/Report.php");
session_start();

//if(isset($_SESSION['id']) && $_SESSION['id'] != ""){
  echo Report::getReportNumAll($_POST['date']);
//}
