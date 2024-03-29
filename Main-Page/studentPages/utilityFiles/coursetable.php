<?php
session_start();

include_once "../../connect.php";

$selectSem = $_POST["selectSem"];
$selectSub = $_POST["selectSub"];
$subjectCode = json_decode($_POST["subjectCode"]);
$subjectName = json_decode($_POST["subjectName"]);
$maxClasses = json_decode($_POST["maxClasses"]);
$minimumRequired = json_decode($_POST["minimumRequired"]);
$id = $_SESSION["id"];
?>

<!-- Table Construction -->

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Subject Code</th>
            <th>Subject Name</th>
            <th>Classes Attended</th>
            <th>Classes Conducted</th>
            <th>Attendence Percentage</th>
            <th>Required Percentage</th>
            <th>Max Planned</th>
        </tr>
    </thead>
    <?php
    if ($selectSub == -1) {
        for ($i = 0; $i < count($subjectName[$selectSem - 1]); $i++) {
            generateTable($conn, $selectSem, $subjectCode, $subjectName, $minimumRequired, $maxClasses, $id, $i, $selectSub);
        }
    } else {
        $i = $selectSub;
        generateTable($conn, $selectSem, $subjectCode, $subjectName, $minimumRequired, $maxClasses, $id, $i, $selectSub);
    }
    ?>
</table>
<?php

// Dynamically generates rows for table to display subjects

function generateTable($conn, $selectSem, $subjectCode, $subjectName, $minimumRequired, $maxClasses, $id, $i, $selectSub)
{
    $classesconducted = 0; //needed for attendence calculation and the class number column
    $attendence = 0;

    $stmt = $conn->prepare("SELECT COUNT(*) FROM attendence WHERE semester = ? AND subjectID = ? AND studentID = ?");
    $stmt->bind_param("iss", $selectSem, $subjectCode[$selectSem - 1][$i], $id);
    $stmt->execute();
    $stmt->bind_result($classesconducted);
    $stmt->fetch();
    $stmt->close();

    $present = 0;

    $stmt = $conn->prepare("SELECT attendence FROM attendence WHERE semester = ? AND subjectID = ? AND studentID = ?");
    $stmt->bind_param("iss", $selectSem, $subjectCode[$selectSem - 1][$i], $id);
    $stmt->execute();
    $stmt->bind_result($attendence);
    while ($stmt->fetch()) {
        if ($attendence == 1) {
            $present++;
        }
    }
    $stmt->close();

    $presentPercentage = round(($present / $classesconducted) * 100, 2);


    echo "<tr class='subjectLog' id='" . $subjectCode[$selectSem - 1][$i] . "'>";
    echo "<td>" . $subjectCode[$selectSem - 1][$i] . "</td>";
    //This is related to the "all" selector, adds classes and ids depeding on this "all" thing
    if ($selectSub != -1) {
        echo "<td>" . $subjectName[$selectSem - 1][$i] . "</td>";
    }
    if ($selectSub == -1) {
        echo "<td>" . $subjectName[$selectSem - 1][$i] . "</td>";
    }
    echo "<td>" . $present . "</td>";
    echo "<td>" . $classesconducted . "</td>";
    echo "<td>" . $presentPercentage . "</td>";
    echo "<td>" . $minimumRequired[$selectSem - 1][$i] . "</td>";
    echo "<td>" . $maxClasses[$selectSem - 1][$i] . "</td>";
    echo  "</tr>";
}
?>