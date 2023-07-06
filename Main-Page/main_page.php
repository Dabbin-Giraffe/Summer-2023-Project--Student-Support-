<?php
session_start();
include "student.php";
include_once "connect.php";
?>
<?php
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
    <script>
        let semesterCount;
        let subjectName;
        let subjectCode;
        let maxClasses;
        let minimumRequired;

        $(document).ready(function() {
            let selectSem;
            let selectSub;
            $("#semSelect").change(function() {
                $("#select").hide();
                selectSem = parseInt($(this).val());
                // Passing arrays from php to js
                semesterCount = `<?php echo $semesterCount; ?>`;
                subjectName = JSON.parse('<?php echo $student->jsonEncoder($student->subjectName); ?>')
                subjectCode = JSON.parse('<?php echo $student->jsonEncoder($student->subjectCode); ?>')
                maxClasses = JSON.parse('<?php echo $student->jsonEncoder($student->maxClasses); ?>')
                minimumRequired = JSON.parse('<?php echo $student->jsonEncoder($student->minimumRequired); ?>')

                //Deals with generating second drop down to select subjects

                if (selectElementId.find('option').length > 2) {
                    selectElementId.find('option:not(#all,#selectHide)').remove();
                }
                for (let i = 0; i < subjectName[selectSem - 1].length; i++) {
                    let option = $('<option>');
                    option.text(subjectName[selectSem - 1][i]);
                    option.val(i);
                    selectElementId.append(option);
                }
                $("#subSelect").show();
            });
            let selectElementId = $("#subSelect");
            selectElementId.change(function() {
                $("#selectHide").hide();
                selectSub = parseInt($(this).val());

                let details = {
                    selectSem: selectSem,
                    selectSub: selectSub,
                    subjectCode: JSON.stringify(subjectCode),
                    subjectName: JSON.stringify(subjectName),
                    maxClasses: JSON.stringify(maxClasses),
                    minimumRequired: JSON.stringify(minimumRequired),
                    fullLog: 0
                }
                $("#logDiv").empty();
                $("#tableDiv").load("coursetable.php", details)
                $("#tableDiv").show();

                if (selectSub == -1) {
                    $(document).on("click", ".subjectLog", function() {
                        $("#logDiv").empty();
                        let subCode = $(this).attr("id");
                        subLogIndex = subjectCode[selectSem - 1].indexOf(subCode);
                        let logDetails = details;
                        logDetails["selectSub"] = subLogIndex;
                        logDetails["fullLog"] = 0;
                        $("#logDiv").load("attendencelog.php", logDetails, function() {
                            console.log(logDetails);
                            $("#logDiv").show();
                            var fullLogButton = $("<button>").attr("id", "fullLogAll").text("View full Log");
                            $("#logDiv").append(fullLogButton);
                            $("#fullLogAll").click(function() {
                                
                                logDetails["selectSub"] = subLogIndex;
                                logDetails["fullLog"] = 1;
                                $("#logDiv").load("attendencelog.php", logDetails);
                            });
                        });
                    })
                }
                if (selectSub != -1) {
                    $("#logDiv").load("attendencelog.php", details, function() {
                        $("#logDiv").show();
                        var fullLogButton = $("<button>").attr("id", "fullLog").text("View full Log");
                        $("#logDiv").append(fullLogButton);
                        $("#fullLog").click(function() {
                            let logDetails = details;
                            logDetails["fullLog"] = 1;
                            $("#logDiv").load("attendencelog.php", logDetails);
                        });
                    })
                }
            })
        })
    </script>

</head>

<body>
    <select name="" id="semSelect">
        <option id="select" value="">Select a semester</option>
        <?php
        for ($i = 1; $i <= $semesterCount; $i++) {
            echo "<option value='" . $i . "'>Semester " . $i . "</option>";
        }
        ?>
    </select>
    <select id='subSelect' style='display: none;width : 150px;'>
        <option id="selectHide" value="">Select a subject</option>
        <option value="-1" id="all">All</option>
    </select>
    <br><br>
    <button id="valueSubmit" style="display: none;">Submit</button>
    <div id="tableDiv" style="display : none;border : 2px solid black"></div>
    <div id="logDiv" style="display:none;margin : 10px;">
        <button>hi</button>
    </div>

</body>

</html>