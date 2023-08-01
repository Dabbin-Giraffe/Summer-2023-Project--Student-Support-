<?php
session_start();

if (!(isset($_SESSION["login"]) && ($_SESSION["login"] == true) && isset($_COOKIE["login"]) && ($_COOKIE["login"] == true))) {
    header("Location:../../loginPages/login.php");
}

include "../utilityFiles/faculty.php";
include "../../connect.php";

$email = $_SESSION["email"];
$faculty = new Faculty($email, $conn);

$userDetails = $faculty->getUserdetails();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        let userDetails = JSON.parse('<?php echo $faculty->jsonEncoder($userDetails); ?>')
    </script>
    <script src="facultyUpload.js?v=1"></script>
    <link rel="stylesheet" href="facultyNavbarStyle.css?v=3">

</head>

<?php
include "navbar.php"
?>

<body>
    <div class="container mt-5">
        <?php
        if (count($userDetails["years"]) > 1) {
            echo '<div class="row">';
            for ($i = 0; $i < count($userDetails["years"]); $i++) {
                echo '<div class="col-md-2">';
                echo '<div class="form-check">';
                echo '<input class="form-check-input yearSelection" id="year' . $i . '" type="radio" value="' . $i . '">';
                echo '<label class="form-check-label" for="year' . $i . '">' . $userDetails["years"][$i] . '</label>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<h4>' . $userDetails["years"][0] . '</h4>';
        }
        ?>
        <div id="subSelect" style="display: none;" class="my-3"></div>
        <div id="uploadMessage" style="display: none;" class="alert alert-info mt-3"></div>
        <div id="uploadSelectContainer" style="display: none;" class="my-3">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="uploadSelect">Select attendence Date</label>
                    <select name="uploadSelect" id="uploadOptionSelect" class="uploadDate form-control">
                        <option value="0" id="dummySelect">Select upload Date</option>
                        <option value="1">Today</option>
                        <option value="2">Select Date</option>
                    </select>
                </div>
                <div id="uploadDateContainer" style="display: none;" class="form-group col-md-6">>
                    <label for="uploadDate">Select Date</label>
                    <input type="date" name="uploadDate" id="uploadDate" class="form-control">
                </div>
            </div>
        </div>
        <div id="uploadFile" style="display: none;">
            <form id="uploadForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-control-label" for="fileToupload">Upload Attendance File</label>
                    <input type="file" name="fileToupload" class="attendenceFile form-control-file" accept=".csv,.xlsx,xls" multiple="false">
                </div>
                <button type="submit" class="btn btn-primary" id="submitButton">Upload</button>
            </form>
        </div>
        <div id="responseMessage" class="malert alert-success mt-3"></div>
        <div>
            <button id="fullAttendence" style="display: none;margin : 10px;" class="btn btn-info">View attendence Log</button>
        </div>
        <div id="attendenceLog" class="mt-3"></div>
    </div>
</body>

</html>