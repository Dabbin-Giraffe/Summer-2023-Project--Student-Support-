<?php

// include_once "D:\Summer Project - Student Support\Main-Page\connect.php";

$semester = $_POST["semester"];
$subject = $_POST["subject"];
$studentName = "lorem";

// $stmt = $conn->prepare("SELECT * FROM attendencedata WHERE subject = ? AND semester = ? AND studentName = ?");
// $stmt->bind_param("sis",$semester,$subject,$studentName);
// $stmt->execute();
// $stmt->bind_result($subjectFetch,$semesterFetch,$attendenceFetch,$nameFetch);
// $stmt->fetch();

// $stmt = $conn->prepare("SELECT * FROM attendencedata WHERE subject = ? AND semester = ? AND studentName = ?");
// $stmt->bind_param("sis", $subject, $semester, $studentName);
// $stmt->execute();
// $stmt->bind_result($subjectFetch,$semesterFetch,$attendenceFetch,$nameFetch);

$nameFetch = "lorem";
$subjectFetch = "CS1201";
$semesterFetch = 2;
$attendenceFetch = 69;

// while($stmt->fetch()){
echo "<table><tr><th>Student Name</th><th>Subject</th><th>Semester</th><th>Attendence</th></tr>";
echo "<tr><td>".$nameFetch."</td><td>".$subjectFetch."</td><td>".$semesterFetch."</td><td>".$attendenceFetch."</td></tr></table>";

// }