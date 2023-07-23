<?php
session_start();

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        let userDetails = JSON.parse('<?php echo $faculty->jsonEncoder($userDetails); ?>')
    </script>
    <script src="facultyFetch.js"></script>
    <link rel="stylesheet" href="facultyNavbarStyle.css">
    <link rel="stylesheet" href="facultyFetchStyle.css">
    <title>Document</title>
</head>
<header>
    <nav>
        <ul class="navbar">
            <li><a href="facultyUploadPage.php">Upload</a></li>
            <li class="active"><a href="facultyFetchPage.php">Fetch Details</a></li>
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
    <div id="search" class="searchHidden">
        <input type="text" name="studentSearch" id="studentSearch">
        <button id="studentSearchButton">Search</button>
    </div>
    <div id="attendenceFetchtable"></div>
</body>

</html