<?php
session_start();
include_once "../../connect.php";
include "../../utilityFiles/attendenceLogfunction.php";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    $jsondata = file_get_contents('php://input');
    $Details = json_decode($jsondata, true);

    $studentID = $Details["studentID"];
    $yearIndexselect = $Details["yearSelectIndex"];
    $subIndexselect = $Details["subSelect"];
    $subjectID = $Details["subCode"];
    $year = $Details["year"];

    $constructTable = attendenceLog($studentID, $subjectID, 1, $conn);

    $response = [
        "success" => true,
        "message" => "lol",
        "table" => $constructTable
    ];

    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
}
