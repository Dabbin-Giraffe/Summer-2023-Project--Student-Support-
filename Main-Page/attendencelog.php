<?php
session_start();
include_once "connect.php";
$selectSem = $_POST["selectSem"];
$selectSub = $_POST["selectSub"];
$subjectCode = json_decode($_POST["subjectCode"]);
$id = $_SESSION["id"];
$subjectid = $subjectCode[$selectSem - 1][$selectSub];
$fullLog = $_POST["fullLog"];


$stmt = $conn->prepare("SELECT COUNT(*) FROM attendence WHERE semester = ? AND subjectID = ? AND studentID = ?");
$stmt->bind_param("iss", $selectSem, $subjectCode[$selectSem - 1][$selectSub], $id);
$stmt->execute();
$stmt->bind_result($classesConducted);
$stmt->fetch();

$stmt->close();

$date = [];
$attendence = [];
if($fullLog){
    $limit = $classesConducted;
}else{
    $limit = 3;
}

$stmt = $conn->prepare("SELECT date,attendence FROM attendence WHERE semester = ? AND subjectID = ? AND studentID = ? ORDER BY date DESC LIMIT ?");
$stmt->bind_param("issi", $selectSem, $subjectid, $id, $limit);
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

$stmt = $conn->prepare("SELECT COUNT(*) FROM attendence WHERE semester = ? AND subjectID = ? AND studentID = ? AND attendence = 1");
$stmt->bind_param("iss", $selectSem, $subjectCode[$selectSem - 1][$selectSub], $id);
$stmt->execute();
$stmt->bind_result($present);
$stmt->fetch();
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