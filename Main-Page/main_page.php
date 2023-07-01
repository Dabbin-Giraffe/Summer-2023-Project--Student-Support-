<?php
session_start();
include "student.php";
include_once "connect.php";
?>

<?php
$email = $_SESSION["email"] = "lorem@ipsum.com";
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
        $(document).ready(function() {
            let selectSem;
            let selectSub;
            $("#semSelect").change(function() {
                $("#select").hide();
                selectSem = parseInt($(this).val());
                console.log(selectSem);
                // Passing arrays from php to js
                let semesterCount = `<?php echo $semesterCount; ?>`;
                let subjectName = JSON.parse('<?php echo $student->jsonEncoder($student->subjectName); ?>')
                let subjectCode = JSON.parse('<?php echo $student->jsonEncoder($student->subjectCode); ?>')
                let maxClasses = JSON.parse('<?php echo $student->jsonEncoder($student->maxClasses); ?>')
                let minimumRequired = JSON.parse('<?php echo $student->jsonEncoder($student->minimumRequired); ?>')

                //Deals with generating second drop down to select subjects
                let selectElementId = $('#subSelect');
                selectElementId.show();

                if (selectElementId.find('option').length > 1) {
                    selectElementId.empty();
                }
                for (let i = 0; i < subjectName[selectSem - 1].length; i++) {
                    let option = $('<option>');
                    option.text(subjectName[selectSem - 1][i]);
                    option.val(i);
                    selectElementId.append(option);
                }
                selectElementId.change(function() {
                    selectSub = parseInt($(this).val());
                    console.log("selectedsub", subjectName[selectSem - 1][selectSub], " ", subjectCode[selectSem - 1][selectSub]);
                })

            });
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
    <select id='subSelect' style='display: none;width : 150px'>
        <option id="selectHide" value="">Select a subject</option>
    </select>
    <br><br>
    <button id="valueSubmit" style="display: none;">Submit</button>
    <div id="tableDiv"></div>
</body>

</html>