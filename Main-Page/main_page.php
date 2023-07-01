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
            let selectedSem;
            let selectSub;
            $("#semSelect").change(function() {
                $("#select").hide();
                selectedSem = parseInt($(this).val());
                console.log(selectedSem);
                let semesterCount = `<?php echo $semesterCount; ?>`;
                // console.log("maxClasses", maxClasses);
                for (let i = 0; i < semesterCount; i++) {
                    $(`#subSelect${i}`).hide();
                }
                $(`#subSelect${selectedSem}`).show();
                $(`#subSelect${selectedSem}`).val("Select a Subject");

            });

            $("#valueSubmit").click(function() {
                let student_details = {
                    semester: selectedSem,
                    subject: selectSub
                };
                console.log(student_details);
                $("#tableDiv").load("tableConstruct.php", student_details)
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
    <?php
    // if (isset($_POST["selectedSemester"])) {
    //     $semester = $_POST["selectedSemester"];
    //     // $semester = 1;
    //     echo "<select id='subSelect" . $semester . "' style='display: none;'>";
    //     $student->getSubjectdetails($semester);
    //     $subjectCode = $student->subjectCode;
    //     $subjectName = $student->subjectName;
    //     $subjectCount = count($subjectCode);
    //     for ($i = 0; $i < $subjectCount; $i++) {
    //         // store subject codes and subject names in an arrray
    //         echo "<option value='" . $subjectCode[$i] . "'>" . $subjectName[$i] . " " . $subjectCode[$i] . "</option>";
    //     }

    //     echo "</select>";
    //     // echo strip_tags($semester);
    // }
    ?>
    <br><br>
    <button id="valueSubmit" style="display: none;">Submit</button>
    <div id="tableDiv"></div>
</body>

</html>