<?php

include_once "connect.php";

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
// $stmt = "SELECT * FROM user";
// if($conn->query($stmt)){echo "suc";}

// $stmt = "UPDATE attendence SET flag = 1";
// if($conn->query($stmt)){
//     echo "suc";
// }

// $stmt = "DELETE FROM attendence WHERE semester = 1";
// if ($conn->query($stmt)) {
//     echo "suc";
// }

// $stmt = "INSERT INTO semesterdates (flag,semester,startDate,endDate) VALUES (1,1,'2022-01-15','2022-04-15')";
// if ($conn->query($stmt)) {
//     echo "suc";
// }


// $changedAttendence = [
//     [
//         "attendence" => 0,
//         "id" => 4
//     ]
// ];
// $defaultAttendence = [
//     [
//         "attendence" => 1,
//         "id" => 4
//     ]
// ];


// function uploadData($conn, $defaultAttendence, $changedAttendence)
// {
//     $changedVals = [];

//     for ($i = 0; $i < count($changedAttendence); $i++) {
//         if ($defaultAttendence[$i]["attendence"] != $changedAttendence[$i]["attendence"]) {
//             $changedVals[] = [
//                 "id" => $changedAttendence[$i]["id"],
//                 "attendence" => $changedAttendence[$i]["attendence"]
//             ];
//         }
//     }

//     foreach ($changedVals as $value) {
//         $stmt = $conn->prepare("UPDATE attendence SET attendence = ? WHERE id = ?");
//         $stmt->bind_param("ii", $value["attendence"], $value["id"]);
//         if (!($stmt->execute())) {
//             $stmt->close();
//             echo "sql error";
//         }
//         $stmt->close();
//     }
//     echo "success";
// }

// uploadData($conn,$defaultAttendence,$changedAttendence);

// $stmt = "INSERT INTO attendence (studentID,date,attendence,subjectID,semester,flag) VALUES ('SE21UCSE198','2022-01-16',1,'EC1101',1,1)";
// if($conn->query($stmt)){
//     echo "suc";
// }


// $result = fetchAttendenceDetails("CS1201","SE21UCSE198",$conn);
// print_r($result);


// function fetchAttendenceDetails($subjectID, $studentID, $conn)
// {

//     $id = 0;
//     $date = "";
//     $attendence = 0;
//     $classesConducted = 0;
//     $present = 0;

//     $stmt = $conn->prepare("SELECT id,date,attendence FROM attendence WHERE subjectID = ? AND studentID = ? ORDER BY date DESC");
//     $stmt->bind_param("ss", $subjectID, $studentID);
//     $stmt->execute();
//     $stmt->bind_result($id, $date, $attendence);

//     $attendenceDetails = [];
//     while ($stmt->fetch()) {
//         $classesConducted++;
//         if ($attendence == 1) {
//             $present++;
//         }
//         $attendenceDetails[] = [
//             'id' => $id,
//             'date' => $date,
//             'attendence' => $attendence
//         ];
//     }
//     $stmt->close();

//     $studentDetails = fetchStudentDetails($conn, $studentID);

//     $result = [
//         "attendenceDetails" => $attendenceDetails,
//         "studentDetails" => $studentDetails
//     ];

//     return $result;
// }

// function fetchStudentDetails($conn, $studentID)
// {

//     $firstName = "";
//     $lastName = "";
//     $year = 0;
//     $flag = 0;

//     $stmt = $conn->prepare("SELECT firstName, lastName, flag FROM user WHERE userID = ?");
//     $stmt->bind_param("s", $studentID);
//     $stmt->execute();
//     $stmt->bind_result($firstName, $lastName, $flag);
//     $stmt->fetch();
//     $stmt->close();

//     $stmt = $conn->prepare("SELECT role FROM flag WHERE flag = ?");
//     $stmt->bind_param("i", $flag);
//     $stmt->execute();
//     $stmt->bind_result($year);
//     $stmt->fetch();
//     $stmt->close();

//     $studentDetails = [
//         "studentName" => $firstName . " " . $lastName,
//         "year" => $year
//     ];
//     return $studentDetails;
// }

// $dates = editDatesFetch($conn,"CS1201",1);
// print_r( $dates);

// function editDatesFetch($conn, $subjectCode, $flag)
// {
//     $minDate = "";
//     $maxDate = "";
//     $stmt = $conn->prepare("SELECT MIN(date) as minDate, MAX(date) as maxDate FROM attendence WHERE subjectID = ? AND flag = ?");
//     $stmt->bind_param("si", $subjectCode, $flag);
//     $stmt->execute();
//     $stmt->bind_result($minDate, $maxDate);
//     $stmt->fetch();
//     $stmt->close();

//     $dates = [
//         "minDate" => $minDate,
//         "maxDate" => $maxDate
//     ];

//     return $dates;
// }

// $count = checkDates($conn,"CS1201","2023-03-08",1);
// echo $count;

// function checkDates($conn, $subjectCode, $selectDate, $flag)
// {
//     $count = 0;
//     $stmt = $conn->prepare("SELECT COUNT(*) FROM attendence WHERE subjectID = ? AND date = ? AND flag = ?");
//     $stmt->bind_param("ssi", $subjectCode, $selectDate, $flag);
//     $stmt->execute();
//     $stmt->bind_result($count);
//     $stmt->fetch();
//     $stmt->close();

//     return $count;
// }

// $arr1 = ["SE21UCSE198","SE21UCSE179"];
// $arr2 = ["SE21UCSE198"];

// $potato = [1,2];
// $newPotato = [];
// $change = array_diff($arr1,$arr2);
// $changed = $arr1;
// $changed = array_values($change);

// foreach ($change as $key => $value) {
//     $newPotato[] = $change[$key];
// }

