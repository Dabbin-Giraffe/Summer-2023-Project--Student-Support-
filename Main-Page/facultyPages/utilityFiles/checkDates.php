<?php
session_start();

include_once "../../connect.php";
include "../../utilityFiles/fetchSubjectDatesFunction.php";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    $jsondata = file_get_contents('php://input');
    $dateDetails = json_decode($jsondata, true);

    $subjectCode = $dateDetails["subjectCode"];
    $flag = $dateDetails["flag"];
    $selectDate = $dateDetails["selectDate"];

    $count = checkDates($conn, $subjectCode, $selectDate, $flag);

    $response = [
        "success" => true,
        "count" => $count
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

function checkDates($conn, $subjectCode, $selectDate, $flag)
{
    $count = 0;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM attendence WHERE subjectID = ? AND date = ? AND flag = ?");
    $stmt->bind_param("ssi", $subjectCode, $selectDate, $flag);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    return $count;
}
