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

    $resultData = constructTableAttendenceEdit($conn, $subjectID, $studentID);

    $response = [
        "success" => true,
        "message" => "lol",
        "table" => $resultData["html"],
        "result" => $resultData["result"],
        "studentName" => $resultData["studentName"],
        "studentYear" => $resultData["studentYear"]
    ];

    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
}

function constructTableAttendenceEdit($conn, $subjectID, $studentID)
{
    $html = "";

    $details = fetchAttendenceDetails($subjectID, $studentID, $conn);
    $result = $details["attendenceDetails"];
    $studentDetails = $details["studentDetails"];

    $html .= "<table class = 'table table-bordered'>
    <thead>
        <tr>
        <th>Sno.</th>
        <th>Date</th>
        <th>Attendance Marked</th>
        <th>Edit Attendence</th>
        </tr>
        </thead><tbody>";
    $sno = 1;

    foreach ($result as $value) {
        $html .= "<tr>";
        $html .= "<td>" . $sno++ . "</td>";
        $html .= "<td>" . $value["date"] . "</td>";
        if ($value["attendence"]) {
            $html .= "<td>Present</td>";
            $html .= "<td><input type='radio' class = 'attendenceRadio' id='" . $value['id'] . "+present' name='" . $value['id'] . "' value='1' checked>";
            $html .= "<label for='" . $value['id'] . "'>Present</label>";
            $html .= "<input type='radio' class = 'attendenceRadio' id='" . $value['id'] . "+absent'name='" . $value['id'] . "' value='0'>";
            $html .= "<label for='" . $value['id'] . "'>Absent</label></td>";
        } else {
            $html .= "<td>Absent</td>";
            $html .= "<td><input type='radio' class = 'attendenceRadio' id='" . $value['id'] . "+present'name='" . $value['id'] . "' value='1' >";
            $html .= "<label for='" . $value['id'] . "'>Present</label>";
            $html .= "<input type='radio' class = 'attendenceRadio' id='" . $value['id'] . "+absent'name='" . $value['id'] . "' value='0' checked>";
            $html .= "<label for='" . $value['id'] . "'>Absent</label></td>";
        }
        $html .= "</tr>";
    }
    $html .= "</tbody></table>";
    $data = [
        "html" => $html,
        "result" => $result,
        "studentName" => $studentDetails["studentName"],
        "studentYear" => $studentDetails["year"]
    ];
    return $data;
}

function fetchAttendenceDetails($subjectID, $studentID, $conn)
{

    $id = 0;
    $date = "";
    $attendence = 0;
    $classesConducted = 0;
    $present = 0;

    $stmt = $conn->prepare("SELECT id,date,attendence FROM attendence WHERE subjectID = ? AND studentID = ? ORDER BY date DESC");
    $stmt->bind_param("ss", $subjectID, $studentID);
    $stmt->execute();
    $stmt->bind_result($id, $date, $attendence);

    $attendenceDetails = [];
    while ($stmt->fetch()) {
        $classesConducted++;
        if ($attendence == 1) {
            $present++;
        }
        $attendenceDetails[] = [
            'id' => $id,
            'date' => $date,
            'attendence' => $attendence
        ];
    }
    $stmt->close();

    $studentDetails = fetchStudentDetails($conn, $studentID);

    $result = [
        "attendenceDetails" => $attendenceDetails,
        "studentDetails" => $studentDetails
    ];

    return $result;
}

function fetchStudentDetails($conn, $studentID)
{

    $firstName = "";
    $lastName = "";
    $year = 0;
    $flag = 0;

    $stmt = $conn->prepare("SELECT firstName, lastName, flag FROM user WHERE userID = ?");
    $stmt->bind_param("s", $studentID);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName, $flag);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT role FROM flag WHERE flag = ?");
    $stmt->bind_param("i", $flag);
    $stmt->execute();
    $stmt->bind_result($year);
    $stmt->fetch();
    $stmt->close();

    $studentDetails = [
        "studentName" => $firstName . " " . $lastName,
        "year" => $year
    ];
    return $studentDetails;
}
