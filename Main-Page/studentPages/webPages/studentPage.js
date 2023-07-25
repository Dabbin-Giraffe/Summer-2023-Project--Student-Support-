
$(document).ready(function () {
    let fromDate;
    let toDate;
    let selectSem;
    let selectSub;
    let subCode;
    let subLogIndex;
    let details;
    console.log("gello")
    /*Helps in dynamic generation of Dropdown boxes. The dropdown for semester
    is created dynamically by php and that data
    is sent to JS, very weird but thats how i managed to make it work for now*/


    $("#semSelect").change(function () {
        $("#select").hide();
        selectSem = parseInt($(this).val());

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
    selectElementId.change(function () {
        $("#selectHide").hide();
        selectSub = parseInt($(this).val());
        $(".dateInputlog").show();

        console.log(selectSub);

        //Loading selected data into respective divs, fullLog is bool tells whether to show full log or nah
        //This just send the details to coursetable php file

        //coursetable.php : Generates Table for resective subject or all subjects if selectSub = -1

        details = {
            selectSem: selectSem,
            selectSub: selectSub,
            subjectCode: JSON.stringify(subjectCode),
            subjectName: JSON.stringify(subjectName),
            maxClasses: JSON.stringify(maxClasses),
            minimumRequired: JSON.stringify(minimumRequired),
            flag: flag,
            fullLog: 0
        }
        // $("#logDiv").empty();
        // $("#logDiv").children().not("#fromDate").remove();
        $("#tableDiv").load("../utilityFiles/coursetable.php", details);
        $("#tableDiv").show();

        //Deals with generating attendence logs for selected subject while all subject view
        let logDetails = details;

        if (selectSub == -1) {
            //Deals with subject selection during all subject view
            $("#logDiv").empty();
            $(document).on("click", ".subjectLog", function () {
                subCode = $(this).attr("id"); //Fetching Id of selected anchor tag
                subLogIndex = subjectCode[selectSem - 1].indexOf(subCode); // Index of the selected anchor tag
                logDetails["selectSub"] = subLogIndex;
                logDetails["fullLog"] = 0;
                $("#logDiv").load("../utilityFiles/attendencelog.php", logDetails, function () {
                    $("#logDiv").show();

                    let fullLogButton = $("<button>").attr("id", "fullLog").text("View full Log");
                    $("#logDiv").append(fullLogButton);
                })
            })
        }

        logDetails["fullLog"] = 0; //setting boolean to zero at first

        if (selectSub != -1) {
            $("#logDiv").load("../utilityFiles/attendencelog.php", logDetails, function () {
                $("#logDiv").show();

                let fullLogButton = $("<button>").attr("id", "fullLog").text("View full Log");
                $("#logDiv").append(fullLogButton);
            })
        }

    })

    $(document).on("click", "#fullLog", function () {
        console.log("click");
        let logDetails = details;
        if (selectSub == -1) {
            logDetails["selectSub"] = subLogIndex;
        }
        logDetails["fullLog"] = 1; //setting bool to 1
        $("#logDiv").load("../utilityFiles/attendencelog.php", logDetails);
    });

    $("#dateSubmit").click(function () {
        fromDate = $("#fromDate").val();
        toDate = $("#toDate").val();
        if (!fromDate && !toDate) {
            return;
        }
        if (!fromDate && toDate) {
            fromDate = "2000-01-01";
        } else if (fromDate && !toDate) {
            toDate = "2100-01-01";
        }
        if (fromDate > toDate) {
            let temp = toDate;
            toDate = fromDate;
            fromDate = temp;
        }

        let dateDetails = {
            "fromDate": fromDate,
            "toDate": toDate,
        }
        if (selectSub == -1) {
            dateDetails["subCode"] = subCode;
        } else {
            dateDetails["subCode"] = subjectCode[selectSem - 1][selectSub];
        }

        console.log(dateDetails);
        dateDetails = JSON.stringify(dateDetails);

        $.ajax({
            url: "../utilityFiles/subjectDates.php",
            type: 'POST',
            data: dateDetails,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    $("#logDiv").empty();
                    let tableConstruct = response.tableConstruct;
                    $("#logDiv").html(tableConstruct);
                    let fullLogButton = $("<button>").attr("id", "fullLog").text("View full Log");
                    $("#logDiv").append(fullLogButton);
                    console.log("suc");
                }
            },
            error: function () {
                console.log("error js side?");
            }
        })

    })
})