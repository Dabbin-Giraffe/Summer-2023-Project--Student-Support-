<!-- 
    Webpage generates dropdown boxes dynamically and fetches respective subjects' Attendence
 -->

<?php
session_start();


if (!(isset($_SESSION["login"]) && ($_SESSION["login"] == true) && isset($_COOKIE["login"]) && ($_COOKIE["login"] == true))) {
    header("Location:../../loginPages/login.php");
}

include "../utilityFiles/student.php";
include_once "../../connect.php";

$email = $_SESSION["email"] = "se21ucse198@mahindrauniversity.edu.in";
$student = new Student($email, $conn);
$_SESSION["id"] = $student->id;

$id = $student->id;
$firstName = $student->firstName;
$lastName = $student->lastName;
$semesterCount = $student->semesterCount;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script>
        let semesterCount = `<?php echo $semesterCount; ?>`;
        let subjectName = JSON.parse('<?php echo $student->jsonEncoder($student->subjectName); ?>');
        let subjectCode = JSON.parse('<?php echo $student->jsonEncoder($student->subjectCode); ?>');
        let maxClasses = JSON.parse('<?php echo $student->jsonEncoder($student->maxClasses); ?>');
        let minimumRequired = JSON.parse('<?php echo $student->jsonEncoder($student->minimumRequired); ?>');
        let flag = "<?php echo $student->flag; ?>";

    </script>
    <script src="studentPage.js"></script>

</head>

<header>
    <div>
        <div style="display: flex;justify-content : flex-end;">
            <form action="../../loginPages/logout.php">
                <button id="logOut" type="submit">Logout</button>
            </form>
        </div>
    </div>
</header>

<body>
    <!-- Dynamic sem selector -->
    <select name="" id="semSelect">
        <option id="select" value="">Select a semester</option>
        <?php
        for ($i = 1; $i <= $semesterCount; $i++) {
            echo "<option value='" . $i . "'>Semester " . $i . "</option>";
        }
        ?>
    </select>
    <!-- All displays are none and later changed using JQuery selectors -->
    <select id='subSelect' style='display: none;width : 150px;'>
        <option id="selectHide" value="">Select a subject</option>
        <option value="-1" id="all">All</option>
    </select>
    <br><br>
    <div id="tableDiv" style="display : none;border : 2px solid black"></div>
    <div>
        <label for="fromDate" style="display : none;margin:10px;" class="dateInputlog">From - </label>
        <input style="display:none;margin : 10px;" class="dateInputlog" type="date" name="fromDate" id="fromDate">
        <label for="fromDate" style="display : none;margin:10px;" class="dateInputlog">To - </label>
        <input style="display:none;margin : 10px;" class="dateInputlog" type="date" name="toDate" id="toDate">
        <button type="submit" style="display : none;margin:10px;" class="dateInputlog" id="dateSubmit">Submit</button>
    </div>
    <div id="logDiv" style="display:none;margin : 10px;">
    </div>

</body>

</html>