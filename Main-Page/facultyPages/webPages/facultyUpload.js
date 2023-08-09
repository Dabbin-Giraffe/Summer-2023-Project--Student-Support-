
console.log("fge");
// Year selection part
$(document).ready(function () {
    let yearSelectIndex;
    let subSelect;
    let dateOption;
    let selectDate;
    let startDate;
    let endDate;

    if (userDetails["years"].length > 1) {
        $(".yearSelection").change(function () {
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
        radioHtml += "<select id='subSelectContainer' class = 'form-control'>"
        radioHtml += "<option class = 'form-check-input subSelect' id = 'subSelectPlaceHolder' value = ''>Select Subject </option>"
        $.each(subjectRadio, function (index, option) {
            radioHtml += "<option class = 'form-check-input subSelect' id = '" + option.id + "'value = '" + option.value + "'>";
            radioHtml += "" + option.label + '</option>';
        });
        radioHtml += "</select>"
        $("#subSelect").append(radioHtml);
        $("#subSelect").show();

        //deals with getting the selected subject

        $("#subSelectContainer").change(function () {
            subSelect = $(this).val();
            $("#subSelectPlaceHolder").remove();
            // Uploading to respective subject message
            $("#uploadMessage").show();
            $("#uploadMessage").text("You are uploading to " + userDetails["subjectName"][yearSelectIndex][subSelect] + "(" + userDetails["subjectCode"][yearSelectIndex][subSelect] + ")")
            $("#uploadForm")[0].reset(); //removes any uploaded file if user changes the subject select
            $("#attendenceLog").empty(); // Clears the attendence log
            $("#fullAttendence").hide(); //Hides the attendence button incase user changes option
            $("#responseMessage").empty(); //Same thing erases all the message content
            $("#submitButton").prop("disabled", false); //disables upload button after submitting one button

            //Date selection Container

            $("#uploadSelectContainer").show(); //shows the date selector
            $("#uploadDateContainer").hide();
            $("#dummySelect").show();
            $("#uploadOptionSelect").val("0");
            $("#uploadFile").hide();
        })

        //Deals with Date select 

        $("#uploadOptionSelect").change(function () {
            $("#submitButton").prop("disabled", false);
            $("#dummySelect").hide();
            dateOption = $(this).val();

            //Deals with option 1, Today Date

            if (dateOption == "1") {
                selectDate = new Date().toISOString().slice(0, 10);
                $("#uploadFile").show(); //shows upload file option
            }

            //Deals with option 2, manual select Date

            if (dateOption == "2") {
                $("#uploadFile").hide();
                console.log("here");
                let dateDetails = {
                    "subjectCode": userDetails["subjectCode"][yearSelectIndex][subSelect],
                    "flag": userDetails["flags"][yearSelectIndex],
                }

                dateDetails = JSON.stringify(dateDetails);


                $.ajax({
                    url: '../utilityFiles/subjectDatesFetch.php',
                    type: 'POST',
                    data: dateDetails,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.success) {
                            startDate = response.startDate;
                            endDate = response.endDate;
                            console.log(startDate, " ", endDate);
                            $("#uploadDate").prop("min", startDate);
                            $("#uploadDate").prop("max", endDate);
                            $("#uploadDateContainer").show();
                        }
                    },
                    error: function () {
                        console.log("error js side?");
                    }
                })

            } else {
                $("#uploadDateContainer").hide();
            }
        })

        $("#uploadDate").change(function () {
            selectDate = $(this).val();

            if (selectDate) {
                $("#uploadFile").show(); //shows upload file option
                $("#submitButton").prop("disabled", false);
                $("#responseMessage").empty();
                $("#attendenceLog").empty();
                $("#fullAttendence").hide();

            } else {
                $("#uploadFile").hide();
            }
        })

        //Deals with file Upload AJAX
        $("#uploadForm").submit(function (e) {
            e.prevenDefault();
            $("#submitButton").prop("disabled", true);
            $("#uploadDate").val("0");

            //Sets up the AJAX data that needs to be sent over

            let formData = new FormData(this);
            formData.append("subIndexselect", subSelect);
            formData.append("yearIndexselect", yearSelectIndex);
            formData.append("subjectCode", userDetails["subjectCode"][yearSelectIndex][subSelect]);
            formData.append("subjectName", userDetails["subjectName"][yearSelectIndex][subSelect]);
            formData.append("userID", userDetails["id"]);
            formData.append("date", selectDate);
            //AJAX stuff

            $.ajax({
                url: '../utilityFiles/attendenceUpload.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        let html = "";
                        html += "<strong>" + response.message + "</strong>";
                        $("#responseMessage").html(html)
                        $("#responseMessage").show();
                        $("#fullAttendence").show();
                    }
                },
                error: function () {
                    console.log("error js side?");
                }
            })

            //Show attendence log button

            $("#fullAttendence").click(function () {
                let attendenceLog = userDetails;
                attendenceLog["selectSubindex"] = subSelect;
                attendenceLog["selectYearindex"] = yearSelectIndex;
                attendenceLog["date"] = selectDate;

                //Loads up the fetched Date

                $("#attendenceLog").load("../utilityFiles/facultyAttendencelog.php", attendenceLog);
            })

        })
    }
})