<?php

include_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $userDetails = $_POST['userDetails'];
    $attendenceForm = $_FILES["fileToupload"];

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
                    $present = strtolower($data[3]);
                    if ($present == "present") {
                        $attendence[] = 1;
                    } else {
                        $attendence[] = 0;
                    }
                }
                fclose($handle);
            }

            // Connection stuff
            // Fetch semester and then push the data
            $stmt = $conn->prepare("SELECT semester FROM user WHERE subjectCode = ?");
            $stmt->bind_param("")
            $response = [
                "success" => true,
                "message" => "success",
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }
}
