
$(document).ready(function () {

    //User Details var has all the faculty subject years etc

    let studentID;
    let subSelect;
    let selectDate;
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

        //Creating radio buttons

        let radioHtml = "";
        radioHtml += "<select id='subSelectContainer' class = 'form-control'>"
        radioHtml += "<option class = 'form-check-input subSelect' id = 'subSelectPlaceHolder' value = ''>Select Subject </option>"
        $.each(subjectRadio, function (index, option) {
            radioHtml += "<option class = 'form-check-input subSelect' id = '" + option.id + "'value = '" + option.value + "'>";
            radioHtml += "" + option.label + '</option>';
        });
        radioHtml += "</select>"
        $("#subSelect").append(radioHtml);
        $("#subSelect").show();

        $("#subSelectContainer").change(function () {
            $("#uploadDate").val("");
            $("#dateAlert").hide();
            $("#uploadFileContainer").hide();
            subSelect = $(this).val();
            $("#subSelectPlaceHolder").remove();
            $("#attendenceFetchtable").empty();
            $(".radioChanges").hide();
            $("#uploadDateContainer").show();

            let dateDetails = {
                "subjectCode": userDetails["subjectCode"][yearSelectIndex][subSelect],
                "flag": userDetails["flags"][yearSelectIndex],
            }

            dateDetails = JSON.stringify(dateDetails);

            $.ajax({
                url: '../utilityFiles/editDatesFetch.php',
                type: 'POST',
                data: dateDetails,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        startDate = response.minDate;
                        endDate = response.maxDate;
                        $("#uploadDate").prop("min", startDate);
                        $("#uploadDate").prop("max", endDate);
                        $("#uploadDateContainer").show();
                    }
                },
                error: function () {
                    console.log("error js side?");
                }
            })

            $("#uploadDate").change(function () {
                selectDate = $(this).val();

                if (selectDate) {
                    let dateDetails = {
                        "subjectCode": userDetails["subjectCode"][yearSelectIndex][subSelect],
                        "flag": userDetails["flags"][yearSelectIndex],
                        "selectDate": selectDate
                    }

                    dateDetails = JSON.stringify(dateDetails);
                    $.ajax({
                        url: '../utilityFiles/checkDates.php',
                        type: 'POST',
                        data: dateDetails,
                        dataType: 'json',
                        contentType: 'application/json',
                        processData: false,
                        success: function (response) {
                            if (response.success) {
                                let count = response.count;
                                console.log(count);
                                if (!count) {
                                    $("#uploadFileContainer").hide();
                                    $("#dateAlert").show();
                                } else {
                                    $("#dateAlert").hide();
                                    $('#fileInput').change(function () {
                                        var fileName = $(this).val().split('\\').pop();
                                        $('#fileLabel').html(fileName);
                                    });
                                    $("#uploadFileContainer").show();
                                }
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log("AJAX Error: " + error);
                        }
                    })
                }
            })

        })

        $("#uploadForm").submit(function (e) {

            e.preventDefault();

            $("#submitButton").prop("disabled", true);
            $("#uploadDate").val("0");

            let formData = new FormData(this);
            formData.append("selectDate", selectDate);
            formData.append("subjectCode", userDetails["subjectCode"][yearSelectIndex][subSelect]);
            formData.append("flag", userDetails["flags"][yearSelectIndex]);
            formData.append("subjectName", userDetails["subjectName"][yearSelectIndex][subSelect]);
            formData.append("userID", userDetails["id"]);
            console.log(formData);

            $.ajax({
                url: "../utilityFiles/editUpload.php",
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        console.log("heya");
                    }
                },
                error: function (xhr, status, error) {
                    console.log("AJAX Error: " + error);
                }
            })

        })
    }
})