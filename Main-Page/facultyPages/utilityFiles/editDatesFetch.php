<?php
session_start();

include_once "../../connect.php";
include "../../utilityFiles/fetchSubjectDatesFunction.php";


if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    $jsondata = file_get_contents('php://input');
    $dateDetails = json_decode($jsondata, true);

    $subjectCode = $dateDetails["subjectCode"];
    $flag = $dateDetails["flag"];

    $dates = editDatesFetch($conn, $subjectCode, $flag);

    $minDate = $dates["minDate"];
    $maxDate = $dates["maxDate"];

    $response = [
        "success" => true,
        "minDate" => $minDate,
        "maxDate" => $maxDate
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

function editDatesFetch($conn, $subjectCode, $flag)
{
    $minDate = "";
    $maxDate = "";
    $stmt = $conn->prepare("SELECT MIN(date) as minDate, MAX(date) as maxDate FROM attendence WHERE subjectID = ? AND flag = ?");
    $stmt->bind_param("si", $subjectCode, $flag);
    $stmt->execute();
    $stmt->bind_result($minDate, $maxDate);
    $stmt->fetch();
    $stmt->close();

    $dates = [
        "minDate" => $minDate,
        "maxDate" => $maxDate
    ];

    return $dates;
}
