<?php

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

                    $("#uploadForm").submit(function(e){
                        e.preventDefault();
                        let formData = new FormData(this);
                        formData.append("id",userDetails["id"]);
                        formData.append("subIndexSelect",subSelect);
                        formData.append("yearSelectIndex",yearSelectIndex);
                        $.ajax({
                            url : 'upload.php',
                            type : 'POST',
                            data : formData,
                            dataType : 'json',
                            contentType : false,
                            processData : false,
                            success : function(response){
                                $('#responseMessage').text(response.message);
                            }
                        })
                    })
                })
            }
        })
    </script>
</head>

<body>
    <h3>Welcome <?php echo $userDetails["firstName"] . " " . $userDetails["lastName"] ?></h3>
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
            <input type="file" name="fileToUpload" class="attendenceFile" accept=".csv,.xlsx,xls">
            <input type="submit" value="upload">
        </form>
    </div>
    <div id="responseMessage"></div>
</body>
</html>