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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        let semesterCount = `<?php echo $semesterCount; ?>`;
        let subjectName = JSON.parse('<?php echo $student->jsonEncoder($student->subjectName); ?>');
        let subjectCode = JSON.parse('<?php echo $student->jsonEncoder($student->subjectCode); ?>');
        let maxClasses = JSON.parse('<?php echo $student->jsonEncoder($student->maxClasses); ?>');
        let minimumRequired = JSON.parse('<?php echo $student->jsonEncoder($student->minimumRequired); ?>');
        let flag = "<?php echo $student->flag; ?>";
    </script>
    <script src="studentPage.js?v=3"></script>

</head>

<header>
    <div>
        <div style="display: flex;justify-content : flex-end;">
            <form action="../../loginPages/logout.php">
                <button id="logOut" class="btn btn-danger" type="submit" style="margin: 20px;">Logout</button>
            </form>
        </div>
    </div>
</header>

<body>
    <div class="container mt-5">
        <!-- Dynamic sem selector -->
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <select name="" id="semSelect" class="form-control">
                        <option id="select" value="">Select a semester</option>
                        <?php
                        for ($i = 1; $i <= $semesterCount; $i++) {
                            echo "<option value='" . $i . "'>Semester " . $i . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- All displays are none and later changed using JQuery selectors -->

                <div class="col-md-6 subSelect">
                    <select id='subSelect' class="form-control">
                        <option id="selectHide" value="">Select a subject</option>
                        <option value="-1" id="all">All</option>
                    </select>

                </div>
            </div>
        </div>
        <br><br>
        <div id="tableDiv" style="display : none"></div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <label for="fromDate" style="display : none;" class="dateInputlog">From - </label>
                    <input style="display:none" class="form-control dateInputlog dateInputs" type="date" name="fromDate" id="fromDate">
                </div>
                <div class="col-md-4">
                    <label for="fromDate" style="display : none;" class="dateInputlog">To - </label>
                    <input style="display:none;" class="form-control dateInputlog dateInputs" type="date" name="toDate" id="toDate">
                </div>
                <div class="col-md-4">
                    <button type="submit" style="display : none;margin:30px;" class="btn btn-dark dateInputlog" id="dateSubmit">Submit</button>
                </div>
            </div>
        </div>
        <div id="logDiv" style="display:none"></div>
        <div>
            <button id="fullLog" class="btn btn-dark" style="display: none;">View full Log</button>
        </div>
    </div>

</body>

</html>