// print_r($change);
// print_r($newPotato);
// print_r($changed);

// $editAttendence = [1,0];
// $editIDs = ["SE21UCSE198","SE21UCSE197"];
// $flag = 1;
// $subjectID = "MA1201";
// $date = "2022-10-03";


// foreach ($editIDs as $key => $ID) {
//     $stmt = $conn->prepare("UPDATE attendence SET attendence = ? WHERE studentID = ? AND flag = ? AND date = ? AND subjectID = ?");
//     $stmt->bind_param("isiss", $editAttendence[$key], $ID, $flag, $date, $subjectID);

//     if ($stmt->execute()) {
//         echo "suc\n";
//     }
//     $stmt->close();
// }



// $studentFetchID = [];
// $id = "";
// $date = "2022-10-06";
// $flag = 1;
// $subjectCode = "MA1201";
// $stmt = $conn->prepare("SELECT studentID FROM attendence WHERE date = ? and subjectID = ? and flag = ?");
// $stmt->bind_param("ssi", $date, $subjectCode, $flag);
// $stmt->execute();
// $stmt->bind_result($id);
// while ($stmt->fetch()) {
//     $studentFetchID[] = $id;
// }
// $stmt->close();

// print_r($studentFetchID);

$studentID = ["SE21UCSE198", "SE21UCSE070"];
$studentName = ["abc", "lorem"];
$flag = 1;
$subjectCode = "CS1201";
$date = "2022-10-05";
$attendence = [1, 1];

// $finalResult =  fetchDetails($conn, $studentID, $date, $subjectCode, $flag, $attendence, $studentName);

// function fetchDetails($conn, $studentID, $date, $subjectCode, $flag, $attendence, $studentName)
// {
//     $studentFetchID = [];
//     $id = "";
//     $stmt = $conn->prepare("SELECT studentID FROM attendence WHERE date = ? and subjectID = ? and flag = ?");
//     $stmt->bind_param("ssi", $date, $subjectCode, $flag);
//     $stmt->execute();
//     $stmt->bind_result($id);
//     while ($stmt->fetch()) {
//         $studentFetchID[] = $id;
//     }
//     $stmt->close();

//     // editVals is array of elements that are already present in the table
//     // newIDS are elemnts that are not present in the table and need to be added

//     $editAttendence = [];
//     $editNames = [];
//     $newIDs = array_diff($studentID, $studentFetchID);
//     $editIDs = array_diff($studentID, $newIDs);

//     if (count($newIDs) > 0) {

//         $uploadID = [];
//         $uploadNames = [];
//         $uploadAttendence = [];

//         foreach ($newIDs as $key => $value) {
//             $uploadID[] = $studentID[$key];
//             $uploadNames[] = $studentName[$key];
//             $uploadAttendence[] = $attendence[$key];
//         }
//         echo "count(newids) " . count($newIDs);
//         $uploadResult = newUpload($conn, $uploadID, $uploadAttendence, $date, $subjectCode, $flag);
//     } else {
//         $uploadResult = false;
//     }

//     if (count($editIDs) > 0) {
//         $editID = [];
//         $editNames = [];
//         $editAttendence = [];
//         foreach ($editIDs as $key => $value) {
//             $editID[] = $studentID[$key];
//             $editNames[] = $studentName[$key];
//             $editAttendence[] = $attendence[$key];
//         }
//         echo "count(editID) ".count($editID);
//         $editResult = editUpload($conn, $editID, $editAttendence, $date, $subjectCode, $flag);
//     } else {
//         $editResult = false;
//     }

//     // echo "upload";
//     // print_r($uploadID);
//     // echo "\n edit";
//     // print_r($editIDs);


//     if ($editResult) {
//         $editedVals = [
//             "editAttendence" => $editAttendence,
//             "editNames" => $editNames,
//             "editID" => $editID,
//         ];
//     } else {
//         $editedVals = null;
//     }
//     if ($uploadResult) {
//         $uploadVals = [
//             "uploadAttendence" => $uploadAttendence,
//             "uploadNames" => $uploadNames,
//             "uploadID" => $uploadID
//         ];
//     } else {
//         $uploadVals = null;
//     }
//     echo "<br>edit Result ";
//     print_r(count($editAttendence));
//     echo "<br>upload Result ";
//     print_r($uploadVals);
//     $finalResult = [
//         "editVals" => $editedVals,
//         "uploadVals" => $uploadVals
//     ];

//     return $finalResult;
// }

// function editUpload($conn, $editIDs, $editAttendence, $date, $subjectID, $flag)
// {
//     foreach ($editIDs as $key => $ID) {
//         $stmt = $conn->prepare("UPDATE attendence SET attendence = ? WHERE studentID = ? AND flag = ? AND date = ? AND subjectID = ?");
//         $stmt->bind_param("isiss", $editAttendence[$key], $ID, $flag, $date, $subjectID);
//         $stmt->execute();
//         $stmt->close();
//     }
//     return true;
// }

// function newUpload($conn, $newIDs, $newAttendence, $date, $subjectID, $flag)
// {
//     $semester = 0;

//     $stmt = $conn->prepare("SELECT semester FROM subject WHERE subjectCode = ?");
//     $stmt->bind_param("s", $subjectID);
//     $stmt->execute();
//     $stmt->bind_result($semester);
//     $stmt->fetch();
//     $stmt->close();

//     foreach ($newIDs as $index => $ID) {
//         $stmt = $conn->prepare("INSERT INTO attendence (studentID,date,attendence,subjectID,semester,flag) VALUES (?,?,?,?,?,?)");
//         $stmt->bind_param("ssisii", $ID, $date, $newAttendence[$index], $subjectID, $semester, $flag);
//         $stmt->execute();
//         $stmt->close();
//     }
//     return true;
// }
