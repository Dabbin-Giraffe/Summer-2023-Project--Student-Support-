<?php
session_start();
include_once "../../connect.php";
include "../../utilityFiles/attendenceLogfunction.php";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    $jsondata = file_get_contents('php://input');
    $dateDetails = json_decode($jsondata, true);

    $id = $_SESSION["id"];
    $fromDate = $dateDetails["fromDate"];
    $toDate = $dateDetails["toDate"];
    $fullLog = 1;
    $subjectID = $dateDetails["subCode"];

    $tableConstruct = attendenceLog($id, $subjectID, $fullLog, $conn, $fromDate, $toDate);
    
    $response = [
        "success" => true,
        "tableConstruct" => $tableConstruct
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
