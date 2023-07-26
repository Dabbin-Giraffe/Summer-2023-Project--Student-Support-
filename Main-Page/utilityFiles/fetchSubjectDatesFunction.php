<?php

function fetchSubjectDatesFunction($conn, $subjectCode, $flag)
{

    $startDate = 0;
    $endDate = 0;

    $stmt = $conn->prepare("SELECT d.startDate, d.endDate
    FROM semesterdates d
    WHERE d.semester = (
        SELECT s.semester
        FROM subject s
        WHERE s.subjectCode = ?
    )
    AND d.flag = ?");
    $stmt->bind_param("si", $subjectCode, $flag);
    $stmt->execute();
    $stmt->bind_result($startDate, $endDate);
    $stmt->fetch();
    $stmt->close();

    $dates = [
        "startDate" => $startDate,
        "endDate" => $endDate
    ];

    return $dates;
}
