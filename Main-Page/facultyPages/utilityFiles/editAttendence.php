<?php
session_start();
include_once "../../connect.php";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    $jsondata = file_get_contents('php://input');
    $Details = json_decode($jsondata, true);

    $studentID = $Details["studentID"];
    $yearIndexselect = $Details["yearSelectIndex"];
    $subIndexselect = $Details["subSelect"];
    $subjectID = $Details["subCode"];
    $year = $Details["year"];
    $defaultAttendence = $Details["defaultAttendence"];
    $changedAttendence = $Details["changedAttendence"];

    
    $changeStatus = uploadData($conn, $defaultAttendence, $changedAttendence);

    $response = [
        "success" => true,
        "changedVals" => $changeStatus
    ];

    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
}

function uploadData($conn, $defaultAttendence, $changedAttendence)
{
    $changedVals = [];

    for ($i = 0; $i < count($changedAttendence); $i++) {
        if ($defaultAttendence[$i]["attendence"] != $changedAttendence[$i]["attendence"]) {
            $changedVals[] = [
                "id" => $changedAttendence[$i]["id"],
                "attendence" => $changedAttendence[$i]["attendence"]
            ];
        }
    }

    foreach ($changedVals as $value) {
        $stmt = $conn->prepare("UPDATE attendence SET attendence = ? WHERE id = ?");
        $stmt->bind_param("ii", $value["attendence"], $value["id"]);
        $stmt->execute();
        $stmt->close();
    }
    return "success";
}
