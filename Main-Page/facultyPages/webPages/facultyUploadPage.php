<?php
session_start();

if (!(isset($_SESSION["login"]) && ($_SESSION["login"] == true) && isset($_COOKIE["login"]) && ($_COOKIE["login"] == true))) {
    header("Location:../../loginPages/login.php");
}


include "../utilityFiles/faculty.php";
include "../../connect.php";

$email = "FC123@mahindrauniversity.edu.in";
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

    <style>
        ul.navbar {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        ul.navbar li {
            float: left;
        }

        ul.navbar li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        ul.navbar li a:hover {
            background-color: #111;
        }

        ul.navbar li:last-child {
            float: right;
        }
    </style>
</head>

<header>
    <nav>
        <ul class="navbar">
            <li><a href="upload.php">Upload</a></li>
            <li><a href="fetch.php">Fetch</a></li>
            <li><a href="../../loginPages/logout.php">Logout</a></li>
        </ul>
    </nav>
    <h3>Welcome <?php echo $userDetails["firstName"] . " " . $userDetails["lastName"] ?></h3>
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
    <div id="uploadFile" style="display: none;">
        <form id="uploadForm" enctype="multipart/form-data">
            <input type="file" name="fileToupload" class="attendenceFile" accept=".csv,.xlsx,xls">
            <input type="submit" value="upload">
        </form>
    </div>
    <div id="responseMessage"></div>
    <div><button id="fullAttendence" style="display: none;margin : 10px;">View attendence Log</button></div>
    <div id="attendenceLog"></div>
</body>

</html>