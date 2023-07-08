<?php

include_once "D:\Summer Project - Student Support\Main-Page\connect.php";

// $stmt = $conn->prepare("INSERT INTO attendencedata (subject,semester) VALUES (?,?)");
// $stmt->bind_param("si",$subject,$semester);

$subject_arr = ["MA1102", "CS1102", "HS1101", "MA1202", "CS1202", "HS1201", "ML2102", "CS2102", "HS2101", "MA2202", "CS2202", "HS2201"];
$semester_arr = [1, 1, 1, 2, 2, 2, 3, 3, 3, 4, 4, 4];

// for($i = 0;$i<count($subject_arr);$i++){
//     $subject = $subject_arr[$i];
//     $semester = $semester_arr[$i];
//     $stmt->execute();
//     echo "suc";
// }

// $stmt = "ALTER TABLE attendencedata ADD COLUMN attendencePercentage FLOAT, ADD COLUMN studentName VARCHAR(255)";

// $stmt = "UPDATE attendencedata SET studentName = 'lorem'";

// $stmt = "UPDATE attendencedata SET attendencePercentage = FLOOR(RAND()*70)+30";
// if($conn->query($stmt)){
//     echo "suc";
// }

// $stmt = "INSERT INTO user (email, password, firstName,lastName,flag,userID) VALUES ('lorem@ipsum.com','1234','lorem','ipsum',1,'SE21UCSE198')";
// $stmt = "INSERT INTO attendencerequired (subjectCode,minRequired,classesCountmax) VALUES ('CS1101',75,40)";
// $stmt = "INSERT INTO attendencerequired (subjectCode,minRequired,classesCountmax) VALUES ('CS1201',75,40)";
// $stmt = "INSERT INTO attendence (studentID,date,attendence,subjectID) VALUES ('SE21UCSE198','2022-11-4',1,'CS1101')";
// $stmt = "INSERT INTO attendence (studentID,date,attendence,subjectID) VALUES ('SE21UCSE198','2022-11-8',0,'CS1101')";
// $stmt = "INSERT INTO attendence (studentID,date,attendence,subjectID) VALUES ('SE21UCSE198','2023-3-8',1,'CS1201')";
// $stmt = "INSERT INTO attendence (studentID,date,attendence,subjectID) VALUES ('SE21UCSE198','2023-3-9',1,'CS1201')";
// $stmt = "ALTER TABLE attendence ADD COLUMN semester INT";
// $stmt = "UPDATE attendence SET semester=1 WHERE id = 1";
// $stmt = "UPDATE attendence SET semester=1 WHERE id = 2";
// $stmt = "UPDATE attendence SET semester=2 WHERE id = 3";
// $stmt = "UPDATE attendence SET semester=2 WHERE id = 4";
// $stmt = "INSERT INTO flag (flag,role) VALUES ('1','2022')";

// $stmt = "C;
// $stmt = "INSERT INTO subject (subjectCode,subjectName,flag,semester) VALUES ('MA1101','Maths',1,1)";
// $stmt = "INSERT INTO subject (subjectCode,subjectName,flag,semester) VALUES ('EC1101','Electronics',1,1)";
// $stmt = "INSERT INTO subject (subjectCode,subjectName,flag,semester) VALUES ('CS1201','Computer Science',1,2)";
// $stmt = "INSERT INTO subject (subjectCode,subjectName,flag,semester) VALUES ('MA1201','Maths',1,2)";
// $stmt = "INSERT INTO subject (subjectCode,subjectName,flag,semester) VALUES ('CE1201','Signals and Systems',1,2)";
// $stmt = "INSERT INTO subject (subjectCode,subjectName,flag,semester) VALUES ('CS1203','Programming Workshop',1,2)";
// $stmt = "INSERT INTO subject (subjectCode,subjectName,flag,semester) VALUES ('HS1201','French',1,2)";

// $stmt = "ALTER TABLE subject ADD COLUMN minRequired FLOAT,ADD COLUMN maxClasses INT";
// $stmt = $conn->prepare("UPDATE subject SET maxClasses = ? WHERE id = ?");
// $stmt->bind_param("di", $minrequired, $id);
// $stmt = $conn->prepare("UPDATE subject SET minRequired = ? WHERE id = ?");
// $stmt->bind_param("di", $minrequired, $id);

// $minRequired = [75, 75, 75, 75, 75, 70, 100, 65];
// for ($i = 1; $i <= 8; $i++) {
//     $minrequired = $minRequired[$i-1];
//     $id = $i;
//     $stmt->execute();
//     echo "suc <br/>";
// }

// $stmt = $conn->prepare("SELECT u.firstName,u.lastName,u.flag,f.role FROM user u JOIN flag f ON u.flag = f.flag WHERE u.email = ?");
// $email = "lorem@ipsum.com";
// $stmt->bind_param("s",$email);
// $stmt->execute();
// $stmt->bind_result($firstName,$lastName,$flag,$role);

// if($stmt->fetch()){
//     echo "First Name ".$firstName."<br/>";
//     echo "First Name ".$lastName."<br/>";
//     echo "First Name ".$flag."<br/>";
//     echo "First Name ".$role."<br/>";
// }

// $dates = ["2022-11-09", "2022-11-10", "2022-11-11", "2022-11-12", "2022-11-13"];
// $firstSemsubjects = ["MA1101", "EC1101"];
// $secondSemsubjects = ["CS1201", "CE1201", "CS1203", "HS1201"];
// $attendence = [0, 0, 0, 0, 1];

// $stmt = $conn->prepare("INSERT INTO attendence (studentID,date,attendence,subjectID,semester) VALUES ('SE21UCSE198',?,?,?,2)");
// $stmt->bind_param("sis", $date, $attend, $subject);

// for ($i = 0; $i < count($dates); $i++) {
//     $subject = "MA1201";
//     $attend = $attendence[$i];
//     $date = $dates[$i];
//     $stmt->execute();
//     echo "suc";
// // }

// $stmt = "DROP TABLE attendencerequired";

// $stmt = "ALTER TABLE user ADD COLUMN isStudent BOOL";
// $stmt = "UPDATE user SET isStudent=1 WHERE userID = 'SE21UCSE198'";
// $stmt = "INSERT INTO user (email,password,firstName,lastName,flag,userID,isStudent) VALUES ('FC123@mahindrauniversity.edu.in','1234','dolor','sit',0,'FC123',0)";
// $stmt = "INSERT INTO user (email,password,firstName,lastName,flag,userID,isStudent) VALUES ('FC124@mahindrauniversity.edu.in','1234','amet','emet',0,'FC124',0)";

// $stmt = "INSERT INTO faculty (userID,flag,subjectCode) VALUES ('FC124',1,'CS1101')";
// $stmt = "INSERT INTO faculty (userID,flag,subjectCode) VALUES ('FC124',1,'MA1101')";
// $stmt = "INSERT INTO faculty (userID,flag,subjectCode) VALUES ('FC123',1,'CS1201')";
// $stmt = "INSERT INTO faculty (userID,flag,subjectCode) VALUES ('FC123',1,'MA1201')";
$stmt = "SELECT * FROM user";
if($conn->query($stmt)){echo "suc";}