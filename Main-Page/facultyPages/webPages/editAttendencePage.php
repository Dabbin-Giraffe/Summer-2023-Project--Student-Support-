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
    <script src="editAttendence.js?v=6"></script>
    <link rel="stylesheet" href="facultyNavbarStyle.css?v=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Document</title>
</head>
<?php
include "navbar.php"
?>

<body>
    <div class="container mt-5">
        <div class="alert alert-warning">
            This updates existing student data based on IDs in the Excel sheet and uploads new data. Existing data remains unchanged. </div>
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
        <div id="uploadSelectContainer" class="my-3">
            <div class="form-row">
                <div id="uploadDateContainer" class="form-group col-md-6" style="display: none;">
                    <label for="uploadDate">Select Date</label>
                    <input type="date" name="uploadDate" id="uploadDate" class="form-control">
                    <p class="small" id="dateAlert" style="display : none;color: red;">There isn't a class matching this date please check</p>
                </div>
                <div id="uploadFileContainer" class="form-group col-md-6" style="display: none;">
                    <form id="uploadForm" enctype="multipart/form-data" method="POST">
                        <div class="custom-file">
                            <input id="fileInput" style="margin-top: 33px;" type="file" name="fileToupload" class="attendenceFile custom-file-input form-control" accept=".csv,.xlsx,xls" multiple="false">
                            <label style="margin-top: 33px;" class="custom-file-label" id="fileLabel" for="fileToupload">Choose file...</label>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submitButton" style="margin-top: 15px;margin-left : 2px">Upload</button>
                    </form>
                </div>
            </div>
        </div>
        <div id="detailsContainer" class="alert alert-secondary mt-3" style="display : none;"></div>
    </div>
</body>

</html>