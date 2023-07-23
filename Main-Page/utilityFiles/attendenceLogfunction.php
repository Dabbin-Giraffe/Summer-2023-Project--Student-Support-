<?php

function attendenceLog($id, $subjectid, $fullLog, $conn)
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
    
        if($fullLog){
            $limit = $classesConducted;
        }else{
            $limit = 3;
        }
    
    $html = "<table>
            <tr>
                <th>Date</th>
                <th>Attendence Status</th>
                <th>Attendended Classes</th>
                <th>Attendence Percent</th>
                <th>Class Number</th>
            </tr>";

    foreach ($result as $value) {
        if(!($limit--)){
            break;
        }
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
        // echo "<td>" . round(($present / $classesConducted) * 100, 2) . "</td>";
        $html .= "<td>" . $classesConducted-- . "</td>";
    }

    $html .=  "</table>";

    return $html;
}
