<?php

include_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    $jsondata = file_get_contents('php://input');
    $userDetails = json_decode($jsondata,true);

    $selectSubCode = $userDetails["selectSubCode"];
    $flag = $userDetails["flag"];

    $stmt = $conn->prepare("SELECT MAX(date) AS highest_date, MIN(date) AS lowest_date
    FROM attendence
    WHERE subjectID = ? AND flag = ?");
    $stmt->bind_param("si", $selectSubCode, $flag);
    $stmt->execute();
    $stmt->bind_result($startDate, $endDate);
    $stmt->fetch();
    $stmt->close();

    $response = [
        "success" => true,
        "startDate" => $startDate,
        "endDate" => $endDate
        // "startDate" => "123",
        // "endDate" => "ppotato"
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
