<!-- 
    Webpage generates dropdown boxes dynamically and fetches respective subjects' Attendence
 -->

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

            /*Helps in dynamic generation of Dropdown boxes. The dropdown for semester
            is created dynamically by php and that data
            is sent to JS, very weird but thats how i managed to make it work for now*/

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
                    selectElementId.find('option:not(#all,#selectHide)').remove(); //removes everything except the two mentioned, clears and reuses div 
                }
                // Dynamic subject dropdown generation by JS
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

                //Loading selected data into respective divs, fullLog is bool tells whether to show full log or nah
                //This just send the details to coursetable php file

                //coursetable.php : Generates Table for resective subject or all subjects if selectSub = -1

                let details = {
                    selectSem: selectSem,
                    selectSub: selectSub,
                    subjectCode: JSON.stringify(subjectCode),
                    subjectName: JSON.stringify(subjectName),
                    maxClasses: JSON.stringify(maxClasses),
                    minimumRequired: JSON.stringify(minimumRequired),
                    fullLog: 0
                }
                // $("#logDiv").empty();
                $("#logDiv").children().not("#fromDate").remove();
                $("#tableDiv").load("coursetable.php", details);
                $("#tableDiv").show();

                //Deals with generating attendence logs for selected subject while all subject view

                if (selectSub == -1) {
                    $(document).on("click", ".subjectLog", function() {

                        //Classes : Common classes for all anchor tags, 'subjectLog'
                        //Id : Fetching Id here, ID for each anchor tag is its respective Subject Code
                        
                        // $("#logDiv").empty(); //clearing out everything first
                        $("#logDiv").children().not("#fromDate").remove();
                        let subCode = $(this).attr("id"); //Fetching Id of selected anchor tag
                        subLogIndex = subjectCode[selectSem - 1].indexOf(subCode); // Index of the selected anchor tag
                        
                        // Dealing with the Date input Here
    
                        let logDetails = details;
                        logDetails["selectSub"] = subLogIndex;
                        logDetails["fullLog"] = 0; //setting boolean to zero at first
                        logDetails["fromDate"] = null;
                        logDetails["toDate"] = null;
                        $(".dateInputlog").show();
                        $("#fromDate").datepicker("option",")
                        $("#fromDate").change(function(){
                            let fromDate = $(this).val();
                            logDetails["fromDate"] = fromDate;
                        })
                        $("#toDate").change(function(){
                            let toDate = $(this).val();
                            logDetails["toDate"] = toDate;
                        })
                        //Preparing To load the attendence details
                        $("#logDiv").load("attendencelog.php", logDetails, function() {
                            $("#logDiv").show();

                            // Show full Log button

                            let fullLogButton = $("<button>").attr("id", "fullLogAll").text("View full Log");
                            $("#logDiv").append(fullLogButton);

                            $("#fullLogAll").click(function() {
                                logDetails["selectSub"] = subLogIndex;
                                logDetails["fullLog"] = 1; //setting boolean to 1
                                $("#logDiv").load("attendencelog.php", logDetails);
                            });
                        });
                    })
                }
                if (selectSub != -1) {
                    // If selected a specific subjects, shows partial log
                    $("#logDiv").load("attendencelog.php", details, function() {
                        $("#logDiv").show();

                        // Show full log button

                        let fullLogButton = $("<button>").attr("id", "fullLog").text("View full Log");
                        $("#logDiv").append(fullLogButton);
                        $("#fullLog").click(function() {
                            let logDetails = details;
                            logDetails["fullLog"] = 1; //setting bool to 1
                            $("#logDiv").load("attendencelog.php", logDetails);
                        });
                    })
                }
            })
        })
    </script>

</head>

<body>
    <!-- Dynamic sem selector -->
    <select name="" id="semSelect">
        <option id="select" value="">Select a semester</option>
        <?php
        for ($i = 1; $i <= $semesterCount; $i++) {
            echo "<option value='" . $i . "'>Semester " . $i . "</option>";
        }
        ?>
    </select>
    <!-- All displays are none and later changed using JQuery selectors -->
    <select id='subSelect' style='display: none;width : 150px;'>
        <option id="selectHide" value="">Select a subject</option>
        <option value="-1" id="all">All</option>
    </select>
    <br><br>
    <div id="tableDiv" style="display : none;border : 2px solid black"></div>
    <div>
        <label for="fromDate" style="display : none;margin:10px;" class="dateInputlog">From - </label>
        <input style="display:none;margin : 10px;" class="dateInputlog" type="date" name="fromDate" id="fromDate">
        <label for="fromDate" style="display : none;margin:10px;" class="dateInputlog">To - </label>
        <input style="display:none;margin : 10px;" class="dateInputlog" type="date" name="toDate" id="toDate">

    </div>
    <div id="logDiv" style="display:none;margin : 10px;">
    </div>

</body>

</html>