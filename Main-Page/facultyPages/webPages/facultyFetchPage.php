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
    <script src="facultyFetch.js?v=3"></script>
    <link rel="stylesheet" href="facultyNavbarStyle.css?v=1">
    <style>
        .searchHidden {
            display: none;
        }
    </style>
    <title>Document</title>
</head>
<?php
include "navbar.php"
?>

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
    <div id="subSelect" style="display: none;">
        <b>Choose a subject : </b>
    </div>
    <div id="search" class="searchHidden">
        <input type="text" name="studentSearch" id="studentSearch">
        <button id="studentSearchButton">Search</button>
        <button id="saveChanges" class="radioChanges" style="display: none;">Submit Changes</button>
        <small class="radioChanges" style="color : red;display : none">*If changes are not submitted, the data won't be updated</small>
    </div>
    <div id="attendenceFetchtable"></div>
</body>

</html