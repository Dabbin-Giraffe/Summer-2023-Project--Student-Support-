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
    <script src="facultyFetch.js?v=2"></script>
    <link rel="stylesheet" href="facultyNavbarStyle.css?v=1">
    <style>
        .searchHidden {
            display: none;
        }
    </style>
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<?php
include "navbar.php"
?>

<body>
    <div class="container mt-5">
        <div class="form-group">
            <div class="row">
                <div class="col md-7">
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
                </div>
                <div id="subSelect" style="display: none;" class="col-md-7">
                </div>
            </div>
        </div>
        <div id="search" class="searchHidden">
            <div class="input-group mb-3">
                <input type="text" name="studentSearch" class="form-control" placeholder="Search students" id="studentSearch">
                <div class="input-group-append">
                    <button class="btn btn-primary" id="studentSearchButton">Search</button>
                </div>
            </div>
            <button id="saveChanges" class="btn btn-success radioChanges" style="display: none;">Submit Changes</button>
            <small class="text-danger radioChanges" style="color : red;display : none">*If changes are not submitted, the data won't be updated</small>
        </div>
        <div id="studentDetailsContainer" class="alert alert-secondary mt-3">
        </div>
        <div id="attendenceFetchtable"></div>
    </div>
</body>

</html