<?php
session_start();

include_once "../../connect.php";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    $attendenceForm = $_FILES["fileToupload"];
    $date =  $_POST["selectDate"];
    $subjectID = $_POST["subjectCode"];
    $subjectName = $_POST["subjectName"];
    $userID = $_POST["userID"];
    $flag = $_POST["flag"];


    if ($attendenceForm["error"] === UPLOAD_ERR_OK) {
        $fileTemppath = $attendenceForm["tmp_name"];
        $fileType = $attendenceForm["type"];
        if ($fileType === "application/vnd.ms-excel" || $fileType === "text/csv") {
            $studentID = [];
            $attendence = [];
            $studentName = [];

            if (($handle = fopen($fileTemppath, "r")) !== false) {
                fgets($handle);
                while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                    $studentID[] = $data[1];
                    $studentName[] = $data[2];
                    // $present = strtolower($data[3]);
                    // if ($present == "present") {
                    //     $attendence[] = 1;
                    // } else {
                    //     $attendence[] = 0;
                    // }
                    $attendence[] = random_int(0, 1);
                }
                fclose($handle);
            }

            $finalResult =  fetchDetails($conn, $studentID, $date, $subjectID, $flag, $attendence, $studentName);

            $response = [
                "success" => true,
                "message" => "[" . $date . "] : successfully uploaded attendence data of students for " . $subjectName . "(" . $subjectID . ")",
                "finalResult" => $finalResult
            ];

            // $response = [
            //     "success" => true,
            //     "finalResult" =>"suc"
            // ];

            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }
}

function fetchDetails($conn, $studentID, $date, $subjectCode, $flag, $attendence, $studentName)
{
    $studentFetchID = [];
    $id = "";
    $stmt = $conn->prepare("SELECT studentID FROM attendence WHERE date = ? and subjectID = ? and flag = ?");
    $stmt->bind_param("ssi", $date, $subjectCode, $flag);
    $stmt->execute();
    $stmt->bind_result($id);
    while ($stmt->fetch()) {
        $studentFetchID[] = $id;
    }
    $stmt->close();

    $editAttendence = [];
    $editNames = [];
    $newIDs = array_diff($studentID, $studentFetchID);
    $editIDs = array_diff($studentID, $newIDs);

    if (count($newIDs) > 0) {

        $uploadID = [];
        $uploadNames = [];
        $uploadAttendence = [];

        foreach ($newIDs as $key => $value) {
            $uploadID[] = $studentID[$key];
            $uploadNames[] = $studentName[$key];
            $uploadAttendence[] = $attendence[$key];
        }
        $uploadResult = newUpload($conn, $uploadID, $uploadAttendence, $date, $subjectCode, $flag);
    } else {
        $uploadResult = false;
    }

    if (count($editIDs) > 0) {
        $editID = [];
        $editNames = [];
        $editAttendence = [];
        foreach ($editIDs as $key => $value) {
            $editID[] = $studentID[$key];
            $editNames[] = $studentName[$key];
            $editAttendence[] = $attendence[$key];
        }
        $editResult = editUpload($conn, $editID, $editAttendence, $date, $subjectCode, $flag);
    } else {
        $editResult = false;
    }

    if ($editResult) {
        $editedVals = [
            "editAttendence" => $editAttendence,
            "editNames" => $editNames,
            "editID" => $editID,
        ];
    } else {
        $editedVals = null;
    }
    if ($uploadResult) {
        $uploadVals = [
            "uploadAttendence" => $uploadAttendence,
            "uploadNames" => $uploadNames,
            "uploadID" => $uploadID
        ];
    } else {
        $uploadVals = null;
    }

    $finalResult = [
        "editVals" => $editedVals,
        "uploadVals" => $uploadVals
    ];

    return $finalResult;
}

function editUpload($conn, $editIDs, $editAttendence, $date, $subjectID, $flag)
{
    foreach ($editIDs as $key => $ID) {
        $stmt = $conn->prepare("UPDATE attendence SET attendence = ? WHERE studentID = ? AND flag = ? AND date = ? AND subjectID = ?");
        $stmt->bind_param("isiss", $editAttendence[$key], $ID, $flag, $date, $subjectID);
        $stmt->execute();
        $stmt->close();
    }
    return true;
}

function newUpload($conn, $newIDs, $newAttendence, $date, $subjectID, $flag)
{
    $semester = 0;

    $stmt = $conn->prepare("SELECT semester FROM subject WHERE subjectCode = ?");
    $stmt->bind_param("s", $subjectID);
    $stmt->execute();
    $stmt->bind_result($semester);
    $stmt->fetch();
    $stmt->close();

    foreach ($newIDs as $index => $ID) {
        $stmt = $conn->prepare("INSERT INTO attendence (studentID,date,attendence,subjectID,semester,flag) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssisii", $ID, $date, $newAttendence[$index], $subjectID, $semester, $flag);
        $stmt->execute();
        $stmt->close();
    }
    return true;
}
