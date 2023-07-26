<?php

include_once "../../connect.php";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    // $userDetails = $_POST['userDetails'];

    $subIndexselect = $_POST["subIndexselect"];
    $yearIndexselect = $_POST["yearIndexselect"];
    $attendenceForm = $_FILES["fileToupload"];
    $date =  $_POST["date"];
    $subjectID = $_POST["subjectCode"];
    $subjectName = $_POST["subjectName"];
    $userID = $_POST["userID"];

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

            // Connection stuff
            // Fetch semester
            $stmt = $conn->prepare("SELECT semester FROM subject WHERE subjectCode = ?");
            $stmt->bind_param("s", $subjectID);
            $stmt->execute();
            $stmt->bind_result($semester);
            $stmt->fetch();
            $stmt->close();

            $stmt = $conn->prepare("SELECT flag FROM faculty WHERE userID = ? and subjectCode = ?");
            $stmt->bind_param("ss", $userID, $subjectID);
            $stmt->execute();
            $stmt->bind_result($flag);
            $stmt->fetch();
            $stmt->close();

            //Pushing attendence data
            foreach ($studentID as $index => $ID) {
                $stmt = $conn->prepare("INSERT INTO attendence (studentID,date,attendence,subjectID,semester,flag) VALUES (?,?,?,?,?,?)");
                $stmt->bind_param("ssisii", $ID, $date, $attendence[$index], $subjectID, $semester, $flag);
                if (!($stmt->execute())) {
                    $response = [
                        "success" => false,
                        "message" => "There was problem with uploading the data",
                    ];
                }
            }
            $response = [
                "success" => true,
                "message" => "[" . $date . "] : successfully uploaded attendence data of " . count($attendence) . " students for" . $subjectName . "(" . $subjectID . ")",
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }
}
