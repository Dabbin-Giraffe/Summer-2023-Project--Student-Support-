<!-- 
    Webpage generates dropdown boxes dynamically and fetches respective subjects' Attendence
 -->

<?php
session_start();


if (!(isset($_SESSION["login"]) && ($_SESSION["login"] == true) && isset($_COOKIE["login"]) && ($_COOKIE["login"] == true))) {
    header("Location:../../loginPages/login.php");
}

include "../utilityFiles/student.php";
include_once "../../connect.php";

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script>
        let semesterCount;
        let subjectName;
        let subjectCode;
        let maxClasses;
        let minimumRequired;

        let startDate;
        let endDate;

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
                    flag: "<?php echo $student->flag; ?>",
                    fullLog: 0
                }
                // $("#logDiv").empty();
                $("#logDiv").children().not("#fromDate").remove();
                $("#tableDiv").load("../utilityFiles/coursetable.php", details);
                $("#tableDiv").show();

                //Deals with generating attendence logs for selected subject while all subject view

                if (selectSub == -1) {

                    //Deals with subject selection during all subject view

                    $(document).on("click", ".subjectLog", function() {

                        //Classes : Common classes for all anchor tags, 'subjectLog'
                        //Id : Fetching Id here, ID for each anchor tag is its respective Subject Code

                        // $("#logDiv").empty(); //clearing out everything first
                        $("#logDiv").children().not("#fromDate").remove();
                        let subCode = $(this).attr("id"); //Fetching Id of selected anchor tag
                        let subLogIndex = subjectCode[selectSem - 1].indexOf(subCode); // Index of the selected anchor tag

                        // Dealing with the Date input Here

                        let logDetails = details;
                        logDetails["selectSub"] = subLogIndex;
                        logDetails["fullLog"] = 0; //setting boolean to zero at first

                        // $(".dateInputlog").show();


                        // Deals with ajax request for restricting dates
                        let dateDetails = {
                            "selectSubCode": subjectCode[selectSem - 1][subLogIndex],
                            "flag": details["flag"]
                        };
                        dateDetails = JSON.stringify(dateDetails);
                        console.log(dateDetails);
                        $.ajax({
                            url: '../utilityFiles/subjectDates.php',
                            type: 'POST',
                            data: dateDetails,
                            dataType: "json",
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                if (response.success) {
                                    startDate = response.startDate;
                                    endDate = response.endDate;
                                    $(".dateInputlog").show();

                                    startDate = moment(startDate, "YYYY-MM-DD");
                                    endDate = moment(endDate, "YYYY-MM-DD");
                                } else {
                                    console.log("error php side")
                                }
                            },
                            error: function() {
                                console.log("error js side?");
                            }
                        })

                        //Taking Date input, if the date selected is older than the date we have it will just take oldest date
                        // and same in the case of "to" date too, blocking out the dates is giving weird results.

                        // let fromDate = null;
                        // let toDate = null;

                        // $("#dateSubmit").click(function() {

                        //     //From date

                        //     fromDate = moment($("#fromDate").val());
                        //     if (fromDate.isBefore(startDate)) {
                        //         fromDate = startDate.clone();
                        //     } else if (fromDate.isAfter(endDate)) {
                        //         fromDate = endDate.clone();
                        //         fromDate = moment().subtract(1, "days");
                        //     } else if (fromDate.isSame(endDate)) {
                        //         fromDate = moment().subtract(1, "days");
                        //     }
                        //     // fromDate = fromDate.format("YYYY-MM-DD");

                        //     //To date

                        //     toDate = moment($("#toDate").val());
                        //     if (toDate.isAfter(endDate)) {
                        //         toDate = endDate.clone();
                        //     } else if (toDate.isBefore(startDate)) {
                        //         toDate = startDate.clone();
                        //         toDate = moment().add(1, "days");
                        //     } else if (toDate.isSame(startDate)) {
                        //         toDate = moment().add(1, "days");
                        //     }
                        //     // toDate = toDate.format("YYYY-MM-DD");

                        //     if (fromDate.isAfter(toDate)) {
                        //         let tempDate = toDate;
                        //         toDate = fromDate;
                        //         fromDate = tempDate;
                        //     }

                        //     //logic

                        //     console.log(toDate)
                        //     console.log(fromDate);
                        // })

                        $("#logDiv").load("../utilityFiles/attendencelog.php", logDetails, function() {
                            $("#logDiv").show();

                            // Show full Log button

                            let fullLogButton = $("<button>").attr("id", "fullLogAll").text("View full Log");
                            $("#logDiv").append(fullLogButton);

                            $("#fullLogAll").click(function() {
                                logDetails["selectSub"] = subLogIndex;
                                logDetails["fullLog"] = 1; //setting boolean to 1
                                $("#logDiv").load("../utilityFiles/attendencelog.php", logDetails);
                            });
                        });
                    })
                }
                if (selectSub != -1) {
                    // If selected a specific subjects, shows partial log
                    $("#logDiv").load("../utilityFiles/attendencelog.php", details, function() {
                        $("#logDiv").show();

                        // Show full log button

                        let fullLogButton = $("<button>").attr("id", "fullLog").text("View full Log");
                        $("#logDiv").append(fullLogButton);
                        $("#fullLog").click(function() {
                            let logDetails = details;
                            logDetails["fullLog"] = 1; //setting bool to 1
                            $("#logDiv").load("../utilityFiles/attendencelog.php", logDetails);
                        });
                    })
                }
            })
        })
    </script>

</head>

<header>
    <div>
        <div style="display: flex;justify-content : flex-end;">
            <form action="logout.php">
                <button id="logOut" type="submit">Logout</button>
            </form>
        </div>
    </div>
</header>

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
        <button type="submit" style="display : none;margin:10px;" class="dateInputlog" id="dateSubmit">Submit</button>
    </div>
    <div id="logDiv" style="display:none;margin : 10px;">
    </div>

</body>

</html>