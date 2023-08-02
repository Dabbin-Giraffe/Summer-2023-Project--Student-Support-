function isStudentID(studentID) {
    let pattern = /^SE\d{2}[A-Z]{4}\d{2}$/;
    return pattern.test(studentID);
}

function cleanStudentID(studentID) {
    studentID = studentID.trim().toUpperCase();
    return studentID;
}

function loadAttendenceLog(fetchDetails) {

    $.ajax({
        url: "../utilityFiles/studentAttendencefetch.php",
        type: "POST",
        data: fetchDetails,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.success) {
                let attendenceTable = response.table;
                $("#attendenceFetchtable").html(attendenceTable);
                $(".radioChanges").show();
                return response.result;
            }
        },
        error: function () {
            console.log("error js side in attendence log function");
        }
    })

}

$(document).ready(function () {

    //User Details var has all the faculty subject years etc

    let studentID;
    let subSelect;
    let attendenceTable;
    let defaultAttendence = [];
    let changedAttendence = [];


    // Year selection part

    let yearSelectIndex;
    if (userDetails["years"].length > 1) {
        $(".yearSelection").change(function () {
            yearSelectIndex = $(".yearSelection:checked").attr("id");
        })
    } else {
        yearSelectIndex = 0;
    }
    // console.log(yearSelectIndex);

    if (yearSelectIndex != null) {
        let subjectRadio = [];
        for (let i = 0; i < userDetails["subjectCount"][yearSelectIndex]; i++) {
            subjectRadio[i] = {
                id: userDetails["subjectCode"][yearSelectIndex][i],
                label: userDetails["subjectName"][yearSelectIndex][i] + "(" + userDetails["subjectCode"][yearSelectIndex][i] + ")",
                "value": i
            }
        }
        // console.log(subjectRadio);

        //Creating radio buttons

        let radioHtml = "";
        $.each(subjectRadio, function (index, option) {
            radioHtml += "<div class='form-check'>";
            radioHtml += "<input name = 'subSelect' type = 'radio' class = 'form-check-input subSelect' id = '" + option.id + "'value = '" + option.value + "'>";
            radioHtml += "<label class = 'form-check-label' for = '" + option.id + "' >" + option.label + '</label>';
            radioHtml += "</div>";
        });
        $("#subSelect").append(radioHtml);
        $("#subSelect").show();
    }

    //deals with getting the selected subject

    $(".subSelect").change(function () {
        subSelect = $('.subSelect:checked').val();
        // console.log(subSelect);

        //Deals with the search student thing 

        if (subSelect != null) {
            $("#search").show()
        }

        $("#studentSearchButton").click(function () {
            studentID = $("#studentSearch").val();
            studentID = cleanStudentID(studentID);
            $("#alerterID").remove();

            // Deals with adding the alerter

            if (studentID == "" || isStudentID(studentID)) {
                $("#alerterID").remove();
                let htmlAlert = $("<small>").text("Invalid student ID");
                htmlAlert.attr("id", "alerterID")
                $("#search").append(htmlAlert);
                return;
            }

            //Deals with AJAX transfer of the student details and the year

            let Details = {
                "studentID": studentID,
                "yearSelectIndex": yearSelectIndex,
                "subSelect": subSelect,
                "subCode": userDetails["subjectCode"][yearSelectIndex][subSelect],
                "year": userDetails["years"][yearSelectIndex]
            }

            let fetchDetails = JSON.stringify(Details);

            defaultAttendence = loadAttendenceLog(fetchDetails);

            // Deals with getting the radio button data and also sending over AJAX data to php file so that we can push the changes to mysql table

            $("#saveChanges").click(function () {
                $('table tr').each(function (index, row) {
                    let setName = $(row).find('input[type="radio"]').attr('id');
                    if (setName) {
                        let selectedValue = $(row).find('input[type="radio"]:checked').val();
                        changedAttendence.push({ "id": setName.split('+')[0], "attendence": selectedValue });
                    }
                })

                let editAttendenceDetails = Details;
                editAttendenceDetails["defaultAttendence"] = defaultAttendence;
                editAttendenceDetails["changedAttendence"] = changedAttendence;

                editAttendenceDetails = JSON.stringify(editAttendenceDetails);
                // console.log(editAttendenceDetails);
                $.ajax({
                    url: "../utilityFiles/editAttendence.php",
                    type: "POST",
                    data: editAttendenceDetails,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.success) {
                            loadAttendenceLog(fetchDetails);
                        }
                    },
                    error: function () {
                        loadAttendenceLog(fetchDetails);
                        console.log("error js side");
                    }
                })

            })

        })
    })


})
