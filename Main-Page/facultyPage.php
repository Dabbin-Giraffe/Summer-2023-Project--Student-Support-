<?php
session_start();

if (!(isset($_SESSION["login"]) && ($_SESSION["login"] == true) && isset($_COOKIE["login"]) && ($_COOKIE["login"] == true))) {
    header("Location:login.php");
}


include "faculty.php";
include "connect.php";

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

        // Year selection part
        $(document).ready(function() {
            let yearSelectIndex;
            let subSelect;
            if (userDetails["years"].length > 1) {
                $(".yearSelection").change(function() {
                    yearSelectIndex = $(".yearSelection:checked").attr("id");
                })
            } else {
                yearSelectIndex = 0;
            }
            console.log(yearSelectIndex);

            //deals with everything that happens after selecting a year

            if (yearSelectIndex != null) {
                let subjectRadio = [];
                for (let i = 0; i < userDetails["subjectCount"][yearSelectIndex]; i++) {
                    subjectRadio[i] = {
                        id: userDetails["subjectCode"][yearSelectIndex][i],
                        label: userDetails["subjectName"][yearSelectIndex][i] + "(" + userDetails["subjectCode"][yearSelectIndex][i] + ")",
                        "value": i
                    }
                }
                console.log(subjectRadio);

                //Creating radio buttons

                let radioHtml = "";
                $.each(subjectRadio, function(index, option) {
                    radioHtml += "<input name = 'subSelect' type = 'radio' class = 'subSelect' id = '" + option.id + "'value = '" + option.value + "'>";
                    radioHtml += "<label for = '" + option.id + "' >" + option.label + '</label>';
                });
                $("#subSelect").append(radioHtml);
                $("#subSelect").show();

                //deals with getting the selected subject

                $(".subSelect").change(function() {
                    subSelect = $('.subSelect:checked').val();

                    $("#uploadMessage").text("You are uploading to " + userDetails["subjectName"][yearSelectIndex][subSelect] + "(" + userDetails["subjectCode"][yearSelectIndex][subSelect] + ")")
                    $("#uploadFile").show();

                    //Deals with file AJAX

                    $("#uploadForm").submit(function(e) {
                        e.preventDefault();
                        let formData = new FormData(this);
                        formData.append("subIndexselect", subSelect);
                        formData.append("yearIndexselect", yearSelectIndex);
                        // formData.append("userDetails", userDetails);
                        formData.append("subjectCode", userDetails["subjectCode"][yearSelectIndex][subSelect]);
                        formData.append("subjectName", userDetails["subjectName"][yearSelectIndex][subSelect])
                        $.ajax({
                            url: 'attendenceUpload.php',
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                if (response.success) {
                                    $("#responseMessage").text(response.message);
                                    $("#fullAttendence").show();
                                } else {
                                    $("#responseMessage").text("error php sidee");
                                }
                            },
                            error: function() {
                                console.log("error js side?");
                            }
                        })
                        $("#fullAttendence").click(function() {

                            // console.log("clicked");
                            $("#attendenceLog").empty();
                            let attendenceLog = userDetails;
                            attendenceLog["selectSubindex"] = subSelect;
                            attendenceLog["selectYearindex"] = yearSelectIndex;
                            $("#attendenceLog").load("facultyAttendencelog.php", attendenceLog);
                        })
                    })
                })
            }
        })
    </script>
</head>

<header>
    <h3>Welcome <?php echo $userDetails["firstName"] . " " . $userDetails["lastName"] ?></h3>
    <div style="display: flex;justify-content : flex-end;">
        <form action="logout.php">
            <button id="logOut" type="submit">Logout</button>
        </form>
    </div>
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