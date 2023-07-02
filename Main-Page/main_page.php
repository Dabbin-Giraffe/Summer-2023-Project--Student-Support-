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
                console.log(selectSem);
                // Passing arrays from php to js
                semesterCount = `<?php echo $semesterCount; ?>`;
                subjectName = JSON.parse('<?php echo $student->jsonEncoder($student->subjectName); ?>')
                subjectCode = JSON.parse('<?php echo $student->jsonEncoder($student->subjectCode); ?>')
                maxClasses = JSON.parse('<?php echo $student->jsonEncoder($student->maxClasses); ?>')
                minimumRequired = JSON.parse('<?php echo $student->jsonEncoder($student->minimumRequired); ?>')

                //Deals with generating second drop down to select subjects
                $("#subSelect").show();

                if (selectElementId.find('option').length > 1) {
                    selectElementId.empty();
                }
                for (let i = 0; i < subjectName[selectSem - 1].length; i++) {
                    let option = $('<option>');
                    option.text(subjectName[selectSem - 1][i]);
                    option.val(i);
                    selectElementId.append(option);
                }
            });
            let selectElementId = $("#subSelect");
            selectElementId.change(function() {
                $("#selectHide").hide();
                selectSub = parseInt($(this).val());
                console.log("selectedsub", subjectName[selectSem - 1][selectSub], " ", subjectCode[selectSem - 1][selectSub]);
                if (selectSub != NaN && selectSem != NaN) {
                    $("#valueSubmit").show();
                }
                console.log(typeof subjectCode);
            })
            $("#valueSubmit").click(function() {
                let details = {
                    selectSem: selectSem,
                    selectSub: selectSub,
                    subjectCode: JSON.stringify(subjectCode),
                    subjectName: JSON.stringify(subjectName),
                    maxClasses: JSON.stringify(maxClasses),
                    minimumRequired: JSON.stringify(minimumRequired)
                }

                $("#tableDiv").load("subjectTable.php", details);
                $("#tableDiv").show();
                
                $("#logDiv").load("attendencelog.php",details);
                $("#logDiv").show();

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
    </select>
    <br><br>
    <button id="valueSubmit" style="display: none;">Submit</button>
    <div id="tableDiv" style="display : none;border : 2px solid black"></div>
    <div id="logDiv" style="display:none;margin : 10px;"></div>

</body>

</html>