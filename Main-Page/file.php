<?php

if (isset($_POST["selectedSemester"])) {
    $semester = $_POST["selectedSemester"];
    // $semester = 1;
    echo "<select id='subSelect" . $semester . "' style='display: none;'>";
    $student->getSubjectdetails($semester);
    $subjectCode = $student->subjectCode;
    $subjectName = $student->subjectName;
    $subjectCount = count($subjectCode);
    for ($i = 0; $i < $subjectCount; $i++) {
        // store subject codes and subject names in an arrray
        echo "<option value='" . $subjectCode[$i] . "'>" . $subjectName[$i] . " " . $subjectCode[$i] . "</option>";
    }

    echo "</select>";
}
