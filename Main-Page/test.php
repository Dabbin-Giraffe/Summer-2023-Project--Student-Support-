<?php
if (isset($_POST["selectedSem"])) {
    $semester = $_POST["selectedSem"];
    echo "<select id='subSelect" . $semester . "' style='display: none;'>";
    for ($i = 0; $i < $subjectCount; $i++) {
        // store subject codes and subject names in an arrray
        echo "<option value='" . $subjectCode[$i] . "'>" . $subjectName[$i] . " " . $subjectCode[$i] . "</option>";
    }
    $student->getSubjectdetails($semester);
    $subjectCode = $student->subjectCode;
    $subjectName = $student->subjectName;
    $subjectCount = count($subjectCode);

    echo "</select>";
}
?>
