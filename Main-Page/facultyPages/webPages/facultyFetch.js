function isStudentID(studentID) {
    let pattern = /^SE\d{2}[A-Z]{4}\d{2}$/;
    return pattern.test(studentID);
}

function cleanStudentID(studentID) {
    studentID = studentID.trim().toUpperCase();
    return studentID;
}

$(document).ready(function () {

    //User Details var has all the faculty subject years etc

    let studentID;
    let subSelect;
    let attendenceTable;

    // Year selection part

    let yearSelectIndex;
    if (userDetails["years"].length > 1) {
        $(".yearSelection").change(function () {
            yearSelectIndex = $(".yearSelection:checked").attr("id");
        })
    } else {
        yearSelectIndex = 0;
    }
    console.log(yearSelectIndex);

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
        $.each(subjectRadio, function (index, option) {
            radioHtml += "<input name = 'subSelect' type = 'radio' class = 'subSelect' id = '" + option.id + "'value = '" + option.value + "'>";
            radioHtml += "<label for = '" + option.id + "' >" + option.label + '</label>';
        });
        $("#subSelect").append(radioHtml);
        $("#subSelect").show();
    }

    //deals with getting the selected subject

    $(".subSelect").change(function () {
        subSelect = $('.subSelect:checked').val();
        console.log(subSelect);

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

            Details = JSON.stringify(Details);

            $.ajax({
                url: "../utilityFiles/studentAttendencefetch.php",
                type: "POST",
                data: Details,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        attendenceTable = response.table;
                        $("#attendenceFetchtable").html(attendenceTable);
                    } else {
                        console.log("brhe");
                    }
                },
                error: function () {
                    console.log("error js side");
                }
            })

        })
    })


})