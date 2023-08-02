<?php

function attendenceLog($id, $subjectid, $fullLog, $conn, $fromDate = "2000-01-01", $toDate = "2100-01-01")
{
    $present = 0;
    $attendence = 0;
    $date = 0;
    $classesConducted = 0;

    //Fetching Dates and attendence(bool)

    $stmt = $conn->prepare("SELECT date,attendence FROM attendence WHERE subjectID = ? AND studentID = ? ORDER BY date DESC");
    $stmt->bind_param("ss", $subjectid, $id);
    $stmt->execute();
    $stmt->bind_result($date, $attendence);

    $result = [];
    while ($stmt->fetch()) {
        $classesConducted++;
        if ($attendence == 1) {
            $present++;
        }
        $result[] = [
            'date' => $date,
            'attendence' => $attendence
        ];
    }
    $stmt->close();

    if ($fullLog) {
        $limit = $classesConducted;
    } else {
        $limit = 3;
    }

    $html = "<table class='table table-bordered'>
    <thead>
            <tr>
                <th>Date</th>
                <th>Attendence Status</th>
                <th>Attendended Classes</th>
                <th>Attendence Percent</th>
                <th>Class Number</th>
            </tr></thead>";

    foreach ($result as $value) {
        if (!($limit--)) {
            break;
        }
        if ($value["date"] >= $fromDate && $value["date"] <= $toDate) {
            $html .= "<tr>";
            $html .= "<td>" . $value["date"] . "</td>";
            if ($value["attendence"] == 1) {
                $html .=  "<td>present</td>";
                $html .= "<td>" . $present . "</td>";
                $html .= "<td>" . round(($present / $classesConducted) * 100, 2) . "</td>";
                $present--;
            } else {
                $html .= "<td>Absent</td>";
                $html .= "<td>" . $present . "</td>";
                $html .= "<td>" . round(($present / $classesConducted) * 100, 2) . "</td>";
            }
            $html .= "<td>" . $classesConducted . "</td></tr>";
        }else{
            if ($value["attendence"] == 1) {
                $present--;
            }

        }
        $classesConducted--;
    }

    $html .=  "</table>";

    return $html;
}
