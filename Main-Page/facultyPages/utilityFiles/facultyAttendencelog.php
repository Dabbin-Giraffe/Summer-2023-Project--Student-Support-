<?php

include_once "../../connect.php";

$selectYearindex = $_POST["selectYearindex"];
$selectSubindex = $_POST["selectSubindex"];

$selectSubcode = $_POST["subjectCode"][$selectYearindex][$selectSubindex];
$selectSubname = $_POST["subjectName"][$selectYearindex][$selectSubindex];
$date =  $_POST["date"];
$studentID = [];
$attendence = [];
$studentName = [];

$stmt = $conn->prepare("SELECT a.studentID,a.attendence,u.firstName,u.lastName FROM attendence a JOIN user u ON a.studentID = u.userID WHERE a.date = ? AND a.subjectID = ?");
$stmt->bind_param("ss", $date, $selectSubcode);
$stmt->execute();
$stmt->bind_result($studentid, $attendencebool, $firstName, $lastName);

while ($stmt->fetch()) {
    $studentID[] = $studentid;
    if ($attendencebool == 1) {
        $attendence[] = "Present";
    } else {
        $attendence[] = "Absent";
    }
    $studentName[] = $firstName . " " . $lastName;
}

?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sno.</th>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Attendence Status</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $html = "";
        $sno = 0;
        for ($i = 0; $i < count($studentID); $i++) {
            $html .= "<tr>";
            $html .= "<td>" . ++$sno . "</td>";
            $html .= "<td>" . $studentID[$i] . "</td>";
            $html .= "<td>" . $studentName[$i] . "</td>";
            $html .= "<td>" . $attendence[$i] . "</td>";
            $html .= "</tr>";
        }
        echo $html;
        ?>
    </tbody>
</table>