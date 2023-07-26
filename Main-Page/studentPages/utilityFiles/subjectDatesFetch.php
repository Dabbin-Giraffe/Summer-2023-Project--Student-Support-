<?php
session_start();

include_once "../../connect.php";
include "../../utilityFiles/fetchSubjectDatesFunction.php";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    $jsondata = file_get_contents('php://input');
    $dateDetails = json_decode($jsondata, true);

    $subjectCode = $dateDetails["subjectCode"];
    $flag = $dateDetails["flag"];

    $dates = fetchSubjectDatesFunction($conn, $subjectCode, $flag);

    $startDate = $dates["startDate"];
    $endDate = $dates["endDate"];

    $response = [
        "success" => true,
        "startDate" => $startDate,
        "endDate" => $endDate
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
