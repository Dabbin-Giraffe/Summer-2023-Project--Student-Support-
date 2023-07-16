
// Year selection part
$(document).ready(function () {
    let yearSelectIndex;
    let subSelect;
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
        $.each(subjectRadio, function (index, option) {
            radioHtml += "<input name = 'subSelect' type = 'radio' class = 'subSelect' id = '" + option.id + "'value = '" + option.value + "'>";
            radioHtml += "<label for = '" + option.id + "' >" + option.label + '</label>';
        });
        $("#subSelect").append(radioHtml);
        $("#subSelect").show();

        //deals with getting the selected subject

        $(".subSelect").change(function () {
            subSelect = $('.subSelect:checked').val();

            $("#uploadMessage").text("You are uploading to " + userDetails["subjectName"][yearSelectIndex][subSelect] + "(" + userDetails["subjectCode"][yearSelectIndex][subSelect] + ")")
            $("#uploadFile").show();

            //Deals with file AJAX

            $("#uploadForm").submit(function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                formData.append("subIndexselect", subSelect);
                formData.append("yearIndexselect", yearSelectIndex);
                // formData.append("userDetails", userDetails);
                formData.append("subjectCode", userDetails["subjectCode"][yearSelectIndex][subSelect]);
                formData.append("subjectName", userDetails["subjectName"][yearSelectIndex][subSelect])
                $.ajax({
                    url: '../utilityFiles/attendenceUpload.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.success) {
                            $("#responseMessage").text(response.message);
                            $("#fullAttendence").show();
                        } else {
                            $("#responseMessage").text("error php sidee");
                        }
                    },
                    error: function () {
                        console.log("error js side?");
                    }
                })
                $("#fullAttendence").click(function () {

                    // console.log("clicked");
                    $("#attendenceLog").empty();
                    let attendenceLog = userDetails;
                    attendenceLog["selectSubindex"] = subSelect;
                    attendenceLog["selectYearindex"] = yearSelectIndex;
                    $("#attendenceLog").load("../utilityFiles/facultyAttendencelog.php", attendenceLog);
                })
            })
        })
    }
})