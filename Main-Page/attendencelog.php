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
$present = 0;
while ($stmt->fetch()) {
    if ($attendence == 1) {
        $present++;
    }
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
        <th>Attendended Classes</th>
        <th>Attendence Percent</th>
        <th>Class Number</th>
    </tr>

    <?php
    foreach ($result as $value) {
        echo "<tr>";
        echo "<td>" . $value["date"] . "</td>";
        if ($value["attendence"] == 1) {
            echo "<td>present</td>";
            echo "<td>" . $present . "</td>";
            echo "<td>" . round(($present / $classesConducted) * 100, 2) . "</td>";
            $present--;
        } else {
            // $present -= 2;
            echo "<td>Absent</td>";
            echo "<td>" . $present . "</td>";
            echo "<td>" . round(($present / $classesConducted) * 100, 2) . "</td>";
        }
        // echo "<td>" . round(($present / $classesConducted) * 100, 2) . "</td>";
        echo "<td>" . $classesConducted-- . "</td>";
    }
    ?>


</table>