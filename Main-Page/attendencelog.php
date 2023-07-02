<?php
session_start();
$selectSem = $_POST["selectSem"];
$selectSub = $_POST["selectSub"];
$subjectCode = json_decode($_POST["subjectCode"]);
$id = $_SESSION["id"];
$subjectid = $subjectCode[$selectSem - 1][$selectSub];
$classesConducted = $_SESSION["classesConducted"];

$date = [];
$attendence = [];

include_once "connect.php";
$stmt = $conn->prepare("SELECT date,attendence FROM attendence WHERE semester = ? AND subjectID = ? AND studentID = ? ORDER BY date DESC LIMIT 10");
$stmt->bind_param("iss", $selectSem, $subjectid, $id);
$stmt->execute();
$stmt->bind_result($date, $attendence);

$result = [];
while ($stmt->fetch()) {
    $result[] = [
        'date' => $date,
        'attendence' => $attendence
    ];
}

$stmt->close();
// print_r($result);
?>

<table>
    <tr>
        <th>Date</th>
        <th>Attendence Status</th>
        <th>Class Number</th>
    </tr>

    <?php
    foreach ($result as $value) {
        echo "<tr>";
        echo "<td>" . $value["date"] . "</td>";
        if ($value["attendence"] == 1) {
            echo "<td>present</td>";
        }else{
            echo "<td>Absent</td>";
        }
        echo "<td>" . $classesConducted-- . "</td>";
    }
    ?>


</table>