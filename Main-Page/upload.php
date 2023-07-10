<?php

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $userDetails = $_POST['userDetails'];
    $attendenceForm = $_FILES["fileToupload"];

    if ($attendenceForm["error"] === UPLOAD_ERR_OK) {

        $fileTemppath = $attendenceForm["tmp_name"];
        $fileType = $attendenceForm["type"];
        if ($fileType === "application/vnd.ms-excel" || $fileType === "text/csv") {
            $studentID = [];
            $attendence = [];

            if (($handle = fopen($fileTemppath, "r")) !== false) {
                fgets($handle);
                while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                    $studentID[] = $data[1];
                    $attendence[] = $data[3];
                }
            }

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
