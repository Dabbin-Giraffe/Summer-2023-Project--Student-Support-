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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        let userDetails = JSON.parse('<?php echo $faculty->jsonEncoder($userDetails); ?>')
    </script>
    <script src="facultyUpload.js"></script>

    <link rel="stylesheet" href="facultyNavbarStyle.css">
</head>

<header>
    <nav>
        <ul class="navbar">
            <li class="active"><a href="facultyUploadPage.php">Upload</a></li>
            <li><a href="facultyFetchPage.php">Fetch Details</a></li>
            <li><a href="../../loginPages/logout.php">Logout</a></li>
        </ul>
    </nav>
    <h3>Welcome <?php echo $_SESSION["firstName"] . " " . $_SESSION["lastName"] ?></h3>

</header>

<body>
    <?php
    if (count($userDetails["years"]) > 1) {
        for ($i = 0; $i < count($userDetails["years"]); $i++) {

            echo "<input class = 'yearSelection' id = '" . $i . "' type = 'radio' value = '" . $i . "'>";
            echo "<label for = '" . $userDetails["years"][$i] . "'>" . $userDetails["years"][$i] . "</label>";
        }
    } else {
        echo "<h4>" . $userDetails["years"][0] . "</h4>";
    }
    ?>
    <div id="subSelect" style="display: none;"></div>
    <div id="uploadMessage"></div>
    <div id="uploadSelectContainer" style="display: none;">
        <label for="uploadSelect">Select attendence Date</label>
        <select name="uploadSelect" id="uploadOptionSelect" class="uploadDate">
            <option value="0" id="dummySelect">Select upload Date</option>
            <option value="1">Today</option>
            <option value="2">Select Date</option>
        </select>
        <div id="uploadDateContainer" style="display: none;">
            <input type="date" name="uploadDate" id="uploadDate">
        </div>
    </div>
    <div id="uploadFile" style="display: none;">
        <form id="uploadForm" enctype="multipart/form-data">
            <input type="file" name="fileToupload" class="attendenceFile" accept=".csv,.xlsx,xls" multiple="false">
            <input type="submit" value="upload" id="submitButton">
        </form>
    </div>
    <div id="responseMessage"></div>
    <div><button id="fullAttendence" style="display: none;margin : 10px;">View attendence Log</button></div>
    <div id="attendenceLog"></div>
</body>

</html>