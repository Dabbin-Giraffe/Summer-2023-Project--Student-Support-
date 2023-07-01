<?php
session_start();
$selectSem = $_POST["selectSem"];
$selectSub = $_POST["selectSub"];
$subjectCode = json_decode($_POST["subjectCode"]);
$subjectName = json_decode($_POST["subjectName"]);
$maxClasses = json_decode($_POST["maxClasses"]);
$minimumRequired = json_decode($_POST["minimumRequired"]);
$id = $_SESSION["id"];

$semester = $selectSem;
$subjectid = $subjectCode[$selectSem - 1][$selectSub];
$subjectname = $subjectName[$selectSem - 1][$selectSub];
$minimumrequired = $minimumRequired[$selectSem - 1][$selectSub];
$maxclasses = $maxClasses[$selectSem - 1][$selectSub];

include_once "connect.php";
$stmt = $conn->prepare("SELECT attendence FROM attendence WHERE semester = ? AND subjectID = ? AND studentID = ?");
$stmt->bind_param("iss", $semester, $subjectid, $id);
$stmt->execute();
$stmt->bind_result($attendence);
while ($stmt->fetch()) {
    $attendeceArr[] = $attendence;
}
$stmt->close();

$present = 0;
foreach ($attendeceArr as $value) {
    if ($value) {
        $present++;
    }
}


$stmt = $conn->prepare("SELECT COUNT(*) FROM attendence WHERE semester = ? AND subjectID = ? AND studentID = ?");
$stmt->bind_param("iss", $semester, $subjectid, $id);
$stmt->execute();
$stmt->bind_result($classesConducted);
$stmt->fetch();
$stmt->close();

$presentPercentage = round(($present / $classesConducted) * 100, 2);

$userDetails = [
    'subjectid' => $subjectid,
    'subjectname' => $subjectname,
    'present' => $present,
    'classesConducted' => $classesConducted,
    'presentPercentage' => $presentPercentage,
    'minimumrequired' => $minimumrequired,
    'maxclasses' => $maxclasses
];

?>

<table>
    <tr>
        <th>Subject Code</th>
        <th>Subject Name</th>
        <th>Classes Attended</th>
        <th>Classes Conducted</th>
        <th>Attendence Percentage</th>
        <th>Minimum Required Percentage</th>
        <th>Maximum Classes planned for Semester</th>
    </tr>
    <tr>
        <?php
        foreach ($userDetails as $key => $value) {

            echo "<td>" . $value . "</td>";
        }
        ?>
    </tr>
</table>