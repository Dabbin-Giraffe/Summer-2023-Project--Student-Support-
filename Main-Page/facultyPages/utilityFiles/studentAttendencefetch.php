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
        "result" => $resultData["result"]
    ];

    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
}

function constructTableAttendenceEdit($conn, $subjectID, $studentID)
{

    $html = "";

    $attendence = 0;
    $date = 0;
    $id = 0;
    $classesConducted = 0;
    $present = 0;

    $stmt = $conn->prepare("SELECT id,date,attendence FROM attendence WHERE subjectID = ? AND studentID = ? ORDER BY date DESC");
    $stmt->bind_param("ss", $subjectID, $studentID);
    $stmt->execute();
    $stmt->bind_result($id, $date, $attendence);

    $result = [];
    while ($stmt->fetch()) {
        $classesConducted++;
        if ($attendence == 1) {
            $present++;
        }
        $result[] = [
            'id' => $id,
            'date' => $date,
            'attendence' => $attendence
        ];
    }
    $stmt->close();

    $html .= "<table>
        <tr>
        <th>Sno.</th>
        <th>Date</th>
        <th>Attendance Marked</th>
        <th>Edit Attendence</th>
        </tr>";
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
    $html .= "</table>";
    $data = [
        "html" => $html,
        "result" => $result
    ];
    return $data;
}
