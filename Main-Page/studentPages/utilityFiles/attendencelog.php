<!-- Deals with attendence log generation -->

<?php
session_start();
include_once "../../connect.php";
include "../../utilityFiles/attendenceLogfunction.php";

$selectSem = $_POST["selectSem"];
$selectSub = $_POST["selectSub"];
$subjectCode = json_decode($_POST["subjectCode"]);
$id = $_SESSION["id"];
$subjectid = $subjectCode[$selectSem - 1][$selectSub];
$fullLog = $_POST["fullLog"];
// $fromDate  =  $_POST["fromDate"];
// $toDate = $_POST["toDate"];


echo attendenceLog($id,$subjectid,$fullLog,$conn);
